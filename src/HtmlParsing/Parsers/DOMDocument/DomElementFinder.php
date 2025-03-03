<?php

namespace OlxScraper\HtmlParsing\Parsers\DOMDocument;

use DOMElement;
use DOMNodeList;
use OlxScraper\Exceptions\ParsingException;

class DomElementFinder
{
    public function __construct(
        private DOMElement $element
    ) {}

    public function getFirstByTagNames(array $tagNames): DOMElement
    {
        $element = self::getFirstByTagNameFromElement($this->element, array_shift($tagNames));
        foreach ($tagNames as $tag) {
            $element = self::getFirstByTagNameFromElement($element, $tag);
        }

        return $element;
    }

    public function getFirstByTagName(string $tagName): DOMElement
    {
        return self::getFirstByTagNameFromElement($this->element, $tagName);
    }

    private static function getFirstByTagNameFromElement(DOMElement $element, string $tag): DOMElement
    {
        $element = $element->getElementsByTagName($tag)->item(0);
        if (!$element) {
            throw new ParsingException("Element with tag name {$tag} not found");
        }

        return $element;
    }

    public function getFirstTextContentByTagName(string $tagName): string
    {
        return trim($this->getFirstByTagName($tagName)->textContent);
    }

    public function getFirstByTagNameAndClass(string $tagName, string $className): DOMElement
    {
        $childNodeList = $this->getByTagNameAndClass($tagName, $className);

        if (count($childNodeList) > 0) {
            return $childNodeList[0];
        }

        throw new ParsingException("Element with tag name {$tagName} and class {$className} not found");
    }

    public function getFirstTextContentByTagNameAndClass(string $tagName, string $className): string
    {
        return trim($this->getFirstByTagNameAndClass($tagName, $className)->textContent);
    }

    public function getByTagNameAndClass(string $tagName, string $className): array
    {
        $nodeList = [];
        $childNodeList = $this->element->getElementsByTagName($tagName);

        for ($i = 0; $i < $childNodeList->length; $i++) {
            $nodeWithTagName = $childNodeList->item($i);
            if (stripos($nodeWithTagName->getAttribute('class'), $className) !== false) {
                $nodeList[] = $nodeWithTagName;
            }
        }

        return $nodeList;
    }

    public function getAttribute(string $attribute): string
    {
        return $this->element->getAttribute($attribute);
    }
}
