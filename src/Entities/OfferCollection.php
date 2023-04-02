<?php

namespace OlxScraper\Entities;

class OfferCollection
{
    public function __construct(
        private array $offers = []
    ) {
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