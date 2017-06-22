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
namespace Zb\AffiliateMember\Model;

class AffiliatememberRepository implements \Zb\AffiliateMember\Api\AffiliatememberRepositoryInterface
{
    /**
     * Cached instances
     * 
     * @var array
     */
    protected $instances = [];

    /**
     * Affiliate member resource model
     * 
     * @var \Zb\AffiliateMember\Model\ResourceModel\Affiliatemember
     */
    protected $resource;

    /**
     * Affiliate member collection factory
     * 
     * @var \Zb\AffiliateMember\Model\ResourceModel\Affiliatemember\CollectionFactory
     */
    protected $affiliatememberCollectionFactory;

    /**
     * Affiliate member interface factory
     * 
     * @var \Zb\AffiliateMember\Api\Data\AffiliatememberInterfaceFactory
     */
    protected $affiliatememberInterfaceFactory;

    /**
     * Data Object Helper
     * 
     * @var \Magento\Framework\Api\DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * Search result factory
     * 
     * @var \Zb\AffiliateMember\Api\Data\AffiliatememberSearchResultInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * constructor
     * 
     * @param \Zb\AffiliateMember\Model\ResourceModel\Affiliatemember $resource
     * @param \Zb\AffiliateMember\Model\ResourceModel\Affiliatemember\CollectionFactory $affiliatememberCollectionFactory
     * @param \Zb\AffiliateMember\Api\Data\AffiliatememberInterfaceFactory $affiliatememberInterfaceFactory
     * @param \Magento\Framework\Api\DataObjectHelper $dataObjectHelper
     * @param \Zb\AffiliateMember\Api\Data\AffiliatememberSearchResultInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        \Zb\AffiliateMember\Model\ResourceModel\Affiliatemember $resource,
        \Zb\AffiliateMember\Model\ResourceModel\Affiliatemember\CollectionFactory $affiliatememberCollectionFactory,
        \Zb\AffiliateMember\Api\Data\AffiliatememberInterfaceFactory $affiliatememberInterfaceFactory,
        \Magento\Framework\Api\DataObjectHelper $dataObjectHelper,
        \Zb\AffiliateMember\Api\Data\AffiliatememberSearchResultInterfaceFactory $searchResultsFactory
    ) {
        $this->resource                         = $resource;
        $this->affiliatememberCollectionFactory = $affiliatememberCollectionFactory;
        $this->affiliatememberInterfaceFactory  = $affiliatememberInterfaceFactory;
        $this->dataObjectHelper                 = $dataObjectHelper;
        $this->searchResultsFactory             = $searchResultsFactory;
    }

    /**
     * Save Affiliate member.
     *
     * @param \Zb\AffiliateMember\Api\Data\AffiliatememberInterface $affiliatemember
     * @return \Zb\AffiliateMember\Api\Data\AffiliatememberInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\Zb\AffiliateMember\Api\Data\AffiliatememberInterface $affiliatemember)
    {
        /** @var \Zb\AffiliateMember\Api\Data\AffiliatememberInterface|\Magento\Framework\Model\AbstractModel $affiliatemember */
        try {
            $this->resource->save($affiliatemember);
        } catch (\Exception $exception) {
            throw new \Magento\Framework\Exception\CouldNotSaveException(__(
                'Could not save the Affiliate&#x20;member: %1',
                $exception->getMessage()
            ));
        }
        return $affiliatemember;
    }

    /**
     * Retrieve Affiliate member.
     *
     * @param int $affiliatememberId
     * @return \Zb\AffiliateMember\Api\Data\AffiliatememberInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($affiliatememberId)
    {
        if (!isset($this->instances[$affiliatememberId])) {
            /** @var \Zb\AffiliateMember\Api\Data\AffiliatememberInterface|\Magento\Framework\Model\AbstractModel $affiliatemember */
            $affiliatemember = $this->affiliatememberInterfaceFactory->create();
            $this->resource->load($affiliatemember, $affiliatememberId);
            if (!$affiliatemember->getId()) {
                throw new \Magento\Framework\Exception\NoSuchEntityException(__('Requested Affiliate&#x20;member doesn\'t exist'));
            }
            $this->instances[$affiliatememberId] = $affiliatemember;
        }
        return $this->instances[$affiliatememberId];
    }

    /**
     * Retrieve Affiliate members matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Zb\AffiliateMember\Api\Data\AffiliatememberSearchResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        /** @var \Zb\AffiliateMember\Api\Data\AffiliatememberSearchResultInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);

        /** @var \Zb\AffiliateMember\Model\ResourceModel\Affiliatemember\Collection $collection */
        $collection = $this->affiliatememberCollectionFactory->create();

        //Add filters from root filter group to the collection
        /** @var \Magento\Framework\Api\Search\FilterGroup $group */
        foreach ($searchCriteria->getFilterGroups() as $group) {
            $this->addFilterGroupToCollection($group, $collection);
        }
        $sortOrders = $searchCriteria->getSortOrders();
        /** @var \Magento\Framework\Api\SortOrder $sortOrder */
        if ($sortOrders) {
            foreach ($searchCriteria->getSortOrders() as $sortOrder) {
                $field = $sortOrder->getField();
                $collection->addOrder(
                    $field,
                    ($sortOrder->getDirection() == \Magento\Framework\Api\SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        } else {
            // set a default sorting order since this method is used constantly in many
            // different blocks
            $field = 'affiliatemember_id';
            $collection->addOrder($field, 'ASC');
        }
        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());

        /** @var \Zb\AffiliateMember\Api\Data\AffiliatememberInterface[] $affiliatemembers */
        $affiliatemembers = [];
        /** @var \Zb\AffiliateMember\Model\Affiliatemember $affiliatemember */
        foreach ($collection as $affiliatemember) {
            /** @var \Zb\AffiliateMember\Api\Data\AffiliatememberInterface $affiliatememberDataObject */
            $affiliatememberDataObject = $this->affiliatememberInterfaceFactory->create();
            $this->dataObjectHelper->populateWithArray(
                $affiliatememberDataObject,
                $affiliatememberr->getData(),
                \Zb\AffiliateMember\Api\Data\AffiliatememberInterface::class
            );
            $affiliatemembers[] = $affiliatememberDataObject;
        }
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults->setItems($affiliatemembers);
    }

    /**
     * Delete Affiliate member.
     *
     * @param \Zb\AffiliateMember\Api\Data\AffiliatememberInterface $affiliatemember
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(\Zb\AffiliateMember\Api\Data\AffiliatememberInterface $affiliatemember)
    {
        /** @var \Zb\AffiliateMember\Api\Data\AffiliatememberInterface|\Magento\Framework\Model\AbstractModel $affiliatemember */
        $id = $affiliatemember->getId();
        try {
            unset($this->instances[$id]);
            $this->resource->delete($affiliatemember);
        } catch (\Magento\Framework\Exception\ValidatorException $e) {
            throw new \Magento\Framework\Exception\CouldNotSaveException(__($e->getMessage()));
        } catch (\Exception $e) {
            throw new \Magento\Framework\Exception\StateException(
                __('Unable to remove Affiliate&#x20;member %1', $id)
            );
        }
        unset($this->instances[$id]);
        return true;
    }

    /**
     * Delete Affiliate member by ID.
     *
     * @param int $affiliatememberId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($affiliatememberId)
    {
        $affiliatemember = $this->getById($affiliatememberId);
        return $this->delete($affiliatemember);
    }

    /**
     * Helper function that adds a FilterGroup to the collection.
     *
     * @param \Magento\Framework\Api\Search\FilterGroup $filterGroup
     * @param \Zb\AffiliateMember\Model\ResourceModel\Affiliatemember\Collection $collection
     * @return $this
     * @throws \Magento\Framework\Exception\InputException
     */
    protected function addFilterGroupToCollection(
        \Magento\Framework\Api\Search\FilterGroup $filterGroup,
        \Zb\AffiliateMember\Model\ResourceModel\Affiliatemember\Collection $collection
    ) {
        $fields = [];
        $conditions = [];
        foreach ($filterGroup->getFilters() as $filter) {
            $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
            $fields[] = $filter->getField();
            $conditions[] = [$condition => $filter->getValue()];
        }
        if ($fields) {
            $collection->addFieldToFilter($fields, $conditions);
        }
        return $this;
    }
}
