<?php

namespace AppBundle\Controller;

use AppBundle\Builder\Service as ServiceBuilder;
use AppBundle\Services\Service;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class ServiceController
 *
 * @category Controller
 * @package  AppBundle\Controller
 * @author   Rodrigo Silva <rodrigo.pssilva@gmail.com>
 * @license  proprietary https://github.com/
 * @link     https://github.com/
 */
class ServiceController extends AbstractController
{
    /**
     * ServiceController constructor.
     */
    public function __construct()
    {
        $this->serviceName = Service::class;
        $this->builder = ServiceBuilder::class;
    }

    /**
     * Returns all Services
     *
     * @Rest\Get("/service")
     *
     * @return View
     */
    public function getAllAction(): View
    {
        return parent::getAllAction();
    }

    /**
     * Returns one Service by it's identifier
     *
     * @param int $id Service identifier
     *
     * @throws NotFoundHttpException
     *
     * @Rest\Get("/service/{id}")
     *
     * @return View
     */
    public function getAction($id): View
    {
        return parent::getAction($id);
    }

    /**
     * Action to insert a new Service
     *
     * @param Request $request HTTP request
     *
     * @Rest\Post("/service")
     *
     * @return View
     */
    public function postAction(Request $request): View
    {
        return parent::postAction($request);
    }
}
