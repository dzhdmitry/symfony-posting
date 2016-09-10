<?php

namespace AppBundle\Service;

use AppBundle\Form\AuthorPostType;
use Symfony\Component\Form\AbstractType;

class AuthorPostFormCreator extends PostFormCreator
{
    /**
     * @return AbstractType
     */
    public function getFormType()
    {
        return AuthorPostType::class;
    }

    /**
     * @return string
     */
    public function getCreateUrl()
    {
        return $this->router->generate("post_create_author");
    }
}
