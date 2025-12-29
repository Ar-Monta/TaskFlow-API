<?php

use Contracts\TaskRepositoryInterface;

class TaskRepository extends BaseRepository implements TaskRepositoryInterface
{

    public function model(): string
    {
        return \App\Models\Task::class;
    }
}
