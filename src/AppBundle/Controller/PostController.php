<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AuthorPost;
use AppBundle\Entity\Post;
use AppBundle\Entity\RegularPost;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/posts")
 */
class PostController extends Controller
{
    /**
     * @Template
     * @Route("/create")
     * @Route("/create/{type}", requirements={"type"="author|regular"})
     *
     * @param Request $request
     * @param $type
     * @return RedirectResponse|array
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createAction(Request $request, $type = null)
    {
        $authorPostForm = $this->get('author_form_factory')->createCreateForm();
        $regularPostForm = $this->get('regular_form_factory')->createCreateForm();

        if ($type !== null) {
            if ($type === Post::TYPE_AUTHOR) {
                $post = new AuthorPost();
                $form = $authorPostForm;
            } else {
                $post = new RegularPost();
                $form = $regularPostForm;
            }

            $form->setData($post);
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->get('doctrine.orm.default_entity_manager');

                $em->persist($post);
                $em->flush();

                return $this->redirectToRoute('app_default_index');
            }
        }

        return [
            'authorPostForm' => $authorPostForm->createView(),
            'regularPostForm' => $regularPostForm->createView(),
            'activeTab' => $type
        ];
    }

    /**
     * @Route("/{id}")
     *
     * @param Request $request
     * @param Post $post
     * @return RedirectResponse|Response
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function postAction(Request $request, Post $post)
    {
        if ($post->getPostType() === Post::TYPE_AUTHOR) {
            $form = $this->get('author_form_factory')->createEditForm($post);
            $template = '@App/Post/post.author.html.twig';
        } else {
            $form = $this->get('regular_form_factory')->createEditForm($post);
            $template = '@App/Post/post.regular.html.twig';
        }

        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->get('doctrine.orm.default_entity_manager')->flush();

            return $this->redirectToRoute('app_post_postview', [
                'id' => $post->getId()
            ]);
        }

        return $this->render($template, [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Template
     * @Route("/{id}/view")
     *
     * @param Post $post
     * @return array
     */
    public function postViewAction(Post $post)
    {
        return [
            'post' => $post
        ];
    }
}
