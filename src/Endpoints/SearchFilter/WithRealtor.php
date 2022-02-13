<?php

namespace OlxScraper\Endpoints\SearchFilter;

use OlxScraper\Endpoints\Interfaces\SearchFilterInterface;

class WithRealtor implements SearchFilterInterface
{
    public function getFilter(): string
    {
        return 'search[filter_enum_cooperate][0]=1';
    }
}
