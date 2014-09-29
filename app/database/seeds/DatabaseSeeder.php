<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('AddressTableSeeder');
	}



}

class AddressTableSeeder extends Seeder {
 
    public function run()
    {
        // $faker->seed(1234);
 
        for( $x=0 ; $x<1000; $x++ )
        {
            Address::create(array(
            	'address'=>'1688 Los Berros Rd',
            	'lng' => rand(-120,120),
            	'lat' => rand(-120,120),
            	'depth' => rand(0,100),
            	'flow_rate' => rand(0,100),
            	'year_dug' => rand(0,200),
            	'user_id' => rand(0,1000),

            ));
        }
 
        $this->command->info('Person table seeded using Faker ...');
    }
 
}
