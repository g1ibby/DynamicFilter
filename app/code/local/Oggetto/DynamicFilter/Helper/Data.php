<?php
/**
 * Oggetto Web extension for Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade
 * the Oggetto Module module to newer versions in the future.
 * If you wish to customize the module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Oggetto
 * @package    Oggetto_Module
 * @copyright  Copyright (C) 2014 Oggetto Web ltd (http://oggettoweb.com/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
 
/**
 * Enter some description...
 *
 * @category   Oggetto
 * @package    Oggetto_Module
 * @subpackage Model
 * @author     Sergei Waribrus <svaribrus@oggettoweb.com>
 */
class Oggetto_DynamicFilter_Helper_Data extends Mage_Core_Helper_Abstract
{
    private $_exception = [
        'name',
        'custom_name',
        'status',
        'visibility',
        'price',
        'sku',
        'qty',
        'websites',
        'type',
        'attribute_set_id',
        'group_price',
        'tier_price',
        'cost'
    ];

    private $_customElements = [
        ["value" => "Created", "data" => "created_at"],
        ["value" => "Updated", "data" => "updated_at"]
    ];

    public function getCustomElements()
    {
        return $this->_customElements;
    }

    public function checkAttribute($indexes, $attributeId)
    {
        if (!in_array($attributeId, array_merge($indexes, $this->_exception))) {
            return true;
        }
        return false;
    }

    public function getColumns()
    {
        return Mage::getSingleton('core/session')->getData('columns');
    }
}