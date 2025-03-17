<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            ['name' => 'Mathematics', 'description' => 'Study of numbers, quantities, and shapes'],
            ['name' => 'English', 'description' => 'Study of language, literature, and writing'],
            ['name' => 'Science', 'description' => 'Study of the natural world'],
            ['name' => 'History', 'description' => 'Study of past events'],
            ['name' => 'Geography', 'description' => 'Study of places and the relationships between people and their environments'],
            ['name' => 'Computer Science', 'description' => 'Study of computers and computational systems'],
        ];
        
        foreach ($subjects as $subject) {
            Subject::create($subject);
        }
    }
}
