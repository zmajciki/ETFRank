<?php

namespace ETFRank\CandidateBundle\Import;

use ETFRank\CandidateBundle\Entity\CandidateGroup;

interface ImporterInterface
{
    public function import(\SplFileObject $file, CandidateGroup $group);
}
