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
		return $this->service->show($id);
	}
}
