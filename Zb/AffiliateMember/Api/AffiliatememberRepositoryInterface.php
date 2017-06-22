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
namespace Zb\AffiliateMember\Api;

/**
 * @api
 */
interface AffiliatememberRepositoryInterface
{
    /**
     * Save Affiliate member.
     *
     * @param \Zb\AffiliateMember\Api\Data\AffiliatememberInterface $affiliatemember
     * @return \Zb\AffiliateMember\Api\Data\AffiliatememberInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\Zb\AffiliateMember\Api\Data\AffiliatememberInterface $affiliatemember);

    /**
     * Retrieve Affiliate member
     *
     * @param int $affiliatememberId
     * @return \Zb\AffiliateMember\Api\Data\AffiliatememberInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($affiliatememberId);

    /**
     * Retrieve Affiliate members matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Zb\AffiliateMember\Api\Data\AffiliatememberSearchResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete Affiliate member.
     *
     * @param \Zb\AffiliateMember\Api\Data\AffiliatememberInterface $affiliatemember
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(\Zb\AffiliateMember\Api\Data\AffiliatememberInterface $affiliatemember);

    /**
     * Delete Affiliate member by ID.
     *
     * @param int $affiliatememberId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($affiliatememberId);
}
