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

class Oggetto_DynamicFilter_Block_Adminhtml_Widget_Grid_Column_Renderer_Dynamic
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function renderHeader()
    {
        if (false !== $this->getColumn()->getGrid()->getSortable() && false !== $this->getColumn()->getSortable()) {
            $className = 'not-sort';
            $dir = strtolower($this->getColumn()->getDir());
            $nDir= ($dir=='asc') ? 'desc' : 'asc';
            if ($this->getColumn()->getDir()) {
                $className = 'sort-arrow-' . $dir;
            }
            $out = '<form id="formDynamicFilter", action="' . Mage::helper('adminhtml')->getUrl("admin/df/filter") . '?isAjax=1">';
            $out .= '<input name="dynamic_filter" class="' . $className . '" id="attrsearch"/>';
            $out .= '<input type="submit">';
            $out .= '</form>';
        } else {
            $out = $this->getColumn()->getHeader();
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
        $renderer = $this->getColumn()->getOptions();
        if ($renderer) {
            return $renderer->getRenderer()->render($row);
        } else {
            return '';
        }
    }
}