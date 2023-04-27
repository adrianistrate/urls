<?php

namespace App\Command\Generate;

use App\Service\ProcessManager;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Process;
use Symfony\Component\Stopwatch\Stopwatch;

#[AsCommand(
    name: 'urls:generate',
    description: 'Master generate command',
)]
class UrlsGenerateCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $stopwatch = new Stopwatch();

        $io->title('Generating URLs');
        $stopwatch->start('generateUrls');

        $processes = [];
        for ($i = 0; $i <= 1000; $i++) {
            $process = new Process(['php', 'bin/console', 'urls:generate-batch', $i * 1000]);
            $processes[] = $process;
        }

        $proc_mgr = new ProcessManager();

        $max_parallel_processes = 5;
        $polling_interval = 1000; // microseconds
        $proc_mgr->runParallel($processes, $max_parallel_processes, $polling_interval);

        $event = $stopwatch->stop('generateUrls');

        $io->success('Done');

        $io->info(sprintf('Duration: %s seconds', $event->getDuration() / 1000));

        return Command::SUCCESS;
    }
}
