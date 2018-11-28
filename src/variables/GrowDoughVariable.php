<?php
/**
 * GrowDough plugin for Craft CMS 3.x
 *
 * This plugin allows collecting donation designations in a Donations List that works similar to a shopping cart.
 *
 * @link      https://www.atomic74.com
 * @copyright Copyright (c) 2018 Tungsten Creative Group
 */

namespace tungsten\growdough\variables;

use tungsten\growdough\GrowDough;
use tungsten\growdough\helpers\PluginTemplate as PluginTemplateHelper;

/**
 * @author    Tungsten Creative Group
 * @package   GrowDough
 * @since     2.0.0
 */
class GrowDoughVariable
{
    // Public Methods
    // =========================================================================

    /**
     * Provide the donation items to a template
     *
     * @return array|false The donation items or false if none exist
     */
    public function getDonationItems()
    {
        $donationItems = GrowDough::$plugin->service->getDonationItems();
        if (count($donationItems) > 0) {
            return $donationItems;
        }

        return false;
    }

    /**
     * Check if the donation item with the provided id is already in the list of donation items.
     *
     * @param string Id that uniquely identifies the donation item in the list of donation items.
     * @return bool True if the donation item with the id is already in the list, false otherwise.
     **/
    public function donationItemInList($itemId): bool
    {
        $donationItems = GrowDough::$plugin->service->getDonationItems();
        return array_key_exists($itemId, $donationItems);
    }

    /**
     * Opening form tag to add a donation item to the donation items list.
     *
     * @param string $itemId Unique id for the donation item
     * @param string $itemTitle Donation item title that is used for display
     * @param array $itemAttributes Donation item attributes that will be stored as JSON
     *
     * {{ craft.growDough.addDonationItemFormTag(
     *   fund.id,
     *   fund.title,
     *   {
     *     'Attribute Key': 'Attribute Value',
     *     'Attribute Key': 'Attribute Value',
     *     'Attribute Key': fund.title
     *   }
     * )}}
     *
     * @return string Opening form tag with hidden fields.
     **/
    public function addDonationItemFormTag($itemId, $itemTitle, $itemAttributes = [])
    {
        return PluginTemplateHelper::renderPluginTemplate(
            '_components/variables/addDonationItemFormTag',
            [
                'itemId'         => $itemId,
                'itemTitle'      => $itemTitle,
                'itemAttributes' => json_encode($itemAttributes)
            ]
        );
    }

    /**
     * Opening form tag to submit donation to GrowDough. Includes the GrowDough post URL and hidden fields.
     *
     * @param array $options Array structure with optional values for hidden form tags
     *
     * {{ craft.growDough.formTag({
     *   'templateVariables': {
     *     'Variable Key': 'Variable Value',
     *     'Variable Key': 'Variable Value',
     *     ...
     *   },
     *   'donationItems': [
     *     {
     *      "title": "Item title",
     *      "attributes": {
     *        "Attribute Key": "Attribute Value",
     *        "Attribute Key": "Attribute Value",
     *        ...
     *      }
     *    },
     *    {
     *      "title": "Item title",
     *      "attributes": {
     *        "Attribute Key": "Attribute Value",
     *        "Attribute Key": "Attribute Value",
     *        ...
     *      }
     *    }
     *   ],
     *   'paymentMethod': 'credit_card|giving_card'
     * }) }}
     *
     * @return string Opening form tag with hidden fields.
     **/
    public function formTag($options = [])
    {
        if (!array_key_exists('templateVariables', $options) || !$options['templateVariables']) {
            $options['templateVariables'] = array();
        }

        if (!array_key_exists('donationItems', $options) || !$options['donationItems']) {
            $donationItems = $this->getDonationItemsJson();
        } else {
            $donationItems = json_encode($options['donationItems']);
        }

        if (!array_key_exists('paymentMethod', $options) || !$options['paymentMethod']) {
            $paymentMethod = '';
        }
        else {
            $paymentMethod = $options['paymentMethod'];
        }

        return PluginTemplateHelper::renderPluginTemplate(
            '_components/variables/formTag',
            [
                'donationsUrl' => $this->donationsUrl(),
                'testModeEnabled' => $this->testModeEnabled(),
                'paymentMethod' => $paymentMethod,
                'templateVariables' => json_encode($options['templateVariables']),
                'donationItems' => $donationItems,
            ]
        );
    }

    /**
     * Retrieve the GrowDough donation URL and provide to a template.
     *
     * @return string The GrowDough donation URL stored in plugin settings.
     **/
    public function donationsUrl(): string
    {
        return GrowDough::$plugin->getSettings()->donationsUrl;
    }

    /**
     * Retrieve the GrowDough Giving Card purchase URL and provide to a template.
     *
     * @return string The GrowDough Giving Card purchase URL.
     **/
    public function givingCardPurchaseUrl(): string
    {
        return str_replace('donate', 'giving_cards', $this->donationsUrl());
    }

    /**
     * Format the donation items as JSON.
     *
     *  [
     *    {
     *      "title": "Item title",
     *      "attributes": {
     *        "Attribute Key": "Attribute Value",
     *        "Attribute Key": "Attribute Value",
     *        ...
     *      }
     *    },
     *    {
     *      "title": "Item title",
     *      "attributes": {
     *        "Attribute Key": "Attribute Value",
     *        "Attribute Key": "Attribute Value",
     *        ...
     *      }
     *    }
     *  ]
     *
     * @return string JSON formatted donation items.
     **/
    public function getDonationItemsJson(): string
    {
        $donationItems = GrowDough::$plugin->service->getDonationItems();
        if (count($donationItems) > 0) {
            $donationItemsArray = [];
            foreach ($donationItems as $donationItem) {
                $donationItemsArray[] = $donationItem;
            }
            $donationItems = $donationItemsArray;
        }
        return json_encode($donationItems);
    }

    /**
     * Retrieve whether the GrowDough Test Mode setting is enabled.
     *
     * @return boolean True if Test Mode is enabled
     **/
    private function testModeEnabled(): bool
    {
        $testModeEnabled = GrowDough::$plugin->getSettings()->testModeEnabled;
        return $testModeEnabled == '1';
    }
}
