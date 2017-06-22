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
namespace Zb\AffiliateMember\Block\Adminhtml\Affiliatemember\Edit\Buttons;

class Generic
{
    /**
     * Widget Context
     * 
     * @var \Magento\Backend\Block\Widget\Context
     */
    protected $context;

    /**
     * Affiliate member Repository
     * 
     * @var \Zb\AffiliateMember\Api\AffiliatememberRepositoryInterface
     */
    protected $affiliatememberRepository;

    /**
     * constructor
     * 
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Zb\AffiliateMember\Api\AffiliatememberRepositoryInterface $affiliatememberRepository
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Zb\AffiliateMember\Api\AffiliatememberRepositoryInterface $affiliatememberRepository
    ) {
        $this->context                   = $context;
        $this->affiliatememberRepository = $affiliatememberRepository;
    }

    /**
     * Return Affiliate member ID
     *
     * @return int|null
     */
    public function getAffiliatememberId()
    {
        try {
            return $this->affiliatememberRepository->getById(
                $this->context->getRequest()->getParam('affiliatemember_id')
            )->getId();
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            return null;
        }
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
