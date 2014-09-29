<div id="some-content" class="box box-shadow grid_13 clearfix">
    <?php echo $this->load->view("topik/headerTab-topik");?>
    <?php echo $this->load->view("topik/subContent-topik");?>
    <div class="alpha omega">
        <h1>Daftar Topik Dosen</h1>
        <?php echo $this->load->view("topik/yellowNote-topik");?>
        <div style="margin: 30px 0 30px 1em;font-size: 12px;min-width: 100%">
            <?php echo $this->load->view("topik/search-topik");?>
        </div>
        <?php echo $this->load->view("topik/daftarTopikDosen");?>
    </div>
    <br/>
</div>