<?php

namespace AiDaYu\Customer\Model\Indexer\Student\Flat\Action;

use AiDaYu\Customer\Model\Indexer\Student\Flat\AbstractAction;
use AiDaYu\Customer\Api\Data\StudentInterface;
use Magento\Store\Model\Store;

class Full extends AbstractAction
{
    /**
     * Suffix for table to show it is old
     */
    const OLD_TABLE_SUFFIX = '_old';

    protected bool $allowTableChanges = true;

    /**
     * @param int $store
     * @return $this
     */
    protected function createTable(int $store)
    {
        $temporaryTable = $this->addTemporaryTableSuffix($this->getMainStoreTable($store));
        $table = $this->getFlatTableStructure($temporaryTable);
        $this->connection->dropTable($temporaryTable);
        $this->connection->createTable($table);
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

    /**
     * Transactional rebuild flat data from eav
     *
     * @return Full
     */
    public function reindexAll()
    {
        $this->createTables();
        if ($this->allowTableChanges) {
            $this->allowTableChanges = false;
        }
        $stores = $this->storeManager->getStores();
        $this->populateFlatTables($stores);
        $this->switchTables($stores);
        $this->allowTableChanges = true;

        return $this;
    }

    /**
     * @param array $stores
     * @return $this
     */
    public function switchTables(array $stores = [])
    {
        /** @var  $store Store */
        foreach ($stores as $store) {
            $activeTableName = $this->getMainStoreTable($store->getId());
            $temporaryTableName = $this->addTemporaryTableSuffix($this->getMainStoreTable($store->getId()));
            $oldTableName = $this->addOldTableSuffix($this->getMainStoreTable($store->getId()));
            //switch table
            $tablesToRename = [];
            if ($this->connection->isTableExists($activeTableName)) {
                $tablesToRename[] = ['oldName' => $activeTableName,'newName' => $oldTableName];
            }
            $tablesToRename[] = ['oldName'=>$temporaryTableName,'newName'=>$activeTableName];
            foreach ($tablesToRename as $tableName) {
                $this->connection->renameTable($tableName['oldName'], $tableName['newName']);
            }
            $tableToDelete = $oldTableName;
            if ($this->connection->isTableExists($tableToDelete)) {
                $this->connection->dropTable($tableToDelete);
            }
        }
        return $this;
    }

    /**
     * @param string $tableName
     * @return string
     */
    public function addOldTableSuffix(string $tableName): string
    {
        return $tableName . self::OLD_TABLE_SUFFIX;
    }

    /**
     * @param array $stores
     * @return void
     */
    protected function populateFlatTables(array $stores)
    {
        foreach ($stores as $store) {
            $select = $this->connection->select()->from(
                [
                   'def' => $this->connection->getTableName($this->getTableName('student'))
                ],
                [StudentInterface::STUDENT_ID,StudentInterface::STUDENT_NAME,StudentInterface::CLASS_ID]
            )->joinLeft(
                [
                    'e' => $this->connection->getTableName($this->getTableName('class'))
                ],
                "def.class_id = e.class_id",
                ['class_name']
            );
            $result = $this->connection->fetchAll($select);
            $resultChunks = array_chunk($result, 500);
            $data = [];
            foreach ($resultChunks as $item) {
                foreach ($item as $v) {
                    $data[] = $this->prepareValuesToInsert(
                    // phpcs:ignore Magento2.Performance.ForeachArrayMerge
                        array_merge($v, ['store_id' => $store->getId()])
                    );
                }
            }
            $this->connection->insertMultiple(
                $this->addTemporaryTableSuffix($this->getMainStoreTable($store->getId())),
                $data
            );
        }
    }
}
