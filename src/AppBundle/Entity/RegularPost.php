<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RegularPostRepository")
 */
class RegularPost extends Post
{
    /**
     * @ORM\OneToMany(targetEntity="Tag", mappedBy="post", cascade={"persist"}, orphanRemoval=true)
     * @Assert\Count(max="3")
     */
    protected $tags;

    public function __construct()
    {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add tag
     *
     * @param Tag $tag
     * @return Post
     */
    public function addTag(Tag $tag)
    {
        $this->tags[] = $tag->setPost($this);

        return $this;
    }

    /**
     * Remove tag
     *
     * @param Tag $tag
     */
    public function removeTag(Tag $tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    public function getPostType()
    {
        return $this::TYPE_REGULAR;
    }
}
