<?php

namespace OlxScraper\HtmlParsing\Parsers\DOMDocument;

use DOMDocument;

class DomDocumentProvider
{
    private DOMDocument $dom;

    public function __construct()
    {
        $this->dom = new DOMDocument('1.0', 'UTF-8');
    }

    public function loadHtml(string $htmlData): self
    {
        // set error level
        $internalErrors = libxml_use_internal_errors(true);
        $this->dom->loadHTML($htmlData);
        // Restore error level
        libxml_use_internal_errors($internalErrors);

        return $this;
    }

    public function getInstance(): DOMDocument
    {
        return $this->dom;
    }
}
