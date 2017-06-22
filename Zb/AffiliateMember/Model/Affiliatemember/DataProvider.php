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
namespace Zb\AffiliateMember\Model\Affiliatemember;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * Loaded data cache
     * 
     * @var array
     */
    protected $loadedData;

    /**
     * Data persistor
     * 
     * @var \Magento\Framework\App\Request\DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * constructor
     * 
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param \Zb\AffiliateMember\Model\ResourceModel\Affiliatemember\CollectionFactory $collectionFactory
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Zb\AffiliateMember\Model\ResourceModel\Affiliatemember\CollectionFactory $collectionFactory,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var \Zb\AffiliateMember\Model\Affiliatemember $affiliatemember */
        foreach ($items as $affiliatemember) {
            $this->loadedData[$affiliatemember->getId()] = $affiliatemember->getData();

            if (isset($this->loadedData[$affiliatemember->getId()]['profile_image'])) {
                $profileImage = [];
                $profileImage[0]['name'] = $affiliatemember->getProfileImage();
                $profileImage[0]['url'] = $affiliatemember->getProfileImageUrl();
                $this->loadedData[$affiliatemember->getId()]['profile_image'] = $profileImage;
            }
        }
        $data = $this->dataPersistor->get('zb_affiliatemember_affiliatemember');
        if (!empty($data)) {
            $affiliatemember = $this->collection->getNewEmptyItem();
            $affiliatemember->setData($data);
            $this->loadedData[$affiliatemember->getId()] = $affiliatemember->getData();
            $this->dataPersistor->clear('zb_affiliatemember_affiliatemember');
        }
        return $this->loadedData;
    }
}
