<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;

use LucaDegasperi\OAuth2Server\Facades\Authorizer;
use CodeProject\Entities\User;

class UserController extends Controller
{
    private $repository;
    
    public function __construct(User $repository){
    	$this->repository = $repository;
    }
    
    public function authenticated(){
    	$userId = Authorizer::getResourceOwnerId();
		return $this->repository->find($userId);
	}
}
