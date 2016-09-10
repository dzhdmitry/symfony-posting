<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AuthorPost;
use AppBundle\Entity\Post;
use AppBundle\Entity\RegularPost;
use AppBundle\Form\AuthorPostType;
use AppBundle\Form\RegularPostType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/posts")
 */
class PostController extends Controller
{
    /**
     * @Template
     * @Route("/create", name="post_create")
     * @return array
     */
    public function createAction()
    {
        $authorPostForm = $this->createAuthorPostForm();
        $regularPostForm = $this->createRegularPostForm();

        return [
            'authorPostForm' => $authorPostForm->createView(),
            'regularPostForm' => $regularPostForm->createView()
        ];
    }

    /**
     * @Template("@App/Post/create.html.twig")
     * @Route("/create/author", name="post_create_author")
     * @param Request $request
     * @return array
     */
    public function createAuthorPostAction(Request $request)
    {
        $authorPost = new AuthorPost();
        $authorPostForm = $this->createAuthorPostForm($authorPost);
        $regularPostForm = $this->createRegularPostForm();

        if ($request->isMethod("post")) {
            $authorPostForm->handleRequest($request);

            if ($authorPostForm->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $em->persist($authorPost);
                $em->flush();

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
     * @param Request $request
     * @return array
     */
    public function createRegularPostAction(Request $request)
    {
        $regularPost = new RegularPost();
        $authorPostForm = $this->createAuthorPostForm();
        $regularPostForm = $this->createRegularPostForm($regularPost);

        if ($request->isMethod("post")) {
            $regularPostForm->handleRequest($request);

            if ($regularPostForm->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $em->persist($regularPost);
                $em->flush();

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
     * @param Request $request
     * @param $id
     * @return array
     */
    public function postAction(Request $request, $id)
    {
        $post = $this->findPostOr404($id);
        $action = $this->generateUrl("post", [
            'id' => $post->getId()
        ]);

        if ($post->getPostType() == Post::TYPE_AUTHOR) {
            $template = "@App/Post/post.author.html.twig";
            $form = $this->createForm(AuthorPostType::class, $post, [
                'action' => $action,
                'method' => "put"
            ]);
        } else {
            $template = "@App/Post/post.regular.html.twig";
            $form = $this->createForm(RegularPostType::class, $post, [
                'action' => $action,
                'method' => "put"
            ]);
        }

        if ($request->isMethod("put")) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $em->persist($post);
                $em->flush();

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
     * @param $id
     * @return array
     */
    public function postViewAction($id)
    {
        $post = $this->findPostOr404($id);

        return [
            'post' => $post
        ];
    }

    /**
     * @param $id
     * @return Post
     */
    protected function findPostOr404($id)
    {
        $post = $this->getDoctrine()->getRepository(Post::class)->find($id);

        if ($post) {
            return $post;
        } else {
            throw $this->createNotFoundException();
        }
    }

    /**
     * @param AuthorPost|null $post
     * @return \Symfony\Component\Form\Form
     */
    protected function createAuthorPostForm($post = null)
    {
        return $this->createForm(AuthorPostType::class, $post, [
            'action' => $this->generateUrl("post_create_author")
        ]);
    }

    /**
     * @param RegularPost|null $post
     * @return \Symfony\Component\Form\Form
     */
    protected function createRegularPostForm($post = null)
    {
        return $this->createForm(RegularPostType::class, $post, [
            'action' => $this->generateUrl("post_create_regular")
        ]);
    }
}
