<?php

namespace App\Controller\Api;

use App\Entity\Order;
use App\Form\OrderType;
use App\Repository\OrderRepository;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\AbstractFOSRestController;

/**
* @Rest\Route(path="/order")
*/

class OrderController extends AbstractFOSRestController{

    private $rep; 

    public function __construct(OrderRepository $rep){ 

        $this->rep = $rep;

    }

    /**
    * @Rest\Post (path="/")
    * @Rest\View (serializerGroups={"order"}, serializerEnableMaxDepthChecks= true)
    */
				
    public function createOrder(Request $request){ 

        $order = new Order();
                    
        $form = $this->createForm(OrderType::class, $order);
                    
        $form->handleRequest($request);
                    
        if(!$form->isSubmitted() || !$form->isValid() ){
            
            return new JsonResponse ('Bad data', 400);
        }
                
        $this->rep->add($order, true);
        return $order;
                    
    }

    /**
    * @Rest\Get (path="/")
    * @Rest\View (serializerGroups={"order"}, serializerEnableMaxDepthChecks = true)
    */

    public function  getAllOrder(){

        return $this->rep->findAll();

    }

    /**
    * @Rest\Get (path="/{id}")
    * @Rest\View(serializerGroups={"order_no_id"}, serializerEnableMaxDepthChecks= true)
    */

    public function getOrder(Request $request){

	    $idOrder = $request->get('id');

	    $order = $this->rep->find($idOrder);

	    if(!$order){

		    return new JsonResponse('Order not found', 404);

	    }

	    return $order;

	}

    /**
    * @Rest\Patch(path="/{id}")
    * @Rest\View (serializerGroups={"order_no_id"}, serializerEnableMaxDepthChecks=true)
    */

	public function updateOrder(Request $request){    

		$idOrder = $request->get('id'); 

		$order = $this->rep->find($idOrder);

		if(!$order){

			return new JsonResponse('Order not found', 404);

		}

		$form = $this->createForm(OrderType::class,$order,['method'=>$request->getMethod()]);

		$form->handleRequest($request);

		if(!$form->isSubmitted() || !$form->isValid()){

			return new JsonResponse('Bad data', 400);

		}

		$this->rep->add($order, true);

		return $order;
	}

	/**
	* @Rest\Delete (path="/{id}")
	*
	*/
			 
     public function deleteNombreEntidad(Request $request){

		$idOrder = $request->get('id');

		$order = $this->rep->find($idOrder);

		if(!$order){

			 return new JsonResponse('Order not found', 404);

		}

		$this->rep->remove($order, true);

		return new JsonResponse('Order erased', 200);

	}

 }