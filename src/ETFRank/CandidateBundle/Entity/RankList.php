<?php

namespace ETFRank\CandidateBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Candidate
 *
 * @ORM\Table("rank_list")
 * @ORM\Entity
 */
class RankList
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var CandidateGroup
     *
     * @ORM\ManyToOne(targetEntity="CandidateGroup")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    private $group;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=150, nullable=true)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="CandidateRank", mappedBy="rankList")
     */
    private $ranks;

    public function __construct($group = null, $name = null)
    {
        $this->ranks = new ArrayCollection();
        $this->group = $group;
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return CandidateGroup
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param CandidateGroup $group
     *
     * @return self
     */
    public function setGroup(CandidateGroup $group)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getRanks()
    {
        return $this->ranks;
    }

    /**
     * @param ArrayCollection $ranks
     *
     * @return self
     */
    public function setRanks(ArrayCollection $ranks = null)
    {
        $this->ranks = $ranks;

        return $this;
    }
}
