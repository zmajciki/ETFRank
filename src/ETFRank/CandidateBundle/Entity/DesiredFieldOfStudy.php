<?php

namespace ETFRank\CandidateBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DesiredFieldOfStudy
 *
 * @ORM\Table("desired_field_of_study")
 * @ORM\Entity
 */
class DesiredFieldOfStudy
{
    /**
     * @var Candidate
     *
     * @ORM\Id
     * @ORM\OneToOne(targetEntity="Candidate", inversedBy="desiredFieldOfStudy")
     * @ORM\JoinColumn(name="candidate_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $candidate;

    /**
     * @var integer
     *
     * @ORM\Column(name="ergf", type="smallint")
     */
    private $ergf;

    /**
     * @var integer
     *
     * @ORM\Column(name="ersf", type="smallint")
     */
    private $ersf;

    /**
     * @var integer
     *
     * @ORM\Column(name="sigf", type="smallint")
     */
    private $sigf;

    /**
     * @var integer
     *
     * @ORM\Column(name="sisf", type="smallint")
     */
    private $sisf;


    /**
     * @param Candidate $candidate
     * @return DesiredFieldOfStudy
     */
    public function setCandidate($candidate)
    {
        $this->candidate = $candidate;

        return $this;
    }

    /**
     * @return Candidate
     */
    public function getCandidate()
    {
        return $this->candidate;
    }

    /**
     * @param integer $ergf
     * @return DesiredFieldOfStudy
     */
    public function setERGF($ergf)
    {
        $this->ergf = $ergf;

        return $this;
    }

    /**
     * @return integer
     */
    public function getERGF()
    {
        return $this->ergf;
    }

    /**
     * @param integer $ersf
     * @return DesiredFieldOfStudy
     */
    public function setERSF($ersf)
    {
        $this->ersf = $ersf;

        return $this;
    }

    /**
     * @return integer
     */
    public function getERSF()
    {
        return $this->ersf;
    }

    /**
     * @param integer $sigf
     * @return DesiredFieldOfStudy
     */
    public function setSIGF($sigf)
    {
        $this->sigf = $sigf;

        return $this;
    }

    /**
     * @return integer
     */
    public function getSIGF()
    {
        return $this->sigf;
    }

    /**
     * @param integer $sisf
     * @return DesiredFieldOfStudy
     */
    public function setSISF($sisf)
    {
        $this->sisf = $sisf;

        return $this;
    }

    /**
     * @return integer
     */
    public function getSISF()
    {
        return $this->sisf;
    }
}
