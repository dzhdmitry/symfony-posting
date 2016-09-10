<?php

namespace AppBundle\Service;

use AppBundle\Entity\Post;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostManager
{
    /**
     * @var EntityManager
     */
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param $id
     * @return Post
     */
    public function findPostOr404($id)
    {
        $post = $this->em->getRepository(Post::class)->find($id);

        if ($post) {
            return $post;
        } else {
            throw new NotFoundHttpException("Post not found");
        }
    }

    /**
     * @param Post $post
     */
    public function save(Post $post)
    {
        $this->em->persist($post);
        $this->em->flush();
    }
}
