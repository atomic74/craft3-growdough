<?php
/**
 * GrowDough plugin for Craft CMS 4.x
 *
 * This plugin allows collecting donation designations in a Donations List that works similar to a shopping cart.
 *
 * @link      https://www.atomic74.com
 * @copyright Copyright (c) 2018 Tungsten Creative Group
 */

namespace tungsten\growdough\helpers;

use Craft;
use craft\helpers\Template;
use craft\web\View;
use yii\base\Exception;

/**
 * @author    Tungsten Creative Group
 * @package   GrowDough
 * @since     2.0.0
 */
class PluginTemplate
{
    // Static Methods
    // =========================================================================

    /**
     * Render a plugin template
     *
     * @param $templatePath
     * @param $params
     *
     * @return string
     */
    public static function renderPluginTemplate(string $templatePath, array $params = [])
    {
        // Stash the old template mode, and set it to AdminCP template mode
        $oldMode = Craft::$app->view->getTemplateMode();
        try {
            Craft::$app->view->setTemplateMode(View::TEMPLATE_MODE_CP);
        } catch (Exception $e) {
            Craft::error($e->getMessage(), __METHOD__);
        }

        // Render the template with our vars passed in
        try {
            $htmlText = Craft::$app->view->renderTemplate('grow-dough/' . $templatePath, $params);
            $templateRendered = true;
        } catch (\Exception $e) {
            $htmlText = Craft::t(
                'grow-dough',
                'Error rendering `{template}` -> {error}',
                ['template' => $templatePath, 'error' => $e->getMessage()]
            );
            Craft::error($htmlText, __METHOD__);
            $templateRendered = false;
        }

        // If we couldn't find a plugin template, look for a frontend template
        if (!$templateRendered) {
            try {
                Craft::$app->view->setTemplateMode(View::TEMPLATE_MODE_SITE);
            } catch (Exception $e) {
                Craft::error($e->getMessage(), __METHOD__);
            }
            // Render the template with our vars passed in
            try {
                $htmlText = Craft::$app->view->renderTemplate($templatePath, $params);
            } catch (\Exception $e) {
                $htmlText = Craft::t(
                    'grow-dough',
                    'Error rendering `{template}` -> {error}',
                    ['template' => $templatePath, 'error' => $e->getMessage()]
                );
                Craft::error($htmlText, __METHOD__);
            }
        }

        // Restore the old template mode
        try {
            Craft::$app->view->setTemplateMode($oldMode);
        } catch (Exception $e) {
            Craft::error($e->getMessage(), __METHOD__);
        }

        return Template::raw($htmlText);
    }
}
