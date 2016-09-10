<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AuthorPostDetails
 *
 * @ORM\Table(name="author_post_details")
 * @ORM\Entity
 */
class AuthorPostDetails
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="authorName", type="string", length=255)
     */
    protected $authorName;

    /**
     * @ORM\Column(name="url", type="text")
     */
    protected $url;

    /**
     * @ORM\OneToOne(targetEntity="AuthorPost", inversedBy="authorPostDetails")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $authorPost;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set authorName
     *
     * @param string $authorName
     * @return AuthorPostDetails
     */
    public function setAuthorName($authorName)
    {
        $this->authorName = $authorName;

        return $this;
    }

    /**
     * Get authorName
     *
     * @return string
     */
    public function getAuthorName()
    {
        return $this->authorName;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return AuthorPostDetails
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set authorPost
     *
     * @param AuthorPost $authorPost
     * @return AuthorPostDetails
     */
    public function setAuthorPost(AuthorPost $authorPost)
    {
        $this->authorPost = $authorPost;

        return $this;
    }

    /**
     * Get authorPost
     *
     * @return AuthorPost
     */
    public function getAuthorPost()
    {
        return $this->authorPost;
    }
}
