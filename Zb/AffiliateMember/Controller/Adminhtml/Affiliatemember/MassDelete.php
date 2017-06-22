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

class MassDelete extends \Zb\AffiliateMember\Controller\Adminhtml\Affiliatemember\MassAction
{
    /**
     * @param \Zb\AffiliateMember\Api\Data\AffiliatememberInterface $affiliatemember
     * @return $this
     */
    protected function massAction(\Zb\AffiliateMember\Api\Data\AffiliatememberInterface $affiliatemember)
    {
        $this->affiliatememberRepository->delete($affiliatemember);
        return $this;
    }
}
