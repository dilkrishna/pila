<?php
namespace FrontendBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function userMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $security_checker = $this->container->get('security.authorization_checker');

        if ($security_checker->isGranted('ROLE_USER')) {
            $user = $this->container->get('security.token_storage')
                ->getToken()
                ->getUser();

            $menu->addChild('menu.user.welcome')
                ->setExtra('translation_domain', 'editor')
                ->setLabelAttribute('class', 'navbar-text')
                ->setExtra('translation_params', array('%username%' => $user->getUsername()));

            $menu->addChild(
                'menu.user.document',
                array('route' => 'document')
            )->setExtra('translation_domain', 'editor');
            $menu->addChild(
                'menu.user.logout',
                array('route' => 'fos_user_security_logout')
            )->setExtra('translation_domain', 'editor');
        } else {
            $menu->addChild('menu.user.signin',
                array('route' => 'fos_user_security_login')
            )->setExtra('translation_domain', 'editor');

            $menu->addChild('menu.user.signup',
                array('route' => 'fos_user_registration_register')
            )->setExtra('translation_domain', 'editor');
        }

        return $menu;
    }
}
