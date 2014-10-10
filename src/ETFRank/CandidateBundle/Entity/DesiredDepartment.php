<?php

namespace ETFRank\CandidateBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DesiredDepartment
 *
 * @ORM\Table("desired_department")
 * @ORM\Entity
 */
class DesiredDepartment
{
    /**
     * @var Candidate
     *
     * @ORM\Id
     * @ORM\OneToOne(targetEntity="Candidate", inversedBy="desiredDepartment")
     * @ORM\JoinColumn(name="candidate_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $candidate;

    /**
     * @var integer
     *
     * @ORM\Column(name="OE", type="smallint")
     */
    private $OE;

    /**
     * @var integer
     *
     * @ORM\Column(name="OG", type="smallint")
     */
    private $OG;

    /**
     * @var integer
     *
     * @ORM\Column(name="IR", type="smallint")
     */
    private $IR;

    /**
     * @var integer
     *
     * @ORM\Column(name="OS", type="smallint")
     */
    private $OS;

    /**
     * @var integer
     *
     * @ORM\Column(name="OT", type="smallint")
     */
    private $OT;

    /**
     * @var integer
     *
     * @ORM\Column(name="OF", type="smallint")
     */
    private $OF;


    /**
     * @param Candidate $candidate
     *
     * @return DesiredDepartment
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
     * Set OE
     *
     * @param integer $OE
     *
     * @return DesiredDepartment
     */
    public function setOE($OE)
    {
        $this->OE = $OE;

        return $this;
    }

    /**
     * Get OE
     *
     * @return integer
     */
    public function getOE()
    {
        return $this->OE;
    }

    /**
     * Set OG
     *
     * @param integer $OG
     *
     * @return DesiredDepartment
     */
    public function setOG($OG)
    {
        $this->OG = $OG;

        return $this;
    }

    /**
     * Get OG
     *
     * @return integer
     */
    public function getOG()
    {
        return $this->OG;
    }

    /**
     * Set IR
     *
     * @param integer $IR
     *
     * @return DesiredDepartment
     */
    public function setIR($IR)
    {
        $this->IR = $IR;

        return $this;
    }

    /**
     * Get IR
     *
     * @return integer
     */
    public function getIR()
    {
        return $this->IR;
    }

    /**
     * Set OS
     *
     * @param integer $OS
     *
     * @return DesiredDepartment
     */
    public function setOS($OS)
    {
        $this->OS = $OS;

        return $this;
    }

    /**
     * Get OS
     *
     * @return integer
     */
    public function getOS()
    {
        return $this->OS;
    }

    /**
     * Set OT
     *
     * @param integer $OT
     *
     * @return DesiredDepartment
     */
    public function setOT($OT)
    {
        $this->OT = $OT;

        return $this;
    }

    /**
     * Get OT
     *
     * @return integer
     */
    public function getOT()
    {
        return $this->OT;
    }

    /**
     * Set OF
     *
     * @param integer $OF
     *
     * @return DesiredDepartment
     */
    public function setOF($OF)
    {
        $this->OF = $OF;

        return $this;
    }

    /**
     * Get OF
     *
     * @return integer
     */
    public function getOF()
    {
        return $this->OF;
    }
}
