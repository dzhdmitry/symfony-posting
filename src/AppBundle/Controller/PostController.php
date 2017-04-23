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
     * @Route("/create", name="post_create")
     *
     * @return array
     */
    public function createAction()
    {
        $authorPostForm = $this->get("author_form_creator")->createForm();
        $regularPostForm = $this->get("regular_form_creator")->createForm();

        return [
            'authorPostForm' => $authorPostForm->createView(),
            'regularPostForm' => $regularPostForm->createView()
        ];
    }

    /**
     * @Template("@App/Post/create.html.twig")
     * @Route("/create/author", name="post_create_author")
     *
     * @param Request $request
     * @return RedirectResponse|array
     */
    public function createAuthorPostAction(Request $request)
    {
        $authorPost = new AuthorPost();
        $authorPostForm = $this->get("author_form_creator")->createForm($authorPost);
        $regularPostForm = $this->get("regular_form_creator")->createForm();

        if ($request->isMethod("post")) {
            $authorPostForm->handleRequest($request);

            if ($authorPostForm->isValid()) {
                $this->get("post_manager")->save($authorPost);

                return $this->redirectToRoute("homepage");
            }
        }

        return [
            'authorPostForm' => $authorPostForm->createView(),
            'regularPostForm' => $regularPostForm->createView(),
            'activeTab' => "author"
        ];
    }

    /**
     * @Template("@App/Post/create.html.twig")
     * @Route("/create/regular", name="post_create_regular")
     *
     * @param Request $request
     * @return RedirectResponse|array
     */
    public function createRegularPostAction(Request $request)
    {
        $regularPost = new RegularPost();
        $authorPostForm = $this->get("author_form_creator")->createForm();
        $regularPostForm = $this->get("regular_form_creator")->createForm($regularPost);

        if ($request->isMethod("post")) {
            $regularPostForm->handleRequest($request);

            if ($regularPostForm->isValid()) {
                $this->get("post_manager")->save($regularPost);

                return $this->redirectToRoute("homepage");
            }
        }

        return [
            'authorPostForm' => $authorPostForm->createView(),
            'regularPostForm' => $regularPostForm->createView(),
            'activeTab' => "regular"
        ];
    }

    /**
     * @Route("/{id}", name="post")
     *
     * @param Request $request
     * @param $id
     * @return RedirectResponse|Response
     */
    public function postAction(Request $request, $id)
    {
        $post = $this->get("post_manager")->findPostOr404($id);

        if ($post->getPostType() == Post::TYPE_AUTHOR) {
            $form = $this->get("author_form_creator")->createEditForm($post);
            $template = "@App/Post/post.author.html.twig";
        } else {
            $form = $this->get("regular_form_creator")->createEditForm($post);
            $template = "@App/Post/post.regular.html.twig";
        }

        if ($request->isMethod("put")) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $this->get("post_manager")->save($post);

                return $this->redirectToRoute("post", [
                    'id' => $post->getId()
                ]);
            }
        }

        return $this->render($template, [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Template
     * @Route("/{id}/view", name="post_view")
     *
     * @param $id
     * @return array
     */
    public function postViewAction($id)
    {
        $post = $this->get("post_manager")->findPostOr404($id);

        return [
            'post' => $post
        ];
    }
}
