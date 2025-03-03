<?php

namespace OlxScraper\Logging;

class NullLogger implements LoggerInterface
{
    public function log(string $message): void
    {
    }
}
