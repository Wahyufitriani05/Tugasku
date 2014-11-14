<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="Content-Style-Type" content="text/css" />

        <?php
        // Web Icon
        // echo "<link rel='shortcut icon' href='".base_url()."assets/icons/favicon.ico' />";
        
        // Web Title
        echo "<title>MonTA".(isset($title) ? " | $title" : "")."</title>";
        
        // Thickbox
        //echo $this->lib_js->thickbox(); 
        
        
        // JQuery
        echo "<script type='text/javascript' src='".base_url()."assets/jquery/jquery-1.4.2.min.js'></script>";
        echo "<script type='text/javascript' src='".base_url()."assets/jquery/jquery-ui-1.8.6.custom.min.js'></script>";
        echo "<link rel='stylesheet' href='".base_url()."assets/jquery/themes/base/jquery.ui.all.css'>";
        echo "<script type='text/javascript' src='".base_url()."assets/jquery/ui/jquery.ui.datepicker.js'></script>";
        echo "<script type='text/javascript' src='".base_url()."assets/jquery/ui/jquery-ui-timepicker-addon.js'></script>";
        //echo "<script type='text/javascript' src='".base_url()."assets/jquery/jquery.tablesorter.js'></script>";
        //echo "<script type='text/javascript' src='".base_url()."assets/jquery/jquery.tablesorter.min.js'></script>";
        //echo "<script type='text/javascript' src='".base_url()."assets/jquery/jquery.tablesorter.pager.js'></script>";
        echo "<script type='text/javascript' src='".base_url()."assets/jquery/jquery.dataTables.js'></script>";

        // CSS
        // Base Style (Bento Theme)
        // Content of style.fluid.css:
        // reset.css            (reset default browser settings)
        // grid.css             (add fluid 960 Grid System)
        // base.css             (Basic CSS - Common styles)
        // base.fluid.fix.css   (Fixes for Bento with fluid 960gs)
        /*
        echo "<link rel='stylesheet' href='".base_url()."assets/themes/bento/css/style.fluid.css' type='text/css' media='screen' />";
        // Extension Style (User Interface)
        echo "<link rel='stylesheet' href='".base_url()."assets/skins/common/shared.css?207' type='text/css' media='screen' />";
        echo "<link rel='stylesheet' href='".base_url()."assets/skins/common/commonPrint.css?207' type='text/css' media='print' />";
        // style for pop up window
        echo "<link rel='stylesheet' href='".base_url()."assets/extensions/FlaggedRevs/flaggedrevs.css' type='text/css' />";
        echo "<link rel='stylesheet' href='".base_url()."assets/skins/bento/css_local/style.css' type='text/css' media='screen' />";
		//style for tablesorter
        //echo "<link rel='stylesheet' href='".base_url()."/assets/jquery/themes/tablesorter/blue/style.css' type='text/css' media='screen' />";

        // [if lt IE 7]
        echo "<meta http-equiv='imagetoolbar' content='no' />";
        // [endif]
        */
        
        // Javascript
        //echo "<script type='text/javascript' src='".base_url()."assets/skins/common/wikibits.js?207'></script>";
        // login form
        echo "<script type='text/javascript' src='".base_url()."assets/stage/themes/bento/js/script.js'></script>";
        echo "<script type='text/javascript' src='".base_url()."assets/skins/bento/js_local/script.js'></script>";
        // web menu
        //echo "<script type='text/javascript' src='".base_url()."assets/themes/bento/js/l10n/$js_menu.js'></script>";
        echo "<script type='text/javascript' src='".base_url()."assets/themes/bento/js/global-navigation.js'></script>";
        // pop up window
        echo "<script type='text/javascript' src='".base_url()."assets/extensions/FlaggedRevs/flaggedrevs.js?56'></script>";
        echo "<script type='text/javascript' src='".base_url()."assets/skins/common/ajax.js?207'></script>";

        // CSS Tambahan
        //echo "<link rel='stylesheet' href='".base_url()."assets/css/style-ku.css' type='text/css' media='screen' />";
        //echo "<link rel='stylesheet' href='".base_url()."assets/css/datatable/demo_table.css' type='text/css' media='screen' />";
        //echo "<link rel='stylesheet' href='".base_url()."assets/css/datatable/demo_page.css' type='text/css' media='screen' />";

        
        ?>
    </head>
    <body bgcolor="#FFFFFF">
        <br/>
        <br/>
        <?php
        
        // content
        echo "<div id='content' class='container_16 content-wrapper'>";
            // left side (block_navigation, block_toolbox, block_sponsors)
            if(isset($leftSide)) $this->load->view($leftSide);
            // content rightSide (main content)
            if(isset($content)) $this->load->view($content);
        echo "</div>";

        // Note: this clears floating, set in previous elements
        echo "<div class='clear'></div>";

        // footer
        
        ?>

        <script type="text/javascript">if (window.runOnloadHook) runOnloadHook();</script>
        <!-- Served in 0.130 sec -->
    </body>
</html>
        