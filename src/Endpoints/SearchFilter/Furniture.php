<?php

namespace OlxScraper\Endpoints\SearchFilter;

use OlxScraper\Endpoints\Interfaces\SearchFilterInterface;

class Furniture implements SearchFilterInterface
{
    public function __construct(
        public bool $withFurniture = true
    ) {
    }

    public function getFilter(): string
    {
        return 'search[filter_enum_furnish][0]=' . ($this->withFurniture) ? 'yes' : 'no';
    }
}
