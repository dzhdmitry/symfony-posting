<?php

namespace AppBundle\Service;

use AppBundle\Form\RegularPostType;

class RegularPostFormCreator extends PostFormCreator
{
    /**
     * @return string
     */
    public function getFormType()
    {
        return RegularPostType::class;
    }

    /**
     * @return string
     */
    public function getCreateUrl()
    {
        return $this->router->generate("post_create_regular");
    }
}
