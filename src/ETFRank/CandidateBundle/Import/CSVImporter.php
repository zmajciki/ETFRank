<?php

namespace ETFRank\CandidateBundle\Import;

use ETFRank\CandidateBundle\Entity\Candidate;
use ETFRank\CandidateBundle\Entity\CandidateGroup;
use Symfony\Component\PropertyAccess\PropertyAccessor;

class CSVImporter implements ImporterInterface
{
    public function import(\SplFileObject $file, CandidateGroup $group)
    {
        $csvHeader = $file->fgetcsv();
        $accessor = new PropertyAccessor();
        $candidates = array();
        //var_dump($csvHeader);
        while (!$file->eof()) {
            $row = $file->fgetcsv();
            //var_dump($row);
            if (!empty($row)) {
                $candidate = new Candidate();
                $candidate->setGroup($group);
                foreach ($csvHeader as $index => $field) {
                    if ($field == 'chosen_field_of_study') {
                        if ($row[$index] == 'ER') {
                            $row[$index] = Candidate::FIELD_OF_STUDY_ER;
                        } elseif ($row[$index] == 'SI') {
                            $row[$index] = Candidate::FIELD_OF_STUDY_SI;
                        }
                    }
                    $accessor->setValue($candidate, $field, $row[$index]);
                }
                $candidates[] = $candidate;
            }
        }

        return $candidates;
    }
}
