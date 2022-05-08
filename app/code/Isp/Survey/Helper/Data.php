<?php
namespace Isp\Survey\Helper;
 
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\App\Helper\Context;
 
class Data extends AbstractHelper
{
    protected $_scopeConfig;
    protected $serializer;
 
    public function __construct(
        Context $context,
        \Magento\Framework\Serialize\SerializerInterface $serializer
    ) {
        parent::__construct($context);
        $this->_scopeConfig = $context->getScopeConfig();     
        $this->serializer = $serializer;     
    }
	
	
	public function getIsp(){
			$requestUrl ='http://ip-api.com/json';
			$ch = curl_init($requestUrl);

			// curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$result = curl_exec($ch);

			$result=  json_decode($result);
			$result2 = json_decode(json_encode($result), true);
			
			return $result2;
	}
}