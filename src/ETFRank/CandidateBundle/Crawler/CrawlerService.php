<?php

namespace ETFRank\CandidateBundle\Crawler;

use ETFRank\CandidateBundle\Entity\CandidateGroup;

class CrawlerService
{
    public function getCrawlers()
    {
        return array(
            'simple' => 'ETFRank\CandidateBundle\Crawler\SimpleCrawler',
            'abcd' => 'ETFRank\CandidateBundle\Crawler\AbcdListCrawler',
        );
    }

    /**
     * @param string $crawlerId
     *
     * @return null|CrawlerInterface
     */
    public function getCrawlerInstance($crawlerId)
    {
        $crawler = $this->getCrawlers();
        if (isset($crawler[$crawlerId])) {
            return new $crawler[$crawlerId]();
        } else {
            return null;
        }
    }

    public function crawl(CandidateGroup $group, $crawlerId)
    {
        $crawler = $this->getCrawlerInstance($crawlerId);
        return $crawler->crawl($group);
    }
}
