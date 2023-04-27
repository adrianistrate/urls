<?php

namespace App\Command;

use App\Service\WebpageManager;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'urls:add',
    description: 'Adds a new URL',
)]
class UrlsAddCommand extends Command
{
    public function __construct(private readonly WebpageManager $webpageManager)
    {
        parent::__construct();
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $helper = $this->getHelper('question');

        $question = new Question('Please enter the URL you can to add: ');
        $urlToAdd = $helper->ask($input, $output, $question);

        $this->webpageManager->add($urlToAdd);

        $io->success('The URL has been added');

        return Command::SUCCESS;
    }
}
