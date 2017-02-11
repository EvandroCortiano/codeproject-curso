<?php

namespace CodeProject\Services;

use CodeProject\Repositories\ClientRepository;
use CodeProject\Validators\ClientValidator;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Cache\Repository;

class ClientService{
	/**
	 * @var ClientRepository
	 */
	protected $repository;
	/**
	 * @var ClientValidator
	 */
	protected $validator;
	
	public function __construct(ClientRepository $repository, ClientValidator $validators){
		$this->repository = $repository;
		$this->validators = $validators;
	}
	
	//Cria um novo Client
	public function create(array $data){
		try {
			$this->validators->with($data)->passesOrFail();
			//poderia enviar um email, disparar notificação, postar um tweet
			return $this->repository->create($data);
		} catch (ValidatorException $e){
			return [
				'error' => true,
				'message' => $e->getMessageBag()
			];
		}
	}
	
	//Atualiza Client
	public function update(array $data, $id){
		try {
			$this->validators->with($data)->passesOrFail();
			
			$client = $this->repository->find($id);			
			$client->update($data);
			
			return $client;
		} catch(ValidatorException $e){
			return [
				'error' => true,
				'message' => $e->getMessageBag()
			];
		}
	}
	
	//Apaga Client selecionado
	public function destroy($id){
		try {
			$this->repository->find($id)->delete();
			return "Deleted successfully!";
		} catch (Exception $e){
			return  $e;
		}
	}
	
	//Retorna todos os resultados
	public function index(){
		try {
			return $this->repository->all();
		} catch (Exception $e) {
			return  $e;
		}
	}
	
	//Retorna o Client selecionado
	public function show($id){
		try{
			$client = $this->repository->find($id);
			return $client . "<br/> Projet of this Client: <br/>" . $client->project;
		} catch (Exception $e){
			return $e;
		}
	}
}