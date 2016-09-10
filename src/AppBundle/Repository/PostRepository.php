<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Post;

class PostRepository extends \Doctrine\ORM\EntityRepository
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
