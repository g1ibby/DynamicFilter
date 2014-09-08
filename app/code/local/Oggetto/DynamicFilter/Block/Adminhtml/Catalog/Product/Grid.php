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
        $indexes = Mage::getSingleton('core/session')->getData('columns');
        $customElements = Mage::helper('oggetto_dynamicfilter')->getCustomElements();

        $last = 'websites';
        foreach ($indexes as $index) {
            $this->_addDynamicColumn($index, $customElements, $last);
            $last = $index;
        }

        $this->addColumnAfter('dynamic_filter',
            array(
                'header'   => Mage::helper('catalog')->__('Dynamic Filter'),
                'width'    => '100px',
                'renderer' => 'oggetto_dynamicfilter/adminhtml_widget_grid_column_renderer_dynamic',
                'filter'   => 'oggetto_dynamicfilter/adminhtml_widget_grid_column_filter_dynamic',
            ), $last);

        return parent::_prepareColumns();
    }

    /**
     * Set value for column
     *
     * @param $data
     * @return $this
     */
    protected function _setFilterValues($data)
    {
        foreach ($this->getColumns() as $columnId => $column) {
            if (isset($data[$columnId])
                && (!empty($data[$columnId]) || strlen($data[$columnId]) > 0)
                && $column->getFilter()
            ) {
                if ($column->getData('active')) {
                    $column->getData('nested')->getFilter()->setValue($data[$columnId]);
                }
                $column->getFilter()->setValue($data[$columnId]);
                $this->_addColumnFilterToCollection($column);
            }
        }
        return $this;
    }

    /**
     * Prepare grid
     *
     * @return $this
     */
    protected function _prepareGrid()
    {
        $this->_prepareColumns();
        $this->_prepareMassactionBlock();
        $this->_prepareCollection();
        $this->_setSort();
        return $this;
    }

    /**
     * Prepare grid collection object
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _setSort()
    {
        if ($this->getCollection()) {

            $columnId = $this->getParam($this->getVarNameSort(), $this->_defaultSort);
            $dir      = $this->getParam($this->getVarNameDir(), $this->_defaultDir);

            if (isset($this->_columns[$columnId]) && $this->_columns[$columnId]->getIndex()) {
                $dir = (strtolower($dir)=='desc') ? 'desc' : 'asc';
                if ($this->_columns[$columnId]->getData('active')) {
                    $this->_columns[$columnId]->getData('nested')->setDir($dir);
                }
            }
        }
    }

    /**
     * @param $index
     * @param $customElements
     * @param $last
     */
    protected function _addDynamicColumn($index, $customElements, $last)
    {
        if ($index == 'created_at' || $index == 'updated_at') {
            $options = [];
            $inputType = 'datetime';
            $attributeCode = $index;
            foreach ($customElements as $key => $value) {
                if (array_search($index, $value)) {
                    $frontendLabel = $value["value"];
                }
            }

        } else {
            $attribute = Mage::getModel('oggetto_dynamicfilter/attribute')->load($index);
            $options = $attribute->getSource()->getAllOptions();
            $inputType = $attribute->getFrontendInput();
            $attributeCode = $attribute->getAttributeCode();
            $frontendLabel = $attribute->getFrontendLabel();
        }

        $option = [];
        foreach ($options as $item) {
            if ($item['label'] == '') {
                continue;
            }
            $option[$item['value']] = $item['label'];
        }

        if ($inputType == 'select') {
            $inputType = 'options';
        }

        $column = $this->getLayout()->createBlock('adminhtml/widget_grid_column')
            ->setData(array(
                'header' => Mage::helper('catalog')->__($frontendLabel),
                'width' => '100px',
                'index' => $attributeCode,
                'type' => $inputType,
                'options' => $option,
            ))
            ->setGrid($this)
            ->setId($attributeCode);

        $data = array(
            'header' => Mage::helper('catalog')->__($frontendLabel),
            'width' => '100px',
            'index' => $attributeCode,
            'type' => $inputType,
            'renderer' => 'oggetto_dynamicfilter/adminhtml_widget_grid_column_renderer_dynamic',
            'filter' => 'oggetto_dynamicfilter/adminhtml_widget_grid_column_filter_dynamic',
            'options' => $option,
            'active' => true,
            'nested' => $column,
        );
        $this->addColumnAfter($index, $data, $last);
    }
}
