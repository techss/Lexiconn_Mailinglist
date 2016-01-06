<?php

require_once('Mage/Adminhtml/controllers/Catalog/Category/WidgetController.php');

class Lexiconn_Mailinglist_Adminhtml_Mailinglist_Catalog_Category_WidgetController
    extends Mage_Adminhtml_Catalog_Category_WidgetController
{
    
    /**
     * Categories tree node (Ajax version)
     */
    public function categoriesJsonAction()
    {
        if ($categoryId = (int) $this->getRequest()->getPost('id')) {
            Mage::fireLog($categoryId, "Lexiconn_Mailinglist_Adminhtml_Mailinglist_Catalog_Category_WidgetController");
            $category = Mage::getModel('catalog/category')->load($categoryId);
            if ($category->getId()) {
                Mage::register('category', $category);
                Mage::register('current_category', $category);
            }
            $this->getResponse()->setBody(
                    $this->_getCategoryTreeBlock()->getTreeJson($category)
            );
        }
    }
    
    protected function _getCategoryTreeBlock()
    {
        
        return $this->getLayout()->createBlock('mailinglist/adminhtml_catalog_category_widget_chooser', '', array(
            'id' => $this->getRequest()->getParam('uniq_id'),
            'use_massaction' => $this->getRequest()
            ->getParam('use_massaction', false)
        ));
        
    }
}