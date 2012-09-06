<?php

/**
 * This file is part of Gitonomy.
 *
 * (c) Alexandre Salomé <alexandre.salome@gmail.com>
 * (c) Julien DIDIER <genzo.wm@gmail.com>
 *
 * This source file is subject to the GPL license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Gitonomy\Bundle\DistributionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class VerificationController extends Controller
{
    public function indexAction()
    {
        return $this->render('GitonomyDistributionBundle:Verification:index.html.twig', array(
            'mailForm' => $this->createForm('verification_mail')->createView()
        ));
    }

    public function mailAction(Request $request)
    {
        $form = $this->createForm('verification_mail');
        $form->bind($request);

        if ($form->isValid()) {
            $email = $form->get('email')->getData();

            $this->get('gitonomy_frontend.mailer')->sendMessage('GitonomyDistributionBundle:Verification:mail.mail.twig', array(
                'email' => $email
            ), array(
                $email => $email
            ));

            $request->getSession()->setFlash('verification_confirmation', 'Sent a mail to '.$email);

            return $this->redirect($this->generateUrl('gitonomydistribution_verification_index'));
        }

        return $this->render('GitonomyDistributionBundle:Verification:index.html.twig', array(
            'mailForm' => $form->createView()
        ));
    }
}
