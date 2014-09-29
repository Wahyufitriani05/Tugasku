<div id="some-content" class="box box-shadow clearfix">
    <div class="alpha omega">
        <h1><?php echo (isset($title) ? $title : ""); ?></h1>
        <?php
        if($this->session->flashdata('alert'))
            echo $this->session->flashdata('alert');
        ?>
        <div style="margin: 1em; float: left">
            <?php $this->load->view("progres/search-progres"); ?>
        </div>
        <div style="margin: 1em; float: right">
            <?php $this->load->view("progres/filter-progres"); ?>
        </div>
        <?php
        if(! empty($listTA))
            $this->load->view("progres/tugasakhir");
        ?>
    </div>
</div>