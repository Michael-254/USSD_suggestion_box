<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::insert([
            ['department' => 'Communications', 'HOD_email' => 'communications@betterglobeforestry.com'],
            ['department' => 'Finance', 'HOD_email' => 'lawrence@betterglobeforestry.com'],
            ['department' => 'Forestry', 'HOD_email' => 'samuel@betterglobeforestry.com'],
            ['department' => 'Human Resources', 'HOD_email' => 'hr@betterglobeforestry.com'],
            ['department' => 'IT', 'HOD_email' => 'jpd@betterglobeforestry.com'],
            ['department' => 'Miti Magazine', 'HOD_email' => 'jan@betterglobeforestry.com'],
            ['department' => 'Monitoring & Evaluation', 'HOD_email' => 'lawrence@betterglobeforestry.com'],
            ['department' => 'Operations', 'HOD_email' => 'lawrence@betterglobeforestry.com'],
            ['department' => 'QMS', 'HOD_email' => 'lawrence@betterglobeforestry.com'],
            ['department' => 'Top Management', 'HOD_email' => 'jpd@betterglobeforestry.com'],
        ]);
    }
}
