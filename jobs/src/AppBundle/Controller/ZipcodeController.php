<?php

namespace AppBundle\Controller;

use AppBundle\Builder\Zipcode as ZipcodeBuilder;
use AppBundle\Services\Zipcode;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class ZipcodeController
 *
 * @category Controller
 * @package  AppBundle\Controller
 * @author   Rodrigo Silva <rodrigo.pssilva@gmail.com>
 * @license  proprietary https://github.com/
 * @link     https://github.com/
 */
class ZipcodeController extends AbstractController
{
    /**
     * ZipcodeController constructor.
     */
    public function __construct()
    {
        $this->serviceName = Zipcode::class;
        $this->builder = ZipcodeBuilder::class;
    }

    /**
     * Returns all Zipcodes
     *
     * @Rest\Get("/zipcode")
     *
     * @return View
     */
    public function getAllAction(): View
    {
        return parent::getAllAction();
    }

    /**
     * Returns one Zipcode by it's identifier
     *
     * @param int $id Zipcode identifier
     *
     * @throws NotFoundHttpException
     *
     * @Rest\Get("/zipcode/{id}")
     *
     * @return View
     */
    public function getAction($id): View
    {
        return parent::getAction($id);
    }

    /**
     * Action to insert a new Zipcode
     *
     * @param Request $request HTTP request
     *
     * @Rest\Post("/zipcode")
     *
     * @return View
     */
    public function postAction(Request $request): View
    {
        return parent::postAction($request);
    }
}
