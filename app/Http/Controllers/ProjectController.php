<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\Access\Response;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectService;


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
		return $this->service->index();
	}
	
	/**
	 * 
     * @param Request  $request
     * @return Respons
	 */
	public function store(Request $request){
		return $this->service->create($request->all());
	}
	
	/**
	 * 
	 * @param Request $request
	 * @param unknown $id
	 * @return Response
	 */
	public function update(Request $request, $id){
		return $this->service->update($request->all(), $id);
	}

	/**
	 * 
	 * @param unknown $id
	 * @return string|Exception
	 */
	public function destroy($id){
		return $this->service->destroy($id);
	}
	
	/**
	 * 
	 * @param unknown $id
	 * @return unknown
	 */
	public function show($id){
		//Pegar o id do user
		$userId = \Authorizer::getResourceOwnerId();
		
		if($this->repository->isOwner($id, $userId) == false){
			return ['success' => false];
		}
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
}
