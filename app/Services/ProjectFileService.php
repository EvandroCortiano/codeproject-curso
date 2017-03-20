<?php


namespace CodeProject\Services;
use Illuminate\Contracts\Filesystem\Factory as Storage;
use Illuminate\Filesystem\Filesystem;
use CodeProject\Repositories\ProjectFileRepository;
use CodeProject\Validators\ProjectValidator;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;
use Illuminate\Database\QueryException;

class ProjectFileService
{
	/**
	 * @var IClientRepository
	 */
	protected $repository;
	/**
	 * @var ClientValidator
	 */
	private $validator;
	
	public function __construct(ProjectFileRepository $repository,
			ProjectValidator $validator,
			Filesystem $filesystem,
			Storage $storage)
	{
		$this->validator = $validator;
		$this->repository = $repository;
		$this->filesystem = $filesystem;
		$this->storage = $storage;
	}

	public function find($id)
	{
		$result = $this->repository->with(['project'])->findWhere(['project_id'=> $id]);
		if(! $result ){
			return [
					'error' => true,
					'message' => 'File not found'
			];
		}
		return $result;
	}
	
	public function create(array $data)
	{
		try {
			$this->validator->with( $data )->passesOrFail();
			return $this->repository->create($data);
		} catch (ValidatorException $e) {
			return [
					'error' =>true,
					'message' => $e->getMessageBag()
			];
		}
	}
	public function update(array $data, $id)
	{
		try {
			$this->validator->with($data)->passesOrFail();
			$name = $data['name'];
			$this->repository->update($data,$id);
			return [
					'error' => false,
					'message' => 'Project ' . $name . ' updated'
			];
		} catch (ModelNotFoundException $e) {
			return [
					'error' => true,
					'message' => 'No query results'
			];
		} catch (ValidatorException $e) {
			return [
					'error' => true,
					'message' => $e->getMessageBag()
			];
		}
	}
	public function destroy($id)
	{
		try {
			$this->repository->find($id)->delete();
			return [
					'error' => false,
					'message' => 'Client Deleted'
			];
		} catch (ModelNotFoundException $e) {
			return [
					'error' => true,
					'message' => 'No deleted result'
			];
		} catch (ValidatorException $e) {
			return [
					'error' => true,
					'message' => $e->getMessageBag()
			];
		}
	}
	
	public function createFile(array $data)
	{
		// name, description, extension, File
		$project = $this->repository->skipPresenter()->find($data['project_id']);
		$projectFile = $project->files()->create($data);
		$this->storage->put($projectFile->id .".". $data['extension'], $this->filesystem->get($data['file']));
	}
}