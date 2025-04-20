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
                'email' => 'john.smith1@learnscape.com',
                'password' => 'tutor1234',
                'bio' => 'Experienced math tutor with 5+ years of teaching high school students.',
                'subjects' => ['Mathematics', 'Science'],
                'age_groups' => ['Secondary School', 'Sixth Form'],
                'hourly_rate' => 25.00,
                'qualifications' => ['MSc in Mathematics', 'Teaching Certificate']
            ],
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah.johnson1@learnscape.com',
                'password' => 'tutor1234',
                'bio' => 'English literature specialist with a passion for creative writing.',
                'subjects' => ['English Literature'],
                'age_groups' => ['Secondary School'],
                'hourly_rate' => 15.00,
                'qualifications' => ['BA in English Literature', 'TEFL Certified']
            ],
            [
                'name' => 'Michael Chen',
                'email' => 'michael.chen1@learnscape.com',
                'password' => 'tutor1234',
                'bio' => 'Computer science expert with industry experience in software development.',
                'subjects' => ['Computer Science', 'Maths'],
                'age_groups' => ['Secondary School', 'Sixth Form', 'University'],
                'hourly_rate' => 20.00,
                'qualifications' => ['BSc in Computer Science', 'Google Certified']
            ],
            [
                'name' => 'Emily Wilson',
                'email' => 'emily.wilson1@learnscape.com',
                'password' => 'tutor1234',
                'bio' => 'Chemistry tutor with research background in pharmaceutical sciences.',
                'subjects' => ['Chemistry', 'Biology'],
                'age_groups' => ['Secondary School', 'Sixth Form'],
                'hourly_rate' => 20.00,
                'qualifications' => ['PhD in Chemistry', 'Research Scientist']
            ],
            [
                'name' => 'David Brown',
                'email' => 'david.brown1@learnscape.com',
                'password' => 'tutor1234',
                'bio' => 'History enthusiast with specialization in European history.',
                'subjects' => ['History'],
                'age_groups' => ['Secondary School'],
                'hourly_rate' => 20.00,
                'qualifications' => ['MA in History', 'Teaching License']
            ],
            [
                'name' => 'Aisha Khan',
                'email' => 'aisha.khan1@learnscape.com',
                'password' => 'tutor1234',
                'bio' => 'Passionate about teaching Mathematics and Science.',
                'subjects' => ['Mathematics', 'Science'],
                'age_groups' => ['Primary School', 'Secondary School'],
                'hourly_rate' => 18.00,
                'qualifications' => ['Bachelor\'s Degree', 'Teaching Certificate']
            ],
            [
                'name' => 'Omar Ali',
                'email' => 'omar.ali1@learnscape.com',
                'password' => 'tutor1234',
                'bio' => 'History and Geography enthusiast with a knack for storytelling.',
                'subjects' => ['History', 'Geography'],
                'age_groups' => ['Secondary School', 'Sixth Form'],
                'hourly_rate' => 22.00,
                'qualifications' => ['Master\'s Degree', 'Teaching Certificate']
            ],
            [
                'name' => 'Fatima Noor',
                'email' => 'fatima.noor1@learnscape.com',
                'password' => 'tutor1234',
                'bio' => 'Dedicated to teaching English and Computer Science.',
                'subjects' => ['English', 'Computer Science'],
                'age_groups' => ['University'],
                'hourly_rate' => 25.00,
                'qualifications' => ['PhD', 'Teaching Certificate']
            ],
            [
                'name' => 'Zain Malik',
                'email' => 'zain.malik1@learnscape.com',
                'password' => 'tutor1234',
                'bio' => 'Experienced in teaching Science and Mathematics.',
                'subjects' => ['Science', 'Mathematics'],
                'age_groups' => ['Primary School', 'Secondary School'],
                'hourly_rate' => 20.00,
                'qualifications' => ['Bachelor\'s Degree', 'Teaching Certificate']
            ],
            [
                'name' => 'Layla Ahmed',
                'email' => 'layla.ahmed1@learnscape.com',
                'password' => 'tutor1234',
                'bio' => 'Specializes in teaching Geography and History.',
                'subjects' => ['Geography', 'History'],
                'age_groups' => ['Sixth Form', 'University'],
                'hourly_rate' => 23.00,
                'qualifications' => ['Master\'s Degree', 'Teaching Certificate']
            ],
            [
                'name' => 'Hassan Javed',
                'email' => 'hassan.javed1@learnscape.com',
                'password' => 'tutor1234',
                'bio' => 'Expert in Computer Science and English.',
                'subjects' => ['Computer Science', 'English'],
                'age_groups' => ['Secondary School', 'University'],
                'hourly_rate' => 24.00,
                'qualifications' => ['PhD', 'Teaching Certificate']
            ],
            [
                'name' => 'Nadia Khan',
                'email' => 'nadia.khan1@learnscape.com',
                'password' => 'tutor1234',
                'bio' => 'Passionate about teaching Mathematics and Science.',
                'subjects' => ['Mathematics', 'Science'],
                'age_groups' => ['Primary School', 'Secondary School'],
                'hourly_rate' => 18.00,
                'qualifications' => ['Bachelor\'s Degree', 'Teaching Certificate']
            ],
            [
                'name' => 'Yusuf Ali',
                'email' => 'yusuf.ali1@learnscape.com',
                'password' => 'tutor1234',
                'bio' => 'History and Geography enthusiast with a knack for storytelling.',
                'subjects' => ['History', 'Geography'],
                'age_groups' => ['Secondary School', 'Sixth Form'],
                'hourly_rate' => 22.00,
                'qualifications' => ['Master\'s Degree', 'Teaching Certificate']
            ],
            [
                'name' => 'Amira Noor',
                'email' => 'amira.noor1@learnscape.com',
                'password' => 'tutor1234',
                'bio' => 'Dedicated to teaching English and Computer Science.',
                'subjects' => ['English', 'Computer Science'],
                'age_groups' => ['University'],
                'hourly_rate' => 25.00,
                'qualifications' => ['PhD', 'Teaching Certificate']
            ],
            [
                'name' => 'Bilal Malik',
                'email' => 'bilal.malik1@learnscape.com',
                'password' => 'tutor1234',
                'bio' => 'Experienced in teaching Science and Mathematics.',
                'subjects' => ['Science', 'Mathematics'],
                'age_groups' => ['Primary School', 'Secondary School'],
                'hourly_rate' => 20.00,
                'qualifications' => ['Bachelor\'s Degree', 'Teaching Certificate']
            ],
            [
                'name' => 'Aizah Akbar',
                'email' => 'aizah.akbar@gmail.com',
                'password' => 'Aizah123',
                'bio' => 'BTW GUYS BESKILLUY TRUAST ME.',
                'subjects' => ['Computer Science'],
                'age_groups' => ['Secondary School'],
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