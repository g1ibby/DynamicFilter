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
class Oggetto_DynamicFilter_Adminhtml_DfController extends Mage_Adminhtml_Controller_Action
{
    public function searchAction()
    {
        $search = $this->getRequest()->getPost('search');
        $attrib_data = array();
        $attributes = Mage::getResourceModel('catalog/product_attribute_collection')->addVisibleFilter()
            ->addFieldToFilter('main_table.attribute_code', array('like' => "%$search%"))->getItems();

        foreach ($attributes as $attribute) {
            $attrib_data[$attribute->getAttributeCode()] = $attribute->getData();
        }
        var_dump($attrib_data);
        die;

    }

    public function filterAction()
    {
        $response = Mage::getModel('ajax/response');

        $attributeId = $this->getRequest()->getPost('dynamic_filter');
        if (!$attributeId) {
            Mage::getSingleton('core/session')->unsetData('column');
            $response->success()->setContent('Filter1');
            Mage::helper('ajax')->sendResponse($response);
            return;
        }


        $attribute = Mage::getResourceModel('catalog/product_attribute_collection')->addVisibleFilter()
            ->addFieldToFilter('main_table.attribute_code', $attributeId)->getFirstItem();

        $option = [];
        foreach ($attribute->getSource()->getAllOptions() as $item) {
            $option[$item['value']] = $item['label'];
        }


        $type = $attribute->getFrontendInput();

        $grid = $this->getLayout()->createBlock('adminhtml/catalog_product_grid');
        $data = array(
            'header'  => Mage::helper('catalog')->__($attribute->getFrontendLabel()),
            'width'   => '70px',
            'index'   => $attribute->getAttributeCode(),
            'type'    => $type,
            'options' => $option,
        );
        $column = $this->getLayout()->createBlock('adminhtml/widget_grid_column')
            ->setData($data)
            ->setGrid($grid);
        $column->setId($attribute->getAttributeCode());

        $response->success()->setContent($column->getFilterHtml());

        Mage::getSingleton('core/session')->setData('column', $data);

        Mage::helper('ajax')->sendResponse($response);
    }
}