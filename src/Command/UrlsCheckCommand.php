<?php

namespace App\Command;

use App\Service\WebpageManager;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Stopwatch\Stopwatch;

#[AsCommand(
    name: 'urls:check',
    description: 'Verifies if the URL exists',
)]
class UrlsCheckCommand extends Command
{
    public function __construct(private readonly WebpageManager $webpageManager)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $stopwatch = new Stopwatch();

        $example = $this->webpageManager->fetchExample();

        $io->info(sprintf('Example: %s', $example));

        $helper = $this->getHelper('question');

        $question = new Question('Please enter the URL you can to check: ');

        $urlToVerify = $helper->ask($input, $output, $question);

        $stopwatch->start('verifyUrl');

        if ($webpage = $this->webpageManager->exists($urlToVerify)) {
            $io->error(sprintf('The URL exists: %d', $webpage->getId()));
        } else {
            $io->success('The URL does not exist');
        }

        $event = $stopwatch->stop('verifyUrl');

        $io->info(sprintf('Duration: %s seconds', $event->getDuration() / 1000));

        return Command::SUCCESS;
    }
}
