<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Post;
use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository
{
    /**
     * @return Post[]
     */
    public function findPosts()
    {
        return $this->findBy([], [
            'postedAt' => "DESC"
        ]);
    }
}
