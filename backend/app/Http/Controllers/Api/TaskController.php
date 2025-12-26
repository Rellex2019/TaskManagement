<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskCreateRequest;
use App\Http\Requests\StatusRequest;
use App\Models\Task;
use App\Models\User;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class TaskController extends Controller
{
    public function __construct(private TaskService $taskService) {}

    public function createTask(TaskCreateRequest $request): JsonResponse {
        $task = $this->taskService->createTask($request->user(), $request->title);
        Cache::forget('user_tasks_' . $request->user()->id);
        Cache::forget('all_tasks');
        return response()->json($task);
    }
    public function showTasksForAuthenticatedUser(): JsonResponse
    {
        $user = Auth::user();
        $tasks = $this->taskService->getUserTasks($user);
        return response()->json($tasks);
    }

    public function showTasks(Request $request): JsonResponse
    {
        if ($request->user()->isAdmin()) {
            $tasks = Cache::remember('all_tasks', 60, function () {
                return $this->taskService->getAllTasks();
            });

            return response()->json($tasks);
        }

        $tasks = Cache::remember('user_tasks_' . $request->user()->id, 60, function () use ($request) {
            return $request->user()->tasks()->get();
        });

        return response()->json($tasks);
    }
    public function changeStatus(Task $task, StatusRequest $request): JsonResponse
    {
        $this->taskService->changeStatus($task, $request->status);
        Cache::forget('user_tasks_' . $request->user()->id);
        Cache::forget('all_tasks');
        return response()->json(`Статус задачи изменен на $request->status`);
    }
}
