<?php

namespace AiDaYu\Customer\Controller\Employee;

use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\ActionInterface;
use AiDaYu\Customer\Model\AllRecords;
use AiDaYu\Customer\Model\CustomVirtualEmployee;

class Employee implements ActionInterface
{
    protected $resultPageFactory;

    protected $empAllRecords;

    protected $virEmp;

    public function __construct(
        PageFactory $resultPageFactory,
        AllRecords $empAllRecords,
        CustomVirtualEmployee $virEmp
    ) {
        $this->virEmp   = $virEmp;
        $this->empAllRecords = $empAllRecords;
        $this->resultPageFactory = $resultPageFactory;
    }

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
        echo $dataStrB;die;

        //return $this->resultPageFactory->create();
    }
}
