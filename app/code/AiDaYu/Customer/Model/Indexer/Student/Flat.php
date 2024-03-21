<?php

namespace AiDaYu\Customer\Model\Indexer\Student;

use Magento\Framework\Indexer\CacheContext;

class Flat implements \Magento\Framework\Indexer\ActionInterface, \Magento\Framework\Mview\ActionInterface
{
    protected $fullActionFactory;

    /**
     * @var \Magento\Framework\Indexer\CacheContext
     */
    private CacheContext $cacheContext;

    public function __construct(
        Flat\Action\FullFactory $fullActionFactory
    ) {
        $this->fullActionFactory = $fullActionFactory;
    }

    public function execute($ids)
    {
        //TODO
    }

    public function executeFull()
    {
        $this->fullActionFactory->create()->reindexAll();
        $this->getCacheContext()->registerTags([\AiDaYu\Customer\Model\Student::CACHE_TAG]);
    }

    public function executeList(array $ids)
    {
        //TODO
    }

    public function executeRow($id)
    {
        //TODO
    }

    /**
     * Get cache context
     *
     * @return \Magento\Framework\Indexer\CacheContext
     * @deprecated 100.0.11
     * @since 100.0.11
     */
    protected function getCacheContext()
    {
        if (!($this->cacheContext instanceof CacheContext)) {
            return \Magento\Framework\App\ObjectManager::getInstance()->get(CacheContext::class);
        } else {
            return $this->cacheContext;
        }
    }
}
