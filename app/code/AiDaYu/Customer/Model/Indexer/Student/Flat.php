<?php

namespace AiDaYu\Customer\Model\Indexer\Student;

use AiDaYu\Customer\Model\Indexer\Student\Flat\Action\FullFactory;
use AiDaYu\Customer\Model\Indexer\Student\Flat\Action\RowsFactory;
use Magento\Framework\Indexer\CacheContext;
use Magento\Framework\Indexer\IndexerRegistry;

class Flat implements \Magento\Framework\Indexer\ActionInterface, \Magento\Framework\Mview\ActionInterface
{
    protected FullFactory $fullActionFactory;

    private CacheContext $cacheContext;

    protected RowsFactory $rowsActionFactory;

    protected IndexerRegistry $indexerRegistry;

    public function __construct(
        FullFactory $fullActionFactory,
        RowsFactory $rowsActionFactory,
        IndexerRegistry $indexerRegistry,
    ) {
        $this->fullActionFactory = $fullActionFactory;
        $this->rowsActionFactory = $rowsActionFactory;
        $this->indexerRegistry = $indexerRegistry;
    }

    public function execute($ids)
    {
        $indexer = $this->indexerRegistry->get(Flat\State::INDEXER_ID);
        if ($indexer->isInvalid()) {
            return;
        }
        /** @var Flat\Action\Rows $action */
        $action = $this->rowsActionFactory->create();
        if ($indexer->isWorking()) {
            $action->reindex($ids, true);
        }
        $action->reindex($ids);
        $this->getCacheContext()->registerEntities(\AiDaYu\Customer\Model\Student::CACHE_TAG, $ids);
    }

    public function executeFull()
    {
        $this->fullActionFactory->create()->reindexAll();
        $this->getCacheContext()->registerTags([\AiDaYu\Customer\Model\Student::CACHE_TAG]);
    }

    public function executeList(array $ids)
    {
        $this->execute($ids);
    }

    public function executeRow($id)
    {
        $this->execute([$id]);
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
