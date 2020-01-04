<?php
namespace DoIRun\Rules\Observer;

class XAddressConditionObserver implements \Magento\Framework\Event\ObserverInterface
{
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $additional = $observer->getEvent()->getAdditional();
        $conditions = (array) $additional->getConditions();
        $conditions = array_merge_recursive($conditions, [
                [
                    'value' => \Nume\Rules\Model\Rule\Condition\Address::class,
                    'label' => __('Subtotal after discount')
                ],
            ]
        );
        $additional->setConditions($conditions);
        return $this;
    }
    private function getSubtotalAfterDiscountCondition()
    {
        return [
            'value' => \Nume\Rules\Model\Rule\Condition\Address::class,
            'label' => __('Subtotal after discount')
        ];
    }
}