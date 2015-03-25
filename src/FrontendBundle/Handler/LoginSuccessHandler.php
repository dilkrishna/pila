<?php

namespace FrontendBundle\Handler;

use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;

class LoginSuccessHandler extends ContainerAware implements AuthenticationSuccessHandlerInterface
{
    protected $router;
    protected $security;

    public function __construct(Router $router, SecurityContext $security)
    {
        $this->router   = $router;
        $this->security = $security;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $session = $request->getSession();
        $target_path_key = '_security.main.target_path';

        if ($session->has($target_path_key)) {
            $url = $session->get($target_path_key);
        } elseif ($referer_url = $this->getRefererUrl($request)) {
            $url = $referer_url;
        } elseif ($this->security->isGranted('ROLE_ADMIN')) {
            //TODO later change to admin home page
            $url = $this->router->generate('uam_document');
        } else {
            $url = $this->router->generate('uam_document');
        }

        $response = new RedirectResponse($url);

        return $response;
    }

    protected function getRefererUrl(Request $request)
    {
        $referer_url = $request->headers->get('referer');

        if (!$referer_url
            || $referer_url == $this->router->generate('fos_user_security_login')) {
            return $referer_url;
        }
    }
}
