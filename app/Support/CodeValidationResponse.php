<?php

namespace App\Support;

class CodeValidationResponse
{
    protected const DEFAULT_POINTS = 10;

    protected $isValidated = false;

    protected $nextTask;

    protected $taskNumber;

    /**
     * CodeValidationResponse constructor.
     *
     * @param int  $taskNumber
     * @param bool $isValidated
     */
    public function __construct(int $taskNumber, bool $isValidated)
    {
        $this->taskNumber = $taskNumber;
        $this->isValidated = $isValidated;
    }

    public function isValidated() : bool
    {
        return $this->isValidated;
    }

    public function getEarnedPoints() : int
    {
        if ($this->isValidated()) {
            return self::DEFAULT_POINTS;
        }
        return 0;
    }

    public function getNextTask() : int
    {
        if ($this->isValidated()) {
            return $this->taskNumber + 1;
        }
        return $this->taskNumber;
    }

    public function toArray() : array
    {
        return [
            'currentPoints' => $this->getEarnedPoints(),
            'validate'      => $this->isValidated(),
            'next'          => $this->getNextTask()
        ];
    }
}
