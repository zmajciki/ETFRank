<?php


namespace ETFRank\CandidateBundle\Crawler;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Subscriber\Retry\RetrySubscriber;
use GuzzleHttp\Exception\RequestException;
use ETFRank\CandidateBundle\Crawler\Util\Crawler;

/**
 * Spider used to crawl Impact Guns website.
 */
abstract class AbstractCrawler implements CrawlerInterface
{
    private $client;

    /**
     * Constructor
     *
     * @param array $requestOptions Additional options for client
     */
    public function __construct(array $requestOptions = array())
    {
        // create client
        $defaultOptions = array(
            'timeout' => 10,
            'connect_timeout' => 5,
        );
        $options = array_merge($defaultOptions, $requestOptions);
        $this->client = new GuzzleClient(array('defaults' => $options));

        // retry subscriber
        $retry = new RetrySubscriber(array(
                'filter' => RetrySubscriber::createChainFilter(array(
                        RetrySubscriber::createCurlFilter(),
                        RetrySubscriber::createStatusFilter(),
                    )),
            ));
        $this->client->getEmitter()->attach($retry);
    }

    /**
     * Return client object.
     *
     * @return GuzzleClient
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param string $url
     * @param string $method
     *
     * @return Crawler
     */
    protected function getCrawler($url, $method = 'get')
    {
        try {
            /** @var \GuzzleHttp\Message\ResponseInterface $response */
            $response = $this->client->$method($url);
            return new Crawler((string) $response->getBody(), $response->getEffectiveUrl());
        } catch (RequestException $e) {
            return new Crawler(null, $url);
        }
    }
}
