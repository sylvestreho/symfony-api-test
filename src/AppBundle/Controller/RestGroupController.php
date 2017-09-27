<?php
namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Service\Group;

class RestGroupController extends FOSRestController
{
    /**
     * @Route("/api/groups")
     * @Method({"GET"})
     * @ApiDoc(
     *   resource = true,
     *   description = "Get list of groups",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Error occured"
     *   }
     * )
     *
     * @return View
     */
    public function getAction()
    {
        try {
            $groups = $this->get(Group::class)->getAll();
            $view = $this->view($groups, 200);
        } catch (\Exception $e) {
            $view = $this->view(['error' => $e->getMessage()], 400);
        }

        return $this->handleView($view);
    }

    /**
     * @Route("/api/groups/{id}")
     * @Method({"GET"})
     * @ApiDoc(
     *   resource = true,
     *   description = "Get one group",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Error occured"
     *   }
     * )
     *
     * @return View
     */
    public function getOneAction($id)
    {
        try {
            $group = $this->get(Group::class)->getOne($id);
            if (!$group) {
                throw new \Exception('Goupo not found');
            }
            $view = $this->view($group, 200);
        } catch (\Exception $e) {
            $view = $this->view(['error' => $e->getMessage()], 400);
        }

        return $this->handleView($view);
    }

    /**
     * @Route("/api/groups")
     * @Method({"POST"})
     * @ApiDoc(
     *   resource = true,
     *   description = "Add a new group",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Error occured"
     *   }
     * )
     *
     * @RequestParam(name="name", nullable=false, strict=true, description="Group name")
     * @return View
     */
    public function postAction(Request $request)
    {
        try {
            $group = $this->get(Group::class)->insert($request->request); // post
            $view = $this->view($group, 200);
        } catch (\Exception $e) {
            $view = $this->view(['error' => $e->getMessage()], 400);
        }

        return $this->handleView($view);
    }

    /**
     * @Route("/api/groups/{id}")
     * @Method({"PATCH"})
     * @ApiDoc(
     *   resource = true,
     *   description = "Patch a group",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Error occured"
     *   }
     * )
     *
     * @RequestParam(name="name", nullable=false, strict=true, description="Group name")
     * @return View
     */
    public function patchAction(Request $request, $id)
    {
        try {
            $group = $this->get(Group::class)->update($id, $request->request); // post
            $view = $this->view($group, 200);
        } catch (\Exception $e) {
            $view = $this->view(['error' => $e->getMessage()], 400);
        }

        return $this->handleView($view);
    }
}