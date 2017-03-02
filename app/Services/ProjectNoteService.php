<?php

namespace CodeProject\Services;

use CodeProject\Repositories\ProjectNoteRepository;
use CodeProject\Validators\ProjectNoteValidator;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Cache\Repository;

class ProjectNoteService{
	/**
	 * @var ProjectNoteRepository
	 */
	protected $repository;
	/**
	 * @var ProjectNoteValidator
	 */
	protected $validator;
	
	public function __construct(ProjectNoteRepository $repository, ProjectNoteValidator $validators){
		$this->repository = $repository;
		$this->validators = $validators;
	}
	
	//Retorna todos os resultados
	public function index(){
		try {
			return $this->repository->all();
		} catch (Exception $e) {
			return  $e;
		}
	}
	
	//cria um novo registro
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
	
	//atualiza dados
	public function update(array $data, $id){
		try {
			$this->validators->with($data)->passesOrFail();
			
			$project = $this->repository->find($id);
			$project->update($data);
			
			return $project;
		} catch (ValidatorException $e){
			return [
					'error' => true,
					'message' => $e->getMessageBag()
			];
		}
	}
	
	//apagar os dados do banco
	public function destroy($id){
		try {
			$this->repository->find($id)->delete();
			return "Deletado com sucesso";
		} catch (Exception $e) {
			return  $e;
		}
	}
	
	//busca o registro selecionado
	public function show($id){
		try{
			$project = $this->repository->find($id);
			return $project . "<br/> Client of this project: <br/>" . $project->client;
		} catch (Exception $e){
			return $e;
		}
	}

}