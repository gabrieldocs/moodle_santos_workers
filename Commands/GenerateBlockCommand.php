<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\ConsoleOutputInterface;

use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;

class GenerateBlockCommand extends Command { 

    

    protected $commandName = 'workers:makeblock';
    protected $commandDescription = "Generates Moodle's simple block plugin's structure";

    protected $commandArgumentName = "blockname";
    protected $commandArgumentDescription = "Name a new Moodle Block";


    protected $commandOptionName = "full"; // should be specified like "app:greet John --cap"
    protected $commandOptionDescription = 'If set, it will greet in uppercase letters';    

    protected function configure()
    {
        $this
            ->setName($this->commandName)
            ->setDescription($this->commandDescription)
            ->addArgument(
                $this->commandArgumentName,
                InputArgument::REQUIRED,
                $this->commandArgumentDescription
            )
            ->addOption(
               $this->commandOptionName,
               null,
               InputOption::VALUE_NONE,
               $this->commandOptionDescription
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        
        // Manipulando o Filesystem
        // $command = $this->getApplication()->find('workers:greet');
        
        $consoleInput = $input->getArgument('blockname');
        $filesystem = new Filesystem();

        try {
            $dir = getcwd() . '/block' . '/' . $input->getArgument('blockname');
            if($filesystem->exists(getcwd() . '/block')){
                $output->writeln('The block dir exists in path');
                $output->writeln('<info>' . getcwd() . '/block' . '</info>');
                $output->writeln('<comment>foo</comment>');
                $output->writeln('<question>foo</question>');
            } else { 
                $filesystem->mkdir(getcwd() . '/block' . $dir);
            }

            $filesystem->mkdir($dir);
            if($filesystem->exists($dir)) { 
                $filesystem->copy('version.php',  $dir . '/' . $consoleInput.'.php');                
            }            
        } catch (IOExceptionInterface $exception) {
            echo "An error occurred while creating your directory at ".$exception->getPath();
        }
        return Command::SUCCESS;

    }

}