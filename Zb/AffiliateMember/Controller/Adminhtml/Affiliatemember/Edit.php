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

class Edit extends \Zb\AffiliateMember\Controller\Adminhtml\Affiliatemember
{
    /**
     * Initialize current Affiliate member and set it in the registry.
     *
     * @return int
     */
    protected function initAffiliatemember()
    {
        $affiliatememberId = $this->getRequest()->getParam('affiliatemember_id');
        $this->coreRegistry->register(\Zb\AffiliateMember\Controller\RegistryConstants::CURRENT_AFFILIATEMEMBER_ID, $affiliatememberId);

        return $affiliatememberId;
    }

    /**
     * Edit or create Affiliate member
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $affiliatememberId = $this->initAffiliatemember();

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Zb_AffiliateMember::affiliatemember_affiliatemember');
        $resultPage->getConfig()->getTitle()->prepend(__('Affiliate&#x20;members'));
        $resultPage->addBreadcrumb(__('Affiliate Members'), __('Affiliate Members'));
        $resultPage->addBreadcrumb(__('Affiliate&#x20;members'), __('Affiliate&#x20;members'), $this->getUrl('zb_affiliatemember/affiliatemember'));

        if ($affiliatememberId === null) {
            $resultPage->addBreadcrumb(__('New Affiliate&#x20;member'), __('New Affiliate&#x20;member'));
            $resultPage->getConfig()->getTitle()->prepend(__('New Affiliate&#x20;member'));
        } else {
            $resultPage->addBreadcrumb(__('Edit Affiliate&#x20;member'), __('Edit Affiliate&#x20;member'));
            $resultPage->getConfig()->getTitle()->prepend(
                $this->affiliatememberRepository->getById($affiliatememberId)->getName()
            );
        }
        return $resultPage;
    }
}
