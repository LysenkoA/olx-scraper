<?php

namespace OlxScraper\Logging;

interface LoggerInterface
{
    public function log(string $message): void;
}