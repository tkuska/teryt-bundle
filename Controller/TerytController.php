<?php

namespace Tkuska\TerytBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Akcja controller.
 *
 * @Route("/teryt")
 */
class TerytController extends Controller
{
    /**
     * Lists all Wojewodztwa entities.
     *
     * @Route("/wojewodztwa/{term}", name="teryt_wojewodztwa", defaults={"term"=""})
     */
    public function wojewodztwaAction($term = '')
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TkuskaTerytBundle:Wojewodztwo')
                ->getWojewodztwoByName($term);

        return new JsonResponse($entities);
    }

    /**
     * Lists all Powiaty entities.
     *
     * @Route("/powiaty/{term}/{wojewodztwo}", name="teryt_powiaty")
     */
    public function powiatyAction($term = '', $wojewodztwo = null)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TkuskaTerytBundle:Powiat')
                ->getPowiatByName($term, $wojewodztwo);

        return new JsonResponse($entities);
    }

    /**
     * Lists all Gminy entities.
     *
     * @Route("/gminy/{term}/{wojewodztwo}/{powiat}", name="teryt_gminy")
     */
    public function gminyAction($term = '', $wojewodztwo = null, $powiat = null)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TkuskaTerytBundle:Gmina')
                ->getGminaByName($term, $wojewodztwo, $powiat);

        return new JsonResponse($entities);
    }

    /**
     * Lists all Gminy entities.
     *
     * @Route("/miasta/{term}/{wojewodztwo}/{powiat}/{gmina}", name="teryt_miasta")
     */
    public function miastaAction($term = '', $wojewodztwo = null, $powiat = null, $gmina = null)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TkuskaTerytBundle:Miejscowosc')
                ->getMiejscowoscByName($term, $wojewodztwo, $powiat, $gmina);

        return new JsonResponse($entities);
    }

    /**
     * Lists all Ulice entities.
     *
     * @Route("/ulice/{term}/{wojewodztwo}/{powiat}/{gmina}/{rodzaj_gminy}", name="teryt_ulice")
     */
    public function uliceAction($term = '', $wojewodztwo = null, $powiat = null, $gmina = null, $rodzaj_gminy = null)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TkuskaTerytBundle:Ulica')
                ->getUlicaByName($term, $wojewodztwo, $powiat, $gmina, $rodzaj_gminy);

        return new JsonResponse($entities);
    }
}
