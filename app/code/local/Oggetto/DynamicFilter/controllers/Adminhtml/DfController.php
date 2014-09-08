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
 * If you wish to customize the module DynamicFilter for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Oggetto
 * @package    Oggetto_DynamicFilter
 * @copyright  Copyright (C) 2014 Oggetto Web ltd (http://oggettoweb.com/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
 
/**
 * Controller for search attributes
 *
 * @category   Oggetto
 * @package    Oggetto_DynamicFilter
 * @subpackage Controller
 * @author     Sergei Waribrus <svaribrus@oggettoweb.com>
 */
class Oggetto_DynamicFilter_Adminhtml_DfController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Search attribute
     *
     * @return void
     */
    public function searchAction()
    {
        $response = Mage::getModel('ajax/response');
        $search = $this->getRequest()->getParam('dynamic_filter');
        $attributes = Mage::getModel('oggetto_dynamicfilter/attribute')->searchCode($search);

        $response->success()->setQuery($search)
            ->setSuggestions($attributes);
        Mage::helper('ajax')->sendResponse($response);
    }

    /**
     * Choice attribute
     *
     * @return void
     */
    public function filterAction()
    {
        $response = Mage::getModel('ajax/response');

        if ($attributeId = $this->getRequest()->getPost('dynamic_filter')) {
            $indexes = Mage::helper('oggetto_dynamicfilter')->getColumns();
            if (Mage::helper('oggetto_dynamicfilter')->checkAttribute($indexes, $attributeId)) {
                if (($key = array_search($this->getRequest()->getPost('previous_value'), $indexes)) !== false) {
                    $indexes[$key] = $attributeId;
                } else {
                    $indexes[] = $attributeId;
                }
                Mage::getSingleton('core/session')->setData('columns', $indexes);
            }
        }
        $response->success();
        Mage::helper('ajax')->sendResponse($response);
        return;
    }

    /**
     * Delete column
     *
     * @return void
     */
    public function deleteAction()
    {
        $response = Mage::getModel('ajax/response');

        if ($attributeId = $this->getRequest()->getPost('dynamic_filter')) {
            $indexes = Mage::getSingleton('core/session')->getData('columns');
            Mage::getSingleton('core/session')->setData('columns', array_diff($indexes, [$attributeId]));
        }
        $response->success();
        Mage::helper('ajax')->sendResponse($response);
        return;
    }
}
