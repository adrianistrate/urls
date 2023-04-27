<?php

namespace App\Entity;

use App\Repository\WebpageParameterRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WebpageParameterRepository::class)]
#[ORM\Index(columns: ['parameter'], name: 'parameter_idx', options: ['lengths' => ['parameter' => 768]])]
class WebpageParameter
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'webpageParameters')]
    private ?Webpage $webpage = null;

    #[ORM\Column(length: 1785, nullable: true)]
    private ?string $parameter = null;

    #[ORM\Column(length: 255)]
    private ?string $val = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWebpage(): ?Webpage
    {
        return $this->webpage;
    }

    public function setWebpage(?Webpage $webpage): self
    {
        $this->webpage = $webpage;

        return $this;
    }

    public function getParameter(): ?string
    {
        return $this->parameter;
    }

    public function setParameter(string $parameter): self
    {
        $this->parameter = $parameter;

        return $this;
    }

    public function getVal(): ?string
    {
        return $this->val;
    }

    public function setVal(string $val): self
    {
        $this->val = $val;

        return $this;
    }
}
