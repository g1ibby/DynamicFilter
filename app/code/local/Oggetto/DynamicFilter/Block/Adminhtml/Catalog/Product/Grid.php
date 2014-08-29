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
 * Block grid products
 *
 * @category   Oggetto
 * @package    Oggetto_DynamicFilter
 * @subpackage Block
 * @author     Sergei Waribrus <svaribrus@oggettoweb.com>
 */
class Oggetto_DynamicFilter_Block_Adminhtml_Catalog_Product_Grid extends Mage_Adminhtml_Block_Catalog_Product_Grid
{
    /**
     * Prepare grid collection object
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareCollection()
    {
        $store = $this->_getStore();
        $collection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToSelect('sku')
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('attribute_set_id')
            ->addAttributeToSelect('type_id');

        if ($index = Mage::getSingleton('core/session')->getData('index_column')) {
            $collection->addAttributeToSelect($index);
        }

        if (Mage::helper('catalog')->isModuleEnabled('Mage_CatalogInventory')) {
            $collection->joinField('qty',
                'cataloginventory/stock_item',
                'qty',
                'product_id=entity_id',
                '{{table}}.stock_id=1',
                'left');
        }
        if ($store->getId()) {
            //$collection->setStoreId($store->getId());
            $adminStore = Mage_Core_Model_App::ADMIN_STORE_ID;
            $collection->addStoreFilter($store);
            $collection->joinAttribute(
                'name',
                'catalog_product/name',
                'entity_id',
                null,
                'inner',
                $adminStore
            );
            $collection->joinAttribute(
                'custom_name',
                'catalog_product/name',
                'entity_id',
                null,
                'inner',
                $store->getId()
            );
            $collection->joinAttribute(
                'status',
                'catalog_product/status',
                'entity_id',
                null,
                'inner',
                $store->getId()
            );
            $collection->joinAttribute(
                'visibility',
                'catalog_product/visibility',
                'entity_id',
                null,
                'inner',
                $store->getId()
            );
            $collection->joinAttribute(
                'price',
                'catalog_product/price',
                'entity_id',
                null,
                'left',
                $store->getId()
            );
        }
        else {
            $collection->addAttributeToSelect('price');
            $collection->joinAttribute('status', 'catalog_product/status', 'entity_id', null, 'inner');
            $collection->joinAttribute('visibility', 'catalog_product/visibility', 'entity_id', null, 'inner');
        }

        $this->setCollection($collection);

        parent::_prepareCollection();
        $this->getCollection()->addWebsiteNamesToResult();
        return $this;
    }

    /**
     * Prepare grid columns
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareColumns()
    {
        if ($filter = $this->getParam($this->getVarNameFilter(), null) == null) {
            Mage::getSingleton('core/session')->unsetData('index_column');
        }

        if ($index = Mage::getSingleton('core/session')->getData('index_column')) {
            $attribute = Mage::getResourceModel('catalog/product_attribute_collection')->addVisibleFilter()
                ->addFieldToFilter('main_table.attribute_code', $index)->getFirstItem();

            $option = [];
            foreach ($attribute->getSource()->getAllOptions() as $item) {
                if ($item['label'] == '') {
                    continue;
                }
                $option[$item['value']] = $item['label'];
            }

            $data = array(
                'header'  => Mage::helper('catalog')->__($attribute->getFrontendLabel()),
                'width'   => '100px',
                'index'   => $attribute->getAttributeCode(),
                'type'    => $attribute->getFrontendInput(),
                'options' => $option,
            );
            $this->addColumnAfter($index, $data, 'websites');
        } else {
            $this->addColumnAfter('dynamic_filter',
                array(
                    'header'=> Mage::helper('catalog')->__('Dynamic Filter'),
                    'width' => '100px',
                    'type'  => 'dynamic',
                    'index' => 'dynamic_filter',
                    'renderer'
                ), 'websites');
        }
        return parent::_prepareColumns();
    }
}