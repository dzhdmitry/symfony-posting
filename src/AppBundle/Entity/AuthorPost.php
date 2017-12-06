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
     * @param AuthorPostDetails $authorPostDetails
     * @return AuthorPost
     */
    public function setAuthorPostDetails(AuthorPostDetails $authorPostDetails = null)
    {
        $this->authorPostDetails = $authorPostDetails->setAuthorPost($this);

        return $this;
    }

    /**
     * @return AuthorPostDetails
     */
    public function getAuthorPostDetails()
    {
        return $this->authorPostDetails;
    }

    /**
     * @return string
     */
    public function getPostType()
    {
        return self::TYPE_AUTHOR;
    }
}
