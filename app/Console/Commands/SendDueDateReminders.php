<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Notifications\TaskDueReminderNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class SendDueDateReminders extends Command
{
    protected $signature = 'tasks:send-due-reminders';
    protected $description = 'Send push notification 2 hours before a task is due';

    public function handle(): int
    {
        $now       = now();
        $twoHrsOut = now()->addHours(2);

        $tasks = Task::query()
            ->whereIn('status', ['pending', 'in_progress'])
            ->whereNull('due_reminder_sent_at')
            // due_date, fal in our window of 2 hours from now
            ->whereBetween('due_date', [$now, $twoHrsOut])
            ->with('creator')
            ->get();

        if ($tasks->isEmpty()) {
            $this->info('No tasks due within the next 2 hours.');
            return self::SUCCESS;
        }

        foreach ($tasks as $task) {
            // Send notification to the task creator
            $task->creator->notify(new TaskDueReminderNotification($task));

            $task->update(['due_reminder_sent_at' => now()]);

            $this->info("Reminder sent for task: {$task->title}");
        }

        return self::SUCCESS;
    }
}