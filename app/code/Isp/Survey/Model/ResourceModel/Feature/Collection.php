<?php
/*
 *  @category	Survey
 *  @author		Custom
 *  @copyright  Copyright (c) 2022 Custom
 *
 */
 
namespace Isp\Survey\Model\ResourceModel\Feature;
 
/* use required classes */
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Psr\Log\LoggerInterface;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
 
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';
    
    protected $_logger;
 
    /**
     * @param EntityFactoryInterface $entityFactory,
     * @param LoggerInterface        $logger,
     * @param FetchStrategyInterface $fetchStrategy,
     * @param ManagerInterface       $eventManager,
     * @param StoreManagerInterface  $storeManager,
     * @param AdapterInterface       $connection,
     * @param AbstractDb             $resource
     */
    public function __construct(
        EntityFactoryInterface $entityFactory,
        LoggerInterface $logger,
        FetchStrategyInterface $fetchStrategy,
        ManagerInterface $eventManager,
        StoreManagerInterface $storeManager,
        AdapterInterface $connection = null,
        AbstractDb $resource = null
    ) {
        $this->_logger = $logger;
        $this->_init('Isp\Survey\Model\Survey', 'Isp\Survey\Model\ResourceModel\Survey');
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
        $this->storeManager = $storeManager;
    }
    
    
        protected function _initSelect()
    {
        
        parent::_initSelect();

				$query = $this->getSelect()->reset(\Zend_Db_Select::COLUMNS)
					->columns([new \Zend_Db_Expr('sum(main_table.is_satisfied = 1) as satisfied,sum(main_table.is_satisfied = 0) as non_satisfied')])
					->columns('main_table.isp')->where("isp IS NOT NULL")->group('isp');
				
				// echo $query->__toString(); die();
				
				
	
               
                $this->_logger->error("Query: " . $query->__toString());
                return $this;

    }

    
    
}