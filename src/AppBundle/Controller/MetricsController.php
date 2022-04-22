<?php

namespace AppBundle\Controller;

use AppBundle\Service\ConnectionService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class MetricsController extends Controller
{
    public function search($metric, $project){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://localhost:9000/api/measures/component?metricKeys=ncloc&component=CodeQuality');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        $data = json_decode($response);
        $d = $data->component->measures;

        return array("metric"=>$d[0]->metric, "value" => $d[0]->value);
    }


    /**
     * @Route("/", name="homepage")
     * @Route("/metrics", name="metrics_index")
     * @return Response
     */
    public function indexAction()
    {

        $project = $this->get('session')->get('project');;
        ///$project = "CodeQuality";
        $ncloc = $this->search("ncloc", $project);
        $lines = $this->search("lines", $project);
        $comments = $this->search("comment_lines_density", $project);
        $comment_lines = $this->search("comment_lines", $project);
        $files = $this->search("files", $project);
        $directories = $this->search("directories", $project);
        $classes = $this->search("classes", $project);
        $duplicated_blocks = $this->search("complexity", $project);
        $complexity = $this->search("duplicated_blocks", $project);

        return $this->render("metrics/index.html.twig", array("ncloc" => $ncloc, "lines" => $lines, "comments" => $comments, "comment_lines" => $comment_lines, "files" => $files, "directories" => $directories, "classes" => $classes, "duplicated_blocks" => $duplicated_blocks, "complexity" => $complexity));

    }




}
