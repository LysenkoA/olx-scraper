<?php

namespace OlxScraper\Endpoints;

use OlxScraper\Endpoints\Interfaces\SearchFilterInterface;

class SearchFilters
{
    /**
     * @var SearchFilterInterface[]
     */
    private array $searchFilters = [];

    public function __construct(array $searchFilters = [])
    {
        foreach ($searchFilters as $searchFilter) {
            if ($searchFilter instanceof SearchFilterInterface) {
                $this->searchFilters[] = $searchFilter;
            }
        }
    }

    public function addSearchFilter(SearchFilterInterface $searchFilter): self
    {
        $this->searchFilters[] = $searchFilter;

        return $this;
    }

    public function filter(array $listOfAvailableFilters): self
    {
        $this->searchFilters = array_filter(
            $this->searchFilters,
            function (SearchFilterInterface $searchFilter) use ($listOfAvailableFilters) {
                foreach ($listOfAvailableFilters as $availableFilter) {
                    if ($availableFilter === $searchFilter::class) {
                        return true;
                    }
                }
                return false;
            }
        );

        return $this;
    }

    /**
     * @return SearchFilterInterface[]
     */
    public function getFilters(): array
    {
        return $this->searchFilters;
    }

    public function count(): int
    {
        return count($this->searchFilters);
    }

    public function empty(): bool
    {
        return $this->count() === 0;
    }

    public function implode(string $separator = '&'): string
    {
        $filters = array_map(static function(SearchFilterInterface $searchFilter) {
            return $searchFilter->getFilter();
        }, $this->searchFilters);

        return implode($separator, $filters);
    }

    public function getClone(): SearchFilters
    {
        return clone $this;
    }
}