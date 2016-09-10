<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Tag;

class TagRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @return Tag[]
     */
    public function findDistinctTags()
    {
        return $this->createQueryBuilder("tag")
            ->groupBy("tag.name")
            ->getQuery()
            ->execute();
    }
}
