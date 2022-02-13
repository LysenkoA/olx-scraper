<?php

namespace OlxScraper\Endpoints\Interfaces;

interface EndpointInterface
{
    public function setLocation(LocationInterface $location): static;
    public function getUrl(): string;
    public function getAvailableSearchFilters(): array;
}
