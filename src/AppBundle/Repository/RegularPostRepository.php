<?php

namespace AppBundle\Repository;

use AppBundle\Entity\RegularPost;

class RegularPostRepository extends \Doctrine\ORM\EntityRepository
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
