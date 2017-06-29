<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\Access\Response;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectService;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;


class ProjectController extends Controller
{
    //inicia com o metodo privado e contrutor do Repository and Service para usar nesta classe
    /**
     * 
     * @var ProjectRepository
     */
	private $repository;
	
	/**
	 * 
	 * @var ProjectService
	 */
	private $service;
	
	/**
	 *
	 * @param ProjectRepository $repository
	 * @param ProjectService $service
	 */
	//metodo construtor
	public function __construct(ProjectRepository $repository, ProjectService $service){
		$this->repository = $repository;
		$this->service = $service;
	}
	
	/**
	 *
	 * @return Response
	 */
	public function index(){
		
// 		if ($this->checkProjectOwer($id) == false){
// 			return ['error' => 'Access Forbidden'];
// 		}
		
// 		return $this->service->findWhere(['owner_id' => Authorizer::getResourceOwnerId()]);
		return $this->service->index();
	}
	
	/**
	 * 
     * @param Request  $request
     * @return Respons
	 */
	public function store(Request $request){
		
		if ($this->checkProjectOwer($id) == false){
			return ['error' => 'Access Forbidden'];
		}
		
		return $this->service->create($request->all());
	}
	
	/**
	 * 
	 * @param Request $request
	 * @param unknown $id
	 * @return Response
	 */
	public function update(Request $request, $id){
		
		if ($this->checkProjectOwer($id) == false){
			return ['error' => 'Access Forbidden'];
		}
		
		return $this->service->update($request->all(), $id);
	}

	/**
	 * 
	 * @param unknown $id
	 * @return string|Exception
	 */
	public function destroy($id){
		
		if ($this->checkProjectOwer($id) == false){
			return ['error' => 'Access Forbidden'];
		}
		
		return $this->service->destroy($id);
	}
	
	/**
	 * 
	 * @param unknown $id
	 * @return unknown
	 */
	public function show($id){
		//Pegar o id do user
		//$userId = \Authorizer::getResourceOwnerId();
		
		//if($this->repository->isOwner($id, $userId) == false){
		//	return ['success' => false];
		//}
		/*
		if ($this->checkProjectPermissions($id) == false){
			return ['error' => 'Access Forbidden'];	
		}*/
		
		return $this->service->show($id);
	}
	
	/**
	 * 
	 * @param unknown $project_id
	 * @param unknown $user_id
	 * @return unknown
	 */
	
	public function storeMember($project_id, $user_id){
		return $this->service->addMember($project_id, $user_id);
	}
	
	/**
	 * 
	 * @param unknown $project_id
	 * @param unknown $user_id
	 * @return unknown
	 */
	public function destroyMember($project_id, $user_id){
		return $this->service->removeMember($project_id, $user_id);
	}
	
	public function members($project_id){
		return $this->service->isMember($project_id);
	}
	
	//Metodo para verificar a autoriza��o
	private function checkProjectOwer($projectId){
		//Pegar o id do user
		$userId = \Authorizer::getResourceOwnerId();
		
		return $this->repository->isOwner($projectId, $userId);
	}
	
	private function checkProjectMember($projectId){
		//Pegar o id do user
		$userId = \Authorizer::getResourceOwnerId();
	
		return $this->repository->hasMember($projectId, $userId);
	}
	
	private function checkProjectPermissions($projectId){
		if($this->checkProjectOwer($projectId) or $this->checkProjectMember($projectId)){
			return true;
		}
			return false;
	}
}
