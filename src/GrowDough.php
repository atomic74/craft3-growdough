<?php
/**
 * GrowDough plugin for Craft CMS 3.x
 *
 * This plugin allows collecting donation designations in a Donations List that works similar to a shopping cart.
 *
 * @link      https://www.atomic74.com
 * @copyright Copyright (c) 2018 Tungsten Creative Group
 */

namespace tungsten\growdough;

use tungsten\growdough\services\Service;
use tungsten\growdough\variables\GrowDoughVariable;
use tungsten\growdough\models\Settings;

use Craft;
use craft\base\Plugin;
use craft\web\UrlManager;
use craft\web\twig\variables\CraftVariable;
use craft\events\RegisterUrlRulesEvent;

use yii\base\Event;

/**
 * Class GrowDough
 *
 * @author    Tungsten Creative Group
 * @package   GrowDough
 * @since     2.0.0
 *
 * @property  Service $service
 */
class GrowDough extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var GrowDough
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '2.0.0';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_SITE_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                $event->rules['grow-dough/remove-donation-item'] = 'grow-dough/default/remove-donation-item';
                $event->rules['grow-dough/remove-all-donation-items'] = 'grow-dough/default/remove-all-donation-items';
            }
        );

        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('growDough', GrowDoughVariable::class);
            }
        );

        Craft::info(
            Craft::t(
                'grow-dough',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }

    /**
     * @inheritdoc
     */
    protected function settingsHtml(): string
    {
        return Craft::$app->view->renderTemplate(
            'grow-dough/settings',
            [
                'settings' => $this->getSettings()
            ]
        );
    }
}
