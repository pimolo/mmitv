<?php

namespace AppBundle\Controller\Security;

use FOS\UserBundle\Controller\SecurityController as BaseController;

class CustomSecurityController extends BaseController
{
    protected function renderLogin(array $data)
    {
        $template = sprintf('AppBundle:Security:login.html.%s', $this->container->getParameter('fos_user.template.engine'));

        return $this->container->get('templating')->renderResponse($template, $data);
    }
}
