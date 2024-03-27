<?php

namespace AiDaYu\Customer\Model\Indexer\Student\Flat;

class SkipStaticColumnsProvider
{

    /**
     * @var array|mixed
     */
    private array $skipStaticColumns;

    /**
     * @param array $skipStaticColumns
     */
    public function __construct(array $skipStaticColumns = [])
    {
        $this->skipStaticColumns = $skipStaticColumns;
    }

    /**
     * @return array
     */
    public function get(): array
    {
        return $this->skipStaticColumns;
    }
}
