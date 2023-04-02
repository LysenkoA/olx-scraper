<?php

namespace OlxScraper\Factories;

use OlxScraper\Entities\Offer;
use OlxScraper\HtmlParsing\DTO\OfferDTO;

class OfferFactory
{
    public function makeFromOfferDTO(OfferDTO $offerDTO): Offer
    {
        return new Offer(
            id: (int) $offerDTO->id,
            name: $offerDTO->name,
            link: $offerDTO->link,
            price: floatval(
                str_replace(
                    ['грн.', '$', '€', ' '],
                    '',
                    $offerDTO->price
                )
            ),
            originalPrice: $offerDTO->price,
            city: $offerDTO->city,
            district: $offerDTO->district,
            date: date(
                'Y-m-d H:i:s',
                strtotime(
                    str_replace(['Сьогодні', 'Сегодня'], 'Today', $offerDTO->date)
                )
            ),
        );
    }
}
