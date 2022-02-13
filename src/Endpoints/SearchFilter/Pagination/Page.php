<?php

namespace OlxScraper\Endpoints\SearchFilter\Pagination;

use OlxScraper\Endpoints\Interfaces\SearchFilterInterface;

class Page implements SearchFilterInterface
{
    public function __construct(
        private int $page
    ) {
    }

    public function getFilter(): string
    {
        return "page={$this->page}";
    }
}
