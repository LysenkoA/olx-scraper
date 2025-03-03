<?php

namespace OlxScraper\HtmlParsing\Parsers;

use OlxScraper\HtmlParsing\DTO\OfferDTOCollection;

interface OfferListParserInterface
{
    public function setData(string $data): static;
    public function setAfterFailCallback(callable $callback): static;
    public function parse(): static;
    public function getOffers(): OfferDTOCollection;
}
