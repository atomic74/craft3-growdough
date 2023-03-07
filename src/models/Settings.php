<?php
/**
 * GrowDough plugin for Craft CMS 4.x
 *
 * This plugin allows collecting donation designations in a Donations List that works similar to a shopping cart.
 *
 * @link      https://www.atomic74.com
 * @copyright Copyright (c) 2018 Tungsten Creative Group
 */

namespace tungsten\growdough\models;

use craft\base\Model;

/**
 * @author    Tungsten Creative Group
 * @package   GrowDough
 * @since     2.0.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $donationsUrl;

    /**
     * @var bool
     */
    public $testModeEnabled = true;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            ['donationsUrl', 'string'],
            ['donationsUrl', 'default', 'value' => 'Some Default'],
        ];
    }
}
