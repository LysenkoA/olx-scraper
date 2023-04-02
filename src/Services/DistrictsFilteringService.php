<?php

namespace OlxScraper\Services;

use OlxScraper\Entities\Offer;
use OlxScraper\Entities\OfferCollection;

class DistrictsFilteringService
{
    public function filter(OfferCollection $offerCollection, array $districts): OfferCollection
    {
        return new OfferCollection(
            array_filter(
                $offerCollection->getOffers(),
                fn (Offer $offer) => in_array($offer->getDistrict(), $districts)
            )
        );
    }
}
