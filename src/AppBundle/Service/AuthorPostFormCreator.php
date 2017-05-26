<?php

namespace AppBundle\Service;

use AppBundle\Form\AuthorPostType;

class AuthorPostFormCreator extends PostFormCreator
{
    /**
     * @return string
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
