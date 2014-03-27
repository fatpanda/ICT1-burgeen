<?php
/**
 * WiseLoop Web Grabber GoogleSearch Widget sample class definition<br/>
 * @note This widget is provided as a capabilities demonstration of the Web Grabber WordPress Plugin.<br/>
 * WiseLoop takes no responsibility if the targeted url (yahoo.com) changes its tag structure or its HTML DOM tree, resulting in unexpected data retrieval;
 * this will not be considered as malfunction or bug, and you should check the targeted url's HTML DOM tree for changes and modify this class accordingly.<br/>
 * Also, WiseLoop assumes no responsibility for any abusive use of this class and/or violation of terms of usage of the target url (yahoo.com).
 * @author WiseLoop
 */
class wlWgWidgetYahooSearch extends WP_Widget {
    public function wlWgWidgetYahooSearch() {
        $widgetOptions = array('classname' => 'wiseloop-webgrabber-yahoosearch', 'description' => 'Grab and display Yahoo Search results into your blog (based on WiseLooop Web Grabber plugin)');
        $controlOptions = array('width' => 300, 'height' => 350, 'id_base' => 'wiseloop-webgrabber-widget-yahoosearch');
        $this->WP_Widget('wiseloop-webgrabber-widget-yahoosearch', 'WiseLoop Yahoo Search', $widgetOptions, $controlOptions);
    }

    function widget($args, $instance) {
        require_once dirname(__FILE__) . "/../engine/bin/wlWg.php";
        $title = apply_filters('widget_title', $instance['title']);
        $height = trim(isset($instance['height']) ? $instance['height'] : '100%');
        $show_descriptions = isset($instance['show_descriptions']) ? $instance['show_descriptions'] : false;
        $show_page_nav = isset($instance['show_page_nav']) ? $instance['show_page_nav'] : false;
        $border = isset($instance['border']) ? $instance['border'] : false;
        $demo = isset($instance['demo']) ? $instance['demo'] : false;

        if('px' !== substr($height,-2) && 'pt' !== substr($height, -2) && '%' !== substr($height, -1))
            $height.='px';

        //get the search phrase
        $wlwg_q_yahoo = str_replace(" ", "+", wlWgUtils::getArrayValue($_POST, "wlrwg_q_yahoo", wlWgUtils::getArrayValue($_GET, "wlrwg_q_yahoo", "")));
        //get the page
        $wlwg_p_yahoo = intval(wlWgUtils::getArrayValue($_POST, "wlwg_p_yahoo", wlWgUtils::getArrayValue($_GET, "wlwg_p_yahoo", 1)));

        echo $args['before_widget'];

        if ($title)
            echo $args['before_title'] . $title . $args['after_title'];

        echo '<form action="" id="wlwg-wp-yahoo" method="POST" enctype="multipart/form-data">';
        echo '<input style="width:70%; float:left;" type="text" name="wlrwg_q_yahoo" id="wlrwg_q_yahoo" value="'.($wlwg_q_yahoo!='' ? $wlwg_q_yahoo : '').'"/>';
        echo '<input style="width:25%; float:right;" type="submit" value="Search" />';
        if($show_page_nav)
        {
            echo '<div style="width:100%;float:left;">';
            echo '<label for="wlwg_p_yahoo">Page: </label>';
            echo '<select name="wlwg_p_yahoo" id="wlwg_p_yahoo" onchange="document.forms[\'wlwg-wp-yahoo\'].submit();">';
            for($i=1; $i<10; $i++)
                echo '<option '.($wlwg_p_yahoo == $i ? 'selected' : '').' value="'.$i.'">'.$i.'</option>';
            echo '</select>';
            echo '</div>';
        }
        echo '</form>';
        if($wlwg_q_yahoo)
        {
            if($demo)
                echo '<div style="color:#ff0000; text-align:center; width:100%; float:left;">NO IFRAME BELOW! REAL HTML DISPLAYED !</div>';
            $style = 'height:'.$height.'; float:left; overflow-y: scroll; overflow-x: hidden;';
            if($border)
                $style.='border: 1px solid #acacac;';
            echo '<div style="'.$style.'">';

            $b = ($wlwg_p_yahoo - 1) * 10 + 1;

            //compute the url using the given search phrase and page
            $url = 'http://search.yahoo.com/search?p=' . $wlwg_q_yahoo . '&b=' . $b;

            //build the param
            $param = new wlWgParam('<ol start="'.$b.'" data-bns="');
            $param->addStringReplacement('<li>', '<li style="list-style-type:none;margin-bottom:3px;font-size:10px;border-bottom:1px solid #acacac;">');
            $param->addStringReplacement('<ol ', '<ol style="list-style-position:outside; list-style-type:none; margin:0; padding:0;"');
            $param->addStringReplacement('</span> - <a href', '</span><a href');
            $param->addStringReplacement('</div> - <a href', '</div><a href');
            $param->addStringReplacement('Cached', '');

            $param->addTagToRemove('<span class="url');
            $param->addTagToRemove('<span class=url');
            $param->addTagToRemove('<div class="sm-i');
            if(!$show_descriptions)
                $param->addTagToRemove('<div class="abstr">');

            //build the processor
            $wp = new wlWgProcessor(
                $url,                       //the targeted real url
                $param,                     //the parameter
                0                           //no caching needed - it's a search engine :)
            );
            $wp->draw();
            echo '</div>';
        }


        echo $args['after_widget'];
    }

