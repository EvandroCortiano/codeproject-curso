<?php

namespace CodeProject\Services;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectValidator;
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
	
	public function __construct(ProjectRepository $repository, ProjectValidator $validators){
		$this->repository = $repository;
		$this->validators = $validators;
	}
	
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
	
	public function update(array $data, $id){
		return $this->repository->update($data, $id);
	}
}