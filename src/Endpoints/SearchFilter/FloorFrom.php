<?php

namespace OlxScraper\Endpoints\SearchFilter;

use OlxScraper\Endpoints\Interfaces\SearchFilterInterface;

class FloorFrom implements SearchFilterInterface
{
    public function __construct(
        private int $floatNumber
    ) {
    }

    public function getFilter(): string
    {
        return "search[filter_float_floor:from]={$this->floatNumber}";
    }
}
