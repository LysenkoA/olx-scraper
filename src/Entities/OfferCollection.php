<?php

namespace OlxScraper\Entities;

class OfferCollection
{
    private array $offers = [];

    public function __construct()
    {
    }

    public function addOffer(Offer $offer): self
    {
        $this->offers[] = $offer;

        return $this;
    }

    /**
     * @return Offer[]
     */
    public function getOffers(): array
    {
        return $this->offers;
    }
}