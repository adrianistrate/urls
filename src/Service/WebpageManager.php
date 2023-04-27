<?php

namespace App\Service;

use App\Entity\Webpage;
use App\Entity\WebpageParameter;
use App\Repository\WebpageRepository;
use Doctrine\ORM\EntityManagerInterface;

class WebpageManager
{
    public function __construct(private readonly EntityManagerInterface $entityManager, private readonly WebpageRepository $webpageRepository)
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
        if (count($queryParams)) {
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

    public function exists(string $url): ?Webpage
    {
        $urlData = parse_url($url);

        $queryParams = explode('&', $urlData['query'] ?? '');
        $queryParams = array_filter($queryParams);
        $queryParams = array_map(static function ($queryParam) {
            [$key] = explode('=', $queryParam);

            return $key;
        }, $queryParams);

        return $this->webpageRepository->fetchByUrlData($urlData['host'] ?? null, $urlData['path'] ?? null, $queryParams);
    }

    public function fetchExample(): string
    {
        $webpage = $this->webpageRepository->fetchRandom();

        if (!$webpage) {
            return '';
        }

        return sprintf(
            'https://%s%s%s',
            $webpage->getDomain(),
            $webpage->getPathname() ?? '',
            $webpage->getWebpageParameters()->count() ? '?'.implode(
                    '&',
                    $webpage->getWebpageParameters()->map(static function (WebpageParameter $webpageParameter) {
                        return sprintf('%s=%s', $webpageParameter->getParameter(), $webpageParameter->getVal());
                    })->toArray()
                ) : ''
        );
    }
}
