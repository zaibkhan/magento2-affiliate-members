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

class UploaderPool
{
    /**
     * Available Uploaders
     * 
     * @var array
     */
    protected $uploaders = [];

    /**
     * constructor
     * 
     * @param array $uploaders
     */
    public function __construct(
        array $uploaders = []
    ) {
        $this->uploaders = $uploaders;
    }

    /**
     * @param string $type
     * @return \Zb\AffiliateMember\Model\Uploader
     * @throws \Exception
     */
    public function getUploader($type)
    {
        if (!isset($this->uploaders[$type])) {
            throw new \Exception("Uploader not found for type: ".$type);
        }
        $uploader = $this->uploaders[$type];
        if (!($uploader instanceof \Zb\AffiliateMember\Model\Uploader)) {
            throw new \Exception("Uploader for type {$type} not instance of ". \Zb\AffiliateMember\Model\Uploader::class);
        }
        return $uploader;
    }
}
