<?php
/*
 *  @category	Survey
 *  @author		Custom
 *  @copyright  Copyright (c) 2022 Custom
 *
 */

namespace Isp\Survey\Setup\Patch\Data;

use Magento\Customer\Model\Attribute\Backend\Data\Boolean;
use Magento\Customer\Model\Customer;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Customer\Setup\Patch\Data\UpdateIdentifierCustomerAttributesVisibility;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Customer\Model\ResourceModel\Attribute;

/**
 * Class AddCustomerDetectIspAttribute
 * @package Techflarestudio\Content\Setup\Patch\Data
 */
class AddCustomerDetectIspAttribute implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var CustomerSetupFactory
     */
    private $customerSetupFactory;

    /**
     * @var Attribute
     */
    private $attributeResource;
	
	/**
     * @var \Magento\Eav\Model\Entity\Attribute\SetFactory
     */
	private $attributeSetFactory;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param CustomerSetupFactory $customerSetupFactory
     * @param Attribute $attributeResource
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CustomerSetupFactory $customerSetupFactory,
        Attribute $attributeResource,
		\Magento\Eav\Model\Entity\Attribute\SetFactory $attributeSetFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->customerSetupFactory = $customerSetupFactory;
        $this->attributeResource = $attributeResource;
		$this->attributeSetFactory = $attributeSetFactory;
    }

    /**
     * @inheritdoc
     */
    public function apply()
    {
        // $customerSetup = $this->customerSetupFactory->create(['setup' => $this->moduleDataSetup]);
		$customerSetup = $this->customerSetupFactory->create(['setup' => $this->moduleDataSetup]);
		$customerEntity = $customerSetup->getEavConfig()->getEntityType('customer');
        $attributeSetId = $customerEntity->getDefaultAttributeSetId();
		
		
		$attributeSet = $this->attributeSetFactory->create();
        $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);

        /**
         * Add attribute
         */
        $customerSetup->addAttribute(Customer::ENTITY, 'allow_detect_isp', [
            'type' => 'int',
            'label' => 'Allow Detect Isp',
            'input' => 'boolean',
            'backend' => Boolean::class,
            'required' => false,
            'visible' => true,
            'user_defined' => true,
            'sort_order' => 780,
            'position' => 780,
            'system' => 0,
            'is_used_in_grid' => false,
            'is_visible_in_grid' => false,
            'is_html_allowed_on_front' => true,
            'visible_on_front' => true
        ]);

       $attribute = $customerSetup->getEavConfig()->getAttribute(Customer::ENTITY, 'allow_detect_isp')
        ->addData([
            'attribute_set_id' => $attributeSetId,
            'attribute_group_id' => $attributeGroupId,
            'used_in_forms' => ['adminhtml_customer', 'customer_account_edit', 'customer_account_create'],
        ]);

        $attribute->save();

        return $attribute;
    }

    /**
     * @inheritdoc
     */
    public static function getDependencies()
    {
        return [
            UpdateIdentifierCustomerAttributesVisibility::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public function getAliases()
    {
        return [];
    }
}