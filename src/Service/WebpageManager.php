<?php

namespace App\Service;

use App\Entity\Webpage;
use App\Entity\WebpageParameter;
use Doctrine\ORM\EntityManagerInterface;

class WebpageManager
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {

    }

    public function add(string $url): void
    {
        $urlData = parse_url($url);

        $webpage = new Webpage();
        $webpage
            ->setDomain($urlData['host'])
            ->setPathname($urlData['path'] !== '/' ? $urlData['path'] : null);


        $queryParams = explode('&', $urlData['query'] ?? '');
        $queryParams = array_filter($queryParams);
        if(count($queryParams)) {
            foreach ($queryParams as $queryParam) {
                [$key, $value] = explode('=', $queryParam);

                $webpageParameter = new WebpageParameter();
                $webpageParameter
                    ->setParameter($key)
                    ->setVal($value);

                $webpage->addWebpageParameter($webpageParameter);

                $this->entityManager->persist($webpageParameter);
            }
        }

        $this->entityManager->persist($webpage);
    }
}
