<?php

namespace App\Controller\Api;

use App\Entity\OrderLine;
use App\Form\OrderLineType;
use App\Repository\OrderLineRepository;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\AbstractFOSRestController;

/**
* @Rest\Route(path="/orderline")
*/

class OrderLineController extends AbstractFOSRestController{

    private $rep; 

    public function __construct(OrderLineRepository $rep){ 

        $this->rep = $rep;

    }

    /**
    * @Rest\Post (path="/")
    * @Rest\View (serializerGroups={"orderline"}, serializerEnableMaxDepthChecks= true)
    */
				
    public function createOrderLine(Request $request){ 

        $orderLine = new OrderLine();
                    
        $form = $this->createForm(OrderLineType::class, $orderLine);
                    
        $form->handleRequest($request);
                    
        if(!$form->isSubmitted() || !$form->isValid() ){
            
            return new JsonResponse ('Bad data', 400);
        }
                
        $this->rep->add($orderLine, true);
        return $orderLine;
                    
    }

    /**
    * @Rest\Get (path="/")
    * @Rest\View (serializerGroups={"orderline"}, serializerEnableMaxDepthChecks = true)
    */

    public function  getAllOrderLine(){

        return $this->rep->findAll();

    }

    /**
    * @Rest\Get (path="/{id}")
    * @Rest\View(serializerGroups={"orderline_no_id"}, serializerEnableMaxDepthChecks= true)
    */

    public function getOrderLine(Request $request){

	    $idOrderLine = $request->get('id');

	    $orderLine = $this->rep->find($idOrderLine);

	    if(!$orderLine){

		    return new JsonResponse('OrderLine not found', 404);

	    }

	    return $orderLine;

	}

    /**
    * @Rest\Patch(path="/{id}")
    * @Rest\View (serializerGroups={"orderline_no_id"}, serializerEnableMaxDepthChecks=true)
    */

	public function updateOrderLine(Request $request){    

		$idOrderLine = $request->get('id'); 

		$orderLine = $this->rep->find($idOrderLine);

		if(!$orderLine){

			return new JsonResponse('OrderLine not found', 404);

		}

		$form = $this->createForm(OrderLineType::class,$orderLine,['method'=>$request->getMethod()]);

		$form->handleRequest($request);

		if(!$form->isSubmitted() || !$form->isValid()){

			return new JsonResponse('Bad data', 400);

		}

		$this->rep->add($orderLine, true);

		return $orderLine;
	}

	/**
	* @Rest\Delete (path="/{id}")
	*
	*/
			 
     public function deleteNombreEntidad(Request $request){

		$idOrderLine = $request->get('id');

		$orderLine = $this->rep->find($idOrderLine);

		if(!$orderLine){

			 return new JsonResponse('OrderLine not found', 404);

		}

		$this->rep->remove($orderLine, true);

		return new JsonResponse('OrderLine erased', 200);

	}

 }