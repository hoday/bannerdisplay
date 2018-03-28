<?php
/**
 * Defines BannerManageView class
 *
 * PHP version 7
 *
 * @category Pear
 * @package  BannerManageView
 * @author   Display Name <user@example.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     http://
 */

namespace Hoday\Banners;

/**
 * View that allows users to manage banners
 *
 * @category Categoy
 * @package  Package
 * @author   Display Name <user@example.com>
 * @license  http:// license
 * @link     http://
 */
class BannerManageView
{
    /**
     * Format for printing date strings
     *
     * @var string
     */
    const FORMAT_STRING = 'Y-m-d H:i:s';

    /**
     * Creates BannerManageView instance
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Prints the html for the banner mnager view
     *
     * @return void
     */
    public static function show(): void
    {

        $banners = \Hoday\Banners\BannerService::getInstance()->getAll();
        $formatString = self::FORMAT_STRING;
        ob_start();
        include 'templates/banners_template.php';
        echo ob_get_clean();
    }

}
