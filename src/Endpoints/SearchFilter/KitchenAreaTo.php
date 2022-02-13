<?php

namespace OlxScraper\Endpoints\SearchFilter;

use OlxScraper\Endpoints\Interfaces\SearchFilterInterface;

class KitchenAreaTo implements SearchFilterInterface
{
    public function __construct(
        private int $area
    ) {
    }

    public function getFilter(): string
    {
        return "search[filter_float_kitchen_area:to]={$this->area}";
    }
}
