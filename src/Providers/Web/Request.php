<?php

namespace OlxScraper\Providers\Web;

use OlxScraper\Endpoints\Interfaces\EndpointInterface;
use OlxScraper\Endpoints\SearchFilters;

class Request
{
    public function __construct(
        private EndpointInterface $endpoint,
        private SearchFilters $searchFilters
    ) {
        $this->searchFilters = $searchFilters->filter($endpoint->getAvailableSearchFilters());
    }

    public function getUrl(): string
    {
        $url = $this->endpoint->getUrl();
        if (!$this->searchFilters->empty()) {
            $url .= "?" . $this->searchFilters->implode();
        }

        return $url;
    }
}
