<?php

namespace OlxScraper\Entities;

class Offer
{
    public function __construct(
        private int $id,
        private string $name,
        private string $link,
        private float $price,
        private string $originalPrice,
        private string $city,
        private string $district,
        private string $date
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUrl(): string
    {
        return $this->link;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getOriginalPrice(): string
    {
        return $this->originalPrice;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getDistrict(): string
    {
        return $this->district;
    }

    public function getDate(): string
    {
        return $this->date;
    }
}
