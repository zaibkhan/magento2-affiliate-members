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
interface AffiliatememberInterface
{
    /**
     * Name attribute constant
     * 
     * @var string
     */
    const NAME = 'name';

    /**
     * Status attribute constant
     * 
     * @var string
     */
    const STATUS = 'status';

    /**
     * Profile Image attribute constant
     * 
     * @var string
     */
    const PROFILE_IMAGE = 'profile_image';

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get Name
     *
     * @return mixed
     */
    public function getName();

    /**
     * Set Name
     *
     * @param mixed $name
     * @return AffiliatememberInterface
     */
    public function setName($name);

    /**
     * Get Status
     *
     * @return mixed
     */
    public function getStatus();

    /**
     * Set Status
     *
     * @param mixed $status
     * @return AffiliatememberInterface
     */
    public function setStatus($status);

    /**
     * Get Profile Image
     *
     * @return mixed
     */
    public function getProfileImage();

    /**
     * Set Profile Image
     *
     * @param mixed $profileImage
     * @return AffiliatememberInterface
     */
    public function setProfileImage($profileImage);

    /**
     * Get Profile Image URL
     *
     * @return string
     */
    public function getProfileImageUrl();
}
