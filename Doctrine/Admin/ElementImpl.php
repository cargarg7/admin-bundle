<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace FSi\Bundle\AdminBundle\Doctrine\Admin;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use FSi\Bundle\AdminBundle\Exception\RuntimeException;

trait ElementImpl
{
    /**
     * @var ManagerRegistry
     */
    protected $registry;

    public function setManagerRegistry(ManagerRegistry $registry): void
    {
        $this->registry = $registry;
    }

    public function getObjectManager(): ObjectManager
    {
        $om = $this->registry->getManagerForClass($this->getClassName());

        if (null === $om) {
            throw new RuntimeException(sprintf(
                'Registry manager does\'t have manager for class "%s".',
                $this->getClassName()
            ));
        }

        return $om;
    }

    public function getRepository(): ObjectRepository
    {
        return $this->getObjectManager()->getRepository($this->getClassName());
    }
}
