<?php

namespace AppBundle\Repository;

use AppBundle\Entity\RegularPost;
use Doctrine\ORM\EntityRepository;

class RegularPostRepository extends EntityRepository
{
    /**
     * @param string $tagName
     * @return RegularPost[]
     */
    public function findPostsByTag($tagName)
    {
        return $this->createQueryBuilder("regularPost")
            ->innerJoin("regularPost.tags", "tag")
            ->where("tag.name = :tagName")
            ->setParameter("tagName", $tagName)
            ->getQuery()
            ->execute();
    }
}
