<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\Access\Response;
use CodeProject\Repositories\ProjectTaskRepository;
use CodeProject\Services\ProjectTaskService;

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
	 * @param ProjectNoteRepository $repository
	 * @param ProjectNoteService $service
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
	public function update(Request $request, $id, $noteId){
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
	public function show($id, $noteId){
		return $this->repository->findWhere(['project_id' => $id, 'id' => $noteId]);
	}
}