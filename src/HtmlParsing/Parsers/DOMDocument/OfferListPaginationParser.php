<?php

namespace OlxScraper\HtmlParsing\Parsers\DOMDocument;

use DOMAttr;
use DOMNode;
use OlxScraper\HtmlParsing\Parsers\OfferListPaginationParserInterface;

class OfferListPaginationParser implements OfferListPaginationParserInterface
{
    private DomDocumentProvider $domDocumentProvider;
    private ?int $lastPage;

    public function __construct()
    {
        $this->domDocumentProvider = new DomDocumentProvider();
    }

    public function setData(string $data): static
    {
        $this->domDocumentProvider->loadHtml($data);

        return $this;
    }

    public function parse(): static
    {
        $formElement = $this->domDocumentProvider->getInstance()->getElementById('pagerGoToPage');
        $inputElements = $formElement->getElementsByTagName('input');
        /** @var DOMNode $inputElement */
        foreach ($inputElements as $inputElement) {
            $hasAttribute = $this->nodeHasAttribute($inputElement, 'type', 'submit');
            if ($hasAttribute) {
                $class = $this->getNodeClass($inputElement);
                $class = trim($class, "{}");
                $class = str_replace('totalPages:', '', $class);
                $this->lastPage = (int) $class;
            }
        }

        return $this;
    }

    public function getPages(): array
    {
        if (!$this->lastPage) {
            return [];
        }

        $pages = [];
        for ($page = 1; $this->lastPage >= $page; $page++) {
            $pages[] = $page;
        }

        return  $pages;
    }

    private function nodeHasAttribute(DOMNode $DOMNode, string $attributeName, string $attributeValue = null): bool
    {
        /** @var DOMAttr $attribute */
        foreach ($DOMNode->attributes as $attribute) {
            if ($attribute->name === $attributeName && $attributeValue === null) {
                return true;
            } else if ($attribute->name === $attributeName && $attributeValue !== null && $attribute->value === $attributeValue) {
                return true;
            }
        }

        return false;
    }

    public function getNodeClass(DOMNode $DOMNode): ?string
    {
        /** @var DOMAttr $attribute */
        foreach ($DOMNode->attributes as $attribute) {
            if ($attribute->name === 'class') {
                return $attribute->value;
            }
        }

        return null;
    }
}
