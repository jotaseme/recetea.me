<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Steps
 *
 * @ORM\Table(name="steps")
 * @ORM\Entity
 */
class Steps
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_step", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idStep;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="step_order", type="integer", nullable=true)
     */
    private $stepOrder;



    /**
     * Get idStep
     *
     * @return integer
     */
    public function getIdStep()
    {
        return $this->idStep;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Steps
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set stepOrder
     *
     * @param integer $stepOrder
     *
     * @return Steps
     */
    public function setStepOrder($stepOrder)
    {
        $this->stepOrder = $stepOrder;

        return $this;
    }

    /**
     * Get stepOrder
     *
     * @return integer
     */
    public function getStepOrder()
    {
        return $this->stepOrder;
    }
}
