<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace FSi\Bundle\AdminBundle\Admin;

use FSi\Bundle\AdminBundle\Admin\Manager\Visitor;

class Manager implements ManagerInterface
{
    /**
     * @var Element[]
     */
    protected $elements;

    public function __construct()
    {
        $this->elements = [];
    }

    public function addElement(Element $element): void
    {
        $this->elements[$element->getId()] = $element;
    }

    public function hasElement(string $id): bool
    {
        return array_key_exists($id, $this->elements);
    }

    public function getElement(string $id): Element
    {
        return $this->elements[$id];
    }

    public function removeElement(string $id): void
    {
        unset($this->elements[$id]);
    }

    public function getElements(): array
    {
        return $this->elements;
    }

    public function accept(Visitor $visitor): void
    {
        $visitor->visitManager($this);
    }
}
