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
namespace Zb\AffiliateMember\Model\ResourceModel\Affiliatemember;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * ID Field name
     * 
     * @var string
     */
    protected $_idFieldName = 'affiliatemember_id';

    /**
     * Event prefix
     * 
     * @var string
     */
    protected $_eventPrefix = 'zb_affiliatemember_affiliatemember_collection';

    /**
     * Event object
     * 
     * @var string
     */
    protected $_eventObject = 'affiliatemember_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Zb\AffiliateMember\Model\Affiliatemember::class,
            \Zb\AffiliateMember\Model\ResourceModel\Affiliatemember::class
        );
    }

    /**
     * Get SQL for get record count.
     * Extra GROUP BY strip added.
     *
     * @return \Magento\Framework\DB\Select
     */
    public function getSelectCountSql()
    {
        $countSelect = parent::getSelectCountSql();
        $countSelect->reset(\Zend_Db_Select::GROUP);
        return $countSelect;
    }

    /**
     * @param string $valueField
     * @param string $labelField
     * @param array $additional
     * @return array
     */
    protected function _toOptionArray($valueField = 'affiliatemember_id', $labelField = 'name', $additional = [])
    {
        return parent::_toOptionArray($valueField, $labelField, $additional);
    }

    /**
     * @param null $limit
     * @param null $offset
     * @return \Magento\Framework\DB\Select
     */
    protected function getAllIdsSelect($limit = null, $offset = null)
    {
        $idsSelect = clone $this->getSelect();
        $idsSelect->reset(\Magento\Framework\DB\Select::ORDER);
        $idsSelect->reset(\Magento\Framework\DB\Select::LIMIT_COUNT);
        $idsSelect->reset(\Magento\Framework\DB\Select::LIMIT_OFFSET);
        $idsSelect->reset(\Magento\Framework\DB\Select::COLUMNS);
        $idsSelect->columns($this->getResource()->getIdFieldName(), 'main_table');
        $idsSelect->limit($limit, $offset);
        return $idsSelect;
    }
}
