<?php

namespace App\Services;

use App\Services\Contracts\TaskServiceInterface;
use Contracts\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class TaskService implements TaskServiceInterface
{
    public function __construct(private readonly TaskRepositoryInterface $repository){}

    public function getTaskById(int $taskId): Model|array|null
    {
        return $this->repository->getById($taskId);
    }

    public function getAllTasks(): array
    {
        return $this->repository->getAll();
    }

    public function createTask(array $task)
    {
        // TODO: Implement createTask() method.
    }

    public function updateTask(int $taskId, array $task)
    {
        // TODO: Implement updateTask() method.
    }

    public function deleteTask(int $taskId)
    {
        // TODO: Implement deleteTask() method.
    }
}
