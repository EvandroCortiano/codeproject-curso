<?php

namespace CodeProject\Transformers;

use League\Fractal\TransformerAbstract;
use CodeProject\Entities\Client;

class ClientTransformer extends TransformerAbstract{
	
	public function transform(Client $client){
		return[
			'client_id' => $client->id,
			'name' => $client->name,
			'responsible' => $client->responsible,
			'email' => $client->email,
			'phone' => $client->phone,
			'adress' => $client->adress,
			'obs' => $client->obs,
		];
	}
}