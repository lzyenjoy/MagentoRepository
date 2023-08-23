<?php

namespace AiDaYu\Customer\Model;

use AiDaYu\Customer\Api\AppUserRepositoryInterface;
use AiDaYu\Customer\Api\Data\AppUserInterface;
use AiDaYu\Customer\Api\Data\AppUserSearchResultInterfaceFactory;
use AiDaYu\Customer\Api\Data;
use AiDaYu\Customer\Model\AppUserFactory;
use AiDaYu\Customer\Model\ResourceModel\AppUser\CollectionFactory;
use AiDaYu\Customer\Model\ResourceModel\AppUser;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;

class AppUserRepository implements AppUserRepositoryInterface
{

    /**
     * @var AppUserFactory
     */
    private $appUserFactory;

    /**
     * @var AppUser
     */
    private $appUserResource;

    /**
     * @var CollectionFactory
     */
    private $appUserCollectionFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var AppUserSearchResultInterfaceFactory
     */
    private $searchResultFactory;

    /**
     * @param AppUserFactory $appUserFactory
     * @param AppUser $appUserResource
     * @param CollectionFactory $collectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param AppUserSearchResultInterfaceFactory $appUserSearchResultInterfaceFactory
     */
    public function __construct(
        AppUserFactory $appUserFactory,
        AppUser $appUserResource,
        CollectionFactory $collectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        AppUserSearchResultInterfaceFactory $appUserSearchResultInterfaceFactory
    ) {
        $this->appUserFactory = $appUserFactory;
        $this->appUserResource = $appUserResource;
        $this->appUserCollectionFactory = $collectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultFactory  = $appUserSearchResultInterfaceFactory;
    }
    /**
     * @inheritDoc
     */
    public function getById(int $id)
    {
        $appUser = $this->appUserFactory->create();
        $this->appUserResource->load($appUser, $id);
        if (!$appUser->getId()) {
            throw new NoSuchEntityException(__('Unable to find Row with ID "%1"', $id));
        }
        return $appUser;
    }

    /**
     * @inheritDoc
     */
    public function save(AppUserInterface $appUser)
    {
        $this->appUserResource->save($appUser);
        return $appUser;
    }

    /**
     * @inheritDoc
     */
    public function delete(AppUserInterface $appUser)
    {
        try {
            $this->appUserResource->delete($appUser);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the entry: %1', $exception->getMessage())
            );
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->appUserCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());

        return $searchResults;
    }
}
