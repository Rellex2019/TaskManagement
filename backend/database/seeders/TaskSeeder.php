<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userIds = [1, 2]; 

        foreach ($userIds as $userId) {
            Task::insert([
                [
                    'user_id' => $userId,
                    'title' => 'Задача 1 для пользователя ' . $userId,
                    'status' => 'new',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'user_id' => $userId,
                    'title' => 'Задача 2 для пользователя ' . $userId,
                    'status' => 'working',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'user_id' => $userId,
                    'title' => 'Задача 3 для пользователя ' . $userId,
                    'status' => 'completed',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
    }
}
