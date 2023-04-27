<?php

namespace App\Entity;

use App\Repository\WebpageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WebpageRepository::class)]
#[ORM\Index(columns: ['domain'], name: 'domain_idx')]
#[ORM\Index(columns: ['pathname'], name: 'pathname_idx', options: ['lengths' => ['pathname' => 768]])]
class Webpage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 253, nullable: false)]
    private ?string $domain = null;

    #[ORM\Column(length: 1788, nullable: true)]
    private ?string $pathname = null;

    #[ORM\OneToMany(mappedBy: 'webpage', targetEntity: WebpageParameter::class)]
    private Collection $webpageParameters;

    public function __construct()
    {
        $this->webpageParameters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDomain(): ?string
    {
        return $this->domain;
    }

    public function setDomain(string $domain): self
    {
        $this->domain = $domain;

        return $this;
    }

    public function getPathname(): ?string
    {
        return $this->pathname;
    }

    public function setPathname(?string $pathname): self
    {
        $this->pathname = $pathname;

        return $this;
    }

    /**
     * @return Collection<int, WebpageParameter>
     */
    public function getWebpageParameters(): Collection
    {
        return $this->webpageParameters;
    }

    public function addWebpageParameter(WebpageParameter $webpageParameter): self
    {
        if (!$this->webpageParameters->contains($webpageParameter)) {
            $this->webpageParameters->add($webpageParameter);
            $webpageParameter->setWebpage($this);
        }

        return $this;
    }

    public function removeWebpageParameter(WebpageParameter $webpageParameter): self
    {
        if ($this->webpageParameters->removeElement($webpageParameter)) {
            // set the owning side to null (unless already changed)
            if ($webpageParameter->getWebpage() === $this) {
                $webpageParameter->setWebpage(null);
            }
        }

        return $this;
    }
}
