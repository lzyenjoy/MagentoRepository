<?php

namespace AiDaYu\Customer\Model;

class EmpRecord
{
    /**
     * @var array
     */
    private $record;

    /**
     * Construct method
     *
     * @param array $record
     * @return void
     */
    public function __construct(array $record = [])
    {
        $this->record = $record;
    }
    /**
     * Get Record Data
     *
     * @return array
     */
    public function getRecord()
    {
        return $this->record;
    }
}
