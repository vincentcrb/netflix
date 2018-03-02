<?php

namespace AppBundle\Command;

use AppBundle\Entity\CategoryMovie;
use AppBundle\Entity\Movie;
use AppBundle\Manager\CategoryMovieManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use AppBundle\Service\ConvertCsvToArray;


class ImportMovieCommand extends ContainerAwareCommand
{
    /** @var EntityManagerInterface */
    private $em;
    private $convert;
    private $cm;
    public function __construct($name = null, EntityManagerInterface $entityManager, ConvertCsvToArray $convert, CategoryMovieManager $categoryMovieManager)
    {
        $this->cm = $categoryMovieManager;
        $this->convert = $convert;
        $this->em = $entityManager;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->setName('import:movie:csv')
            ->setDescription('Import Movie from CSV file');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $now = new \DateTime();
        $output->writeln('<comment>Start : ' . $now->format('d-m-Y G:i:s') . ' ---</comment>');

        $this->import($input, $output);

        $now = new \DateTime();
        $output->writeln('<comment>End : ' . $now->format('d-m-Y G:i:s') . ' ---</comment>');
    }


    protected function import(InputInterface $input, OutputInterface $output)
    {
        $data = $this->get($input, $output);

        $this->em->getConnection()->getConfiguration()->setSQLLogger(null);

        $size = count($data);
        $batchSize = 20;
        $i = 1;

        $progress = new ProgressBar($output, $size);
        $progress->start();

        foreach ($data as $row) {
            $movie = new Movie();
            /** @var \AppBundle\Entity\CategoryMovie $catMovie */
            $catMovie = $this->cm->getCategoryMovie($row['category_movie_id']);
            $date = new \DateTime($row['releaseDate']);
            $movie->setName($row['name']);
            $movie->setCategoryMovie($catMovie);
            $movie->setReleaseDate($date);
            $movie->setSynopsis($row['synopsis']);
            $movie->setImage($row['image']);
            $movie->setVideo($row['video']);

            $this->em->persist($movie);

// Each 20 users persisted we flush everything
            if (($i % $batchSize) === 0) {

                $this->em->flush();
// Detaches all objects from Doctrine for memory save
                $this->em->clear();

// Advancing for progress display on console
                $progress->advance($batchSize);

                $now = new \DateTime();
                $output->writeln(' of users imported ... | ' . $now->format('d-m-Y G:i:s'));

            }

            $i++;

        }

// Flushing and clear data on queue
        $this->em->flush();
        $this->em->clear();

// Ending the progress bar process
        $progress->finish();
    }

    protected function get(InputInterface $input, OutputInterface $output)
    {
        $fileName = 'web/uploads/import/movie.csv';

        $data = $this->convert->convert($fileName, ';');

        return $data;
    }

}