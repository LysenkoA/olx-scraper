<?php

namespace OlxScraper\Endpoints\Interfaces;

interface NumberOfRoomsInterface
{
    public const KEY = ':number-of-rooms';

    public function getPath(): string;
}
