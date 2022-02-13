<?php

namespace OlxScraper\Endpoints\Interfaces;

interface LocationInterface
{
    public const KEY = ':location';

    public function getPath(): string;
}