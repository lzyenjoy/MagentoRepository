<?php

namespace AiDaYu\Customer\Model\Indexer\Student\Flat;

use AiDaYu\Customer\Model\ResourceModel\Helper;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;

class AbstractAction
{
    /**
     * Suffix for table to show it is temporary
     */
    public const TEMPORARY_TABLE_SUFFIX = '_tmp';

    /**
     * @var Resource
     */
    protected $resource;

    /**
     * @var AdapterInterface
     */
    protected AdapterInterface $connection;

    /**
     * @var StoreManagerInterface
     */
    protected StoreManagerInterface $storeManager;

    protected array $columns;

    /**
     * Catalog resource helper
     *
     * @var Helper
     */
    protected $resourceHelper;

    /**
     * @var SkipStaticColumnsProvider|mixed
     */
    private $skipStaticColumnsProvider;

    /**
     * Static columns to skip
     *
     * @var array
     */
    protected array $skipStaticColumns = [];


    public function __construct(
        ResourceConnection $resource,
        StoreManagerInterface $storeManager,
        Helper $resourceHelper,
        SkipStaticColumnsProvider $skipStaticColumnsProvider = null
    ) {
        $this->resource = $resource;
        $this->connection = $resource->getConnection();
        $this->storeManager = $storeManager;
        $this->resourceHelper = $resourceHelper;
        $this->skipStaticColumnsProvider = $skipStaticColumnsProvider ??
            ObjectManager::getInstance()->get(SkipStaticColumnsProvider::class);
        $this->columns = array_merge($this->getStaticColumns(), $this->getEavColumns());
    }

    protected function getStaticColumns()
    {
        $columns = [];
        $describe = $this->connection->describeTable(
            $this->connection->getTableName($this->getTableName('student'))
        );

        foreach ($describe as $column) {
            if (in_array($column['COLUMN_NAME'], $this->getSkipStaticColumns())) {
                continue;
            }
            $isUnsigned = '';
            $options = null;
            $ddlType = $this->resourceHelper->getDdlTypeByColumnType($column['DATA_TYPE']);
            $column['DEFAULT'] = $column['DEFAULT'] ? trim($column['DEFAULT'], "' ") : '';
            switch ($ddlType) {
                case Table::TYPE_SMALLINT:
                case Table::TYPE_INTEGER:
                case Table::TYPE_BIGINT:
                    $isUnsigned = (bool)$column['UNSIGNED'];
                    if ($column['DEFAULT'] === '') {
                        $column['DEFAULT'] = null;
                    }
                    $options = null;
                    if ($column['SCALE'] > 0) {
                        $ddlType = TABLE::TYPE_DECIMAL;
                    } else {
                        break;
                    }
                case Table::TYPE_DECIMAL:
                    $options = $column['PRECISION']. ','.$column['SCALE'];
                    $isUnsigned = null;
                    if ($column['DEFAULT'] === '') {
                        $column['DEFAULT'] = null;
                    }
                    break;
                case Table::TYPE_TEXT:
                    $options = $column['LENGTH'];
                    $isUnsigned = null;
                    break;
                case Table::TYPE_TIMESTAMP:
                    $options = null;
                    $isUnsigned = null;
                    break;
                case Table::TYPE_DATETIME:
                    $isUnsigned = null;
                    break;
            }
            $columns[$column['COLUMN_NAME']] = [
                'type' => [$ddlType,$options],
                'unsigned' => $isUnsigned,
                'nullable' => $column['NULLABLE'],
                'default' => $column['DEFAULT'] === null ? false : $column['DEFAULT'],
                'comment' => $column['COLUMN_NAME']
            ];
        }
        $columns['store_id'] = [
            'type' => [Table::TYPE_SMALLINT, 5],
            'unsigned' => true,
            'nullable' => false,
            'default' => 0,
            'comment' => 'Store Id'
        ];
        print_r($columns);die;
        return $columns;
    }

    /**
     * Gets skipped static columns.
     *
     * @return array
     */
    private function getSkipStaticColumns(): array
    {
        if ($this->skipStaticColumns === []) {
            $this->skipStaticColumns = $this->skipStaticColumnsProvider->get();
        }
        return $this->skipStaticColumns;
    }

    /**
     * @param int $storeId
     * @return string
     */
    public function getMainStoreTable(int $storeId = Store::DEFAULT_STORE_ID): string
    {
        if (is_string($storeId)) {
            $storeId = (int) $storeId;
        }
        $suffix = sprintf('store_%d', $storeId);
        return $this->connection->getTableName($this->getTableName('student_class_flat_' . $suffix));
    }

    /**
     * Get table name
     *
     * @param string $name
     * @return string
     */
    protected function getTableName(string $name): string
    {
        return $this->resource->getTableName($name);
    }

    /**
     * Add suffix to table name to show it is temporary
     *
     * @param string $tableName
     * @return string
     */
    protected function addTemporaryTableSuffix(string $tableName): string
    {
        return $tableName . self::TEMPORARY_TABLE_SUFFIX;
    }

    protected function getFlatTableStructure($tableName)
    {
        $table = $this->connection->newTable(
            $tableName
        )->setComment(
            'Student Class Flat'
        );
    }
    public function getColumns()
    {
        return $this->columns;
    }
}
