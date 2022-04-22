<?php

namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class IndicatorsController extends Controller
{

    /**
     * @Route("/indicators", name="indicators_index")
     * @return Response
     */
    public function indexAction()
    {
        return $this->render("indicators/index.html.twig");
    }


}
