<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Seed dữ liệu mẫu cho hệ thống
        $this->call([
            DegreeSeeder::class,
            DepartmentSeeder::class,
            SubjectSeeder::class,
            SemesterSeeder::class,
            TeacherSeeder::class,
            ClassSubjectSeeder::class,
            TeachingAssignmentSeeder::class,
        ]);
    }
}
