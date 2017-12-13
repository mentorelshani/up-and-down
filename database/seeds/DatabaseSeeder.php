<?php

use Illuminate\Database\Seeder;
use App\Models\Access_point; 
use App\Models\Address; 
use App\Models\Apartment; 
use App\Models\Building; 
use App\Models\Card; 
use App\Models\Card_access; 
use App\Models\Check_in; 
use App\Models\City; 
use App\Models\Client; 
use App\Models\Elevator; 
use App\Models\Entry; 
use App\Models\Invalid_check_in; 
use App\Models\Monitor; 
use App\Models\Payment; 
use App\Models\Product; 
use App\Models\Relay; 
use App\Models\Role_Access;
use App\Models\Role;
use App\Models\Version;  
use App\User;


class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

		$faker = Faker\Factory::create();
		for ($i=0; $i < 20; $i++) {

			$address = new Address();
			$address->city_id = rand(1,36);
            $address->street = $faker->address;
            $address->neighborhood = $faker->word;
            $address->save();
		}

		for ($i=0; $i < 20; $i++) { 
			$role = new Role();
			$role->name = $faker->word;
			$role->save();
		}
		 
		for ($i = 0; $i < 10; $i++){
			$user = new User();
			$user->username = $faker->userName;
			$user->created_by = 1;
			$user->gender = $i%2==1?'M':'F';
			$user->birthday = $faker->date;
			$user->password = bcrypt("123456");
		    $user->email = $faker->email;
		    $user->role_id = 2;
		    $user->save();
		}

		for ($i=0; $i < 60; $i++) { 
			$building = new Building();
			$building->address_id = $i%20+1;
			$building->name = $faker->word;
			$building->company = $faker->word;
			$building->location = "(42,21)";
			$building->created_by = rand(2,11);
			$building->save();
		}

		for ($i=0; $i < 60; $i++) { 
			$role_access = new Role_Access();
			$role_access->role_id = rand(3,20);
			$role_access->building_id = rand(1,60);

			if($i%3==0)
				$role_access->permission = 'R';
			else if ($i%3==1) 
				$role_access->permission = 'W';
			else
				$role_access->permission = 'D';
			$role_access->save();
		}

		for ($i=0; $i < 120 ; $i++) { 
			$entry = new Entry();
			$entry->building_id = $i%59+1;
			$entry->name = $faker->word;
			$entry->number_of_floors = rand(5,15);
			$entry->number_of_apartments = $entry->number_of_floors * 5;
			$entry->save();
		}

		for ($i=0; $i < 200; $i++) { 
			$elevator = new Elevator();
			$elevator->entry_id = rand(1,120);
			$elevator->identifier = $faker->word;
			$elevator->type = $faker->word;
			$elevator->made_in = $faker->word;
			$elevator->company = $faker->word;
			$elevator->save();
		}

		for ($i=0; $i < 4; $i++) { 
			$version = new Version();
			$version->name = $faker->word;
			$version->number_of_relays = rand (10,20);
			$version->save();
		}

		for ($i=0; $i < 400; $i++) { 
			$access_point = new Access_point();
			$access_point->elevator_id = $i%199 +1;
			$access_point->version_id = rand(1,3);
			$access_point->IMEI = rand(1000,2000);
			$access_point->phone_number = $faker->phoneNumber;
			$access_point->notes = $faker->word;
			$access_point->save();
		}

		for ($i=0; $i < 4800; $i++) { 
			$relay = new Relay();
			$relay->access_point_id = $i%399 +1;
			$relay->relay = rand(1,18);
			$relay->floor = $faker->word;
			$relay->pulse_time = 3.00;
			$relay->save();
		}

		for ($i=0; $i < 500; $i++) { 
			$apartment = new Apartment();
			$apartment->entry_id = $i%120 + 1;
			$apartment->door_number = rand(1,50);
			$apartment->save();
		}

		for ($i=0; $i < 1000; $i++) { 
			$client = new Client();
			$client->apartment_id = $i%499 +1;
			$client->firstname = $faker->firstName;
			$client->lastname = $faker->lastName;
			$client->gender = $i%3==1?'M':'F';
			$client->birthday = $faker->date;
			$client->email = $faker->email;
			$client->phone_number = $faker->phoneNumber;
			$client->type = 'Client';
			$client->save();
		}

		for ($i=0; $i < 60; $i++) { 
			$product = new Product();
			$product->name = $i%5<2?'Pagesa mujore':'Blerje e karteles';
			$product->from = $faker->date;
			$product->until = $faker->date;
			$product->save();
		}

		for ($i=0; $i < 2000; $i++) { 
			$payment = new Payment();
			$payment->product_id = rand(1,60);
			$payment->client_id = rand(1,1000);
			$payment->price = rand(10, 30) / 10;
			$payment->save();
		}

		for ($i=0; $i < 2000; $i++) { 
			$card = new Card();
			$card->client_id = $i%1000 + 1;
			$card->site_code = rand(100,999);
			$card->site_number = rand(1000,9999);
			$card->active = $i%2==0;
			$card->save();
		}

		for ($i=0; $i < 5000; $i++) { 
			$card_access = new Card_access();
			$card_access->card_id = rand(1,2000);
			$card_access->relay_id = rand(1,4800);
			$card_access->save();
		}

		for ($i=0; $i < 2000; $i++) { 
			$monitor = new Monitor();
			$monitor->access_point_id = rand(1,400);
			$monitor->card_id = rand(1,2000);
			$monitor->type = $i%2==0?'insert':'delete';
			$monitor->save();
		}

		for ($i=0; $i < 2000; $i++) { 
			$check_in = new Check_in();
			$check_in->card_id = rand(1,2000);
			$check_in->relay_id = rand(1,4800);
			$check_in->validity = $i%5!=0?'valid':'copy';
			$check_in->save();
		}

		for ($i=0; $i < 2000; $i++) { 
			$invalid_check_in = new Invalid_check_in();
			$invalid_check_in->relay_id = rand(1,4800);
			$invalid_check_in->site_code = rand(100,999);
			$invalid_check_in->site_number = rand(1000,9999);
			$invalid_check_in->validity = 'invalid';
			$invalid_check_in->save();
		}




    }
}
