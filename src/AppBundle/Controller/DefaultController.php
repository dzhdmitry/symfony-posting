<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use AppBundle\Entity\RegularPost;
use AppBundle\Entity\Tag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Template
     * @Route("/")
     */
    public function indexAction()
    {
        $posts = $this->getDoctrine()->getRepository(Post::class)->findPosts();
        $tags = $this->getDoctrine()->getRepository(Tag::class)->findDistinctTags();

        return [
            'posts' => $posts,
            'tags' => $tags
        ];
    }

    /**
     * @Template
     * @Route("/tag/{tagName}")
     *
     * @param $tagName
     * @return array
     */
    public function postsByTagAction($tagName)
    {
        $posts = $this->getDoctrine()->getRepository(RegularPost::class)->findPostsByTag($tagName);

        return [
            'tag' => $tagName,
            'posts' => $posts
        ];
    }
}
