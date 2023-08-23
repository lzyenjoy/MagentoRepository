<?php

namespace AiDaYu\Customer\Model\ResourceModel\AppUser;

use AiDaYu\Customer\Model\ResourceModel\AppUser;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\AiDaYu\Customer\Model\AppUser::class, AppUser::class);
    }
}
