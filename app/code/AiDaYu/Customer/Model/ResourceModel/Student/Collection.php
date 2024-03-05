<?php

namespace AiDaYu\Customer\Model\ResourceModel\Student;

use AiDaYu\Customer\Model\ResourceModel\Student;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(\AiDaYu\Customer\Model\Student::class, Student::class);
    }
}
