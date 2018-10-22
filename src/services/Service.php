<?php
/**
 * GrowDough plugin for Craft CMS 3.x
 *
 * This plugin allows collecting donation designations in a Donations List that works similar to a shopping cart.
 *
 * @link      https://www.atomic74.com
 * @copyright Copyright (c) 2018 Tungsten Creative Group
 */

namespace tungsten\growdough\services;

use tungsten\growdough\GrowDough;

use Craft;
use craft\base\Component;

/**
 * @author    Tungsten Creative Group
 * @package   GrowDough
 * @since     2.0.0
 */
class Service extends Component
{
    // Public Methods
    // =========================================================================

    /*
     * @return mixed
     */
    public function exampleService()
    {
        $result = 'something';
        // Check our Plugin's settings for `someAttribute`
        if (GrowDough::$plugin->getSettings()->someAttribute) {
        }

        return $result;
    }
}
