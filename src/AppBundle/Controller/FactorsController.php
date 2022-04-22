<?php

namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class FactorsController extends Controller
{

    /**
     * @Route("/factors", name="factors_index")
     * @return Response
     */
    public function indexAction()
    {
        return $this->render("factors/index.html.twig");
    }


}
