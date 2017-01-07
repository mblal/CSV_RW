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
    const TARGET_MODEL = '\AppBundle\Entity\Employee';

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
        $content = $csvEmploye->getObjectModel($file,self::TARGET_MODEL);

        echo '<pre>';
        print_r($content);
        exit();
    }
}
