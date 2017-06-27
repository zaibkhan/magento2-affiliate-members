<?php
namespace Zb\AffiliateMember\Model;
use Zb\AffiliateMember\Api\CustomInterface;
 
class Custom implements CustomInterface
{
	public function __contstruct(
        \Magento\Framework\App\Action\Context $context,
        \Psr\Log\LoggerInterface $logger
    ){
        parent::__construct($context);
    }

	/**
     * Returns greeting message to user
     *
     * @api
     * @return string result data
     */
    public function showall()
    {
        try{
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $affiliateMemberFactory = $objectManager->create('Zb\AffiliateMember\Api\Data\AffiliatememberInterfaceFactory');
            $affiliateMember = $affiliateMemberFactory->create()->getCollection();
            $affiliateMemberArr = array();
            foreach ($affiliateMember as $a) {
                $affiliateMemberArr[] = $a->getData();
            }
            return json_encode($affiliateMemberArr);
        }
        catch(Exception $ex){
            return $ex->getMessage();
        }
    }

    /**
     * Returns greeting message to user
     *
     * @api
     * @return string result data
     */
    public function active()
    {
        try{
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $affiliateMemberFactory = $objectManager->create('Zb\AffiliateMember\Api\Data\AffiliatememberInterfaceFactory');
            $affiliateMember = $affiliateMemberFactory->create()->getCollection()->addFieldToFilter('status',array('eq' => 1));
            $affiliateMemberArr = array();
            foreach ($affiliateMember as $a) {
                $affiliateMemberArr[] = $a->getData();
            }
            return json_encode($affiliateMemberArr);
        }
        catch(Exception $ex){
            return $ex->getMessage();
        }
    }
}
