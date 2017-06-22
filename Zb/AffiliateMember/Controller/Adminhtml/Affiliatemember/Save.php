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

class Save extends \Zb\AffiliateMember\Controller\Adminhtml\Affiliatemember
{
    /**
     * Affiliate member factory
     * 
     * @var \Zb\AffiliateMember\Api\Data\AffiliatememberInterfaceFactory
     */
    protected $affiliatememberFactory;

    /**
     * Data Object Processor
     * 
     * @var \Magento\Framework\Reflection\DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * Data Object Helper
     * 
     * @var \Magento\Framework\Api\DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * Uploader pool
     * 
     * @var \Zb\AffiliateMember\Model\UploaderPool
     */
    protected $uploaderPool;

    /**
     * Data Persistor
     * 
     * @var \Magento\Framework\App\Request\DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * constructor
     * 
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Zb\AffiliateMember\Api\AffiliatememberRepositoryInterface $affiliatememberRepository
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Zb\AffiliateMember\Api\Data\AffiliatememberInterfaceFactory $affiliatememberFactory
     * @param \Magento\Framework\Reflection\DataObjectProcessor $dataObjectProcessor
     * @param \Magento\Framework\Api\DataObjectHelper $dataObjectHelper
     * @param \Zb\AffiliateMember\Model\UploaderPool $uploaderPool
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Zb\AffiliateMember\Api\AffiliatememberRepositoryInterface $affiliatememberRepository,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Zb\AffiliateMember\Api\Data\AffiliatememberInterfaceFactory $affiliatememberFactory,
        \Magento\Framework\Reflection\DataObjectProcessor $dataObjectProcessor,
        \Magento\Framework\Api\DataObjectHelper $dataObjectHelper,
        \Zb\AffiliateMember\Model\UploaderPool $uploaderPool,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
    ) {
        $this->affiliatememberFactory = $affiliatememberFactory;
        $this->dataObjectProcessor    = $dataObjectProcessor;
        $this->dataObjectHelper       = $dataObjectHelper;
        $this->uploaderPool           = $uploaderPool;
        $this->dataPersistor          = $dataPersistor;
        parent::__construct($context, $coreRegistry, $affiliatememberRepository, $resultPageFactory);
    }

    /**
     * run the action
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        /** @var \Zb\AffiliateMember\Api\Data\AffiliatememberInterface $affiliatemember */
        $affiliatemember = null;
        $postData = $this->getRequest()->getPostValue();
        $data = $postData;
        $id = !empty($data['affiliatemember_id']) ? $data['affiliatemember_id'] : null;
        $resultRedirect = $this->resultRedirectFactory->create();
        try {
            if ($id) {
                $affiliatemember = $this->affiliatememberRepository->getById((int)$id);
            } else {
                unset($data['affiliatemember_id']);
                $affiliatemember = $this->affiliatememberFactory->create();
            }
            $profileImage = $this->getUploader('image')->uploadFileAndGetName('profile_image', $data);
            $data['profile_image'] = $profileImage;
            $this->dataObjectHelper->populateWithArray($affiliatemember, $data, \Zb\AffiliateMember\Api\Data\AffiliatememberInterface::class);
            $this->affiliatememberRepository->save($affiliatemember);
            $this->messageManager->addSuccessMessage(__('You saved the Affiliate&#x20;member'));
            $this->dataPersistor->clear('zb_affiliatemember_affiliatemember');
            if ($this->getRequest()->getParam('back')) {
                $resultRedirect->setPath('zb_affiliatemember/affiliatemember/edit', ['affiliatemember_id' => $affiliatemember->getId()]);
            } else {
                $resultRedirect->setPath('zb_affiliatemember/affiliatemember');
            }
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            $this->dataPersistor->set('zb_affiliatemember_affiliatemember', $postData);
            $resultRedirect->setPath('zb_affiliatemember/affiliatemember/edit', ['affiliatemember_id' => $id]);
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('There was a problem saving the Affiliate&#x20;member'));
            $this->dataPersistor->set('zb_affiliatemember_affiliatemember', $postData);
            $resultRedirect->setPath('zb_affiliatemember/affiliatemember/edit', ['affiliatemember_id' => $id]);
        }
        return $resultRedirect;
    }

    /**
     * @param string $type
     * @return \Zb\AffiliateMember\Model\Uploader
     * @throws \Exception
     */
    protected function getUploader($type)
    {
        return $this->uploaderPool->getUploader($type);
    }
}
