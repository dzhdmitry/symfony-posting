<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table
 * @ORM\Entity
 */
class AuthorPostDetails
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull
     */
    protected $authorName;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotNull
     * @Assert\Url
     */
    protected $url;

    /**
     * @ORM\OneToOne(targetEntity="AuthorPost", inversedBy="authorPostDetails")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $authorPost;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $authorName
     * @return AuthorPostDetails
     */
    public function setAuthorName($authorName)
    {
        $this->authorName = $authorName;

        return $this;
    }

    /**
     * @return string
     */
    public function getAuthorName()
    {
        return $this->authorName;
    }

    /**
     * @param string $url
     * @return AuthorPostDetails
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param AuthorPost $authorPost
     * @return AuthorPostDetails
     */
    public function setAuthorPost(AuthorPost $authorPost)
    {
        $this->authorPost = $authorPost;

        return $this;
    }

    /**
     * @return AuthorPost
     */
    public function getAuthorPost()
    {
        return $this->authorPost;
    }
}
