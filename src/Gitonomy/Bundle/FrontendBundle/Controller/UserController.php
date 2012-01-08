<?php

namespace Gitonomy\Bundle\FrontendBundle\Controller;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Gitonomy\Bundle\CoreBundle\Entity\User;

/**
 * Controller for user displaying.
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class UserController extends BaseController
{
    /**
     * Displays the project main page
     */
    public function showAction($username)
    {
        $user = $this->getUserEntity($username);

        return $this->render('GitonomyFrontendBundle:User:show.html.twig', array(
            'user' => $user
        ));
    }

    /**
     * @return Gitonomy\Bundle\CoreBundle\Entity\User
     */
    protected function getUserEntity($username)
    {
        $securityUser = $this->get('security.context')->getToken()->getUser();
        if (!$securityUser instanceof User) {
            throw new AccessDeniedException('You must be connected to access a user page');
        }

        $user = $this->getDoctrine()->getRepository('GitonomyCoreBundle:User')->findOneByUsername($username);
        if (null === $user) {
            throw $this->createNotFoundException(sprintf('User "%s" not found', $username));
        }

        return $user;
    }
}
