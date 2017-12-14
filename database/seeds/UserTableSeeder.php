<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
			$user = new User;
			$user->name = 'admin';
			$user->email = 'admin@example.com';
			$user->username = 'admin';
			$user->password = bcrypt('demo123');
			$user->mobile = '';
			$user->address = '';
			$user->super_user = 1;
			$user->status = 1;
			$user->save();
		});
    }
}
