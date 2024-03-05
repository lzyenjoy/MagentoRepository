<?php

namespace AiDaYu\Customer\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface StudentInterface extends ExtensibleDataInterface
{
    const STUDENT_ID='student_id';
    const STUDENT_NAME='student_name';
    const CLASS_ID='class_id';

    public function getStudentId();
    public function getStudentName();

    public function getClassId();
}
