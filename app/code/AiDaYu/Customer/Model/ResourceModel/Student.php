<?php

namespace AiDaYu\Customer\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Student extends AbstractDb
{
    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        // TODO: Implement _construct() method.
        $this->_init('student', 'student_id');
    }
}
