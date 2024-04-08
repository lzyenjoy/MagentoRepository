<?php

namespace AiDaYu\Customer\Model\Indexer\Student\Flat\Action;

use AiDaYu\Customer\Api\Data\StudentInterface;
use AiDaYu\Customer\Model\Indexer\Student\Flat\AbstractAction;
use Magento\Store\Model\Store;

class Rows extends AbstractAction
{

    /**
     * @param array $entityIds
     * @param boolean $useTempTable
     * @return $this
     */
    public function reindex(array $entityIds = [], bool $useTempTable = false)
    {
        $stores = $this->storeManager->getStores();
        foreach ($stores as $store) {
            $this->reindexStore($store, $entityIds, $useTempTable);
        }
        return $this;
    }

    /**
     * @param Store $store
     * @param array $entityIds
     * @param bool $useTempTable
     * @return void
     */
    private function reindexStore(Store $store, array $entityIds, bool $useTempTable)
    {
        $tableName = $this->getTableNameByStore($store, $useTempTable);
        if (!$this->connection->isTableExists($tableName)) {
            return;
        }
        $entityIdsArrChunks = array_chunk($entityIds, 500);
        foreach ($entityIdsArrChunks as $entityIdsArrChunk) {
            foreach ($entityIdsArrChunk as $id) {
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
                )->where(
                    "def.student_id IN (?)",
                    $id,
                    \Zend_Db::INT_TYPE
                );
                $result = $this->connection->fetchAll($select);
                $indexData = $this->buildUpdateData($result, $store);
                $this->updateIndexData($tableName, $indexData);
            }
        }
    }

    /**
     * @param string $tableName
     * @param array $indexData
     * @return void
     */
    private function updateIndexData(string $tableName, array $indexData)
    {
        foreach ($indexData as $row) {
            $updateFields = [];
            foreach (array_keys($row) as $key) {
                $updateFields[$key] = $key;
            }
            $this->connection->insertOnDuplicate($tableName, $row, $updateFields);
        }
    }

    /**
     * @param array $data
     * @param Store $store
     * @return array
     */
    public function buildUpdateData(array $data, Store $store)
    {
        return $this->prepareValuesToInsert(
            array_merge(
                $data,
                ['store_id'=>$store->getId()]
            )
        );
    }

    /**
     * @param Store $store
     * @param bool $useTempTable
     * @return string
     */
    protected function getTableNameByStore(Store $store, bool $useTempTable): string
    {
        $tableName = $this->getMainStoreTable($store->getId());
        return $useTempTable ? $this->addTemporaryTableSuffix($tableName): $tableName;
    }
}
