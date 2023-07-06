<?php

namespace App\Controller\Api;

use App\Entity\Employee;
use App\Form\EmployeeType;
use App\Repository\EmployeeRepository;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\AbstractFOSRestController;

/**
* @Rest\Route(path="/employee")
*/

class EmployeeController extends AbstractFOSRestController{

    private $rep; 

    public function __construct(EmployeeRepository $rep){ 

        $this->rep = $rep;

    }

    /**
    * @Rest\Post (path="/")
    * @Rest\View (serializerGroups={"employee"}, serializerEnableMaxDepthChecks= true)
    */
				
    public function createEmployee(Request $request){ 

        $employee = new Employee();
                    
        $form = $this->createForm(EmployeeType::class, $employee);
                    
        $form->handleRequest($request);
                    
        if(!$form->isSubmitted() || !$form->isValid() ){
            
            return new JsonResponse ('Bad data', 400);
        }
                
        $this->rep->add($employee, true);
        return $employee;
                    
    }

    /**
    * @Rest\Get (path="/")
    * @Rest\View (serializerGroups={"employee"}, serializerEnableMaxDepthChecks = true)
    */

    public function  getAllEmployee(){

        return $this->rep->findAll();

    }

    /**
    * @Rest\Get (path="/{id}")
    * @Rest\View(serializerGroups={"employee_no_id"}, serializerEnableMaxDepthChecks= true)
    */

    public function getEmployee(Request $request){

	    $idEmployee = $request->get('id');

	    $employee = $this->rep->find($idEmployee);

	    if(!$employee){

		    return new JsonResponse('Employee not found', 404);

	    }

	    return $employee;

	}

    /**
    * @Rest\Patch(path="/{id}")
    * @Rest\View (serializerGroups={"employee_no_id"}, serializerEnableMaxDepthChecks=true)
    */

	public function updateEmployee(Request $request){    

		$idEmployee = $request->get('id'); 

		$employee = $this->rep->find($idEmployee);

		if(!$employee){

			return new JsonResponse('Employee not found', 404);

		}

		$form = $this->createForm(EmployeeType::class,$employee,['method'=>$request->getMethod()]);

		$form->handleRequest($request);

		if(!$form->isSubmitted() || !$form->isValid()){

			return new JsonResponse('Bad data', 400);

		}

		$this->rep->add($employee, true);

		return $employee;
	}

	/**
	* @Rest\Delete (path="/{id}")
	*
	*/
			 
     public function deleteNombreEntidad(Request $request){

		$idEmployee = $request->get('id');

		$employee = $this->rep->find($idEmployee);

		if(!$employee){

			 return new JsonResponse('Employee not found', 404);

		}

		$this->rep->remove($employee, true);

		return new JsonResponse('Employee erased', 200);

	}

 }