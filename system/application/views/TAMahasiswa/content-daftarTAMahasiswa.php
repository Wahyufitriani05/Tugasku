<div id="some-content" class="box box-shadow grid_13 clearfix">
    <!--?=$this->load->view("headerTab-addTopik");?-->
    <!--?=$this->load->view("subContent-addTopik");?-->
    <a name="top" id="top"></a>
    <div class="alpha omega">
        <!-- judul halaman + gambar-->
        <h1>Tugas Akhir Mahasiswa</h1>
        <h3 id="siteSub">tagline: From openSUSE</h3>
        <div class="center">
            <div class="floatnone">
                <a href="/Portal:11.2" title="Portal:11.2"><img alt="openSUSE 11.2 out now!" src="<?php echo base_url()?>assets/images/3/31/OpenSUSE_11.2_728x90.png" width="728" height="90" border="0" /></a>
            </div>
        </div>
        <!-- judul halaman + gambar-->
        <div style="margin: 1em 0 1em 1em;font-size: 12px;min-width: 100%">
        <?php echo $this->load->view("TAMahasiswa/filter-ta");?>
        <?php echo $this->load->view("TAMahasiswa/search-ta");?>
        </div>
        <?php echo $this->load->view("TAMahasiswa/table-daftarTA");?>
<!--
NewPP limit report
Preprocessor node count: 31/1000000
Post-expand include size: 5570/2097152 bytes
Template argument size: 2472/2097152 bytes
Expensive parser function count: 0/100
-->

<!-- Saved in stable version parser cache with key opensuse_wiki:stable-pcache:idhash:544-0!1!0!!en!2!edit=0 and timestamp 20100622061758 -->
        <!-- div opo iki? (printfooter)-->
        <div class="printfooter">
        aRetrieved from "<a href="http://wiki.opensuse.org/Main_Page">http://wiki.opensuse.org/Main_Page</a>"
        </div>
    </div>
    <br/>
</div>