<?php

namespace OlxScraper\Endpoints\SearchFilter;

use OlxScraper\Endpoints\Interfaces\SearchFilterInterface;

class WithoutCommission implements SearchFilterInterface
{
    public function getFilter(): string
    {
        return 'search[filter_enum_commission][0]=1';
    }
}
