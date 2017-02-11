<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\Access\Response;
use CodeProject\Repositories\ClientRepository;
use CodeProject\Services\ClientService;

class ClientController extends Controller
{
	/**
	 * @var ClientRepository
	 */
	//serve para utilizar o repository ClientRepository em toda a classe
	//cria metodo privato e um metodo construtor
	private $repository;
	
	/**
	 * 
	 * @var ClientService
	 */
	private $service;
	
	/**
	 * 
	 * @param ClientRepository $repository
	 * @param ClientService $service
	 */
	public function __construct(ClientRepository $repository, ClientService $service){
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
     * @return Response
     */
	public function store(Request $request){
		return $this->service->create($request->all());
	}
	
	/**
	 * 
	 * @param int $id
	 * @return Response
	 */
	public function show($id){
		return $this->service->show($id);
	}
	
	/**
	 * 
	 * @param int $id
	 * @return Response
	 */
	public function destroy($id){
		$this->service->destroy($id);
	}
	
	/**
	 * 
	 * @param int $id
	 * @param Request $request
	 * @return Response
	 */
	public function update(Request $request, $id){
		return $this->service->update($request->all(), $id);
	}

}
	