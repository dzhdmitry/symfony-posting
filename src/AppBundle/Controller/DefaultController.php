<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use AppBundle\Entity\RegularPost;
use AppBundle\Entity\Tag;
use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Template
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $posts = $this->getDoctrine()->getRepository(Post::class)->findAll();
        $tags = $this->getDoctrine()->getRepository(Tag::class)->createQueryBuilder("tag")
            ->groupBy("tag.name")
            ->getQuery()
            ->execute();

        return [
            'posts' => $posts,
            'tags' => $tags
        ];
    }

    /**
     * @Template
     * @Route("/tag/{tagName}", name="posts_by_tag")
     * @param $tagName
     * @return array
     */
    public function postsByTagAction($tagName)
    {
        /** @var $repo EntityRepository */
        $repo = $this->getDoctrine()->getRepository(RegularPost::class);
        $posts = $repo->createQueryBuilder("regularPost")
            ->innerJoin("regularPost.tags", "tag")
            ->where("tag.name = :tagName")
            ->setParameter("tagName", $tagName)
            ->getQuery()
            ->execute();

        return [
            'tag' => $tagName,
            'posts' => $posts
        ];
    }
}
