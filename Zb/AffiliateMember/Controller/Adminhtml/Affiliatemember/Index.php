<?php
/**
 * Zb_AffiliateMember extension
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category  Zb
 * @package   Zb_AffiliateMember
 * @copyright Copyright (c) 2017
 * @license   http://opensource.org/licenses/mit-license.php MIT License
 */
namespace Zb\AffiliateMember\Controller\Adminhtml\Affiliatemember;

class Index extends \Zb\AffiliateMember\Controller\Adminhtml\Affiliatemember
{
    /**
     * Affiliate members list.
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Zb_AffiliateMember::affiliatemember');
        $resultPage->getConfig()->getTitle()->prepend(__('Affiliate&#x20;members'));
        $resultPage->addBreadcrumb(__('Affiliate Members'), __('Affiliate Members'));
        $resultPage->addBreadcrumb(__('Affiliate&#x20;members'), __('Affiliate&#x20;members'));
        return $resultPage;
    }
}
