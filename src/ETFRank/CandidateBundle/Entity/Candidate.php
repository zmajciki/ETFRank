<?php

namespace ETFRank\CandidateBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Candidate
 *
 * @ORM\Table("candidate")
 * @ORM\Entity
 */
class Candidate
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
     * @ORM\ManyToOne(targetEntity="CandidateGroup", inversedBy="candidates")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    private $group;

    /**
     * @var integer
     *
     * @ORM\Column(name="personal_id", type="integer", nullable=true)
     */
    private $personalId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=150, nullable=true)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="parent_name", type="string", length=80, nullable=true)
     * @Assert\NotBlank()
     */
    private $parentName;

    /**
     * @var string
     *
     * @ORM\Column(name="high_school", type="string", length=250, nullable=true)
     * @Assert\NotBlank()
     */
    private $highSchool;

    /**
     * @var string
     *
     * @ORM\Column(name="high_school_score", type="decimal", scale=2, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Type("numeric")
     * @Assert\Range(min="0", max="40")
     */
    private $highSchoolScore;

    /**
     * @var boolean
     *
     * @ORM\Column(name="award_mathematics", type="boolean", nullable=true)
     */
    private $awardMathematics;

    /**
     * @var boolean
     *
     * @ORM\Column(name="award_physics", type="boolean", nullable=true)
     */
    private $awardPhysics;

    /**
     * @var boolean
     *
     * @ORM\Column(name="award_informatics", type="boolean", nullable=true)
     */
    private $awardInformatics;

    /**
     * @var boolean
     *
     * @ORM\Column(name="subscribed_for_mathematics", type="boolean", nullable=true)
     */
    private $subscribedForMathematics;

    /**
     * @var boolean
     *
     * @ORM\Column(name="subscribed_for_physics", type="boolean", nullable=true)
     */
    private $subscribedForPhysics;

    /**
     * @var string
     *
     * @ORM\Column(name="entrance_exam_mathematics", type="decimal", scale=2, nullable=true)
     * @Assert\Type("numeric")
     * @Assert\Range(min="0", max="100")
     */
    private $entranceExamMathematics;

    /**
     * @var string
     *
     * @ORM\Column(name="entrance_exam_physics", type="decimal", scale=2, nullable=true)
     * @Assert\Type("numeric")
     * @Assert\Range(min="0", max="100")
     */
    private $entranceExamPhysics;

    /**
     * @var int
     *
     * @ORM\Column(name="chosen_field_of_study", type="smallint", nullable=true)
     * @Assert\NotBlank()
     */
    private $chosenFieldOfStudy;

    const FIELD_OF_STUDY_ER = 1;
    const FIELD_OF_STUDY_SI = 2;

    /**
     * @var boolean
     *
     * @ORM\Column(name="confirmed", type="boolean")
     */
    private $confirmed = false;

    /**
     * @var DesiredFieldOfStudy
     *
     * @ORM\OneToOne(targetEntity="DesiredFieldOfStudy", mappedBy="candidate")
     **/
    private $desiredFieldOfStudy;

    /**
     * @var DesiredDepartment
     *
     * @ORM\OneToOne(targetEntity="DesiredDepartment", mappedBy="candidate")
     **/
    private $desiredDepartment;

    /**
     * @var CandidateRank
     *
     * @ORM\OneToOne(targetEntity="CandidateRank", mappedBy="candidate")
     **/
    private $rank;


    /**
     * Get id
     *
     * @return integer
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
     * @return int
     */
    public function getPersonalId()
    {
        return $this->personalId;
    }

    /**
     * @param int $personalId
     *
     * @return self
     */
    public function setPersonalId($personalId)
    {
        $this->personalId = $personalId;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
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
     * Get parentName
     *
     * @return string
     */
    public function getParentName()
    {
        return $this->parentName;
    }

    /**
     * Set parentName
     *
     * @param string $parentName
     *
     * @return self
     */
    public function setParentName($parentName)
    {
        $this->parentName = $parentName;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isAwardInformatics()
    {
        return $this->awardInformatics;
    }

    /**
     * @param boolean $awardInformatics
     *
     * @return self
     */
    public function setAwardInformatics($awardInformatics)
    {
        $this->awardInformatics = $awardInformatics;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isAwardMathematics()
    {
        return $this->awardMathematics;
    }

    /**
     * @param boolean $awardMathematics
     *
     * @return self
     */
    public function setAwardMathematics($awardMathematics)
    {
        $this->awardMathematics = $awardMathematics;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isAwardPhysics()
    {
        return $this->awardPhysics;
    }

    /**
     * @param boolean $awardPhysics
     *
     * @return self
     */
    public function setAwardPhysics($awardPhysics)
    {
        $this->awardPhysics = $awardPhysics;

        return $this;
    }

    public function getAwards()
    {
        $awards = array();
        if ($this->isAwardMathematics()) {
            $awards[] = 'Mathematics';
        }
        if ($this->isAwardPhysics()) {
            $awards[] = 'Physics';
        }
        if ($this->isAwardInformatics()) {
            $awards[] = 'Informatics';
        }

        return implode(', ', $awards);
    }

    /**
     * @return int
     */
    public function getChosenFieldOfStudy()
    {
        return $this->chosenFieldOfStudy;
    }

    /**
     * @param int $chosenFieldOfStudy
     *
     * @return self
     */
    public function setChosenFieldOfStudy($chosenFieldOfStudy)
    {
        $this->chosenFieldOfStudy = $chosenFieldOfStudy;

        return $this;
    }

    static public function getFieldsOfStudy()
    {
        return array(
            self::FIELD_OF_STUDY_ER => 'ER',
            self::FIELD_OF_STUDY_SI => 'SI',
        );
    }

    public function getHumanReadableChosenFieldOfStudy()
    {
        if (isset($this->getFieldsOfStudy()[$this->chosenFieldOfStudy])) {
            return $this->getFieldsOfStudy()[$this->chosenFieldOfStudy];
        } else {
            return '';
        }
    }

    /**
     * @return boolean
     */
    public function isConfirmed()
    {
        return $this->confirmed;
    }

    /**
     * @param boolean $confirmed
     *
     * @return self
     */
    public function setConfirmed($confirmed)
    {
        $this->confirmed = $confirmed;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isSubscribedForMathematics()
    {
        return $this->subscribedForMathematics;
    }

    /**
     * @param boolean $subscribedForMathematics
     *
     * @return self
     */
    public function setSubscribedForMathematics($subscribedForMathematics)
    {
        $this->subscribedForMathematics = $subscribedForMathematics;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isSubscribedForPhysics()
    {
        return $this->subscribedForPhysics;
    }

    /**
     * @param boolean $subscribedForPhysics
     *
     * @return self
     */
    public function setSubscribedForPhysics($subscribedForPhysics)
    {
        $this->subscribedForPhysics = $subscribedForPhysics;

        return $this;
    }

    /**
     * @return string
     */
    public function getEntranceExamMathematics()
    {
        return $this->entranceExamMathematics;
    }

    /**
     * @param string $entranceExamMathematics
     *
     * @return self
     */
    public function setEntranceExamMathematics($entranceExamMathematics)
    {
        $this->entranceExamMathematics = $entranceExamMathematics;

        return $this;
    }

    /**
     * @return string
     */
    public function getEntranceExamPhysics()
    {
        return $this->entranceExamPhysics;
    }

    /**
     * @param string $entranceExamPhysics
     *
     * @return self
     */
    public function setEntranceExamPhysics($entranceExamPhysics)
    {
        $this->entranceExamPhysics = $entranceExamPhysics;

        return $this;
    }

    /**
     * @return string
     */
    public function getHighSchool()
    {
        return $this->highSchool;
    }

    /**
     * @param string $highSchool
     *
     * @return self
     */
    public function setHighSchool($highSchool)
    {
        $this->highSchool = $highSchool;

        return $this;
    }

    /**
     * @return string
     */
    public function getHighSchoolScore()
    {
        return $this->highSchoolScore;
    }

    /**
     * @param string $highSchoolScore
     *
     * @return self
     */
    public function setHighSchoolScore($highSchoolScore)
    {
        $this->highSchoolScore = $highSchoolScore;

        return $this;
    }

    /**
     * @return DesiredDepartment
     */
    public function getDesiredDepartment()
    {
        return $this->desiredDepartment;
    }

    /**
     * @param DesiredDepartment $desiredDepartment
     *
     * @return self
     */
    public function setDesiredDepartment(DesiredDepartment $desiredDepartment)
    {
        $this->desiredDepartment = $desiredDepartment;
        $desiredDepartment->setCandidate($this);

        return $this;
    }

    /**
     * @return DesiredFieldOfStudy
     */
    public function getDesiredFieldOfStudy()
    {
        return $this->desiredFieldOfStudy;
    }

    /**
     * @param DesiredFieldOfStudy $desiredFieldOfStudy
     *
     * @return self
     */
    public function setDesiredFieldOfStudy(DesiredFieldOfStudy $desiredFieldOfStudy)
    {
        $this->desiredFieldOfStudy = $desiredFieldOfStudy;
        $desiredFieldOfStudy->setCandidate($this);

        return $this;
    }

    /**
     * @return CandidateRank
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * @param CandidateRank $rank
     *
     * @return self
     */
    public function setRank(CandidateRank $rank)
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * Calculate score for ER
     *
     * @return double
     */
    public function getERScore()
    {
        return (double)($this->highSchoolScore) + max(
            (double)$this->entranceExamMathematics * 0.6,
            (double)$this->entranceExamPhysics * 0.6,
            60 * (int)$this->awardMathematics,
            60 * (int)$this->awardPhysics
        );
    }

    /**
     * Calculate score for SI
     *
     * @return float
     */
    public function getSIScore()
    {
        return (double)($this->highSchoolScore) + max(
            (double)$this->entranceExamMathematics * 0.6,
            60 * (int)$this->awardMathematics,
            60 * (int)$this->awardInformatics
        );
    }

    public function isERChosen()
    {
        return $this->chosenFieldOfStudy == self::FIELD_OF_STUDY_ER;
    }

    public function isSIChosen()
    {
        return $this->chosenFieldOfStudy == self::FIELD_OF_STUDY_SI;
    }

    public function __toString()
    {
        return spl_object_hash($this);
    }
}
