<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RegularPostRepository")
 */
class RegularPost extends Post
{
    /**
     * @ORM\OneToMany(targetEntity="Tag", mappedBy="post", cascade={"persist"}, orphanRemoval=true)
     * @Assert\Count(max="3")
     * @Assert\Valid
     */
    protected $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    /**
     * @param Tag $tag
     * @return Post
     */
    public function addTag(Tag $tag)
    {
        $this->tags[] = $tag->setPost($this);

        return $this;
    }

    /**
     * @param Tag $tag
     */
    public function removeTag(Tag $tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * @return ArrayCollection|Tag[]
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @return string
     */
    public function getPostType()
    {
        return self::TYPE_REGULAR;
    }
}
