<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use App\User;
use App\Vendor;
use Illuminate\Support\Facades\Hash;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'Super Admin', 'guard_name' => 'api']);
        Role::create(['name' => 'User', 'guard_name' => 'api']);
        Role::create(['name' => 'Vendor', 'guard_name' => 'api']);

        $admin = User::create([
            'full_name' => 'admin',
            'email'     => 'admin@helper.com',
            'phone_number' => '081234567890',
            'account_verified_at' => Carbon::now(),
            'password' => Hash::make('admin123'),
            'address' => 'Unknown place',
            'langitude' => '-6.9759416',
            'longitude' => '107.6695213',
            'date_of_birth' => '1999-10-11',
            'user_type' => 0,
        ]);

        $admin->assignRole('Super Admin');

        $user = User::create([
            'full_name' => 'De Paul',
            'email'     => 'depaul@example.com',
            'phone_number' => '081223344556',
            'account_verified_at' => Carbon::now(),
            'password' => Hash::make('password123'),
            'address' => 'Unknown place',
            'langitude' => '-66.9759416',
            'longitude' => '17.6695213',
            'date_of_birth' => '1999-12-11',
            'user_type' => 1,
        ]);

        $user->assignRole('User');

        $vendor = User::create([
            'full_name' => 'Marco Reus',
            'email'     => 'marcor@example.com',
            'phone_number' => '081223344551',
            'account_verified_at' => Carbon::now(),
            'password' => Hash::make('password123'),
            'address' => 'Unknown place',
            'langitude' => '-3.9759416',
            'longitude' => '179.6695213',
            'date_of_birth' => '1999-12-11',
            'user_type' => 2,
        ]);

        Vendor::create([
            'user_id' => 3,
            'name' => 'Markas Sampah',
            'phone_office' => '081122334455',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ut lacus cursus, aliquet ante ut, efficitur quam.',
            'address' => 'Unknown place',
            'langitude' => '-3.9759416',
            'longitude' => '179.6695213',
            'photo_1' => '/storage/image/image_store_13841341.jpg'
        ]);

        $vendor->assignRole('Vendor');
    }
}
