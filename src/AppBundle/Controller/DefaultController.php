<?php

namespace AppBundle\Controller;

use AppBundle\CSVStructure\Employee;
use MBL\CSVRWBundle\Reader\Csv;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{

    /**
     * @Route("/csv/import")
     * @Template()
     */
    public function indexAction(){
        return $this->render('MBLCSVRWBundle:Default:index.html.twig');
        return array();
    }

    /**
     * @Route("/csv/handle", name = "import-handler-path")
     */
    public function handleImportAction(Request $request){

        $file = $request->files->get("imported-file")->getPathName();
        $reader = new Csv();
        $file = $reader->fromFile($file);
        $csvEmploye = new Employee();
        $content = $csvEmploye->plan1($file,'\AppBundle\Entity\Employee');
        //$content = $csvEmploye->formatBatch($file);
        echo '<pre>';
        print_r($content);
        exit();
        //$content = $csvReader->formatBatch($file);
        $targetModel = '\MT\Bundle\CommonBundle\Entity\UniversalDirectory';
        //$file  = $csvReader->formatObjectModel($content, $targetModel);
        //$formatter = new
        echo '<pre>';
        print_r($file);
        exit();
        exit();
    }
}
