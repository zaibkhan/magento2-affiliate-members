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

class Delete extends \Zb\AffiliateMember\Controller\Adminhtml\Affiliatemember
{
    /**
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('affiliatemember_id');
        if ($id) {
            try {
                $this->affiliatememberRepository->deleteById($id);
                $this->messageManager->addSuccessMessage(__('The Affiliate&#x20;member has been deleted.'));
                $resultRedirect->setPath('zb_affiliatemember/*/');
                return $resultRedirect;
            } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(__('The Affiliate&#x20;member no longer exists.'));
                return $resultRedirect->setPath('zb_affiliatemember/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('zb_affiliatemember/affiliatemember/edit', ['affiliatemember_id' => $id]);
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('There was a problem deleting the Affiliate&#x20;member'));
                return $resultRedirect->setPath('zb_affiliatemember/affiliatemember/edit', ['affiliatemember_id' => $id]);
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find a Affiliate&#x20;member to delete.'));
        $resultRedirect->setPath('zb_affiliatemember/*/');
        return $resultRedirect;
    }
}
