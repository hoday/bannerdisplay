<?php
/**
 * Defines BannerView class
 *
 * PHP version 7
 *
 * @category Pear
 * @package  BannerView
 * @author   Display Name <user@example.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     http://
 */

namespace Hoday\Banners;

/**
 * View of a banner
 *
 * @category Categoy
 * @package  Package
 * @author   Display Name <user@example.com>
 * @license  http:// license
 * @link     http://
 */
class BannerView
{
    /**
     * BannerService
     *
     * @var BannerService
     */
    protected $bannerService = null;

    /**
     * Creates instance
     */
    public function __construct()
    {
        $this->bannerService = \Hoday\Banners\BannerService::getInstance();
    }

    /**
     * Prints html for displaying a banner
     *
     * @param int $bannerId id of the banner
     *
     * @return void
     */
    public function show(int $bannerId)
    {

        $isVisible = $this->bannerService->isVisible($bannerId);
        if ($isVisible) {
            $bannerPath = $this->bannerService->getPath($bannerId);

            ob_start();
            include 'templates/banner_template.php';
            echo ob_get_clean();
        }
    }

}
