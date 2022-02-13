<?php

namespace OlxScraper\Endpoints\SearchFilter;

use OlxScraper\Endpoints\Interfaces\SearchFilterInterface;

class ApartmentType implements SearchFilterInterface
{
    public const TYPE_TSARSKYI = 1;
    public const TYPE_STALINKA = 2;
    public const TYPE_HRUSCHOVKA = 3;
    public const TYPE_CHESHKA = 4;
    public const TYPE_GOSTYNKA = 5;
    public const TYPE_SOVMIN = 6;
    public const TYPE_GURTOZHYTOK = 7;
    public const TYPE_80_90_TI = 8;
    public const TYPE_91_2000_I = 9;
    public const TYPE_2001_2010_I = 10;
    public const TYPE_VID_2010 = 11;

    public function __construct(
        private int $type
    ) {
    }

    public function getFilter(): string
    {
        return "search[filter_enum_property_type_appartments_sale][0]={$this->type}";
    }
}
