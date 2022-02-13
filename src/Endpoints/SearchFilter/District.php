<?php

namespace OlxScraper\Endpoints\SearchFilter;

use OlxScraper\Endpoints\Interfaces\SearchFilterInterface;

class District implements SearchFilterInterface
{
    public function __construct(
        private int $districtId
    ) {
    }

    public function getFilter(): string
    {
        return "search[district_id]={$this->districtId}";
    }
}