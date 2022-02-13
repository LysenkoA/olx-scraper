<?php

namespace OlxScraper\Entities;

use OlxScraper\HtmlParsing\DTO\OfferDTO;

class Offer
{
    public function __construct(
        private OfferDTO $offerDTO
    ) {
    }

    public function getId(): int
    {
        return (int) $this->offerDTO->id;
    }

    public function getName(): string
    {
        return $this->offerDTO->name;
    }

    public function getUrl(): string
    {
        return $this->offerDTO->link;
    }

    public function getPrice(): float
    {
        return floatval(
            str_replace(
                ['грн.', '$', '€', ' '],
                '',
                $this->offerDTO->price
            )
        );
    }

    public function getOriginalPrice(): string
    {
        return $this->offerDTO->price;
    }

    public function getCity()
    {
        return $this->offerDTO->city;
    }

    public function getDistrict()
    {
        return $this->offerDTO->district;
    }

    public function getDate(): string
    {
        return date(
            'Y-m-d H:i:s',
            strtotime(
                str_replace(['Сьогодні', 'Сегодня'], 'Today', $this->offerDTO->date)
            )
        );
    }
}
