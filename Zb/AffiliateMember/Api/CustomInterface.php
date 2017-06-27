<?php
namespace Zb\AffiliateMember\Api;

interface CustomInterface
{
    /**
     * Returns greeting message to user
     *
     * @api
     * @return string result data
     */
    public function showall();
    
    /**
     * Returns greeting message to user
     *
     * @api
     * @return string result data
     */
    public function active();
}
