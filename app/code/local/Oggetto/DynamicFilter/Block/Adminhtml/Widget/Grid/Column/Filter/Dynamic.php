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
 * Renderer column
 *
 * @category   Oggetto
 * @package    Oggetto_DynamicFilter
 * @subpackage Block
 * @author     Sergei Waribrus <svaribrus@oggettoweb.com>
 */

class Oggetto_DynamicFilter_Block_Adminhtml_Widget_Grid_Column_Filter_Dynamic
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Filter_Abstract
{

    /**
     * Retrieve filter html
     *
     * @return string
     */
    public function getHtml()
    {
        if ($this->getColumn()->getData('active')) {
            $out = $this->getColumn()->getData('nested')->getFilter()->getHtml();
        } else {
            $out = '';
        }
        return $out;
    }
}