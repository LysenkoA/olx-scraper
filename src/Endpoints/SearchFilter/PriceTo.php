<?php

namespace OlxScraper\Endpoints\SearchFilter;

use OlxScraper\Endpoints\Interfaces\SearchFilterInterface;

class PriceTo implements SearchFilterInterface
{
    public function __construct(
        private float $price
    ) {
    }

    public function getFilter(): string
    {
        return "search[filter_float_price:to]={$this->price}";
    }
}
