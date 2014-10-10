<?php

namespace ETFRank\CandidateBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Candidate
 *
 * @ORM\Table("candidate_rank")
 * @ORM\Entity
 */
class CandidateRank
{
    /**
     * @var Candidate
     *
     * @ORM\Id
     * @ORM\OneToOne(targetEntity="Candidate", inversedBy="rank")
     * @ORM\JoinColumn(name="candidate_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $candidate;

    /**
     * @var RankList
     *
     * @ORM\Id
     * @ORM\OneToOne(targetEntity="RankList")
     * @ORM\JoinColumn(name="rank_list_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $rankList;

    /**
     * @var int
     *
     * @ORM\Column(name="rank", type="integer")
     * @Assert\NotBlank()
     * @Assert\Type("integer")
     */
    private $rank;

    public function __construct($candidate = null, $rank = null, $rankList = null)
    {
        $this->rank = $rank;
        $this->candidate = $candidate;
        $this->rankList = $rankList;
    }

    /**
     * @return Candidate
     */
    public function getCandidate()
    {
        return $this->candidate;
    }

    /**
     * @param Candidate $candidate
     *
     * @return self
     */
    public function setCandidate(Candidate $candidate)
    {
        $this->candidate = $candidate;

        return $this;
    }

    /**
     * @return int
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * @param int $rank
     *
     * @return self
     */
    public function setRank($rank)
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * @return RankList
     */
    public function getRankList()
    {
        return $this->rankList;
    }

    /**
     * @param RankList $rankList
     *
     * @return self
     */
    public function setRankList(RankList $rankList)
    {
        $this->rankList = $rankList;

        return $this;
    }
}
