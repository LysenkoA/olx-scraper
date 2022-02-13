<?php

namespace OlxScraper\Logging;

class EchoLogger implements LoggerInterface
{
    public function log(string $message): void
    {
        $output = fopen('php://output', 'w');
        fputs($output, "{$message}\n");
        fclose($output);
    }
}
