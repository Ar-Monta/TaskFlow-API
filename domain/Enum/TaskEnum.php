<?php

class TaskEnum
{
    const STATUS_PENDING = 0;
    const STATUS_IN_PROGRESS = 1;
    const STATUS_COMPLETED = 2;
    const STATUS_FAILED = 3;
    const STATUS_CANCELLED = 4;
    const STATUS_ALL = [
        self::STATUS_PENDING => "Pending",
        self::STATUS_IN_PROGRESS => "In Progress",
        self::STATUS_COMPLETED => "Completed",
        self::STATUS_FAILED => "Failed",
        self::STATUS_CANCELLED => "Cancelled",
    ];
}
