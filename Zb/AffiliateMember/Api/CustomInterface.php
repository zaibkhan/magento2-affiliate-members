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
    public function list();
    
    /**
     * Returns greeting message to user
     *
     * @api
     * @return string result data
     */
    public function active();
}