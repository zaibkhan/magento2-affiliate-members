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
namespace Zb\AffiliateMember\Api\Data;

/**
 * @api
 */
interface AffiliatememberSearchResultInterface
{
    /**
     * Get Affiliate members list.
     *
     * @return \Zb\AffiliateMember\Api\Data\AffiliatememberInterface[]
     */
    public function getItems();

    /**
     * Set Affiliate members list.
     *
     * @param \Zb\AffiliateMember\Api\Data\AffiliatememberInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
