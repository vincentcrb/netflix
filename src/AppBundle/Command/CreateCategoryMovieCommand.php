<?php
/**
 * Created by PhpStorm.
 * User: shuns
 * Date: 22/02/2018
 * Time: 14:30
 */

namespace AppBundle\Command;


use AppBundle\Entity\CategoryMovie;
use AppBundle\Manager\CategoryMovieManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateCategoryMovieCommand extends Command
{

    private $categoryMovieManager;
    public function __construct(CategoryMovieManager $categoryMovieManager )
    {
        $this->categoryMovieManager = $categoryMovieManager ;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            // le nom de la commande (la partie après "bin/console")
            ->setName('app:create:category')
            // Une description courte, affichée lors de l'éxécution de la
            // commande "php bin/console list"
            ->setDescription( 'Create Category movie.')
            // La description complète affichée lorsque l'on ajoute
            // l'option "--help"
            ->setHelp('This command allow you to create a category for movies')
            ->addArgument( 'name', InputArgument:: REQUIRED, 'The name of the category.');
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $categoryMovie = new CategoryMovie();
        $categoryMovie->setName($input->getArgument('name'));
        $this->categoryMovieManager->createCategoryMovie($categoryMovie);
        $output->writeln('Category successfully created!');
    }
}