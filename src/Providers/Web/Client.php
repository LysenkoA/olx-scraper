<?php

namespace OlxScraper\Providers\Web;

use OlxScraper\Exceptions\ProviderException;
use OlxScraper\Logging\LoggerInterface;
use OlxScraper\Logging\NullLogger;
use OlxScraper\Providers\ProviderInterface;
use OlxScraper\Providers\ResultCollection;

class Client implements ProviderInterface
{
    private const USERAGENT_LIST = [
        'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36'
    ];

    private LoggerInterface $logger;

    public function __construct(
        private array $requests = []
    ) {
        $this->logger = new NullLogger();
    }

    public function setLogger(LoggerInterface $logger): static
    {
        $this->logger = $logger;

        return $this;
    }

    public function addRequest(Request $request): self
    {
        $this->requests[] = $request;

        return $this;
    }

    /**
     * @throws ProviderException
     */
    public function getData(): ResultCollection
    {
        $result = new ResultCollection();

        foreach ($this->requests as $index => $request) {
            if ($index > 0) {
                usleep(rand(100000, 2000000)); // sleep rand 0,1 sec - 2 sec
            }
            $result->append($this->get($request));
        }

        return $result;
    }

    private function get(Request $request): string
    {
        try {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $request->getUrl(),
                CURLOPT_USERAGENT => array_rand(self::USERAGENT_LIST),
            ));

            $response = (string)curl_exec($curl);
            curl_close($curl);

            $this->logger->log("==> Request `{$request->getUrl()}`");
            if (!$response) {
                $this->logger->log("\t <== Response is empty");
            }

            return $response;
        } catch (\Exception $exception) {
            throw new ProviderException(
                "Failed to fetch data from url {$request->getUrl()}: {$exception->getMessage()}"
            );
        }
    }
}
