<?php

namespace OlxScraper\Endpoints\SearchFilter;

use OlxScraper\Endpoints\Interfaces\SearchFilterInterface;

class TotalAreaTo implements SearchFilterInterface
{
    public function __construct(
        private int $area
    ) {
    }

    public function getFilter(): string
    {
        return "search[filter_float_total_area:to]={$this->area}";
    }
}
