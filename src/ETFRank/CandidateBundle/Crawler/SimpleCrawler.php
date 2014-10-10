<?php

namespace ETFRank\CandidateBundle\Crawler;

use ETFRank\CandidateBundle\Entity\Candidate;
use ETFRank\CandidateBundle\Entity\CandidateGroup;

class SimpleCrawler implements CrawlerInterface
{
    const candidateNumber = 250;

    public function crawl(CandidateGroup $group)
    {
        $candidates = array();
        for ($i = 0; $i < self::candidateNumber; $i++) {
            $c = new Candidate();
            $c->setGroup($group);
            $c->setName($this->randomString());
            $c->setParentName($this->randomString());
            $c->setHighSchool($this->randomString());
            $c->setHighSchoolScore($this->randomDecimal(0, 40));
            $c->setAwardMathematics(!(bool)rand(0,50));
            $c->setAwardPhysics(!(bool)rand(0,50));
            $c->setAwardInformatics(!(bool)rand(0,50));
            $c->setChosenFieldOfStudy(rand(1,2));
            $c->setEntranceExamMathematics($this->randomDecimal(0, 40));
            $c->setEntranceExamPhysics($this->randomDecimal(0, 40));
            $candidates[] = $c;
        }

        return $candidates;
    }

    private function randomString($min = 5, $max = 20)
    {
        $length = rand($min, $max);
        $randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);

        return $randomString;
    }

    private function randomDecimal($min, $max, $scale = 2)
    {
        $n = pow(10, $scale);
        $num = rand($min * $n, $max * $n);
        $decimal = number_format($num / $n, $scale);

        return $decimal;
    }
}
