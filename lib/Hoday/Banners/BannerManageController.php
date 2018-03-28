<?php
/**
 * Defines BannerManageController class
 *
 * PHP version 7
 *
 * @category Pear
 * @package  BannerManageController
 * @author   Display Name <user@example.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     http://
 */

namespace Hoday\Banners;

/**
 * Controller for banner manager
 *
 * @category Categoy
 * @package  Package
 * @author   Display Name <user@example.com>
 * @license  http:// license
 * @link     http://
 */
class BannerManageController
{

    /**
     * Creates instance
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Does action
     *
     * @return void
     */
    public function do()
    {

        $ip = $_GET['ip'];
        $id = $_GET['id'];

        $banners = \Hoday\Banners\BannerService::registerIp($id, $ip);
    }

}
