<?php
/*
 *  @category	Survey
 *  @author		Custom
 *  @copyright  Copyright (c) 2022 Custom
 *
 */

namespace Isp\Survey\Model\ResourceModel;
class Survey extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * Construct.
     *
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     * @param string|null                                       $resourcePrefix
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        $resourcePrefix = null
    )
    {
        parent::__construct($context,$resourcePrefix);
    }
    
    protected function _construct()
    {
        $this->_init('sales_order', 'entity_id');
    }
    
}