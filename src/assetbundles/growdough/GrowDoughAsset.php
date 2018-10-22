<?php
/**
 * GrowDough plugin for Craft CMS 3.x
 *
 * This plugin allows collecting donation designations in a Donations List that works similar to a shopping cart.
 *
 * @link      https://www.atomic74.com
 * @copyright Copyright (c) 2018 Tungsten Creative Group
 */

namespace tungsten\growdough\assetbundles\GrowDough;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    Tungsten Creative Group
 * @package   GrowDough
 * @since     2.0.0
 */
class GrowDoughAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@tungsten/growdough/assetbundles/growdough/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'js/GrowDough.js',
        ];

        $this->css = [
            'css/GrowDough.css',
        ];

        parent::init();
    }
}
