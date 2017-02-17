<?php

namespace CodeProject\Services;

use Illuminate\Cache\Repository;
use Prettus\Validator\Exceptions\ValidatorException;
use CodeProject\Validators\ProjectTaskValidator;
use CodeProject\Repositories\ProjectTaskRepository;
use CodeProject\Validators\ProjectNoteValidator;

class ProjectTaskService{
	/**
	 * @var ProjectTaskRepository
	 */
	protected $repository;
	/**
	 * @var ProjectTaskValidator
	 */
	protected $validator;
	
	public function __construct(ProjectTaskRepository $repository, ProjectTaskValidator $validators){
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
			//poderia enviar um email, disparar notifica��o, postar um tweet
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
			
			$task = $this->repository->find($id);
			$task->update($data);
			
			return $task;
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
			$task = $this->repository->find($id);
			return $task . "<br/> Task of project: <br/>" . $task->project;
		} catch (Exception $e){
			return $e;
		}
	}

}