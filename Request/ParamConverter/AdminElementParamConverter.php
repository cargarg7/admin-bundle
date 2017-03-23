<?php

namespace FSi\Bundle\AdminBundle\Request\ParamConverter;

use FSi\Bundle\AdminBundle\Admin\ManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @author Norbert Orzechowicz <norbert@fsi.pl>
 */
class AdminElementParamConverter implements ParamConverterInterface
{
    /**
     * @var \FSi\Bundle\AdminBundle\Admin\ManagerInterface
     */
    private $manager;

    /**
     * @param \FSi\Bundle\AdminBundle\Admin\Manager $manager
     */
    public function __construct(ManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter $configuration
     * @return bool
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $param = $configuration->getName();
        $id = $request->attributes->get($param, '');

        if (!$this->manager->hasElement($id)) {
            throw new NotFoundHttpException(sprintf('Admin element with id %s does not exist.', $id));
        }

        $request->attributes->set($param, $this->manager->getElement($id));

        return true;
    }

    /**
     * @param \Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter $configuration
     * @return bool
     */
    public function supports(ParamConverter $configuration)
    {
        if (!$configuration instanceof ParamConverter) {
            return false;
        }

        if (!class_exists($configuration->getClass()) && !interface_exists($configuration->getClass())) {
            return false;
        }

        $implements = class_implements($configuration->getClass());

        if (in_array('FSi\\Bundle\\AdminBundle\\Admin\\Element', $implements)) {
            return true;
        }

        return false;
    }
}
