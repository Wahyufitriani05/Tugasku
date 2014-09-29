<div id="some-content" class="box box-shadow clearfix">
    <div class="alpha omega">
        <h1><?php echo (isset($title) ? $title : ""); ?></h1>
        <div style="margin: 1em;">
            <?php
            $this->load->view("sidang/filter-jadwalSidangProposal");
            if($this->session->userdata('filter_kbk') != "" || $this->lib_user->is_admin_kbk() == true) {
                $this->load->view("sidang/subContent-entrySidangProposal");
                $this->load->view("sidang/entrySidangProposal");
            }
            echo "<div class='separator'></div>";
            ?>
        </div>
        <div class='separator'></div>
        <?php
        if(!empty($sid_prop)) {
            echo "<span id='sidang_proposal'>";
            echo $this->load->view("sidang/jadwalSidangProposal");
            echo "</span>";
        }
        ?>
    </div>
</div>