    function update($new_instance, $old_instance) {
        foreach($new_instance as $key=>$value)
            $old_instance[$key] = $value;

        foreach($old_instance as $key=>$value)
            if(!isset($new_instance[$key]))
                unset($old_instance[$key]);

        $old_instance['title'] = strip_tags($new_instance['title']);

        return $old_instance;
    }

    function form($instance) {
        $show_descriptions = isset($instance['show_descriptions']) ? $instance['show_descriptions'] : false;
        $show_page_nav = isset($instance['show_page_nav']) ? $instance['show_page_nav'] : false;
        $border = isset($instance['border']) ? $instance['border'] : false;
        $demo = isset($instance['demo']) ? $instance['demo'] : false;
        echo '<p>';
        echo '<label for="'.$this->get_field_id('title').'">Title</label>';
        echo '<input id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" value="'.$instance['title'].'" class="widefat"/>';
        echo '</p>';
        echo '<p>';
        echo '<label for="'.$this->get_field_id('height').'">Height</label>';
        echo '<input id="'.$this->get_field_id('height').'" name="'.$this->get_field_name('height').'" value="'.$instance['height'].'" class="widefat"/>';
        echo '</p>';
        echo '<p>';
        echo '<input class="checkbox" type="checkbox" '.($show_descriptions ? 'checked="yes"' : '').' id="'.$this->get_field_id('show_descriptions').'" name="'.$this->get_field_name('show_descriptions').'"/>';
        echo '<label for="'.$this->get_field_id('show_descriptions').'">Show descriptions</label>';
        echo '</p>';
        echo '<p>';
        echo '<input class="checkbox" type="checkbox" '.($show_page_nav ? 'checked="yes"' : '').' id="'.$this->get_field_id('show_page_nav').'" name="'.$this->get_field_name('show_page_nav').'"/>';
        echo '<label for="'.$this->get_field_id('show_page_nav').'">Show page navigator</label>';
        echo '</p>';
        echo '<p>';
        echo '<input class="checkbox" type="checkbox" '.($border ? 'checked="yes"' : '').' id="'.$this->get_field_id('border').'" name="'.$this->get_field_name('border').'"/>';
        echo '<label for="'.$this->get_field_id('border').'">Border</label>';
        echo '</p>';       
        echo '<p>';
        echo '<input class="checkbox" type="checkbox" '.($demo ? 'checked="yes"' : '').' id="'.$this->get_field_id('demo').'" name="'.$this->get_field_name('demo').'"/>';
        echo '<label for="'.$this->get_field_id('demo').'">Demo only</label>';
        echo '</p>';
    }
}
?>
