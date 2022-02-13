<?php

namespace OlxScraper\Endpoints\SearchFilter;

use OlxScraper\Endpoints\Interfaces\SearchFilterInterface;

class FloorTo implements SearchFilterInterface
{
    public function __construct(
        private int $floatNumber
    ) {
    }

    public function getFilter(): string
    {
        return "search[filter_float_floor:to]={$this->floatNumber}";
    }
}
