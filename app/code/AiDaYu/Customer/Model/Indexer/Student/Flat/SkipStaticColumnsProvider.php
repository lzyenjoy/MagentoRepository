<?php

namespace AiDaYu\Customer\Model\Indexer\Student\Flat;

class SkipStaticColumnsProvider
{

    /**
     * @var array|mixed
     */
    private array $skipStaticColumns;

    /**
     * @param $skipStaticColumns
     */
    public function __construct($skipStaticColumns = [])
    {
        $this->skipStaticColumns = $skipStaticColumns;
    }

    /**
     * @return array
     */
    public function get()
    {
        return $this->skipStaticColumns;
    }
}
