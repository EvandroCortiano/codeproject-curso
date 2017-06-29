<?php

namespace CodeProject\Services;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectValidator;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Cache\Repository;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Filesystem\Factory as Storage;

class ProjectService{
	/**
	 * @var ClientRepository
	 */
	protected $repository;
	/**
	 * @var ClientValidator
	 */
	protected $validator;	
	/**
	 * @var Filesystem
	 */
	protected $filesystem;
	/**
	 * @var Storage
	 */
	protected $storage;
	
	public function __construct(ProjectRepository $repository, ProjectValidator $validators, Filesystem $filesystem, Storage $storage){
		$this->repository = $repository;
		$this->validators = $validators;
		$this->filesystem = $filesystem;
		$this->storage = $storage;
	}
	
	//Retorna todos os resultados
	public function index(){
		try {
			return $this->repository->skipPresenter()->all();
		} catch (Exception $e) {
			return  $e;
		}
	}
	
	//cria um novo registro Angular
	public function create(array $data, $project_id){
		try {
			$this->project_repository->skipPresenter()->find($project_id);
			try {
				$this->validator->with($data)->passesOrFail();
				return $this->repository->create($data);
			} catch (ValidatorException $e) {
				return [
						'success' => false,
						'message' => $e->getMessageBag()
				];
			}
		} catch (QueryException $e) {
			return [
					'success' => false,
					'message' => $e->getMessage()
			];
		} catch (\Exception $e) {
			return [
					'success' => false,
					'message' => $e->getMessage()
			];
		}
		/*try {
			$this->validators->with($data)->passesOrFail();
			//poderia enviar um email, disparar notifica��o, postar um tweet
			return $this->repository->create($data);
		} catch (ValidatorException $e){
			return [
				'error' => true,
				'message' => $e->getMessageBag()
			];
		}*/
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
	
	public function createFile(array $data){
		//Name
		//description
		//extension
		//file
		
		$project = $this->repository->skipPresenter()->find($data['project_id']);
		$projectFile = $project->files()->create($data);
		
		$this->storage->put($projectFile->id . "." . $data['extension'], $this->filesystem->get($data['file']));
	}

}