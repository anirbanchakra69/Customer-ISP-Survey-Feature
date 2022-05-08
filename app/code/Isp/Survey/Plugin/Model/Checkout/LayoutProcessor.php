<?php

/*
 *  @category	Survey
 *  @author		Custom
 *  @copyright  Copyright (c) 2022 Custom
 *
 */
 
namespace Isp\Survey\Plugin\Model\Checkout;


class LayoutProcessor
{

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $checkoutSession;

    /**
     * @var \Magento\Customer\Model\AddressFactory
     */
    protected $customerAddressFactory;

    /**
     * @var \Magento\Framework\Data\Form\FormKey
     */
    protected $formKey;
	
	/**
     * @var \Magento\Customer\Model\Session
     */
	protected $customerSession;
	
	/**
     * @var \Magento\Customer\Api\CustomerRepositoryInterface
     */
	protected $customerRepository;
	
	/**
     * @var \Isp\Survey\Helper\Data
     */
	protected $_surveyhelper;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\CheckoutAgreements\Model\ResourceModel\Agreement\CollectionFactory $agreementCollectionFactory,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Customer\Model\AddressFactory $customerAddressFactory,
		\Magento\Customer\Model\Session $session,
		\Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
		\Isp\Survey\Helper\Data $surveyhelper
    ) {
        $this->scopeConfig = $context->getScopeConfig();
        $this->checkoutSession = $checkoutSession;
        $this->customerAddressFactory = $customerAddressFactory;
		$this->customerSession = $session;
		$this->customerRepository = $customerRepository;
		$this->_surveyhelper = $surveyhelper;
    }
	
	
	public function afterProcess(
        \Magento\Checkout\Block\Checkout\LayoutProcessor $subject,
        array  $jsLayout
    ) {
		 $allow_detect_isp = $this->getAllowDetectIsp();
		 $allow_detect_isp = $allow_detect_isp ? $allow_detect_isp->getValue() : 0;
		
        
		if($allow_detect_isp == 1){
			
			$jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
				['payment']['children']['payments-list']['children']['before-place-order']['children']['is_satisfied'] = [
            'component' => 'Magento_Ui/js/form/element/select',
            'config' => [
                'customScope' => 'shippingAddress',
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/select',
                'id' => 'drop-down',
            ],
            'dataScope' => 'shippingAddress.is_satisfied',
            'label' => 'You are using "'.$this->getName().'" for your internet connection. \n Are You Satisfied with your current internet service provider?',
            'provider' => 'checkoutProvider',
            'visible' => true,
            'validation' => [],
            'sortOrder' => 251,
            'id' => 'is-satisfied',
            'options' => [
                [
                    'value' => '1',
                    'label' => 'Yes',
                ],
                [
                    'value' => '0',
                    'label' => 'No',
                ]
            ]
        ];
		}

        return $jsLayout;
    }
	
	public function getAllowDetectIsp(){
		$allow_detect_isp = 0;
		if ($this->customerSession->isLoggedIn()) 
        {
          $customerid = $this->customerSession->getCustomer()->getId();
		  $customer = $this->customerRepository->getById($customerid);
		  $allow_detect_isp = $customer->getCustomAttribute('allow_detect_isp');
        }
		
	return $allow_detect_isp;
		
	}
	
	
	public function getName(){
		
		$value = $this->_surveyhelper->getIsp();
		return $value['isp'];
		
	}
  
    
    
}