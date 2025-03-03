<?php

namespace OlxScraper\Factories;

use OlxScraper\Entities\Offer;
use OlxScraper\HtmlParsing\DTO\OfferDTO;

class OfferFactory
{
    private const URI = 'https://www.olx.ua/';

    public function makeFromOfferDTO(OfferDTO $offerDTO): Offer
    {
        return new Offer(
            id: (int) $offerDTO->id,
            name: $offerDTO->name,
            link: $this->getUrl($offerDTO->link),
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
            previewImgUrl: $this->getUrl($offerDTO->previewImgUrl),
        );
    }

    private function getUrl(string $link): string
    {
        if ($link === '') {
            return '';
        }

        $link = ltrim($link, '/');

        return str_starts_with($link, 'http') ? $link : self::URI . $link;
    }
}
