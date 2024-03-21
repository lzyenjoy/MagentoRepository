<?php

namespace AiDaYu\Customer\Model\Indexer\Student\Flat\Action;

use AiDaYu\Customer\Model\Indexer\Student\Flat\AbstractAction;

class Full extends AbstractAction
{

    /**
     * @param int $store
     * @return $this
     */
    protected function createTable(int $store)
    {
        $temporaryTable = $this->addTemporaryTableSuffix($this->getMainStoreTable($store));
        $table = $this->getFlatTableStructure($temporaryTable);
//        $this->connection->dropTable($temporaryTable);
//        $this->connection->createTable($table);
        return $this;
    }

    /**
     * @param array $stores
     * @return $this
     */
    protected function createTables(array $stores = [])
    {
        if ($this->connection->getTransactionLevel()>0) {
            return $this;
        }
        if (empty($stores)) {
            $stores = $this->storeManager->getStores();
        }
        foreach ($stores as $store) {
            $this->createTable($store->getId());
        }
        return $this;
    }
    public function reindexAll()
    {
        $this->createTables();
    }
}
