<?php
/**
 * GrowDough plugin for Craft CMS 3.x
 *
 * This plugin allows collecting donation designations in a Donations List that works similar to a shopping cart.
 *
 * @link      https://www.atomic74.com
 * @copyright Copyright (c) 2018 Tungsten Creative Group
 */

namespace tungsten\growdough\controllers;

use tungsten\growdough\GrowDough;

use Craft;
use craft\web\Controller;

/**
 * @author    Tungsten Creative Group
 * @package   GrowDough
 * @since     2.0.0
 */
class DefaultController extends Controller
{

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = ['index', 'do-something'];

    // Public Methods
    // =========================================================================

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $result = 'Welcome to the DefaultController actionIndex() method';

        return $result;
    }

    /**
     * @return mixed
     */
    public function actionDoSomething()
    {
        $result = 'Welcome to the DefaultController actionDoSomething() method';

        return $result;
    }
}
