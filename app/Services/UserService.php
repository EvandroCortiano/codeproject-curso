<?php

namespace CodeProject\Services;

use CodeProject\Repositories\UserRepository;
use CodeProject\Validators\UserValidator;
use Illuminate\Database\QueryException;
use Prettus\Validator\Exceptions\ValidatorException;

class UserService {
	private $repository;
	private $validator;
	public function __construct(UserRepository $repository, UserValidator $validator) {
		$this->repository = $repository;
		$this->validator = $validator;
	}
	public function show($id) {
		try {
			return $this->repository->find ( $id );
		} catch ( QueryException $e ) {
			return [ 
					'success' => false,
					'message' => $e->getMessage () 
			];
		} catch ( \Exception $e ) {
			return [ 
					'success' => false,
					'message' => $e->getMessage () 
			];
		}
	}
	public function store(array $data) {
		try {
			$this->validator->with ( $data )->passesOrFail ();
			return $this->repository->create ( $data );
		} catch ( ValidatorException $e ) {
			return [ 
					'success' => false,
					'message' => $e->getMessageBag () 
			];
		}
	}
	public function update(array $data, $id) {
		try {
			$this->repository->skipPresenter ()->find ( $id );
			try {
				$this->validator->with ( $data )->passesOrFail ();
				return $this->repository->update ( $data, $id );
			} catch ( ValidatorException $e ) {
				return [ 
						'success' => false,
						'message' => $e->getMessageBag () 
				];
			}
		} catch ( QueryException $e ) {
			return [ 
					'success' => false,
					'message' => $e->getMessage () 
			];
		} catch ( \Exception $e ) {
			return [ 
					'success' => false,
					'message' => $e->getMessage () 
			];
		}
	}
}