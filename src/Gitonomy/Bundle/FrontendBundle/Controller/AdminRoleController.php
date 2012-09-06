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

namespace Gitonomy\Bundle\FrontendBundle\Controller;

use Gitonomy\Bundle\CoreBundle\Entity\Role;

/**
 * Controller for repository actions.
 *
 * @author Julien DIDIER <julien@jdidier.net>
 */

class AdminRoleController extends BaseAdminController
{
    public function getMessage($object, $type)
    {
        if ($type == self::MESSAGE_TYPE_CREATE) {
            return sprintf('Role "%s" is created', $object->getName());
        } elseif ($type == self::MESSAGE_TYPE_UPDATE) {
            return sprintf('Role "%s" is updated', $object->getName());
        } elseif ($type == self::MESSAGE_TYPE_DELETE) {
            return sprintf('Role "%s" is deleted', $object->getName());
        }

        throw new \InvalidArgumentException('Unknown type '.$type);
    }

    protected function getRepository()
    {
        return $this->getDoctrine()->getEntityManager()->getRepository('GitonomyCoreBundle:Role');
    }

    public function listAction()
    {
        $this->assertGranted('ROLE_ROLE_LIST');

        return parent::listAction();
    }

    public function createAction()
    {
        $this->assertGranted('ROLE_ROLE_CREATE');

        return parent::createAction();
    }

    public function editAction($id)
    {
        $this->assertGranted('ROLE_ROLE_EDIT');

        return parent::editAction($id);
    }

    public function deleteAction($id)
    {
        $this->assertGranted('ROLE_ROLE_DELETE');

        return parent::deleteAction($id);
    }

    protected function createAdminForm($object, $options = array())
    {
        $options['is_global'] = $object->isGlobal();

        return parent::createAdminForm($object, $options);
    }
}
