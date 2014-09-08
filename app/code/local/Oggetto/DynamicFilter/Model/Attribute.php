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
 * the Oggetto DynamicFilter module to newer versions in the future.
 * If you wish to customize the DynamicFilter for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Oggetto
 * @package    Oggetto_DynamicFilter
 * @copyright  Copyright (C) 2014 Oggetto Web ltd (http://oggettoweb.com/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
 
/**
 * Decorator resource model attribute
 *
 * @category   Oggetto
 * @package    Oggetto_DynamicFilter
 * @subpackage Model
 * @author     Sergei Waribrus <svaribrus@oggettoweb.com>
 */
class Oggetto_DynamicFilter_Model_Attribute
{
    /**
     * Load attribute witch help code
     *
     * @param $code
     * @return mixed
     */
    public function load($code)
    {
        $attribute = Mage::getResourceModel('catalog/product_attribute_collection')->addVisibleFilter()
            ->addFieldToFilter('main_table.attribute_code', $code)->getFirstItem();
        return $attribute;
    }

    /**
     * Search code
     *
     * @param $search
     * @return mixed
     */
    public function searchCode($search)
    {
        $customElements = Mage::helper('oggetto_dynamicfilter')->getCustomElements();

        $attributes = Mage::getResourceModel('catalog/product_attribute_collection')->addVisibleFilter()
            ->addFieldToFilter('main_table.frontend_label', array('like' => "%$search%"));

        $codes = $attributes->getColumnValues('attribute_code');
        $values = $attributes->getColumnValues('frontend_label');

        $indexes = Mage::helper('oggetto_dynamicfilter')->getColumns();

        $adedElements = [];
        foreach ($customElements as $element) {
            if (strripos($element["value"], $search) !== false &&
                Mage::helper('oggetto_dynamicfilter')->checkAttribute($indexes, $element["data"])) {
                $adedElements[] = $element;
            }
        }

        $attribData = [];
        foreach ($codes as $index => $code) {
            if (Mage::helper('oggetto_dynamicfilter')->checkAttribute($indexes, $code)) {
                $attribData[] = ["value" => $values[$index], "data" => $code];
            }
        }

        return array_merge($attribData, $adedElements);
    }
}
