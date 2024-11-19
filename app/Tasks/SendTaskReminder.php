<?php

namespace App\Tasks;

use Illuminate\Support\Facades\Notification;
use App\Models\Task;
use App\Notifications\TaskReminderNotification;

class SendTaskReminder
{
    public function __invoke()
    {
        $tasks = Task::where('due_date', '=', now()->addDay()->toDateTimeString())->with('users')->get();

        foreach ($tasks as $task) {
            Notification::send($task->users, new TaskReminderNotification($task));
        }
    }
}
