<?php 

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class GetFileSystem extends Command { 

    protected $commandName = 'workers:getfiles';
    protected $commandDescription = "Greets Someone";

    protected function configure() 
    {
        $this
        ->setName($this->commandName)
        ->setDescription($this->commandDescription);
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $url = "https://github.com/gabrieldocs/day-to-day-references.git";
        $process = new Process(
            ['git','clone', $url, 'plugin']
        );
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        echo $process->getOutput();
        return Command::SUCCESS;
    }
}