<?php

namespace AiDaYu\Customer\Model;

class CustomVirtualEmployee extends \AiDaYu\Customer\Model\Employee
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
        parent::__construct($empattribute);
        $this->empattribute = $this->getEmployeeData();
        $this->empattribute["addedNewOne"] = $this->getNewAttribute();
    }
    /**
     * Get New Attribute Label
     *
     * @return string
     */
    public function getNewAttribute()
    {
        return "Salary";
    }
    /**
     * Get All Data
     *
     * @return array
     */
    public function getAllData()
    {
        return $this->empattribute;
    }
}
