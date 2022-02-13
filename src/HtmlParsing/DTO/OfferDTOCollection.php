<?php

namespace OlxScraper\HtmlParsing\DTO;

class OfferDTOCollection implements \Iterator
{
    private int $position = 0;
    private array $items = [];

    public function add(OfferDTO $offerDTO): void
    {
        $this->items[] = $offerDTO;
    }

    public function current(): OfferDTO
    {
        return $this->items[$this->position];
    }

    public function next(): void
    {
        ++$this->position;
    }

    public function key(): int
    {
        return $this->position;
    }

    public function valid(): bool
    {
        return isset($this->items[$this->position]);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }
}