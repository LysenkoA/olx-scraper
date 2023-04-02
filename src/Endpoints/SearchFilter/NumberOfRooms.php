<?php

namespace OlxScraper\Endpoints\SearchFilter;

use OlxScraper\Endpoints\Interfaces\SearchFilterInterface;

class NumberOfRooms implements SearchFilterInterface
{
    public const ROOMS_1 = 'odnokomnatnye';
    public const ROOMS_2 = 'dvuhkomnatnye';
    public const ROOMS_3 = 'trehkomnatnye';
    public const ROOMS_4 = 'chetyrehkomnatnye';
    public const ROOMS_5_MORE = 'pyatikomnatnye';

    private const AVAILABLE_VALUES = [
        self::ROOMS_1,
        self::ROOMS_2,
        self::ROOMS_3,
        self::ROOMS_4,
        self::ROOMS_5_MORE,
    ];

    public function __construct(
        private array $rooms
    ) {
        if (count($this->rooms) === 0) {
            throw new \InvalidArgumentException("Rooms can not be empty!");
        }

        foreach ($this->rooms as $room) {
            if (!in_array($room, self::AVAILABLE_VALUES, true)) {
                throw new \InvalidArgumentException("Invalid room valiant - {$room}");
            }
        }
    }

    public function getFilter(): string
    {
        $searchVariants = array_map(function (string $room, int $index) {
            return "search[filter_enum_number_of_rooms_string][{$index}]={$room}";
        }, $this->rooms, array_keys($this->rooms));

        return implode('&', $searchVariants);
    }
}
