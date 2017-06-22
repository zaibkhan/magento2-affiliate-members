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

/**
 * @method \Zb\AffiliateMember\Model\ResourceModel\Affiliatemember _getResource()
 * @method \Zb\AffiliateMember\Model\ResourceModel\Affiliatemember getResource()
 */
class Affiliatemember extends \Magento\Framework\Model\AbstractModel implements \Zb\AffiliateMember\Api\Data\AffiliatememberInterface
{
    /**
     * Cache tag
     * 
     * @var string
     */
    const CACHE_TAG = 'zb_affiliatemember_affiliatemember';

    /**
     * Cache tag
     * 
     * @var string
     */
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * Event prefix
     * 
     * @var string
     */
    protected $_eventPrefix = 'zb_affiliatemember_affiliatemember';

    /**
     * Event object
     * 
     * @var string
     */
    protected $_eventObject = 'affiliatemember';

    /**
     * Uploader pool
     * 
     * @var \Zb\AffiliateMember\Model\UploaderPool
     */
    protected $uploaderPool;

    /**
     * constructor
     * 
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Zb\AffiliateMember\Model\UploaderPool $uploaderPool
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Zb\AffiliateMember\Model\UploaderPool $uploaderPool,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->uploaderPool = $uploaderPool;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Zb\AffiliateMember\Model\ResourceModel\Affiliatemember::class);
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * set Name
     *
     * @param mixed $name
     * @return \Zb\AffiliateMember\Api\Data\AffiliatememberInterface
     */
    public function setName($name)
    {
        return $this->setData(\Zb\AffiliateMember\Api\Data\AffiliatememberInterface::NAME, $name);
    }

    /**
     * get Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->getData(\Zb\AffiliateMember\Api\Data\AffiliatememberInterface::NAME);
    }

    /**
     * set Status
     *
     * @param mixed $status
     * @return \Zb\AffiliateMember\Api\Data\AffiliatememberInterface
     */
    public function setStatus($status)
    {
        return $this->setData(\Zb\AffiliateMember\Api\Data\AffiliatememberInterface::STATUS, $status);
    }

    /**
     * get Status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->getData(\Zb\AffiliateMember\Api\Data\AffiliatememberInterface::STATUS);
    }

    /**
     * set Profile Image
     *
     * @param mixed $profileImage
     * @return \Zb\AffiliateMember\Api\Data\AffiliatememberInterface
     */
    public function setProfileImage($profileImage)
    {
        return $this->setData(\Zb\AffiliateMember\Api\Data\AffiliatememberInterface::PROFILE_IMAGE, $profileImage);
    }

    /**
     * get Profile Image
     *
     * @return string
     */
    public function getProfileImage()
    {
        return $this->getData(\Zb\AffiliateMember\Api\Data\AffiliatememberInterface::PROFILE_IMAGE);
    }

    /**
     * @return bool|string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getProfileImageUrl()
    {
        $url = false;
        $profileImage = $this->getProfileImage();
        if ($profileImage) {
            if (is_string($profileImage)) {
                $uploader = $this->uploaderPool->getUploader('image');
                $url = $uploader->getBaseUrl().$uploader->getBasePath().$profileImage;
            } else {
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('Something went wrong while getting the Profile&#x20;Image url.')
                );
            }
        }
        return $url;
    }
}
