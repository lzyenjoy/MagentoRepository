<?php

namespace AiDaYu\Customer\Api;

interface AppUserRepositoryInterface
{

    /**
     * Get by id
     *
     * @param int $id
     * @return \AiDaYu\Customer\Api\Data\AppUserInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $id);

    /**
     * Save the model
     *
     * @param \AiDaYu\Customer\Api\Data\AppUserInterface $appUser
     * @return \AiDaYu\Customer\Api\Data\AppUserInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(\AiDaYu\Customer\Api\Data\AppUserInterface $appUser);

    /**
     * Delete category by identifier
     *
     * @param \AiDaYu\Customer\Api\Data\AppUserInterface $appUser
     * @return bool Will returned True if deleted
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(\AiDaYu\Customer\Api\Data\AppUserInterface $appUser);

    /**
     * Get data list
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \AiDaYu\Customer\Api\Data\AppUserSearchResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);
}
