<?php

namespace App\Controller\Api;

use App\Entity\Batch;
use App\Form\BatchType;
use App\Repository\BatchRepository;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\AbstractFOSRestController;

/**
* @Rest\Route(path="/batch")
*/

class BatchController extends AbstractFOSRestController{

    private $rep; 

    public function __construct(BatchRepository $rep){ 

        $this->rep = $rep;

    }

    /**
    * @Rest\Post (path="/")
    * @Rest\View (serializerGroups={"batch"}, serializerEnableMaxDepthChecks= true)
    */
				
    public function createBatch(Request $request){ 

        $batch = new Batch();
                    
        $form = $this->createForm(BatchType::class, $batch);
                    
        $form->handleRequest($request);
                    
        if(!$form->isSubmitted() || !$form->isValid() ){
            
            return new JsonResponse ('Bad data', 400);
        }
                
        $this->rep->add($batch, true);
        return $batch;
                    
    }

    /**
    * @Rest\Get (path="/")
    * @Rest\View (serializerGroups={"batch"}, serializerEnableMaxDepthChecks = true)
    */

    public function  getAllBatch(){

        return $this->rep->findAll();

    }

    /**
    * @Rest\Get (path="/{id}")
    * @Rest\View(serializerGroups={"batch_no_id"}, serializerEnableMaxDepthChecks= true)
    */

    public function getBatch(Request $request){

	    $idBatch = $request->get('id');

	    $batch = $this->rep->find($idBatch);

	    if(!$batch){

		    return new JsonResponse('Batch not found', 404);

	    }

	    return $batch;

	}

    /**
    * @Rest\Patch(path="/{id}")
    * @Rest\View (serializerGroups={"batch_no_id"}, serializerEnableMaxDepthChecks=true)
    */

	public function updateBatch(Request $request){    

		$idBatch = $request->get('id'); 

		$batch = $this->rep->find($idBatch);

		if(!$batch){

			return new JsonResponse('Batch not found', 404);

		}

		$form = $this->createForm(BatchType::class,$batch,['method'=>$request->getMethod()]);

		$form->handleRequest($request);

		if(!$form->isSubmitted() || !$form->isValid()){

			return new JsonResponse('Bad data', 400);

		}

		$this->rep->add($batch, true);

		return $batch;
	}

	/**
	* @Rest\Delete (path="/{id}")
	*
	*/
			 
     public function deleteNombreEntidad(Request $request){

		$idBatch = $request->get('id');

		$batch = $this->rep->find($idBatch);

		if(!$batch){

			 return new JsonResponse('Batch not found', 404);

		}

		$this->rep->remove($batch, true);

		return new JsonResponse('Batch erased', 200);

	}

 }