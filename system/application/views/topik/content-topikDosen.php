<div id="some-content" class="box box-shadow grid_13 clearfix">
     <?php echo $this->load->view("topik/headerTab-topik");?>
    <?php echo $this->load->view("topik/subContent-topik");?>
    <div class="alpha omega">
        <h1>Daftar Topik Dosen</h1>
        <h3 style="color: #006699">oleh Tegar R Putra</h3>
        <?php echo $this->load->view("topik/yellowNote-topik");?>
        <div style="margin: 30px 0 30px 1em;font-size: 12px;min-width: 100%">
            <?php echo $this->load->view("topik/filter-topik");?>
            <?php echo $this->load->view("topik/search-topik");?>
        </div>
        <?php echo $this->load->view("topik/topikDosen");?>
    </div>
    <br/>
</div>