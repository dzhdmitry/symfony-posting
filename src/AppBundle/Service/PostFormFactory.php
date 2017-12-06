<?php

namespace AppBundle\Service;

use AppBundle\Entity\Post;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Routing\Router;

class PostFormFactory
{
    /**
     * @var Router
     */
    protected $router;

    /**
     * @var FormFactory
     */
    protected $formFactory;

    /**
     * @var string
     */
    protected $formType;

    /**
     * @var string
     */
    protected $type;

    public function __construct(Router $router, FormFactory $formFactory, $formType, $type)
    {
        $this->router = $router;
        $this->formFactory = $formFactory;
        $this->formType = $formType;
        $this->type = $type;
    }

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createCreateForm()
    {
        $action = $this->router->generate('app_post_create_1', [
            'type' => $this->type
        ]);

        return $this->formFactory->create($this->formType, null, [
            'action' => $action,
            'method' => 'post'
        ]);
    }

    /**
     * @param Post $post
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createEditForm(Post $post)
    {
        $action = $this->router->generate('app_post_post', [
            'id' => $post->getId()
        ]);

        return $this->formFactory->create($this->formType, $post, [
            'action' => $action,
            'method' => 'put'
        ]);
    }
}
