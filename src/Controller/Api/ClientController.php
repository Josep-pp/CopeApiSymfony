<?php

namespace App\Controller\Api;

use App\Entity\Client;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\AbstractFOSRestController;

/**
* @Rest\Route(path="/client")
*/

class ClientController extends AbstractFOSRestController{

    private $rep; 

    public function __construct(ClientRepository $rep){ 

        $this->rep = $rep;

    }

    /**
    * @Rest\Post (path="/")
    * @Rest\View (serializerGroups={"client"}, serializerEnableMaxDepthChecks= true)
    */
				
    public function createClient(Request $request){ 

        $client = new Client();
                    
        $form = $this->createForm(ClientType::class, $client);
                    
        $form->handleRequest($request);
                    
        if(!$form->isSubmitted() || !$form->isValid() ){
            
            return new JsonResponse ('Bad data', 400);
        }
                
        $this->rep->add($client, true);
        return $client;
                    
    }

    /**
    * @Rest\Get (path="/")
    * @Rest\View (serializerGroups={"client"}, serializerEnableMaxDepthChecks = true)
    */

    public function  getAllClient(){

        return $this->rep->findAll();

    }

    /**
    * @Rest\Get (path="/{id}")
    * @Rest\View(serializerGroups={"client_no_id"}, serializerEnableMaxDepthChecks= true)
    */

    public function getClient(Request $request){

	    $idClient = $request->get('id');

	    $client = $this->rep->find($idClient);

	    if(!$client){

		    return new JsonResponse('Client not found', 404);

	    }

	    return $client;

	}

    /**
    * @Rest\Patch(path="/{id}")
    * @Rest\View (serializerGroups={"client_no_id"}, serializerEnableMaxDepthChecks=true)
    */

	public function updateClient(Request $request){    

		$idClient = $request->get('id'); 

		$client = $this->rep->find($idClient);

		if(!$client){

			return new JsonResponse('Client not found', 404);

		}

		$form = $this->createForm(ClientType::class,$client,['method'=>$request->getMethod()]);

		$form->handleRequest($request);

		if(!$form->isSubmitted() || !$form->isValid()){

			return new JsonResponse('Bad data', 400);

		}

		$this->rep->add($client, true);

		return $client;
	}

	/**
	* @Rest\Delete (path="/{id}")
	*
	*/
			 
     public function deleteNombreEntidad(Request $request){

		$idClient = $request->get('id');

		$client = $this->rep->find($idClient);

		if(!$client){

			 return new JsonResponse('Client not found', 404);

		}

		$this->rep->remove($client, true);

		return new JsonResponse('Client erased', 200);

	}

 }