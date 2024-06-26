<?php

namespace AiDaYu\Customer\Model;

use AiDaYu\Customer\Api\Data\StudentInterface;
use Magento\Framework\Model\AbstractExtensibleModel;

class Student extends AbstractExtensibleModel implements StudentInterface
{
    public const CACHE_TAG = 'student_c';

    protected function _construct()
    {
        $this->_init(ResourceModel\Student::class);
    }
    public function getStudentId()
    {
        return parent::getData(self::STUDENT_ID);
    }
    public function getStudentName()
    {
        return parent::getData(self::STUDENT_NAME);
    }
    public function getClassId()
    {
        return parent::getData(self::CLASS_ID);
    }
}
