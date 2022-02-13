

One page

```php

use OlxScraper\Endpoints\FlatRentEndpoint;
use OlxScraper\Endpoints\Locations\KyivCity;
use OlxScraper\Endpoints\SearchFilters;
use OlxScraper\Providers\Web\Request;
use OlxScraper\Providers\Web\Client;
use OlxScraper\HtmlParsing\Parsers\DOMDocument\DOMDocumentOfferListParser;
use OlxScraper\Scraper;

$endPoint = new FlatRentEndpoint();
$endPoint->setLocation(new KyivCity());
$searchFilters = new SearchFilters();
$request = new Request($endPoint, $searchFilters);

$provider = new Client([$request]);
$parser = new DOMDocumentOfferListParser();
$scraper = new Scraper($provider, $parser);
$scraper->run();
$offers = $scraper->getOfferCollection();

```

With pagination

```php

use OlxScraper\Endpoints\FlatRentEndpoint;
use OlxScraper\Endpoints\Locations\KyivCity;
use OlxScraper\Endpoints\SearchFilters;
use OlxScraper\Providers\Web\Client;
use OlxScraper\Providers\Web\Request;
use OlxScraper\HtmlParsing\Parsers\DOMDocument\OfferListPaginationParser;
use OlxScraper\Endpoints\SearchFilter\Pagination\Page;
use OlxScraper\HtmlParsing\Parsers\DOMDocument\DOMDocumentOfferListParser;
use OlxScraper\Scraper;
use OlxScraper\Logging\EchoLogger;

$endPoint = new FlatRentEndpoint();
$endPoint->setLocation(new KyivCity());
$searchFilters = new SearchFilters();

$providerForFirstPage = new Client();
$resultCollection = $providerForFirstPage
    ->addRequest(new Request($endPoint, $searchFilters))
    ->getData();
$offerListPaginationParser = new OfferListPaginationParser();

$pages = $offerListPaginationParser
    ->setData($resultCollection->current())
    ->parse()
    ->getPages();

$requestList = array_map(function (int $pageNumber) use ($endPoint, $searchFilters) {
    $newSearchFilters = $searchFilters->getClone();
    if ($pageNumber > 1) {
        $newSearchFilters->addSearchFilter(new Page($pageNumber));
    }
    return new Request($endPoint, $newSearchFilters);
}, $pages);

$provider = new Client($requestList);
$parser = new DOMDocumentOfferListParser();
$scraper = new Scraper($provider, $parser, new EchoLogger());
$scraper->run();
$offers = $scraper->getOfferCollection();

```

With file storage

```php

use OlxScraper\Providers\Storage\FileStorage;
use OlxScraper\HtmlParsing\Parsers\DOMDocument\DOMDocumentOfferListParser;
use OlxScraper\Scraper;

$provider = new FileStorage('data.log');
$parser = new DOMDocumentOfferListParser();
$parser->setAfterFailCallback(function($exception) {
    // TODO: implement;
});
$scraper = new Scraper($provider, $parser);
$scraper->run();
$offers = $scraper->getOfferCollection();

var_dump($offers);

```