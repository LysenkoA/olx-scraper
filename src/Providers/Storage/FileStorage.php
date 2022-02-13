<?php

namespace OlxScraper\Providers\Storage;

use OlxScraper\Logging\LoggerInterface;
use OlxScraper\Providers\ProviderInterface;
use OlxScraper\Providers\ResultCollection;

class FileStorage implements ProviderInterface
{
    public function __construct(
        private string $filePath
    ) {
    }

    public function setLogger(LoggerInterface $logger): static
    {
        return $this;
    }

    public function getData(): ResultCollection
    {
        return new ResultCollection(
            [
                file_get_contents($this->filePath)
            ]
        );
    }
}
