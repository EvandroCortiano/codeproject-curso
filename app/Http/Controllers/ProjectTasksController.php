<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\Access\Response;
use CodeProject\Repositories\ProjectTaskRepository;
use CodeProject\Services\ProjectTaskService;
use CodeProject\Entities\ProjectTask;

class ProjectTasksController extends Controller
{
	//inicia com o metodo privado e contrutor do Repository and Service para usar nesta classe
	/**
	 *
	 * @var ProjectTaskRepository
	 */
	private $repository;
	
	/**
	 *
	 * @var ProjectTaskService
	 */
	private $service;
	
	/**
	 *
	 * @param ProjectTaskRepository $repository
	 * @param ProjectTaskService $service
	 */
	//metodo construtor
	public function __construct(ProjectTaskRepository $repository, ProjectTaskService $service){
		$this->repository = $repository;
		$this->service = $service;
	}
	
	/**
	 *
	 * @return Response
	 */
	public function index($id){
		return $this->repository->findWhere(['project_id' => $id]);
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
	public function update(Request $request, $id, $taskId){
		return $this->service->update($request->all(), $id, $taskId);
	}
	
	/**
	 *
	 * @param unknown $id
	 * @return string|Exception
	 */
	public function destroy($id, $taskId){
		return $this->service->destroy($id, $taskId);
	}
	
	/**
	 *
	 * @param unknown $id
	 * @return unknown
	 */
	public function show($id, $taskId){
		return $this->service->show($id, $taskId);
	}
}
