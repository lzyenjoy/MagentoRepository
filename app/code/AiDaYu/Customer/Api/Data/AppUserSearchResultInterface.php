<?php

namespace AiDaYu\Customer\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface AppUserSearchResultInterface extends SearchResultsInterface
{

    /**
     * Get items list.
     *
     * @return \AiDaYu\Customer\Api\Data\AppUserInterface[]
     */
    public function getItems();

    /**
     * Set items list.
     *
     * @param \AiDaYu\Customer\Api\Data\AppUserInterface[] $items
     * @return void
     */
    public function setItems(array $items);
}
