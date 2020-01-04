<?php

namespace DoIRun\Rules\Model\Rule\Condition;

class Address extends \Magento\Rule\Model\Condition\AbstractCondition
{
    public function __construct(
        \Magento\Rule\Model\Condition\Context $context,
        array $data
    )
    {
        parent::__construct($context, $data);
    }

    public function loadAttributeOptions()
    {
        $this->setAttributeOption([
            'subtotal_after_discount' => __('Subtotal after discount')
        ]);
        return $this;
    }

    public function getInputType()
    {
        return 'numeric';
    }

    public function getValueElementType()
    {
        return 'text';
    }

    public function getValueSelectOptions()
    {
        if (!$this->hasData('value_select_options')) {
            $options = [];
            $this->setData('value_select_options', $options);
        }
        return $this->getData('value_select_options');
    }

    public function validate(\Magento\Framework\Model\AbstractModel $model)
    {
        if(!$model->hasData('doirun_rules_stad')) {
            $model->setData('doirun_rules_stad',1);
        }
        $tcount = $model->getData('doirun_rules_stad');
        $tcount += 1;
        $model->setData('doirun_rules_stad',$tcount);
        if($tcount > 1) {
            $ttl_discount = 0;
            $ttl_rows = 0;
            if(array_key_exists('cached_items_all', $model->getData())) {
                foreach ($model->getData('cached_items_all') as $item) {
                    $idiscount = $item->getData('base_discount_amount');
                    $row = $item->getData('base_row_total');
                    $ttl_discount += $idiscount;
                    $ttl_rows += $row;
                }
            }
            $stwd = $ttl_rows - $ttl_discount;
        }
        $model->setData('subtotal_after_discount',$stwd);
        return parent::validate($model);
    }
}