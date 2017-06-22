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

class InlineEdit extends \Zb\AffiliateMember\Controller\Adminhtml\Affiliatemember
{
    /**
     * Core registry
     * 
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;

    /**
     * Affiliate member repository
     * 
     * @var \Zb\AffiliateMember\Api\AffiliatememberRepositoryInterface
     */
    protected $affiliatememberRepository;

    /**
     * Page factory
     * 
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * Data object processor
     * 
     * @var \Magento\Framework\Reflection\DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * Data object helper
     * 
     * @var \Magento\Framework\Api\DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * JSON Factory
     * 
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $jsonFactory;

    /**
     * Affiliate member resource model
     * 
     * @var \Zb\AffiliateMember\Model\ResourceModel\Affiliatemember
     */
    protected $affiliatememberResourceModel;

    /**
     * constructor
     * 
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Zb\AffiliateMember\Api\AffiliatememberRepositoryInterface $affiliatememberRepository
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Reflection\DataObjectProcessor $dataObjectProcessor
     * @param \Magento\Framework\Api\DataObjectHelper $dataObjectHelper
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
     * @param \Zb\AffiliateMember\Model\ResourceModel\Affiliatemember $affiliatememberResourceModel
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Zb\AffiliateMember\Api\AffiliatememberRepositoryInterface $affiliatememberRepository,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Reflection\DataObjectProcessor $dataObjectProcessor,
        \Magento\Framework\Api\DataObjectHelper $dataObjectHelper,
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        \Zb\AffiliateMember\Model\ResourceModel\Affiliatemember $affiliatememberResourceModel
    ) {
        $this->dataObjectProcessor          = $dataObjectProcessor;
        $this->dataObjectHelper             = $dataObjectHelper;
        $this->jsonFactory                  = $jsonFactory;
        $this->affiliatememberResourceModel = $affiliatememberResourceModel;
        parent::__construct($context, $coreRegistry, $affiliatememberRepository, $resultPageFactory);
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        $postItems = $this->getRequest()->getParam('items', []);
        if (!($this->getRequest()->getParam('isAjax') && count($postItems))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }

        foreach (array_keys($postItems) as $affiliatememberId) {
            /** @var \Zb\AffiliateMember\Model\Affiliatemember|\Zb\AffiliateMember\Api\Data\AffiliatememberInterface $affiliatemember */
            $affiliatemember = $this->affiliatememberRepository->getById((int)$affiliatememberId);
            try {
                $affiliatememberData = $postItems[$affiliatememberId];
                $this->dataObjectHelper->populateWithArray($affiliatemember, $affiliatememberData, \Zb\AffiliateMember\Api\Data\AffiliatememberInterface::class);
                $this->affiliatememberResourceModel->saveAttribute($affiliatemember, array_keys($affiliatememberData));
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $messages[] = $this->getErrorWithAffiliatememberId($affiliatemember, $e->getMessage());
                $error = true;
            } catch (\RuntimeException $e) {
                $messages[] = $this->getErrorWithAffiliatememberId($affiliatemember, $e->getMessage());
                $error = true;
            } catch (\Exception $e) {
                $messages[] = $this->getErrorWithAffiliatememberId(
                    $affiliatemember,
                    __('Something went wrong while saving the Affiliate&#x20;member.')
                );
                $error = true;
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    /**
     * Add Affiliate&#x20;member id to error message
     *
     * @param \Zb\AffiliateMember\Api\Data\AffiliatememberInterface $affiliatemember
     * @param string $errorText
     * @return string
     */
    protected function getErrorWithAffiliatememberId(\Zb\AffiliateMember\Api\Data\AffiliatememberInterface $affiliatemember, $errorText)
    {
        return '[Affiliate&#x20;member ID: ' . $affiliatemember->getId() . '] ' . $errorText;
    }
}
