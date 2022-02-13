<?php

namespace OlxScraper\Endpoints\SearchFilter;

use OlxScraper\Endpoints\Interfaces\SearchFilterInterface;

class TotalAreaFrom implements SearchFilterInterface
{
    public function __construct(
        private int $area
    ) {
    }

    public function getFilter(): string
    {
        return "search[filter_float_total_area:from]={$this->area}";
    }
}
