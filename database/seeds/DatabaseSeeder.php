<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	//Model::unguard();
    	
    	//CodeProject\Entities\Client::truncate();
    	//CodeProject\Entities\Project::truncate();
        
    	
    	$this->call(UserTableSeeder::class);
    	$this->call(ClientTableSeeder::class);
    	$this->call(ProjectTableSeeder::class);    	
    	$this->call(ProjectNoteTableSeeder::class);
    	$this->call(ProjectTaskTableSeeder::class);
		$this->call(OAuthClientSeeder::class);
    	
    	//Model::reguard();
    }
}
