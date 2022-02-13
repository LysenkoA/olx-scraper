<?php

namespace OlxScraper\Endpoints\SearchFilter;

use OlxScraper\Endpoints\Interfaces\SearchFilterInterface;

class PriceFrom implements SearchFilterInterface
{
    public function __construct(
        private float $price
    ) {
    }

    public function getFilter(): string
    {
        return "search[filter_float_price:from]={$this->price}";
    }
}
