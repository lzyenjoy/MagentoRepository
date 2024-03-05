<?php

namespace AiDaYu\Customer\Model;

class Employee
{
    /**
     * @var array
     */
    private $empattribute;

    /**
     * Construct method
     *
     * @param array $empattribute
     * @return void
     */
    public function __construct(array $empattribute = [])
    {
        $this->empattribute = $empattribute;
    }
    /**
     * Get Employee Data
     *
     * @return array
     */
    public function getEmployeeData()
    {
        return $this->empattribute;
    }
}
