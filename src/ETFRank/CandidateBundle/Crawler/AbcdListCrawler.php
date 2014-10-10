<?php

namespace ETFRank\CandidateBundle\Crawler;

use ETFRank\CandidateBundle\Crawler\Util\Crawler;
use ETFRank\CandidateBundle\Entity\Candidate;
use ETFRank\CandidateBundle\Entity\CandidateGroup;

class AbcdListCrawler extends AbstractCrawler implements CrawlerInterface
{
    public $url = 'http://prijemni.etf.bg.ac.rs/liste/abcd.php';

    public function crawl(CandidateGroup $group)
    {
        $candidates = array();
        for ($i = 0; $i < 30; $i++) {
            $page = $this->getCrawler("{$this->url}?startid={$i}");

            $rows = $page->filter('#content .table tr:not(.listHeader)');
            foreach ($rows as $row) {
                $c = $this->parseRow(new Crawler($row));
                $c->setGroup($group);
                $c->setConfirmed(true);
                $candidates[] = $c;
            }
        }

        return $candidates;
    }

    /**
     * @param Crawler $row
     *
     * @return Candidate
     */
    private function parseRow(Crawler $row)
    {
        $c = new Candidate();
        $c->setPersonalId($row->filter('td:nth-child(1)')->textOrNull());
        $c->setName($row->filter('td:nth-child(2) a')->textOrNull());
        $c->setParentName($row->filter('td:nth-child(3)')->textOrNull());
        $c->setHighSchoolScore($row->filter('td:nth-child(9)')->textOrNull());
        $c->setChosenFieldOfStudy($row->filter('td:nth-child(4)')->textOrNull() == 'ЕР' ? Candidate::FIELD_OF_STUDY_ER : Candidate::FIELD_OF_STUDY_SI);

        return $c;
    }
}
