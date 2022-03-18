<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use App\Repository\FinancialOperationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FinancialOperationRepository::class)]
#[ApiResource]
#[ApiFilter(DateFilter::class, properties: ['date'])]
class FinancialOperation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 25)]
    private $title;

    #[ORM\Column(type: 'float')]
    private $price;

    #[ORM\Column(type: 'boolean')]
    private $side;

    #[ORM\Column(type: 'date')]
    private $date;

    #[ORM\Column(type: 'date')]
    private $creation_date;

    #[ORM\Column(type: 'date', nullable: true)]
    private $end_date;

    #[ORM\Column(type: 'boolean')]
    private $recurssive;

    #[ORM\Column(type: 'string', length: 15)]
    private $financialStatus;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $recurss_duration;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $mensuality_number;

    #[ORM\Column(type: 'float', nullable: true)]
    private $lastMensuality;

    #[ORM\Column(type: 'float', nullable: true)]
    private $totalCost;

    #[ORM\Column(type: 'float', nullable: true)]
    private $mensuality_cost;

    #[ORM\Column(type: 'boolean')]
    private $isAllMensualityequals;

    #[ORM\Column(type: 'text', nullable: true)]
    private $detail;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getSide(): ?bool
    {
        return $this->side;
    }

    public function setSide(bool $side): self
    {
        $this->side = $side;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creation_date;
    }

    public function setCreationDate(\DateTimeInterface $creation_date): self
    {
        $this->creation_date = $creation_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(?\DateTimeInterface $end_date): self
    {
        $this->end_date = $end_date;

        return $this;
    }

    public function getRecurssive(): ?bool
    {
        return $this->recurssive;
    }

    public function setRecurssive(bool $recurssive): self
    {
        $this->recurssive = $recurssive;

        return $this;
    }

    public function getFinancialStatus(): ?string
    {
        return $this->financialStatus;
    }

    public function setFinancialStatus(string $financialStatus): self
    {
        $this->financialStatus = $financialStatus;

        return $this;
    }

    public function getRecurssDuration(): ?int
    {
        return $this->recurss_duration;
    }

    public function setRecurssDuration(?int $recurss_duration): self
    {
        $this->recurss_duration = $recurss_duration;

        return $this;
    }

    public function getMensualityNumber(): ?int
    {
        return $this->mensuality_number;
    }

    public function setMensualityNumber(int $mensuality_number): self
    {
        $this->mensuality_number = $mensuality_number;

        return $this;
    }

    public function getLastMensuality(): ?float
    {
        return $this->lastMensuality;
    }

    public function setLastMensuality(?float $lastMensuality): self
    {
        $this->lastMensuality = $lastMensuality;

        return $this;
    }

    public function getTotalCost(): ?float
    {
        return $this->totalCost;
    }

    public function setTotalCost(?float $totalCost): self
    {
        $this->totalCost = $totalCost;

        return $this;
    }

    public function getMensualityCost(): ?float
    {
        return $this->mensuality_cost;
    }

    public function setMensualityCost(?float $mensuality_cost): self
    {
        $this->mensuality_cost = $mensuality_cost;

        return $this;
    }

    public function getIsAllMensualityequals(): ?bool
    {
        return $this->isAllMensualityequals;
    }

    public function setIsAllMensualityequals(bool $isAllMensualityequals): self
    {
        $this->isAllMensualityequals = $isAllMensualityequals;

        return $this;
    }

    public function getDetail(): ?string
    {
        return $this->detail;
    }

    public function setDetail(?string $detail): self
    {
        $this->detail = $detail;

        return $this;
    }
}
