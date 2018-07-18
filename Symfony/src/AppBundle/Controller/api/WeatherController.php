<?php
/**
 * Created by PhpStorm.
 * User: Anas.Dawood
 * Date: 7/9/2018
 * Time: 2:36 PM
 */

namespace AppBundle\Controller\api;


use AppBundle\Entity\CityDetail;
use AppBundle\Entity\Dashboard;
use AppBundle\Entity\User;
use AppBundle\Form\DashboardType;
use GuzzleHttp\Exception\BadResponseException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class WeatherController extends Controller
{

    private $apiKey = '1ce7af52ca88d0fc7fabb72e38429d76';

    /**
     * @Route("/api/weather/dashboard/user/{id}")
     * @Method("GET")
     */
    public function getAction($id)
    {
        $data = $this->getDoctrine()->getRepository('AppBundle:Dashboard')->findBy(["user" => $id]);
        $response = new JsonResponse($data, 200);
        return $response;
    }

    /**
     * @Route("/api/weather/details/{id}")
     * @Method("GET")
     */
    public function getCityDetails($id)
    {
        $dash = $this->getDoctrine()->getRepository('AppBundle:Dashboard')->find($id);
        $data = $this->getDoctrine()->getRepository('AppBundle:CityDetail')->findBy(["dashboard" => $id]);
        $nowDate = new \DateTime();
        $difference = round(abs($nowDate->getTimestamp() - $dash->getLastUpdated()->getTimestamp()) / 60, 2);
        if ($difference >= 10) {
            $dash->setLastUpdated($nowDate);
            $jsonRes = $this->getJsonResponse($dash->getCityName());
            $this->saveCityData($jsonRes, $dash, $data);
        }
        $response = new JsonResponse($data, 200);
        return $response;

    }

    /**
     * @Route("/api/weather/dashboard/{id}")
     * @Method("DELETE")
     */
    public function deleteAction($id)
    {
        /**
         * @var $blogPost BlogPost
         */
        $dashboard = $this->getDoctrine()->getRepository(Dashboard::class)->find($id);

        if ($dashboard === null) {
            return new View(null, Response::HTTP_NOT_FOUND);
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($dashboard);
        $em->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/api/weather/addCity")
     * @Method("POST")
     */
    public function addCityManual(Request $request)
    {

        $data = json_decode($request->getContent(), true);
        $dasboard = new Dashboard();
        $form = $this->createForm(DashboardType::class, $dasboard, [
            'csrf_protection' => false,
        ]);

        $form->submit($data);

        //$dasboard = $form->getData();

        $em = $this->getDoctrine()->getManager();
        $em->merge($dasboard);
        $em->flush();

        return new JsonResponse($dasboard, 201);
    }

    /**
     * @Route("/api/weather/addCityCall")
     * @Method("POST")
     */
    public function addCity(Request $request)
    {
        $data = json_decode($request->getContent(), true);


        $jsonRes = $this->getJsonResponse($data["cityName"]);


        $dashboard = $this->populateDashboard($data, $jsonRes);

        $this->saveCityData($jsonRes, $dashboard);
        $response = new JsonResponse($jsonRes, 200);
        return $response;
    }

    public function getJsonResponse($cityName)
    {
        $client = new \GuzzleHttp\Client();
        try {
            $res = $client->request('GET', 'http://api.openweathermap.org/data/2.5/forecast?q=' . $cityName . '&APPID=' . $this->apiKey);
        } catch (BadResponseException $ex) {
            $response = $ex->getResponse();
            $jsonBody = $response->getBody()->getContents();
            return new JsonResponse(json_decode($jsonBody), 404);
        }

        $jsonRes = json_decode($res->getBody()->getContents());
        return $jsonRes;
    }

    public function populateDashboard($data, $jsonRes)
    {
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($data["userId"]);
        $dashboard = new Dashboard();
        $dashboard->setCityName($data["cityName"]);
        $dashboard->setUser($user);
        $dashboard->setIcon($jsonRes->list[0]->weather[0]->icon);
        $dashboard->setTemperature($jsonRes->list[0]->main->temp);
        $dashboard->setRainPossibility("");
        $dashboard->setLastUpdated(new \DateTime());
        return $dashboard;
    }

    public function saveCityData($cityData, $dash, $orgList = null)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($dash);
        for ($i = 0; $i < 8; $i++) {
            $data = new CityDetail();
            if ($orgList != null) {
                $data->setId($orgList[$i]->getId());
            }
            $data->setDashboard($dash);
            $data->setTemperature($cityData->list[$i]->main->temp);
            $data->setIcon($cityData->list[$i]->weather[0]->icon);
            $data->setDateTime($cityData->list[$i]->dt_txt);
            $data->setHumidity($cityData->list[$i]->main->humidity);
            $em->merge($data);
        }
        $em->flush();

        return new JsonResponse($dash, 201);

    }

}