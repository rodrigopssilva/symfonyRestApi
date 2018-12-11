<?php

namespace AppBundle\Controller;

use AppBundle\Builder\Job as JobBuilder;
use AppBundle\Services\Job;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class JobController
 *
 * @category Controller
 * @package  AppBundle\Controller
 * @author   Rodrigo Silva <rodrigo.pssilva@gmail.com>
 * @license  proprietary https://github.com/
 * @link     https://github.com/
 */
class JobController extends AbstractController
{
    /**
     * JobController constructor.
     */
    public function __construct()
    {
        $this->serviceName = Job::class;
        $this->builder = JobBuilder::class;
    }

    /**
     * Returns all Jobs
     *
     * @param Request $request HTTP request
     *
     * @Rest\Get("/job")
     *
     * @return View
     */
    public function getAllFilteringAction(Request $request): View
    {
        return new View(
            $this
                ->container
                ->get($this->serviceName)
                ->findAll($request->query->all()),
            Response::HTTP_OK
        );
    }

    /**
     * Action to return a Job by it's identifier
     *
     * @param string $id data identifier
     *
     * @throws NotFoundHttpException
     *
     * @Rest\Get("/job/{id}")
     *
     * @return View
     */
    public function getAction($id): View
    {
        return parent::getAction($id);
    }

    /**
     * Action to insert new a Job
     *
     * @param Request $request HTTP request
     *
     * @Rest\Post("/job")
     *
     * @return View
     */
    public function postAction(Request $request): View
    {
        return parent::postAction($request);
    }

    /**
     * Action to update a Job by it's identifier
     *
     * @param string  $id      data identifier
     * @param Request $request HTTP request
     *
     * @Rest\Put("/job/{id}")
     *
     * @return View
     */
    public function putAction(String $id, Request $request): View
    {
        $params = $request->request->all();
        $params['id'] = $id;
        $entity = $this->builder::build($params);
        $persistedEntity = $this
            ->container
            ->get($this->serviceName)
            ->update($entity);

        return new View(
            $persistedEntity,
            Response::HTTP_OK
        );
    }
}
