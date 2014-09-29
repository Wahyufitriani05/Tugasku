<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="Content-Style-Type" content="text/css" />
        <meta name="generator" content="MediaWiki 1.15.1" />
        <meta name="keywords" content="Main Page,11.2,Project,Distribution,Wiki,Free and Open Source Software" />

        <?php
        // JQuery
        echo "<script type='text/javascript' src='".base_url()."assets/jquery/jquery-1.4.2.min.js'></script>";
        echo "<script type='text/javascript' src='".base_url()."assets/jquery/jquery-ui-1.8.6.custom.min.js'></script>";
        echo "<link rel='stylesheet' href='".base_url()."assets/jquery/themes/base/jquery.ui.all.css'>";
        echo "<script type='text/javascript' src='".base_url()."assets/jquery/ui/jquery.ui.datepicker.js'></script>";
        echo "<script type='text/javascript' src='".base_url()."assets/jquery/ui/jquery-ui-timepicker-addon.js'></script>";

        // CSS
        // Base Style (Bento Theme)
        // Content of style.fluid.css:
        // reset.css            (reset default browser settings)
        // grid.css             (add fluid 960 Grid System)
        // base.css             (Basic CSS - Common styles)
        // base.fluid.fix.css   (Fixes for Bento with fluid 960gs)
        echo "<link rel='stylesheet' href='".base_url()."assets/themes/bento/css/style.fluid.css' type='text/css' media='screen' />";
        // style for pop up window
        echo "<link rel='stylesheet' href='".base_url()."assets/extensions/FlaggedRevs/flaggedrevs.css' type='text/css' />";
        echo "<link rel='stylesheet' href='".base_url()."assets/skins/bento/css_local/style.css' type='text/css' media='screen' />";

        // [if lt IE 7]
        echo "<meta http-equiv='imagetoolbar' content='no' />";
        // [endif]

        // Thickbox
//        echo $this->lib_js->thickbox(); 
//        

        // CSS Tambahan
        echo "<link rel='stylesheet' href='".base_url()."assets/css/style-ku.css' type='text/css' media='screen' />";
        ?>
    </head>
    <body class="mediawiki ltr ns-0 ns-subject page-Main_Page skin-bentofluid" style="height:70%">
        <?php
        // content
        echo "<div id='content' class='container_16 content-wrapper'>";
        // content rightSide (main content)
        if(isset($content)) $this->load->view($content);
        echo "</div>";

        // Note: this clears floating, set in previous elements
        echo "<div class='clear'></div>";
        ?>
    </body>
</html>
        