<?php

namespace AppBundle\Service;

use AppBundle\Entity\Post;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Routing\Router;

abstract class PostFormCreator
{
    /**
     * @var Router
     */
    protected $router;

    /**
     * @var FormFactory
     */
    protected $formFactory;

    public function __construct(Router $router, FormFactory $formFactory)
    {
        $this->router = $router;
        $this->formFactory = $formFactory;
    }

    /**
     * @return string
     */
    abstract public function getFormType();

    /**
     * @return string
     */
    abstract public function getCreateUrl();

    /**
     * @param Post|null $post
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createForm(Post $post = null)
    {
        return $this->formFactory->create($this->getFormType(), $post, [
            'action' => $this->getCreateUrl()
        ]);
    }

    /**
     * @param Post $post
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createEditForm(Post $post)
    {
        $action = $this->router->generate("post", [
            'id' => $post->getId()
        ]);

        return $this->formFactory->create($this->getFormType(), $post, [
            'action' => $action,
            'method' => "put"
        ]);
    }
}
