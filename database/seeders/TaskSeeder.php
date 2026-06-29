<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $users      = User::all();
        $statuses   = ['pending', 'in_progress', 'completed'];
        $priorities = ['low', 'medium', 'high'];

        $tasks = [
            'Fix login bug',
            'Design homepage UI',
            'Write API documentation',
            'Setup database backups',
            'Implement search feature',
            'Code review for PR #12',
            'Update dependencies',
            'Fix mobile responsiveness',
            'Add email notifications',
            'Create admin panel',
            'Write unit tests',
            'Optimize database queries',
            'Setup CI/CD pipeline',
            'Fix payment gateway issue',
            'Add dark mode support',
            'Refactor authentication module',
            'Create user roles system',
            'Fix CSV export bug',
            'Add activity logs',
            'Deploy to production server',
        ];

        foreach ($tasks as $index => $title) {
            Task::create([
                'title'       => $title,
                'description' => "This task involves working on: {$title}. Please complete it before the due date.",
                'status'      => $statuses[$index % 3],
                'priority'    => $priorities[$index % 3],
                'due_date'    => now()->addDays(rand(1, 30))->format('Y-m-d'),
                'created_by'  => $users->random()->id,
            ]);
        }
    }
}