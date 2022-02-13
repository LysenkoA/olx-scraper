<?php

namespace OlxScraper\Endpoints\Rooms;

use OlxScraper\Endpoints\Interfaces\NumberOfRoomsInterface;

class NumberOfRooms implements NumberOfRoomsInterface
{
    public function __construct(
        private int $numberIfRooms
    ) {
    }

    public function getPath(): string
    {
        return match ($this->numberIfRooms) {
            1 => '1-komnata',
            2 => '2-komnaty',
            3 => '3-komnaty',
            4 => '4-komnaty',
            5 => '5-komnat',
            default => '',
        };
    }
}
