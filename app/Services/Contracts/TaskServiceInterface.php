<?php

namespace App\Services\Contracts;

interface TaskServiceInterface
{
    public function getTaskById(int $taskId);
    public function getAllTasks();
    public function createTask(array $task);
    public function updateTask(int $taskId, array $task);
    public function deleteTask(int $taskId);
}
