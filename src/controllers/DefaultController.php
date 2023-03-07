<?php
/**
 * GrowDough plugin for Craft CMS 4.x
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

use yii\web\BadRequestHttpException;
use yii\web\Response;

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
    protected $allowAnonymous = true;

    // Public Methods
    // =========================================================================

    /**
     * Handle a request to add new donation item
     *
     * e.g.: actions/growdough/default/add-donation-item
     *
     * @return null|Response
     * @throws \yii\web\BadRequestHttpException
     */
    public function actionAddDonationItem()
    {
        $this->requirePostRequest();
        $request = Craft::$app->getRequest();

        $itemId = $request->getRequiredBodyParam('itemId');
        $itemTitle = $request->getRequiredBodyParam('itemTitle');
        $itemAttributes = $request->getRequiredBodyParam('itemAttributes');

        GrowDough::$plugin->service->addDonationItem($itemId, $itemTitle, $itemAttributes);

        return $this->redirectToPostedUrl();
    }

    /**
     * Handle a request to remove donation item
     *
     * e.g.: actions/growdough/default/remove-donation-item
     *
     * @return null|Response
     * @throws \yii\web\BadRequestHttpException
     */
    public function actionRemoveDonationItem()
    {
        $itemId = Craft::$app->request->getRequiredParam('itemId');

        GrowDough::$plugin->service->removeDonationItem($itemId);

        $redirectUrl = Craft::$app->request->getParam('redirectUrl');

        if ($redirectUrl) {
            return $this->redirect($redirectUrl);
        }

        return $this->redirect(Craft::$app->request->getReferrer());
    }

    /**
     * Handle a request to remove all donation items
     *
     * Expects an AJAX request
     *
     * e.g:
     *
     * $.get('/actions/growdough/default/remove-all-donation-items', { deleteAll: true }, function(response) {
     *   console.log('Deleted ' + response.item_count + ' donation items.');
     * });
     *
     * @return null|Response
     * @throws BadRequestHttpException
     */
    public function actionRemoveAllDonationItems()
    {
        if (!Craft::$app->request->isAjax) {
            throw new BadRequestHttpException('Expecting an Ajax request');
        }

        $removeDonationsItemsCount = GrowDough::$plugin->service->removeAllDonationItems();

        return $this->asJson([
            'item_count' => $removeDonationsItemsCount
        ]);
    }
}
