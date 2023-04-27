<?php

namespace App\Command;

use App\Repository\DomainListRepository;
use App\Service\WebpageManager;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\String\Slugger\SluggerInterface;

#[AsCommand(
    name: 'urls:generate-batch',
    description: 'Generate a batch of URLs',
)]
class UrlsGenerateBatchCommand extends Command
{
    public function __construct(private readonly DomainListRepository $domainListRepository, private readonly SluggerInterface $slugger, private readonly WebpageManager $webpageManager, private readonly EntityManagerInterface $entityManager)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('offset', InputArgument::REQUIRED, 'Offset')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $offset = $input->getArgument('offset');

        $desiredNbrUrls = 1000;

        $faker = Factory::create();

        $chosenDomains = $this->domainListRepository->getDomains($offset, $desiredNbrUrls);
        for ($i = 0; $i <= $desiredNbrUrls - 1; $i++) {
            $domain = $chosenDomains[$i];

            $subdomain = $faker->boolean(50) ? $this->slugger->slug($faker->word(1)).'.' : '';
            $path = $faker->boolean(40) ? $this->slugger->slug(implode('/', $faker->words($faker->randomNumber(1)))) : '';

            $url = sprintf('%s://%s%s/%s', $faker->boolean() ? 'https' : 'http', $subdomain, $domain, $path);

            $nbrQueryParams = $faker->numberBetween(0, 5);
            if($nbrQueryParams) {
                $url .= '?'.http_build_query(array_combine($faker->words($nbrQueryParams), $faker->words($nbrQueryParams)));
            }

            $this->webpageManager->add($url);
        }

        $this->entityManager->flush();

        $io->success('Done');

        return Command::SUCCESS;
    }
}
