<?php

namespace App\Controller\Api;

use App\Entity\Adress;
use App\Form\AdressType;
use App\Repository\AdressRepository;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\AbstractFOSRestController;

/**
* @Rest\Route(path="/adress")
*/

class AdressController extends AbstractFOSRestController{

    private $rep; 

    public function __construct(AdressRepository $rep){ 

        $this->rep = $rep;

    }

    /**
    * @Rest\Post (path="/")
    * @Rest\View (serializerGroups={"adress"}, serializerEnableMaxDepthChecks= true)
    */
				
    public function createAdress(Request $request){ 

        $adress = new Adress();
                    
        $form = $this->createForm(AdressType::class, $adress);
                    
        $form->handleRequest($request);
                    
        if(!$form->isSubmitted() || !$form->isValid() ){
            
            return new JsonResponse ('Bad data', 400);
        }
                
        $this->rep->add($adress, true);
        return $adress;
                    
    }

    /**
    * @Rest\Get (path="/")
    * @Rest\View (serializerGroups={"adress"}, serializerEnableMaxDepthChecks = true)
    */

    public function  getAllAdress(){

        return $this->rep->findAll();

    }

    /**
    * @Rest\Get (path="/{id}")
    * @Rest\View(serializerGroups={"adress_no_id"}, serializerEnableMaxDepthChecks= true)
    */

    public function getAdress(Request $request){

	    $idAdress = $request->get('id');

	    $adress = $this->rep->find($idAdress);

	    if(!$adress){

		    return new JsonResponse('Adress not found', 404);

	    }

	    return $adress;

	}

    /**
    * @Rest\Patch(path="/{id}")
    * @Rest\View (serializerGroups={"adress_no_id"}, serializerEnableMaxDepthChecks=true)
    */

	public function updateAdress(Request $request){    

		$idAdress = $request->get('id'); 

		$adress = $this->rep->find($idAdress);

		if(!$adress){

			return new JsonResponse('Adress not found', 404);

		}

		$form = $this->createForm(AdressType::class,$adress,['method'=>$request->getMethod()]);

		$form->handleRequest($request);

		if(!$form->isSubmitted() || !$form->isValid()){

			return new JsonResponse('Bad data', 400);

		}

		$this->rep->add($adress, true);

		return $adress;
	}

	/**
	* @Rest\Delete (path="/{id}")
	*
	*/
			 
     public function deleteNombreEntidad(Request $request){

		$idAdress = $request->get('id');

		$adress = $this->rep->find($idAdress);

		if(!$adress){

			 return new JsonResponse('Adress not found', 404);

		}

		$this->rep->remove($adress, true);

		return new JsonResponse('Adress erased', 200);

	}

 }