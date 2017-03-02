<?php

namespace CodeProject\Http\Middleware;

use Closure;
use CodeProject\Repositories\ProjectRepository;
use Illuminate\Cache\Repository;

class CheckProjectOwner
{
	public function __construct(ProjectRepository $repository){
		$this->repository = $repository;
	}
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
    	//Pegar o id do user
    	$userId = \Authorizer::getResourceOwnerId();
    	$projectId = $request->project;
    	
    	if($this->repository->isOwner($projectId, $userId) == false){
    		return ['success' => false];
    	}
    	
        return $next($request);
    }
}
