<?php

/*
 *  @category	Survey
 *  @author		Custom
 *  @copyright  Copyright (c) 2022 Custom
 *
 */

namespace Isp\Survey\Controller\Quote;

class Save extends \Magento\Framework\App\Action\Action
{
    protected $quoteIdMaskFactory;

    protected $quoteRepository;
	
	protected $_surveyhelper;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Quote\Model\QuoteIdMaskFactory $quoteIdMaskFactory,
        \Magento\Quote\Api\CartRepositoryInterface $quoteRepository,
		\Isp\Survey\Helper\Data $surveyhelper
    ) {
        parent::__construct($context);
        $this->quoteRepository = $quoteRepository;
        $this->quoteIdMaskFactory = $quoteIdMaskFactory;
		$this->_surveyhelper = $surveyhelper;
    }

    /**
     * @return \Magento\Framework\Controller\Result\Raw
     */
    public function execute()
    {
        $post = $this->getRequest()->getPostValue();
        if ($post) {
            $cartId       = $post['cartId'];
            $is_satisfied = $post['is_satisfied'];
			$isp = $this->getName();
			
            $loggin       = $post['is_customer'];

            if ($loggin === 'false') {
                $cartId = $this->quoteIdMaskFactory->create()->load($cartId, 'masked_id')->getQuoteId();
            }

            $quote = $this->quoteRepository->getActive($cartId);
            if (!$quote->getItemsCount()) {
                throw new NoSuchEntityException(__('Cart %1 doesn\'t contain products', $cartId));
            }

            $quote->setData('is_satisfied', $is_satisfied);
			$quote->setData('isp', $isp);
            $this->quoteRepository->save($quote);
        }
    }
	
	public function getName(){
		
		$value = $this->_surveyhelper->getIsp();
		return $value['isp'] ;
		
	}
}