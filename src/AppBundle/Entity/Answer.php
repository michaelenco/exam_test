<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Answer
 *
 * @ORM\Table(name="answer")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AnswerRepository")
 */
class Answer
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;

    /**
     * @var int
     *
     * @ORM\Column(name="ru_id", type="integer")
     */
    private $ruId;

    /**
     * @var int
     *
     * @ORM\Column(name="en_id", type="integer")
     */
    private $enId;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="answers")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Dict")
     * @ORM\JoinColumn(name="en_id", referencedColumnName="id")
     */
    private $en;

    /**
     * @ORM\ManyToOne(targetEntity="Dict")
     * @ORM\JoinColumn(name="ru_id", referencedColumnName="id")
     */
    private $ru;

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
     * Set userId
     *
     * @param integer $userId
     *
     * @return Answer
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set ruId
     *
     * @param integer $ruId
     *
     * @return Answer
     */
    public function setRuId($ruId)
    {
        $this->ruId = $ruId;

        return $this;
    }

    /**
     * Get ruId
     *
     * @return integer
     */
    public function getRuId()
    {
        return $this->ruId;
    }

    /**
     * Set enId
     *
     * @param integer $enId
     *
     * @return Answer
     */
    public function setEnId($enId)
    {
        $this->enId = $enId;

        return $this;
    }

    /**
     * Get enId
     *
     * @return integer
     */
    public function getEnId()
    {
        return $this->enId;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Answer
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set en
     *
     * @param \AppBundle\Entity\Dict $en
     *
     * @return Answer
     */
    public function setEn(\AppBundle\Entity\Dict $en = null)
    {
        $this->en = $en;

        return $this;
    }

    /**
     * Get en
     *
     * @return \AppBundle\Entity\Dict
     */
    public function getEn()
    {
        return $this->en;
    }

    /**
     * Set ru
     *
     * @param \AppBundle\Entity\Dict $ru
     *
     * @return Answer
     */
    public function setRu(\AppBundle\Entity\Dict $ru = null)
    {
        $this->ru = $ru;

        return $this;
    }

    /**
     * Get ru
     *
     * @return \AppBundle\Entity\Dict
     */
    public function getRu()
    {
        return $this->ru;
    }
}
