<?php

namespace AiDaYu\Customer\Model;

class AllRecords
{
    /**
     * @var array
     */
    private $allRecords;
    /**
     * Construct method
     *
     * @param array $allRecords
     * @return void
     */
    public function __construct(array $allRecords = [])
    {
        $this->allRecords = $allRecords;
    }
    /**
     * Get All Records
     *
     * @return array
     */
    public function getRecords()
    {
        return $this->allRecords;
    }
}
