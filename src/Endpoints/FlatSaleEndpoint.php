<?php

namespace OlxScraper\Endpoints;

use OlxScraper\Endpoints\Interfaces\EndpointInterface;
use OlxScraper\Endpoints\Interfaces\LocationInterface;

class FlatSaleEndpoint implements EndpointInterface
{
    private const URL_PREFIX = 'https://www.olx.ua/uk';
    private string $url = '/nedvizhimost/kvartiry/prodazha-kvartir/' . LocationInterface::KEY . '/';
    private ?LocationInterface $location = null;

    public function setLocation(LocationInterface $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getUrl(): string
    {
        $url = str_replace(
            [
                LocationInterface::KEY,
            ],
            [
                ($this->location) ? $this->location->getPath() : '',
            ],
            $this->url
        );

        return self::URL_PREFIX . str_replace(['//', '///'], '/', $url);
    }

    public function getAvailableSearchFilters(): array
    {
        return [
            SearchFilter\Pagination\Page::class,
            SearchFilter\FloorFrom::class,
            SearchFilter\FloorTo::class,
            SearchFilter\TotalAreaFrom::class,
            SearchFilter\TotalAreaTo::class,
            SearchFilter\KitchenAreaFrom::class,
            SearchFilter\KitchenAreaTo::class,
            SearchFilter\PriceFrom::class,
            SearchFilter\PriceTo::class,
            SearchFilter\WithoutCommission::class,
            // обмін
            // поверховість
            SearchFilter\ApartmentType::class,
            SearchFilter\WithRealtor::class,
            SearchFilter\Furniture::class,
            SearchFilter\Repair::class,
            SearchFilter\Order::class,
            SearchFilter\NumberOfRooms::class,
        ];
    }
}
