<?php

namespace OlxScraper\Providers;

use OlxScraper\Logging\LoggerInterface;

interface ProviderInterface
{
    public function setLogger(LoggerInterface $logger): static;
    public function getData(): ResultCollection;
}
