<?php

namespace OlxScraper\HtmlParsing\Parsers\DOMDocument;

use DOMElement;
use DOMNodeList;
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
        $offers = $this->getDOMElementsWithOffers();

        /** @var DOMElement $offer */
        foreach ($offers as $offer) {
            try {
                $finder = new DomElementFinder($offer);

                $offerDTO = new OfferDTO();
                $offerDTO->id = $finder->getAttribute('id');
                $offerDTO->name = trim($finder->getFirstByTagName('h4')->textContent);
                $offerDTO->link = $finder->getFirstByTagName('a')->getAttribute('href');
                $offerDTO->price = $this->resolvePrice($offer);

                $locationAndDate = $this->resolveLocationAndDate($offer);

                $offerDTO->city = $locationAndDate['city'];
                $offerDTO->district = $locationAndDate['district'];
                $offerDTO->date = $locationAndDate['date'];
                $offerDTO->previewImgUrl = $this->resolveImageUrl($finder);
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
     * @return array<DOMElement>
     */
    public function getDOMElementsWithOffers(): array
    {
        $elements = $this->domDocumentProvider->getInstance()->getElementsByTagName("div");

        $DOMElementsArray = [];

        foreach ($elements as $element) {
            if ($element->getAttribute("data-cy") === "l-card") {
                $DOMElementsArray[] = $element;
            }
        }

        return $DOMElementsArray;
    }

    private function getFirstByAttributeAndValue(DOMNodeList $childNodes, string $attribute, string $value): ?DOMElement
    {
        foreach ($childNodes as $childElement) {
            if (
                $childElement instanceof DOMElement
                && $childElement->hasAttribute($attribute)
                && $childElement->getAttribute($attribute) === $value
            ) {
                return $childElement;
            }
        }

        return null;
    }

    private function resolvePrice(DOMElement $element): string
    {
        $childNodes = $element->getElementsByTagName('p');
        $element = $this->getFirstByAttributeAndValue($childNodes, 'data-testid', 'ad-price');

        return $element ? trim($element->nodeValue) : '';
    }

    private function resolveLocationAndDate(DOMElement $element): array
    {
        $childNodes = $element->getElementsByTagName('p');
        $element = $this->getFirstByAttributeAndValue($childNodes, 'data-testid', 'location-date');

        $parts = explode('-', $element->textContent);

        $locationParts = $parts[0] ? explode(',', $parts[0]) : '';
        $date = $parts[1] ? trim($parts[1]) : '';

        return [
            'city' => isset($locationParts[0]) ? trim($locationParts[0]) : '',
            'district' => isset($locationParts[1]) ? trim($locationParts[1]) : '',
            'date' => $date,
        ];
    }

    private function resolveImageUrl(DomElementFinder $finder): string
    {
        $defaultImageUrl = $finder->getFirstByTagName('img')->getAttribute('src');
        $imageUrls = $finder->getFirstByTagName('img')->getAttribute('srcset');
        $imageUrlsArray = explode(',', $imageUrls);

        $imageUrl = ($imageUrlsArray && is_array($imageUrlsArray) && count($imageUrlsArray) > 0)
            ? array_pop($imageUrlsArray)
            : null;

        $url = $imageUrl ? trim($imageUrl) : $defaultImageUrl;

        return str_contains($url, 'no_thumbnail') ? '' : $url;
    }
}
