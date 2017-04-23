<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Tag;
use Doctrine\ORM\EntityRepository;

class TagRepository extends EntityRepository
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
