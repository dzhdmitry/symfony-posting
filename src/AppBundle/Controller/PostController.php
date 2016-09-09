<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AuthorPost;
use AppBundle\Entity\RegularPost;
use AppBundle\Entity\Tag;
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
     * @param Request $request
     * @return array
     */
    public function createAction(Request $request)
    {
        $authorPostForm = $this->createAuthorPostForm();

        $regularPostForm = $this->createForm(RegularPostType::class, null, [
            'action' => $this->generateUrl("post_create_regular")
        ]);

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
     */
    public function postAction(Request $request, $id)
    {
        switch ($request->getMethod()) {
            case "get":
                //

                break;
            case "put":
                //

                break;
            default:
                // method not allowed
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
