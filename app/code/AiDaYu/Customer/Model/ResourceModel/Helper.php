<?php

namespace AiDaYu\Customer\Model\ResourceModel;

/**
 * Eav Mysql resource helper model
 */
class Helper
{
    /**
     * Mysql column - Table DDL type pairs
     *
     * @var array
     */
    protected array $_ddlColumnTypes = [
        \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN => 'bool',
        \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT => 'smallint',
        \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER => 'int',
        \Magento\Framework\DB\Ddl\Table::TYPE_BIGINT => 'bigint',
        \Magento\Framework\DB\Ddl\Table::TYPE_FLOAT => 'float',
        \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL => 'decimal',
        \Magento\Framework\DB\Ddl\Table::TYPE_NUMERIC => 'decimal',
        \Magento\Framework\DB\Ddl\Table::TYPE_DATE => 'date',
        \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP => 'timestamp',
        \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME => 'datetime',
        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT => 'text',
        \Magento\Framework\DB\Ddl\Table::TYPE_BLOB => 'blob',
        \Magento\Framework\DB\Ddl\Table::TYPE_VARBINARY => 'blob',
    ];

    /**
     * @param $columnType
     * @return string
     */
    public function getDdlTypeByColumnType($columnType)
    {
        switch ($columnType) {
            case 'var':
            case 'varchar':
                $columnType = 'text';
                break;
            case 'tinyint':
                $columnType = 'smallint';
                break;
            default:
                break;
        }
        return array_search($columnType, $this->_ddlColumnTypes);
    }
}
