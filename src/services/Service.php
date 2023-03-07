<?php
/**
 * GrowDough plugin for Craft CMS 4.x
 *
 * This plugin allows collecting donation designations in a Donations List that works similar to a shopping cart.
 *
 * @link      https://www.atomic74.com
 * @copyright Copyright (c) 2018 Tungsten Creative Group
 */

namespace tungsten\growdough\services;

use craft\base\Component;

/**
 * @author    Tungsten Creative Group
 * @package   GrowDough
 * @since     2.0.0
 *
 * @property array $donationItems
 */
class Service extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * Get the full list of donation items
     *
     * @return array
     */
    public function getDonationItems(): array
    {
        return \Craft::$app->session->get('growDoughItems', []);
    }

    /**
     * Add donation item to the growDoughItems session variable
     *
     * If the item already exists in the array, it will not be added again
     *
     * @param integer $itemId Donation item id
     * @param string $itemTitle Donation item title
     * @param string $itemAttributes Donation item attributes in JSON format
     */
    public function addDonationItem(int $itemId, string $itemTitle, string $itemAttributes)
    {
        $donationItems = $this->getDonationItems();
        if (array_key_exists($itemId, $donationItems) === false) {
            $donationItems[$itemId]['title'] = $itemTitle;
            $donationItems[$itemId]['attributes'] = json_decode($itemAttributes);
        }
        \Craft::$app->session->set('growDoughItems', $donationItems);
    }

    /**
     * Remove donation item from the growDoughItems session variable
     * @param int $itemId Donation item id
     */
    public function removeDonationItem(int $itemId)
    {
        $donationItems = $this->getDonationItems();
        if (array_key_exists($itemId, $donationItems) === true) {
            unset($donationItems[$itemId]);
        }
        \Craft::$app->session->set('growDoughItems', $donationItems);
    }

    /**
     * Remove all donation items from the session variable by removing the session variable itself
     *
     * @return int The number of deleted items
     */
    public function removeAllDonationItems(): int
    {
        $donationItems = $this->getDonationItems();
        $donationItemsCount = count($donationItems);
        \Craft::$app->session->remove('growDoughItems');

        return $donationItemsCount;
    }
}
