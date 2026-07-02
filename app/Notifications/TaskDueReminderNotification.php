<?php

namespace App\Notifications;

use App\Models\Task;
use App\Notifications\Channels\FcmChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TaskDueReminderNotification extends Notification
{
    use Queueable;

    public function __construct(protected Task $task)
    {
    }

    public function via($notifiable): array
    {
        return ['database', FcmChannel::class];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'type'    => 'due_reminder',
            'task_id' => $this->task->id,
            'title'   => 'Task Due Soon',
            'message' => "Your task '{$this->task->title}' is due at {$this->task->due_date->format('h:i A, d M')}. Please complete it soon.",
            'url'     => route('tasks.edit', $this->task->id),
        ];
    }

    public function toFcm($notifiable): array
    {
        return [
            'title' => 'Task Due Soon ⏰',
            'body'  => "'{$this->task->title}' is due at {$this->task->due_date->format('h:i A')}. Only 2 hours left!",
            'data'  => [
                'task_id' => (string) $this->task->id,
                'type'    => 'due_reminder',
            ],
        ];
    }
}