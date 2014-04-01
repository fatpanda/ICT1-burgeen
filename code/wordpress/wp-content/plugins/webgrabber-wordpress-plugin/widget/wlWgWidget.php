<?php
/**
 * WiseLoop Web Grabber Widget class definition<br/>
 * @author WiseLoop
 */
class wlWgWidget extends WP_Widget {
    private $_counterRemoveTags;
    private $_counterStripTags;
    private $_counterStringReplacements;

    public function wlWgWidget() {
        $this->_counterRemoveTags = 0;
        $this->_counterStripTags = 0;
        $this->_counterStringReplacements = 0;
        $widgetOptions = array('classname' => 'wiseloop-webgrabber', 'description' => 'Grab any web content and display it in within your site');
        $controlOptions = array('width' => 500, 'height' => 350, 'id_base' => 'wiseloop-webgrabber-widget');
        $this->WP_Widget('wiseloop-webgrabber-widget', 'WiseLoop Web Grabber', $widgetOptions, $controlOptions);
    }

    function widget($args, $instance) {
        $title = apply_filters('widget_title', $instance['title']);
        echo $args['before_widget'];

        if ($title)
            echo $args['before_title'] . $title . $args['after_title'];
        echo wlWgPluginEngine::runEngineArray($instance);
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
        require_once dirname(__FILE__) . "/../engine/bin/wlWg.php";
        $defaults = array(
            'title' => '',
            'url' => 'http://',
            'tag' => '<body',
            'cache' => '1440',
        );
        $instance = wp_parse_args((array)$instance, $defaults);
        ?>
        <div class="widget" style="width:95%;">
            <div class="widget-top" style="cursor:default;">
                <div class="widget-title-action"><a class="widget-action hide-if-no-js" style="cursor:pointer;"></a></div>
                <div class="widget-title"><h4>General settings</h4></div>
            </div>
            <div class="widget-inside" style="display: block;">
                <p>
                    <label for="<?php echo $this->get_field_id('title'); ?>">Title</label>
                    <input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" class="widefat"/>
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('url'); ?>">Url to parse</label>
                    <input id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name('url'); ?>" value="<?php echo $instance['url']; ?>" class="widefat"/>
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('tag'); ?>">Tag to extract</label>
                    <input id="<?php echo $this->get_field_id('tag'); ?>" name="<?php echo $this->get_field_name('tag'); ?>" value="<?php echo htmlentities($instance['tag']); ?>" class="widefat"/>
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('cache'); ?>">Cache time</label>
                    <select id="<?php echo $this->get_field_id('cache'); ?>" name="<?php echo $this->get_field_name('cache'); ?>" class="widefat">
                        <option value="<?php echo wlWgConfig::DEFAULT_CACHE_TIME;?>" <?php if (wlWgConfig::DEFAULT_CACHE_TIME == $instance['cache']) echo 'selected="selected"'; ?>>Default</option>
                        <option value="<?php echo wlWgConfig::CACHE_TIME_1_DAY;?>" <?php if (wlWgConfig::CACHE_TIME_1_DAY == $instance['cache']) echo 'selected="selected"'; ?>>1 Day</option>
                        <option value="<?php echo wlWgConfig::CACHE_TIME_1_WEEK;?>" <?php if (wlWgConfig::CACHE_TIME_1_WEEK == $instance['cache']) echo 'selected="selected"'; ?>>1 Week</option>
                        <option value="<?php echo wlWgConfig::CACHE_TIME_1_MONTH;?>" <?php if (wlWgConfig::CACHE_TIME_1_MONTH == $instance['cache']) echo 'selected="selected"'; ?>>1 Month</option>
                        <option value="<?php echo wlWgConfig::CACHE_TIME_1_YEAR;?>" <?php if (wlWgConfig::CACHE_TIME_1_YEAR == $instance['cache']) echo 'selected="selected"'; ?>>1 Year</option>
                    </select>
                </p>
            </div>
        </div>

        <div class="widget" style="width:95%;">
            <div class="widget-top" style="cursor:default;">
                <div class="widget-title-action"><a class="widget-action hide-if-no-js" style="cursor:pointer;"></a></div>
                <div class="widget-title"><h4>Remove tags</h4></div>
            </div>
            <div class="widget-inside" style="display: none;">
                <p>
                    <input type="button" value="Add" style="display:block;" onclick='
                        var e_id = new String("<?php echo $this->get_field_id('rtag#');?>");
                        var e_name = new String("<?php echo $this->get_field_name('rtag#');?>");
                        e_id = e_id.replace("#", wlgw_counterRemoveTags, "g");
                        e_name = e_name.replace("#", wlgw_counterRemoveTags, "g");
                        var e = document.createElement("input");
                        e.setAttribute("type", "text");
                        e.setAttribute("class", "widefat");
                        e.setAttribute("style", "width:80%;float:left;");
                        e.setAttribute("id", e_id);
                        e.setAttribute("name", e_name);
                        e.setAttribute("value", "");
                        var b = document.createElement("input");
                        b.setAttribute("type", "button");
                        b.setAttribute("value", "x");
                        b.setAttribute("style", "float:right;");
                        b.setAttribute("onclick", "this.parentNode.removeChild(document.getElementById(\""+e_id+"\"));this.parentNode.removeChild(this);");
                        this.parentNode.appendChild(e);
                        this.parentNode.appendChild(b);
                        wlgw_counterRemoveTags++;
                    '/>
            <?php
            foreach($instance as $key=>$value)
                if('rtag' == substr($key, 0, strlen('rtag')))
                {
                    $rtag_id = $this->get_field_id('rtag'.$this->_counterRemoveTags);
                    $rtag_name = $this->get_field_name('rtag'.$this->_counterRemoveTags);
                    $this->_counterRemoveTags++;
            ?>
                    <input type="text" id="<?php echo $rtag_id;?>" name="<?php echo $rtag_name;?>" value="<?php echo htmlentities($value);?>" class="widefat" style="width:80%;float:left;"/>
                    <input type="button" value="x" style="float:right;" onclick='
                        this.parentNode.removeChild(document.getElementById("<?php echo $rtag_id;?>"));
                        this.parentNode.removeChild(this);
                    '/>
            <?php
                }
            ?>
                    <script type="text/javascript">var wlgw_counterRemoveTags=<?php echo $this->_counterRemoveTags;?></script>
                </p>
            </div>
        </div>

        <div class="widget" style="width:95%;">
            <div class="widget-top" style="cursor:default;">
                <div class="widget-title-action"><a class="widget-action hide-if-no-js" style="cursor:pointer;"></a></div>
                <div class="widget-title"><h4>Strip tags</h4></div>
            </div>
            <div class="widget-inside" style="display: none;">
                <p>
                    <input type="button" value="Add" style="display:block;" onclick='
                        var e_id = new String("<?php echo $this->get_field_id('stag#');?>");
                        var e_name = new String("<?php echo $this->get_field_name('stag#');?>");
                        e_id = e_id.replace("#", wlgw_counterStripTags, "g");
                        e_name = e_name.replace("#", wlgw_counterStripTags, "g");
                        var e = document.createElement("input");
                        e.setAttribute("type", "text");
                        e.setAttribute("class", "widefat");
                        e.setAttribute("style", "width:80%;float:left;");
                        e.setAttribute("id", e_id);
                        e.setAttribute("name", e_name);
                        e.setAttribute("value", "");
                        var b = document.createElement("input");
                        b.setAttribute("type", "button");
                        b.setAttribute("value", "x");
                        b.setAttribute("style", "float:right;");
                        b.setAttribute("onclick", "this.parentNode.removeChild(document.getElementById(\""+e_id+"\"));this.parentNode.removeChild(this);");
                        this.parentNode.appendChild(e);
                        this.parentNode.appendChild(b);
                        wlgw_counterStripTags++;
                    '/>
            <?php
            foreach($instance as $key=>$value)
                if('stag' == substr($key, 0, strlen('stag')))
                {
                    $stag_id = $this->get_field_id('stag'.$this->_counterStripTags);
                    $stag_name = $this->get_field_name('stag'.$this->_counterStripTags);
                    $this->_counterStripTags++;
            ?>
                    <input type="text" id="<?php echo $stag_id;?>" name="<?php echo $stag_name;?>" value="<?php echo htmlentities($value);?>" class="widefat" style="width:80%;float:left;"/>
                    <input type="button" value="x" style="float:right;" onclick='
                        this.parentNode.removeChild(document.getElementById("<?php echo $stag_id;?>"));
                        this.parentNode.removeChild(this);
                    '/>
            <?php
                }
            ?>
                    <script type="text/javascript">var wlgw_counterStripTags=<?php echo $this->_counterStripTags;?></script>
                </p>
            </div>
        </div>

        <div class="widget" style="width:95%;">
            <div class="widget-top" style="cursor:default;">
                <div class="widget-title-action"><a class="widget-action hide-if-no-js" style="cursor:pointer;"></a></div>
                <div class="widget-title"><h4>String replacements</h4></div>
            </div>
            <div class="widget-inside" style="display: none;">
                <p>
                    <input type="button" value="Add" style="display:block;" onclick='
                        var e1_id = new String("<?php echo $this->get_field_id('srch#');?>");
                        var e1_name = new String("<?php echo $this->get_field_name('srch#');?>");
                        e1_id = e1_id.replace("#", wlgw_counterStringReplacements, "g");
                        e1_name = e1_name.replace("#", wlgw_counterStringReplacements, "g");
                        var e1 = document.createElement("input");
                        e1.setAttribute("type", "text");
                        e1.setAttribute("class", "widefat");
                        e1.setAttribute("style", "width:80%;float:left;");
                        e1.setAttribute("id", e1_id);
                        e1.setAttribute("name", e1_name);
                        e1.setAttribute("value", "");
                        var e2_id = new String("<?php echo $this->get_field_id('repl#');?>");
                        var e2_name = new String("<?php echo $this->get_field_name('repl#');?>");
                        e2_id = e2_id.replace("#", wlgw_counterStringReplacements, "g");
                        e2_name = e2_name.replace("#", wlgw_counterStringReplacements, "g");
                        var e2 = document.createElement("input");
                        e2.setAttribute("type", "text");
                        e2.setAttribute("class", "widefat");
                        e2.setAttribute("style", "width:80%;float:left;");
                        e2.setAttribute("id", e2_id);
                        e2.setAttribute("name", e2_name);
                        e2.setAttribute("value", "");
                        var b = document.createElement("input");
                        b.setAttribute("type", "button");
                        b.setAttribute("value", "x");
                        b.setAttribute("style", "float:right;");
                        b.setAttribute("onclick", "this.parentNode.removeChild(document.getElementById(\""+e1_id+"\"));this.parentNode.removeChild(document.getElementById(\""+e2_id+"\"));this.parentNode.removeChild(this);");
                        this.parentNode.appendChild(e1);
                        this.parentNode.appendChild(e2);
                        this.parentNode.appendChild(b);
                        wlgw_counterStringReplacements++;
                    '/>
            <?php
            foreach($instance as $key=>$value)
                if('srch' == substr($key, 0, strlen('srch')))
                {
                    $idx = intval(str_ireplace('srch', '', $key));
                    $srch_id = $this->get_field_id('srch'.$this->_counterStringReplacements);
                    $srch_name = $this->get_field_name('srch'.$this->_counterStringReplacements);
                    $srch_value = $value;
                    $repl_id = $this->get_field_id('repl'.$this->_counterStringReplacements);
                    $repl_name = $this->get_field_name('repl'.$this->_counterStringReplacements);
                    $repl_value = '';
                    if(isset($instance['repl'.$idx]))
                        $repl_value = $instance['repl'.$idx];
                    $this->_counterStringReplacements++;
            ?>
                    <input title="Search for ..." type="text" id="<?php echo $srch_id;?>" name="<?php echo $srch_name;?>" value="<?php echo htmlentities($srch_value);?>" class="widefat" style="width:80%;float:left;"/>
                    <input title="Replace with ..." type="text" id="<?php echo $repl_id;?>" name="<?php echo $repl_name;?>" value="<?php echo htmlentities($repl_value);?>" class="widefat" style="width:80%;float:left;"/>
                    <input type="button" value="x" style="float:right;" onclick='
                        this.parentNode.removeChild(document.getElementById("<?php echo $srch_id;?>"));
                        this.parentNode.removeChild(document.getElementById("<?php echo $repl_id;?>"));
                        this.parentNode.removeChild(this);
                    '/>
            <?php
                }
            ?>
                    <script type="text/javascript">var wlgw_counterStringReplacements=<?php echo $this->_counterStringReplacements;?></script>
                </p>
            </div>
        </div>


        <?php
    }
}
?>
