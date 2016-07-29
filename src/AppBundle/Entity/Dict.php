<?php
/**
 * Created by PhpStorm.
 * User: gcorn
 * Date: 7/28/16
 * Time: 3:17 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="dict")
 */

class Dict
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $ru;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $en;


    /**
     * Set ru
     *
     * @param string $ru
     *
     * @return Dict
     */
    public function setRu($ru)
    {
        $this->ru = $ru;

        return $this;
    }

    /**
     * Get ru
     *
     * @return string
     */
    public function getRu()
    {
        return $this->ru;
    }

    /**
     * Set en
     *
     * @param string $en
     *
     * @return Dict
     */
    public function setEn($en)
    {
        $this->en = $en;

        return $this;
    }

    /**
     * Get en
     *
     * @return string
     */
    public function getEn()
    {
        return $this->en;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
