<?php
namespace AiDaYu\Customer\Controller\Profile;

use AiDaYu\Customer\Model\AppUserRepository;
use AiDaYu\Customer\Model\AppUserFactory;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrder;

class Index implements HttpGetActionInterface
{
    protected $appUserRepository;
    protected $appUserFactory;
    protected $filterBuilder;
    protected $searchCriteriaBuilder;
    public function __construct(
        AppUserRepository $appUserRepository,
        AppUserFactory $appUserFactory,
        FilterBuilder $filterBuilder,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->appUserRepository = $appUserRepository;
        $this->appUserFactory = $appUserFactory;
        $this->filterBuilder = $filterBuilder;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * Execute action based on request and return result
     *
     * @return ResultInterface|ResponseInterface
     * @throws NotFoundException
     */
    public function execute()
    {

        $this->searchUseRepository();
        die;
    }

    public function insert()
    {
        $appUser = $this->appUserFactory->create();
        $appUser->setName('Alex');
        $appUser->setEmail('66666@gmail.com');
        $appUser->setPhone('15203255458');
        $this->appUserRepository->save($appUser);
    }

    public function get($id)
    {
        $appUser = $this->appUserRepository->getById($id);
        dump($appUser->getData());
        die;
    }

    public function updateById($id)
    {
        $appUser = $this->appUserRepository->getById($id);
        $appUser->setName('Student New Name');
        $appUser->setEmail('abc@qq.com');
        $this->appUserRepository->save($appUser);
        die;
    }

    public function deleteById($id)
    {
        $appUser = $this->appUserRepository->getById($id);
        $this->appUserRepository->delete($appUser);
        die;
    }

    public function searchUseRepository()
    {
        $filter = $this->filterBuilder->setField('phone')
            ->setConditionType('eq')
            ->setValue('15203255458')
            ->create();
        $this->searchCriteriaBuilder->addFilter($filter);
        $this->searchCriteriaBuilder->addSortOrder('id', SortOrder::SORT_DESC);
        //$this->searchCriteriaBuilder->setCurrentPage(1)->setPageSize(2);
        $searchCriteria = $this->searchCriteriaBuilder->create();
        $searchResult = $this->appUserRepository->getList($searchCriteria);
        $items = $searchResult->getItems();
        foreach ($items as $item) {
            dump($item->getData());
        }
        die;
    }
}
