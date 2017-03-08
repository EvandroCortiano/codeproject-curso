<?php

namespace CodeProject\Services;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectValidator;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Cache\Repository;

class ProjectService{
	/**
	 * @var ClientRepository
	 */
	protected $repository;
	/**
	 * @var ClientValidator
	 */
	protected $validator;
	
	public function __construct(ProjectRepository $repository, ProjectValidator $validators){
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
			return $project;
		} catch (Exception $e){
			return $e;
		}
	}
	
	//funcoes para a tabela project_members
	//Adicionar um novo member a um projecto
	public function addMember($project_id, $user_id){
		
		$project = $this->repository->find($project_id);
		
		if(!$this->member($project_id, $user_id)){
			$project->users()->attach($user_id);
		}
		
		return $project->users()->get();

	}
	
	//remove um membro de um projeto
	public function removeMember($project_id, $user_id){
		
		$project = $this->repository->find($project_id);
		
		$project->users()->detach($user_id);
		
		return $project->users()->get();
	}
	
	//verifica se um usuario é membro de um determinado projeto
	public function member($project_id, $user_id){
		
		$project = $this->repository->find($project_id)->users()->find(['user_id' => $user_id]);
		
		if(count($project)){
			return true;
		}
		
		return false;
	}
	
	//verifica os membros de um projeto
	public function isMember($project_id){
		$project = $this->repository->find($project_id);
		return $project->users;
	}

}