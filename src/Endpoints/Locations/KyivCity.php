<?php

namespace OlxScraper\Endpoints\Locations;

use OlxScraper\Endpoints\Interfaces\LocationInterface;

class KyivCity implements LocationInterface
{
    public function getPath(): string
    {
        return 'kiev';
    }
}
