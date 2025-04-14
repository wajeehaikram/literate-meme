<?php

namespace Database\Seeders;

use App\Models\TutorProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TutorSeeder extends Seeder
{
    public function run(): void
    {
        $tutors = [
            [
                'name' => 'John Smith',
                'email' => 'john.smith@learnscape.com',
                'password' => 'tutor1234',
                'bio' => 'Experienced math tutor with 5+ years of teaching high school students.',
                'subjects' => ['Mathematics', 'Science'],
                'age_groups' => ['Secondary School', 'Sixth Form'],
                'hourly_rate' => 25.00,
                'qualifications' => ['MSc in Mathematics', 'Teaching Certificate']
            ],
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah.johnson@learnscape.com',
                'password' => 'tutor1234',
                'bio' => 'English literature specialist with a passion for creative writing.',
                'subjects' => ['English Literature'],
                'age_groups' => ['Secondary School'],
                'hourly_rate' => 15.00,
                'qualifications' => ['BA in English Literature', 'TEFL Certified']
            ],
            [
                'name' => 'Michael Chen',
                'email' => 'michael.chen@learnscape.com',
                'password' => 'tutor1234',
                'bio' => 'Computer science expert with industry experience in software development.',
                'subjects' => ['Computer Science', 'Maths'],
                'age_groups' => ['Secondary School', 'Sixth Form', 'University'],
                'hourly_rate' => 20.00,
                'qualifications' => ['BSc in Computer Science', 'Google Certified']
            ],
            [
                'name' => 'Emily Wilson',
                'email' => 'emily.wilson@learnscape.com',
                'password' => 'tutor1234',
                'bio' => 'Chemistry tutor with research background in pharmaceutical sciences.',
                'subjects' => ['Chemistry', 'Biology'],
                'age_groups' => ['Secondary School', 'Sixth Form'],
                'hourly_rate' => 20.00,
                'qualifications' => ['PhD in Chemistry', 'Research Scientist']
            ],
            [
                'name' => 'David Brown',
                'email' => 'david.brown@learnscape.com',
                'password' => 'tutor1234',
                'bio' => 'History enthusiast with specialization in European history.',
                'subjects' => ['History'],
                'age_groups' => ['High School'],
                'hourly_rate' => 20.00,
                'qualifications' => ['MA in History', 'Teaching License']
            ],
            [
                'name' => 'Aizah Akbar',
                'email' => 'aizahakbar@gmail.com',
                'password' => 'Aizah123',
                'bio' => 'BTW GUYS BESKILLUY TRUAST ME.',
                'subjects' => ['Computer Science'],
                'age_groups' => ['High School'],
                'hourly_rate' => 20.00,
                'qualifications' => ['Teaching License']
            ]
        ];

        foreach ($tutors as $tutorData) {
            $user = User::create([
                'name' => $tutorData['name'],
                'email' => $tutorData['email'],
                'password' => Hash::make($tutorData['password']),
                'user_type' => 'tutor'
            ]);

            TutorProfile::create([
                'user_id' => $user->id,
                'bio' => $tutorData['bio'],
                'subjects' => $tutorData['subjects'],
                'age_groups' => $tutorData['age_groups'],
                'hourly_rate' => $tutorData['hourly_rate'],
                'qualifications' => $tutorData['qualifications']
            ]);
        }
    }
}