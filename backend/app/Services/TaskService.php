<?php

namespace App\Services;

use App\Models\Task;
use App\Models\User;

class TaskService
{
    public function createTask(User $user, string $title): Task
    {
        return $user->tasks()->create(['title' => $title]);
    }

    public function changeStatus(Task $task, $newStatus): bool
    {
        return $task->update(['status' => $newStatus]);
    }
    public function getUserTasks(User $user)
    {
        return $user->tasks;
    }

    public function getAllTasks()
    {
        return Task::all();
    }
}
