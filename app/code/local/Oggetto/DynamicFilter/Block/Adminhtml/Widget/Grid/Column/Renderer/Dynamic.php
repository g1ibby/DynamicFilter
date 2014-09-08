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
 * Block renderer header and row columns
 *
 * @category   Oggetto
 * @package    Oggetto_DynamicFilter
 * @subpackage Block
 * @author     Sergei Waribrus <svaribrus@oggettoweb.com>
 */

class Oggetto_DynamicFilter_Block_Adminhtml_Widget_Grid_Column_Renderer_Dynamic
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

    /**
     * Renderer header columns
     *
     * @return string
     */
    public function renderHeader()
    {
        if ($this->getColumn()->getData('active')) {
            $out  = $this->getColumn()->getData('nested')->getRenderer()->renderHeader();
            $out .= '<img class="delete-filter" src="/skin/adminhtml/default/default/images/rule_component_remove.gif" style="text-align: left; display: inline; margin-right: 7px; cursor: pointer; margin-bottom: 2px;">';
            $out .= '<img class="edit-filter" src="/skin/adminhtml/default/default/images/fam_page_white_edit.gif" style="text-align: left; display: inline; cursor: pointer;">';
        } else {
            $out = '<input name="dynamic_filter" class="attrsearch" placeholder="Dynamic filter" type="text" />';
        }
        return $out;
    }

    /**
     * Renders grid column
     *
     * @param   Varien_Object $row
     * @return  string
     */
    public function render(Varien_Object $row)
    {
        if ($this->getColumn()->getData('active')) {
            return $this->getColumn()->getData('nested')->getRenderer()->render($row);
        } else {
            return '';
        }
    }
}