<?php

namespace OlxScraper\HtmlParsing\Parsers\DOMDocument;

use DOMDocument;
use DOMElement;
use OlxScraper\Exceptions\ParsingException;
use OlxScraper\HtmlParsing\DTO\OfferDTO;
use OlxScraper\HtmlParsing\DTO\OfferDTOCollection;
use OlxScraper\HtmlParsing\Parsers\OfferListParserInterface;

class DOMDocumentOfferListParser implements OfferListParserInterface
{
    private DomDocumentProvider $domDocumentProvider;
    private OfferDTOCollection $offers;
    private $afterFailCallback = null;

    public function __construct()
    {
        $this->domDocumentProvider = new DomDocumentProvider();
        $this->offers = new OfferDTOCollection();
    }

    public function setData(string $data): static
    {
        $this->domDocumentProvider->loadHtml($data);

        return $this;
    }

    /**
     * @param callable $callback(ParsingException $exception)
     * @return $this
     */
    public function setAfterFailCallback(callable $callback): static
    {
        $this->afterFailCallback = $callback;

        return $this;
    }

    public function parse(): static
    {
        $containerWithOffers = $this->getContainerWithOffers();
        $offers = $containerWithOffers->getElementsByTagName('table');

        /** @var DOMElement $offer */
        foreach ($offers as $offer) {
            try {
                $finder = new DomElementFinder($offer);
                $offerDTO = new OfferDTO();
                $offerDTO->id = $finder->getAttribute('data-id');
                $offerDTO->name = trim($finder->getFirstByTagNames(['h3', 'a'])->textContent);
                $offerDTO->link = $finder->getFirstByTagNames(['h3', 'a'])->getAttribute('href');
                $offerDTO->price = $finder->getFirstTextContentByTagNameAndClass('p', 'price');

                $elements = $finder
                    ->getFirstByTagNameAndClass('td', 'bottom-cell')
                    ->getElementsByTagName('small');
                $locationParts = array_map(
                    fn(string $locationPart) => trim($locationPart),
                    explode(',', trim($elements->item(0)->textContent))
                );
                $offerDTO->city = $locationParts[0] ?? '';
                $offerDTO->district = $locationParts[1] ?? '';
                $offerDTO->date = trim($elements->item(1)->textContent);
                $this->offers->add($offerDTO);
            } catch (ParsingException $exception) {
                if (is_callable($this->afterFailCallback)) {
                    call_user_func($this->afterFailCallback, $exception);
                }
            }
        }

        return $this;
    }

    /**
     * @returns array|OfferDTO[]
     */
    public function getOffers(): OfferDTOCollection
    {
        return $this->offers;
    }

    /**
     * @return DOMElement
     * @throws ParsingException
     */
    private function getContainerWithOffers(): DOMElement
    {
        $offersTable = $this->domDocumentProvider->getInstance()->getElementById('offers_table');
        if (!$offersTable) {
            throw new ParsingException("Element with id #offers_table not found");
        }

        return $offersTable;
    }
}