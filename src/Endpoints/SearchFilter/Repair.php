<?php

namespace OlxScraper\Endpoints\SearchFilter;

use OlxScraper\Endpoints\Interfaces\SearchFilterInterface;

class Repair implements SearchFilterInterface
{
    public const TYPE_AVTORSKYI_REMONT = 1;
    public const TYPE_EVROREMONT = 2;
    public const TYPE_KOSMETYCHNYI_REMONT = 3;
    public const TYPE_ZHYTLOVYI_STAN = 4;
    public const TYPE_PISLYA_BUDIVELNYKIV = 5;
    public const TYPE_PID_CHYSTOVU_OBROBKU = 6;
    public const TYPE_AVARIYNYI_STAN = 7;

    public function __construct(
        private int $repairType
    ) {
    }

    public function getFilter(): string
    {
        return 'search[filter_enum_repair][0]=' . $this->repairType;
    }
}
