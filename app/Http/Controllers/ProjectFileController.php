<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\Access\Response;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectService;


class ProjectFileController extends Controller
{
    //inicia com o metodo privado e contrutor do Repository and Service para usar nesta classe
    /**
     * 
     * @var ProjectRepository
     */
	private $repository;
	
	/**
	 * 
	 * @var ProjectService
	 */
	private $service;
	
	/**
	 *
	 * @param ProjectRepository $repository
	 * @param ProjectService $service
	 */
	//metodo construtor
	public function __construct(ProjectRepository $repository, ProjectService $service){
		$this->repository = $repository;
		$this->service = $service;
	}
	
	/**
	 *
	 * @return Response
	 */
	public function index(){
		return $this->service->findWhere(['owner_id' => \Authorizer::getResourceOwnerId()]);
	}
	
	/**
	 * 
     * @param Request  $request
     * @return Respons
	 */
	public function store(Request $request){
		//recebe o arquivo
		$file = $request->file('file');
		//pega a extens�o
		$extension = $file->getClientOriginalExtension();
		
		//carrega o array com os dados
		$data['file'] = $file;
		$data['extension'] = $extension;
		$data['name'] = $request->name;
		$data['project_id'] = $request->project_id;
		$data['description'] = $request->description;

		$this->service->createFile($data);	

		//chama as facedes Storage e Files para pegar o arquivo e salvar no local 
		//Storage::put($request->name.".".$extension, File::get($file));
		
	}
	
	/**
	 * 
	 * @param Rquest $request
	 * @param $project_id
	 * @param $fileId
	 */
	public function destroy(Rquest $request, $project_id, $fileId){
		$data['fileId'] = $fileId;
		$data['project_id'] = $project_id;
		
		return $this->service->deleteFile($data);
	}
}
