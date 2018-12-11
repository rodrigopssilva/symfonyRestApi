<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class AbstractController
 *
 * @category Repository
 * @package  AppBundle\Controller
 * @author   Rodrigo Silva <rodrigo.pssilva@gmail.com>
 * @license  proprietary https://github.com/
 * @link     https://github.com/
 */
abstract class AbstractController extends FOSRestController
{
    /**
     * Stores the namespace of the service that will be used
     *
     * @var String
     */
    protected $serviceName;

    /**
     * Stores the namespace of the builder that will be used
     *
     * @var String
     */
    protected $builder;

    /**
     * Runs the method findAll to return all registers
     *
     * @return View
     */
    public function getAllAction(): View
    {
        return new View(
            $this->container->get($this->serviceName)->findAll(),
            Response::HTTP_OK
        );
    }

    /**
     * Generic getAction
     *
     * @param String $id Identifier of the data
     *
     * @throws NotFoundHttpException when nothing is found
     *
     * @return View
     */
    public function getAction($id): View
    {
        $entity = $this->container->get($this->serviceName)->find($id);
        if (!$entity) {
            throw new NotFoundHttpException(
                sprintf(
                    'The resource \'%s\' was not found.',
                    $id
                )
            );
        }

        return new View(
            $entity,
            Response::HTTP_OK
        );
    }

    /**
     * Generic postAction
     *
     * @param Request $request HTTP request
     *
     * @return View
     */
    public function postAction(Request $request): View
    {
        $parameters = $request->request->all();
        $entity = $this->builder::build($parameters);
        $persistedEntity = $this
            ->container
            ->get($this->serviceName)
            ->create($entity);

        return new View(
            $persistedEntity,
            Response::HTTP_CREATED
        );
    }
}
