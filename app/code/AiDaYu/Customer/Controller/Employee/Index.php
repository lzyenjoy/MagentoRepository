<?php

namespace AiDaYu\Customer\Controller\Employee;

use Magento\Framework\App\Action\HttpGetActionInterface;

class Index implements HttpGetActionInterface
{

    /**
     * @var \AiDaYu\Customer\Model\AllRecords
     */
    protected $empAllRecords;
    /**
     * @var \AiDaYu\Customer\Model\CustomVirtualEmployee
     */
    protected $virEmp;
    /**
     * Initialize dependencies
     *
     * @param \AiDaYu\Customer\Model\AllRecords $empAllRecords
     * @param \AiDaYu\Customer\Model\CustomVirtualEmployee $virEmp
     * @return void
     */
    public function __construct(
        \AiDaYu\Customer\Model\AllRecords $empAllRecords,
        \AiDaYu\Customer\Model\CustomVirtualEmployee $virEmp
    ) {
        $this->virEmp   = $virEmp;
        $this->empAllRecords = $empAllRecords;
    }
    /**
     * Execute method to print data
     *
     * @return
     */
    public function execute()
    {
        $empRecords = $this->empAllRecords->getRecords();
        $dataStr = "";
        foreach ($empRecords as $index => $each) {
            $dataStr .= $index."::".json_encode($each->getRecord())."<br>";
        }
        echo $dataStr.PHP_EOL;
        $employeeAttrs = $this->virEmp->getAllData();

        $dataStrB = '';
        $dataStrB .= "<h3>Result for Case 2: Created &lt;virtualType&gt; for class AiDaYu\Customer\Model\Employee and created CustomVirtualEmployee class</h3>";
        foreach ($employeeAttrs as $key => $value) {
            $dataStrB .= $key."::".$value."<br>";
        }
        echo $dataStrB;
    }
}
