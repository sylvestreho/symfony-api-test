<?php
namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Service\User;

class RestUserController extends FOSRestController
{
    /**
     * @Route("/api/users")
     * @Method({"GET"})
     * @ApiDoc(
     *   resource = true,
     *   description = "Get list of users",
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
            $users = $this->get(User::class)->getAll();
            $view = $this->view($users, 200);
        } catch (\Exception $e) {
            $view = $this->view(['error' => $e->getMessage()], 400);
        }

        return $this->handleView($view);
    }

    /**
     * @Route("/api/users/{id}")
     * @Method({"GET"})
     * @ApiDoc(
     *   resource = true,
     *   description = "Get one user",
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
            $user = $this->get(User::class)->getOne($id);
            if (!$user) {
                throw new \Exception('User not found');
            }
            $view = $this->view($user, 200);
        } catch (\Exception $e) {
            $view = $this->view(['error' => $e->getMessage()], 400);
        }

        return $this->handleView($view);
    }

    /**
     * @Route("/api/users")
     * @Method({"POST"})
     * @ApiDoc(
     *   resource = true,
     *   description = "Add a new user",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Error occured"
     *   }
     * )
     *
     * @RequestParam(name="email", nullable=false, strict=true, description="email")
     * @RequestParam(name="firstname", nullable=false, strict=true, description="firstname")
     * @RequestParam(name="lastname", nullable=false, strict=true, description="lastname")
     * @RequestParam(name="password", nullable=false, strict=true, description="password")
     * @return View
     */
    public function postAction(Request $request)
    {
        try {
            $user = $this->get(User::class)->insert($request->request); // post
            $view = $this->view($user, 200);
        } catch (\Exception $e) {
            $view = $this->view(['error' => $e->getMessage()], 400);
        }

        return $this->handleView($view);
    }

    /**
     * @Route("/api/users/{id}")
     * @Method({"PATCH"})
     * @ApiDoc(
     *   resource = true,
     *   description = "Patch a user",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Error occured"
     *   }
     * )
     *
     * @RequestParam(name="email", nullable=true, strict=true, description="email")
     * @RequestParam(name="firstname", nullable=true, strict=true, description="firstname")
     * @RequestParam(name="lastname", nullable=true, strict=true, description="lastname")
     * @RequestParam(name="password", nullable=true, strict=true, description="password")
     * @return View
     */
    public function patchAction(Request $request, $id)
    {
        try {
            $user = $this->get(User::class)->update($id, $request->request); // post
            $view = $this->view($user, 200);
        } catch (\Exception $e) {
            $view = $this->view(['error' => $e->getMessage()], 400);
        }

        return $this->handleView($view);
    }
}