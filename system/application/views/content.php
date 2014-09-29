<div id="some-content" class="box box-shadow grid_13 clearfix">
    <!-- Toolbar Atas -->
    <?php echo $this->load->view("headerTab");?>

    <!-- Pop Up Window di pojok -->
    <?php echo $this->load->view("subContent");?>

    <div class="alpha omega">
        <!-- judul halaman + gambar-->
        <h1>Main Page</h1>
        
        <h3 id="siteSub">tagline: From openSUSE</h3>
        <div class="center">
            <div class="floatnone">
                <a href="/Portal:11.2" title="Portal:11.2"><img alt="openSUSE 11.2 out now!" src="<?php echo base_url()?>assets/images/3/31/OpenSUSE_11.2_728x90.png" width="728" height="90" border="0" /></a>
            </div>
        </div>
        
        <!-- judul halaman + gambar-->
        <?php echo $this->load->view("2ColArticle");?>
        <?php echo $this->load->view("Article");?>
        <?php echo $this->load->view("guideLine");?>
        <?php echo $this->load->view("note");?>
        <?php echo $this->load->view("summary");?>
        <?php echo $this->load->view("table");?>
        <?php echo $this->load->view("textArea");?>
        <?php echo $this->load->view("blueNote");?>
        <?php echo $this->load->view("yellowNote");?>
        <?php echo $this->load->view("redNote");?>

        <!-- <div class="printfooter">
            aRetrieved from "<a href="http://wiki.opensuse.org/Main_Page">http://wiki.opensuse.org/Main_Page</a>"
         </div>-->
        <?php echo $this->load->view("catLink");?>
    </div>
    <br/>
    <!-- Toolbar Bawah -->
    <?php echo $this->load->view("footerTab");?>
</div>