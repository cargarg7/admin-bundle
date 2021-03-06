<?php

namespace spec\FSi\Bundle\AdminBundle\Admin\CRUD;

use FSi\Bundle\AdminBundle\Exception\RuntimeException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\FormFactoryInterface;
use FSi\Bundle\AdminBundle\spec\fixtures\MyForm;
use FSi\Bundle\AdminBundle\Admin\CRUD\FormElement;
use FSi\Bundle\AdminBundle\Admin\Element;

class GenericFormElementSpec extends ObjectBehavior
{
    function let(FormFactoryInterface $factory)
    {
        $this->beAnInstanceOf(MyForm::class);
        $this->beConstructedWith([]);
        $this->setFormFactory($factory);
    }

    function it_is_form_element()
    {
        $this->shouldHaveType(FormElement::class);
    }

    function it_is_admin_element()
    {
        $this->shouldHaveType(Element::class);
    }

    function it_have_default_route()
    {
        $this->getRoute()->shouldReturn('fsi_admin_form');
    }

    function it_throws_exception_when_init_form_does_not_return_instance_of_form(FormFactoryInterface $factory)
    {
        $factory->create(Argument::cetera())->willReturn(null);

        $this->shouldThrow(\TypeError::class)
            ->during('createForm');
    }

    function it_has_default_options_values()
    {
        $this->getOptions()->shouldReturn([
            'template_form' => null,
            'allow_add' => true
        ]);
    }
}
