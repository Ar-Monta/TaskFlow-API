<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Traits\ResponseHandleTrait;
use App\Services\Contracts\TaskServiceInterface;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class TaskController extends Controller
{
    use ResponseHandleTrait;
    public function __construct(
        private readonly TaskServiceInterface $taskService
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->taskService->getAllTasks();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return ResponseAlias::HTTP_NOT_FOUND;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->taskService->createTask([]);
        return ResponseAlias::HTTP_CREATED;
    }

    /**
     * Display the specified resource.
     */
    public function show(int $taskId): JsonResponse
    {
        $task = $this->taskService->getTaskById($taskId);

        if (is_null($task)) {
            return $this->messageResponse('Not found', ResponseAlias::HTTP_NOT_FOUND);
        }

        return $this->dataResponse('', [], ResponseAlias::HTTP_CREATED);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}
