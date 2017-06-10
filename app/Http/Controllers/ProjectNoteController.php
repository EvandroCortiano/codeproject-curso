<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\Access\Response;
use CodeProject\Repositories\ProjectNoteRepository;
use CodeProject\Services\ProjectNoteService;
use CodeProject\Entities\ProjectNote;


class ProjectNoteController extends Controller
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
	public function __construct(ProjectNoteRepository $repository, ProjectNoteService $service){
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
	public function store(Request $request, $project_id){
		return $this->service->create($request->all(), $project_id);
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
		$note = $this->repository->findWhere(['project_id' => $id, 'id' => $noteId]);
		return $note[0];
	}
}
