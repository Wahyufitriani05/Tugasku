<div id="subheader" class="container_16">
    
    <div id="breadcrump" class="grid_12 alpha">
        <a href="<?php echo site_url();?>" title="Home"><img src="<?php echo base_url()?>assets/skins/bento/home_grey.png" width="16" height="16" alt="Home" /> MonTA</a> &gt;
        <?php echo $this->uri->segment(1,0);?> >
        <?php echo $this->uri->segment(2,0);?>
        &nbsp
    </div>

    <div id="login-wrapper" class="grid_4 omega">
        
        <?php echo $this->load->view("rightBreadcumbs");?>

        <div id="login-form">
            <form action="<?php echo site_url('login/masuk');?>" method="post" enctype="application/x-www-form-urlencoded" id="login_form">
                <input name="url" value="http://wiki.opensuse.org/Main_Page" type="hidden"/>
                <input name="context" value="default" type="hidden"/>
                <input name="proxypath" value="reverse" type="hidden"/>
                <input name="message" value="Please log In" type="hidden"/>
                <p><label class="inlined" for="username">Username</label><input type="text" class="inline-text" name="username" value="<?php echo set_value('username');?>" id="username" /><?php echo form_error('username'); ?></p>
                <p><label class="inlined" for="password">Password</label><input type="password" class="inline-text" name="password" value="<?php echo set_value('password');?>" id="password" /><?php echo form_error('password'); ?></p>
                <p><input type="submit" value="Login" /></p>
                <p class="slim-footer"><a id="close-login" href="#cancel">Cancel</a></p>
            </form>
        </div>
    </div>
</div>