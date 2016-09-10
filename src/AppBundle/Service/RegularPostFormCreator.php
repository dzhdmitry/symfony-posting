<?php

namespace AppBundle\Service;

use AppBundle\Form\RegularPostType;
use Symfony\Component\Form\AbstractType;

class RegularPostFormCreator extends PostFormCreator
{
    /**
     * @return AbstractType
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
        $this->router->generate("post_create_regular");
    }
}
