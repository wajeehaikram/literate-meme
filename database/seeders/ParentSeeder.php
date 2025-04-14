<?php

namespace Database\Seeders;

use App\Models\ParentProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ParentSeeder extends Seeder
{
    public function run(): void
    {
        $parents = [
            [
                'name' => 'Robert Johnson',
                'email' => 'robert.johnson@learnscape.com',
                'password' => 'parent1234',
                'phone' => '555-0101',
                'additional_info' => 'Parent of high school student interested in Mathematics and Science.'
            ],
            [
                'name' => 'Qynaath Kokab',
                'email' => 'qynaathkokab@gmail.com',
                'password' => 'Qynaath123',
                'phone' => '07724833224',
                'additional_info' => 'TRAST ME.'
            ],
            [
                'name' => 'Lisa Williams',
                'email' => 'lisa.williams@learnscape.com',
                'password' => 'parent1234',
                'phone' => '555-0202',
                'additional_info' => 'Parent of middle school student interested in English Literature and History.'
            ],
            [
                'name' => 'James Miller',
                'email' => 'james.miller@learnscape.com',
                'password' => 'parent1234',
                'phone' => '555-0303',
                'additional_info' => 'Parent of college student interested in Computer Science and Physics.'
            ],
            [
                'name' => 'Patricia Davis',
                'email' => 'patricia.davis@learnscape.com',
                'password' => 'parent1234',
                'phone' => '555-0404',
                'additional_info' => 'Parent of high school student interested in Chemistry and Biology.'
            ],
            [
                'name' => 'Michael Wilson',
                'email' => 'michael.wilson@learnscape.com',
                'password' => 'parent1234',
                'phone' => '555-0505',
                'additional_info' => 'Parent of middle school student interested in Geography and Social Studies.'
            ]
        ];

        foreach ($parents as $parentData) {
            $user = User::create([
                'name' => $parentData['name'],
                'email' => $parentData['email'],
                'password' => Hash::make($parentData['password']),
                'user_type' => 'parent'
            ]);

            ParentProfile::create([
                'user_id' => $user->id,
                'phone_number' => $parentData['phone'],
                'additional_info' => $parentData['additional_info']
            ]);
        }
    }
}