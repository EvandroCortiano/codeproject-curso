<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Client;

use Illuminate\Http\Request;


class ClientController extends Controller
{
    public function index(){
    	return \CodeProject\Client::all();
	}
    
	public function store(Request $request){
		return Client::create($request->all());
	}
	
	public function show($id){
		return Client::find($id);
	}
	
	public function destroy($id){
		Client::find($id)->delete();
		return "Deletado";
	}
	
	public function update($id, Request $request){
		$client = Client::findorfail($id);
		
		$client->update($request->all());
		
		if($client){		
			return "Atualizado com sucesso <br>" . $client;
		} else {
			return "Erro ao atualizar";
		}
	}
}
	