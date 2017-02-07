<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use CodeProject\Repositories\ClientRepository;
use CodeProject\Srvices\ClientService;
use Illuminate\Auth\Access\Response;

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
    	return $this->repository->all();
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
		return $this->repository->find($id);
	}
	
	/**
	 * 
	 * @param int $id
	 * @return Response
	 */
	public function destroy($id){
		$this->repository->find($id)->delete();
		return "Deletado";
	}
	
	/**
	 * 
	 * @param int $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, Request $request){
		$client = $this->repository->find($id);
		
		$client->update($request->all());
		
		if($client){		
			return "Atualizado com sucesso <br>" . $client;
		} else {
			return "Erro ao atualizar";
		}
	}
}
	