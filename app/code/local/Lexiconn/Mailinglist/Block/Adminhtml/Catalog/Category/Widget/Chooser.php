<?php
/**
 * @category    Lexiconn
 * @package     Lexiconn_Mailinglist Copyright (c) 2015 LexiConn Internet Services, Inc. (http://www.lexiconn.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Lexiconn_Mailinglist_Block_Adminhtml_Catalog_Category_Widget_Chooser
    extends Mage_Adminhtml_Block_Catalog_Category_Widget_Chooser
{
    /**
     * Block construction
     * Defines tree template and init tree params
     */
    public function prepareElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
   
       $uniqId = Mage::helper('core')->uniqHash($element->getId());
        
        $sourceUrl = $this->getUrl('adminhtml/mailinglist_catalog_category_widget/chooser',
                array('uniq_id' => $uniqId, 'use_massaction' => false));
        
        
        $chooser = $this->getLayout()->createBlock('widget/adminhtml_widget_chooser')
            ->setElement($element)
            ->setTranslationHelper($this->getTranslationHelper())
            ->setConfig($this->getConfig())
            ->setFieldsetId($this->getFieldsetId())
           ->setSourceUrl($sourceUrl)
            ->setUniqId($uniqId);
    
        if ($element->getValue()) {
            $categoryId = $element->getValue();
            if ($categoryId) {
                $label = Mage::getSingleton('catalog/category')->load($categoryId)->getName();
                $chooser->setLabel($label);
            }
        }
       
        $element->setData('after_element_html',
                $chooser->toHtml()
        );
        return $element;
    }
    
    public function getNodeClickListener()
    {
        
        Mage::fireLog("getNodeClickListener()", "Lexiconn_Mailinglist_Block_Adminhtml_Catalog_Category_Widget_Chooser");
        if ($this->getData('node_click_listener')) {
            return $this->getData('node_click_listener');
        }
            
        if ($this->getUseMassaction()) {
                $js = 'function (node, e) { if (node.ui.toggleCheck) { node.ui.toggleCheck(true); }}';
        } else {
                $chooserJsObject = $this->getId();
                
                Mage::fireLog($chooserJsObject, "Lexiconn_Mailinglist_Block_Adminhtml_Catalog_Category_Widget_Chooser");
                $js = 'function (node, e) {'.$chooserJsObject.'.setElementValue(node.attributes.id);'.$chooserJsObject.'.setElementLabel(node.text);'.$chooserJsObject.'.close();}';
            }
        return $js;
     }
     
     /**
      * Get JSON of a tree node or an associative array
      *
      * @param Varien_Data_Tree_Node|array $node
      * @param int $level
      * @return string
      */
     protected function _getNodeJson($node, $level = 0)
     {
        
         $item = array(	'text' =>'Root',
                 'id' => 1,
                 'store' => 0,
                 'path' =>1,
                 'cls' =>'folder no-active-category',
                 'allowDrop' =>1,
                 'allowDrag' => 1,
                 'children' => array(
                         0 => array(
                                 'text' =>'Default Category',
                                 'id' => 2,
                                 'store' => 0,
                                 'path' => '1/2',
                                 'cls' => 'folder active-category',
                                 'allowDrop' => 1,
                                 'allowDrag' => 1,
                                 'children' =>	array(
                                         0 => array(
                                                 'text' => 'Women',
                                                 'id' => 4,
                                                 'store' => 0,
                                                 'path' => '1/2/4',
                                                 'cls' => 'folder active-category',
                                                 'allowDrop' => 1,
                                                 'allowDrag' => 1,
                                                 'children' => array(),
                                                 'is_anchor' => 1,
                                                 'url_key' => 'women',
                                         ),
                                         1 => array(
                                                 'text' => 'Men',
                                                 'id' => 5,
                                                 'store' => 0,
                                                 'path' => '1/2/5',
                                                 'cls' => 'folder active-category',
                                                 'allowDrop' => 1,
                                                 'allowDrag' => 1,
                                                 'children' => array(),
                                                 'is_anchor' => 1,
                                                 'url_key' => 'men',
                                         ),
                                         	
         
                                 ),
                                 	
                                 	
                         ),
                         	
                 ),
         );
         
         return $item;
     }
      
     
     /**
      * Adds some extra params to categories collection
      *
      * @return Mage_Catalog_Model_Resource_Eav_Mysql4_Category_Collection
      */
     public function getCategoryCollection()
     {
         Mage::fireLog(parent::getCategoryCollection()->addAttributeToSelect('url_key')->addAttributeToSelect('is_anchor'), "Lexiconn_Mailinglist_Block_Adminhtml_Catalog_Category_Widget_Chooser");
         return parent::getCategoryCollection()->addAttributeToSelect('url_key')->addAttributeToSelect('is_anchor');
     }
      
}