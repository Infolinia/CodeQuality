<?php

namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ProjectsController extends Controller
{
    public function searchAll()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://localhost:9000/api/components/search?qualifiers=TRK');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        $data = json_decode($response);
        $total = $data->paging->total;
        $projects = array();

        for ($i = 0; $i < $total; $i++) {
            $projects[$i] = $data->components[$i]->project;
        }

        return $projects;
    }

    /**
     * @Route("/projects", name="projects_index")
     * @return Response
     */
    public function indexAction()
    {
       return $this->render("projects/index.html.twig", array("projects"=> $this->searchAll()));
    }

    public function checkExist($project){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:9000/api/components/show?key='. $project.'');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        $data = json_decode($response);
        if(isset($data->errors))
            return false;

        return true;
    }

    /**
     * @Route("/projects/{project}", name="projects_select")
     * @param $project
     * @return Response
     */
    public function selectAction($project)
    {
        if($this->checkExist($project)){
            $this->get('session')->set('project', $project);
        }
        else
            $this->addFlash("errors", "Projektu '" . $project. "' nie istnieje na serwerze.");

        return $this->render("projects/index.html.twig", array("projects"=> $this->searchAll()));
    }




}
