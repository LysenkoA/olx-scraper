<?php


namespace OlxScraper\HtmlParsing\Parsers;


interface OfferListPaginationParserInterface
{
    public function setData(string $data): static;
    public function parse(): static;
    public function getPages();
}
