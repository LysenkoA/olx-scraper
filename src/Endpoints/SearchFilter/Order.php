<?php

namespace OlxScraper\Endpoints\SearchFilter;

use OlxScraper\Endpoints\Interfaces\SearchFilterInterface;
/*
 * filter_float_price:desc
 * filter_float_price:asc
 * created_at:desc
 */
class Order implements SearchFilterInterface
{
    public const SORT_PRICE = 'filter_float_price';
    public const SORT_DATE = 'created_at';

    public const ORDER_ASC = 'asc';
    public const ORDER_DESC = 'desc';

    public function __construct(
        private string $sort,
        private string $order = self::ORDER_DESC
    ) {
    }

    public function getFilter(): string
    {
        return "search[order]={$this->sort}:{$this->order}";
    }
}
