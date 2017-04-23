<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class AuthorPost extends Post
{
    /**
     * @ORM\OneToOne(targetEntity="AuthorPostDetails", mappedBy="authorPost", cascade={"persist"})
     * @Assert\Valid
     */
    protected $authorPostDetails;

    /**
     * Set authorPostDetails
     *
     * @param AuthorPostDetails $authorPostDetails
     * @return AuthorPost
     */
    public function setAuthorPostDetails(AuthorPostDetails $authorPostDetails = null)
    {
        $this->authorPostDetails = $authorPostDetails->setAuthorPost($this);

        return $this;
    }

    /**
     * Get authorPostDetails
     *
     * @return AuthorPostDetails
     */
    public function getAuthorPostDetails()
    {
        return $this->authorPostDetails;
    }

    public function getPostType()
    {
        return $this::TYPE_AUTHOR;
    }
}
