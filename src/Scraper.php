<?php

namespace OlxScraper;

use OlxScraper\Entities\OfferCollection;
use OlxScraper\Factories\OfferFactory;
use OlxScraper\HtmlParsing\Parsers\OfferListParserInterface;
use OlxScraper\Logging\LoggerInterface;
use OlxScraper\Logging\NullLogger;
use OlxScraper\Providers\ProviderInterface;

class Scraper
{
    private OfferCollection $offerCollection;
    private LoggerInterface $logger;
    private OfferFactory $offerFactory;

    public function __construct(
        private ProviderInterface $provider,
        private OfferListParserInterface $offerListParser,
        LoggerInterface $logger = null,
    ) {
        $this->offerCollection = new OfferCollection();
        $this->logger = $logger ?? new NullLogger();
        $this->provider->setLogger($this->logger);
        $this->offerFactory = new OfferFactory();
    }

    public function run(): void
    {
        $this->logger->log(' ========== Start ============');

        $this->offerListParser->setAfterFailCallback(
            function($exception) {
                $this->logger->log("---- Failed to fetch offer: {$exception->getMessage()}");
            }
        );

        $resultCollection = $this->provider->getData();
        foreach ($resultCollection as $result) {
            $offers = $this->offerListParser->setData($result)->parse()->getOffers();

            foreach ($offers as $offerDTO) {
                $this->offerCollection->addOffer(
                    $this->offerFactory->makeFromOfferDTO($offerDTO)
                );
            }
        }

        $this->logger->log(' ========== Finish ============');
    }

    public function getOfferCollection(): OfferCollection
    {
        return $this->offerCollection;
    }
}
