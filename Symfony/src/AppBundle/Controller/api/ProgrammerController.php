<?php
/**
 * Created by PhpStorm.
 * User: Anas.Dawood
 * Date: 7/9/2018
 * Time: 1:03 PM
 */

namespace AppBundle\Controller\api;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ProgrammerController extends Controller
{

    /**
     * @Route("/api/programmers")
     * @Method("POST")
     */
    public function newAction()
    {
        $data = ['anas' => 'anas', 'anwar' => 'anwar'];
        $response = new Response(json_encode($data), 200);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/api/programmers/{nickname}")
     * @Method("GET")
     */
    public function showAction($nickname)
    {
        $data = [1=>"Hello " . $nickname];
        $response = new JsonResponse($data, 200);
        //$response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}

