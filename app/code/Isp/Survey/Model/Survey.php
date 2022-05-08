<?php
/*
 *  @category	Survey
 *  @author		Custom
 *  @copyright  Copyright (c) 2022 Custom
 *
 */

namespace Isp\Survey\Model;

use Magento\Framework\Model\AbstractModel;

class Survey extends AbstractModel
{
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('Isp\Survey\Model\ResourceModel\Survey');
    }
}