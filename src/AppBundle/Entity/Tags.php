<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
/**
 * Tags
 *
 * @ORM\Table(name="tags")
 * @ORM\Entity
 */
class Tags
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_tag", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups({"recipe_detail","tags_list"})
     *
     */
    private $idTag;

    /**
     * @var string
     *
     * @ORM\Column(name="tag", type="string", length=100, nullable=true)
     * @Groups({"recipe_detail", "tags_list"})
     */
    private $tag;

    /**
     * Get idTag
     *
     * @return integer
     */
    public function getIdTag()
    {
        return $this->idTag;
    }

    /**
     * Set tag
     *
     * @param string $tag
     *
     * @return Tags
     */
    public function setTag($tag)
    {
        $this->tag= $tag;

        return $this;
    }

    /**
     * Get tag
     *
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }
}
