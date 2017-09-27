<?php
namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ApiController extends FOSRestController
{
    /**
     * @Route("/api/welcome")
     * @Method({"GET"})
     * @ApiDoc(
     *   resource = true,
     *   description = "Test that API works",
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @return View
     */
    public function indexAction()
    {
        $data = array("hello" => "world");
        $view = $this->view($data);

        return $this->handleView($view);
    }
}