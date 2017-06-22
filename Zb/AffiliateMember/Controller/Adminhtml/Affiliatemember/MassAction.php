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

abstract class MassAction extends \Magento\Backend\App\Action
{
    /**
     * Affiliate member repository
     * 
     * @var \Zb\AffiliateMember\Api\AffiliatememberRepositoryInterface
     */
    protected $affiliatememberRepository;

    /**
     * Mass Action filter
     * 
     * @var \Magento\Ui\Component\MassAction\Filter
     */
    protected $filter;

    /**
     * Affiliate member collection factory
     * 
     * @var \Zb\AffiliateMember\Model\ResourceModel\Affiliatemember\CollectionFactory
     */
    protected $collectionFactory;

    /**
     * Action success message
     * 
     * @var string
     */
    protected $successMessage;

    /**
     * Action error message
     * 
     * @var string
     */
    protected $errorMessage;

    /**
     * constructor
     * 
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Zb\AffiliateMember\Api\AffiliatememberRepositoryInterface $affiliatememberRepository
     * @param \Magento\Ui\Component\MassAction\Filter $filter
     * @param \Zb\AffiliateMember\Model\ResourceModel\Affiliatemember\CollectionFactory $collectionFactory
     * @param string $successMessage
     * @param string $errorMessage
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Zb\AffiliateMember\Api\AffiliatememberRepositoryInterface $affiliatememberRepository,
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Zb\AffiliateMember\Model\ResourceModel\Affiliatemember\CollectionFactory $collectionFactory,
        $successMessage,
        $errorMessage
    ) {
        $this->affiliatememberRepository = $affiliatememberRepository;
        $this->filter                    = $filter;
        $this->collectionFactory         = $collectionFactory;
        $this->successMessage            = $successMessage;
        $this->errorMessage              = $errorMessage;
        parent::__construct($context);
    }

    /**
     * @param \Zb\AffiliateMember\Api\Data\AffiliatememberInterface $affiliatemember
     * @return mixed
     */
    abstract protected function massAction(\Zb\AffiliateMember\Api\Data\AffiliatememberInterface $affiliatemember);

    /**
     * execute action
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        try {
            $collection = $this->filter->getCollection($this->collectionFactory->create());
            $collectionSize = $collection->getSize();
            foreach ($collection as $affiliatemember) {
                $this->massAction($affiliatemember);
            }
            $this->messageManager->addSuccessMessage(__($this->successMessage, $collectionSize));
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, $this->errorMessage);
        }
        $redirectResult = $this->resultRedirectFactory->create();
        $redirectResult->setPath('zb_affiliatemember/*/index');
        return $redirectResult;
    }
}
