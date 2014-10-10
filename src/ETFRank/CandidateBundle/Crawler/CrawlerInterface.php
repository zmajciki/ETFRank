<?php

namespace ETFRank\CandidateBundle\Crawler;

use ETFRank\CandidateBundle\Entity\CandidateGroup;

interface CrawlerInterface
{
    public function crawl(CandidateGroup $group);
}
