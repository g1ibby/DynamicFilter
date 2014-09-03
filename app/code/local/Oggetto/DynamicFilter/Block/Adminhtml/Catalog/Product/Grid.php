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
     * Prepare grid columns
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareColumns()
    {
        if ($filter = $this->getParam($this->getVarNameFilter(), null) == null) {
            Mage::getSingleton('core/session')->unsetData('columns');
        }

        $indexes = Mage::getSingleton('core/session')->getData('columns');

        foreach ($indexes as $index) {
            $attribute = Mage::getResourceModel('catalog/product_attribute_collection')->addVisibleFilter()
                ->addFieldToFilter('main_table.attribute_code', $index)->getFirstItem();

            $option = [];
            foreach ($attribute->getSource()->getAllOptions() as $item) {
                if ($item['label'] == '') {
                    continue;
                }
                $option[$item['value']] = $item['label'];
            }

            $column = $this->getLayout()->createBlock('adminhtml/widget_grid_column')
                ->setData(array(
                    'header'  => Mage::helper('catalog')->__($attribute->getFrontendLabel()),
                    'width'   => '100px',
                    'index'   => $attribute->getAttributeCode(),
                    'type'    => $attribute->getFrontendInput(),
                    'options' => $option,
                ))
                ->setGrid($this);
            $column->setId($attribute->getAttributeCode());

            $data = array(
                'header'   => Mage::helper('catalog')->__($attribute->getFrontendLabel()),
                'width'    => '100px',
                'index'    => $attribute->getAttributeCode(),
                'type'     => $attribute->getFrontendInput(),
                'renderer' => 'oggetto_dynamicfilter/adminhtml_widget_grid_column_renderer_dynamic',
                'filter'   => 'oggetto_dynamicfilter/adminhtml_widget_grid_column_filter_dynamic',
                'options'  => $option,
                'active'   => true,
                'nested'   => $column,
            );
            $this->addColumnAfter($index, $data, 'websites');
        }

        $this->addColumnAfter('dynamic_filter',
            array(
                'header'   => Mage::helper('catalog')->__('Dynamic Filter'),
                'width'    => '100px',
                'renderer' => 'oggetto_dynamicfilter/adminhtml_widget_grid_column_renderer_dynamic',
                'filter'   => 'oggetto_dynamicfilter/adminhtml_widget_grid_column_filter_dynamic',
            ), 'websites');


//            $data = array(
//                'header'           => Mage::helper('catalog')->__($attribute->getFrontendLabel()),
//                'width'            => '100px',
//                'index'            => $attribute->getAttributeCode(),
//                'type'             => $attribute->getFrontendInput(),
//                'options'          => $option,
//                'column_css_class' => 'dynamic-column',
//            );
//            $this->addColumnAfter($index, $data, 'websites');

        return parent::_prepareColumns();
    }
}