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
 * Block column
 *
 * @category   Oggetto
 * @package    Oggetto_DynamicFilter
 * @subpackage Block
 * @author     Sergei Waribrus <svaribrus@oggettoweb.com>
 */

class Oggetto_DynamicFilter_Block_Adminhtml_Widget_Grid_Column extends Mage_Adminhtml_Block_Widget_Grid_Column
{
    /**
     * Returned name block for type
     *
     * @return string
     */
    protected function _getRendererByType()
    {
        $type = strtolower($this->getType());
        $renderers = $this->getGrid()->getColumnRenderers();

        if (is_array($renderers) && isset($renderers[$type])) {
            return $renderers[$type];
        }

        switch ($type) {
            case 'date':
                $rendererClass = 'adminhtml/widget_grid_column_renderer_date';
                break;
            case 'datetime':
                $rendererClass = 'adminhtml/widget_grid_column_renderer_datetime';
                break;
            case 'number':
                $rendererClass = 'adminhtml/widget_grid_column_renderer_number';
                break;
            case 'currency':
                $rendererClass = 'adminhtml/widget_grid_column_renderer_currency';
                break;
            case 'price':
                $rendererClass = 'adminhtml/widget_grid_column_renderer_price';
                break;
            case 'country':
                $rendererClass = 'adminhtml/widget_grid_column_renderer_country';
                break;
            case 'concat':
                $rendererClass = 'adminhtml/widget_grid_column_renderer_concat';
                break;
            case 'action':
                $rendererClass = 'adminhtml/widget_grid_column_renderer_action';
                break;
            case 'options':
                $rendererClass = 'adminhtml/widget_grid_column_renderer_options';
                break;
            case 'checkbox':
                $rendererClass = 'adminhtml/widget_grid_column_renderer_checkbox';
                break;
            case 'massaction':
                $rendererClass = 'adminhtml/widget_grid_column_renderer_massaction';
                break;
            case 'radio':
                $rendererClass = 'adminhtml/widget_grid_column_renderer_radio';
                break;
            case 'input':
                $rendererClass = 'adminhtml/widget_grid_column_renderer_input';
                break;
            case 'select':
                $rendererClass = 'adminhtml/widget_grid_column_renderer_options';
                break;
            case 'text':
                $rendererClass = 'adminhtml/widget_grid_column_renderer_longtext';
                break;
            case 'store':
                $rendererClass = 'adminhtml/widget_grid_column_renderer_store';
                break;
            case 'wrapline':
                $rendererClass = 'adminhtml/widget_grid_column_renderer_wrapline';
                break;
            case 'theme':
                $rendererClass = 'adminhtml/widget_grid_column_renderer_theme';
                break;
            case 'dynamic':
                $rendererClass = 'oggetto_dynamicfilter/adminhtml_widget_grid_column_renderer_dynamic';
                break;
            default:
                $rendererClass = 'adminhtml/widget_grid_column_renderer_text';
                break;
        }
        return $rendererClass;
    }

    /**
     * Returned name block filter for type
     *
     * @return string
     */
    protected function _getFilterByType()
    {
        $type = strtolower($this->getType());
        $filters = $this->getGrid()->getColumnFilters();
        if (is_array($filters) && isset($filters[$type])) {
            return $filters[$type];
        }

        switch ($type) {
            case 'datetime':
                $filterClass = 'adminhtml/widget_grid_column_filter_datetime';
                break;
            case 'date':
                $filterClass = 'adminhtml/widget_grid_column_filter_date';
                break;
            case 'range':
            case 'number':
            case 'currency':
                $filterClass = 'adminhtml/widget_grid_column_filter_range';
                break;
            case 'price':
                $filterClass = 'adminhtml/widget_grid_column_filter_price';
                break;
            case 'country':
                $filterClass = 'adminhtml/widget_grid_column_filter_country';
                break;
            case 'select':
            case 'options':
                $filterClass = 'adminhtml/widget_grid_column_filter_select';
                break;

            case 'massaction':
                $filterClass = 'adminhtml/widget_grid_column_filter_massaction';
                break;

            case 'checkbox':
                $filterClass = 'adminhtml/widget_grid_column_filter_checkbox';
                break;

            case 'radio':
                $filterClass = 'adminhtml/widget_grid_column_filter_radio';
                break;
            case 'store':
                $filterClass = 'adminhtml/widget_grid_column_filter_store';
                break;
            case 'theme':
                $filterClass = 'adminhtml/widget_grid_column_filter_theme';
                break;
            case 'dynamic':
                $filterClass = 'oggetto_dynamicfilter/adminhtml_widget_grid_column_filter_dynamic';
                break;
            default:
                $filterClass = 'adminhtml/widget_grid_column_filter_text';
                break;
        }
        return $filterClass;
    }
}