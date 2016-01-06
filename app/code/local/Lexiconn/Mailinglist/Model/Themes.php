<?php 

class Lexiconn_Mailinglist_Model_Themes { 
    
    

    public function toOptionArray()
    {
        $themes = array("base",
                        "black-tie",
                        "blitzer",
                        "cupertino",
                        "dark-hive",
                        "dot-luv",
                        "eggplant",
                        "excite-bike",
                        "flick",
                        "hot-sneaks",
                        "humanity",
                        "le-frog",
                        "mint-choc",
                        "overcast",
                        "pepper-grinder",
                        "redmond",
                        "smoothness",
                        "south-street",
                        "start",
                        "sunny",
                        "swanky-purse",
                        "trontastic",
                        "ui-darkness",
                        "ui-lightness",
                        "vader",
        );
        
        $base_url = 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/';
        
        $options = array();
        
        foreach($themes as $theme){
            $css_url = $base_url . $theme . "/jquery-ui.css";
            $option = array('value'=>$css_url, 'label'=>$theme);
            
            $options[] = $option;
        }
        
        return $options;
    }

}