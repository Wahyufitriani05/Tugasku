<?php
$keyword = (isset ($keyword) ? $keyword : "kata kunci");
echo "<script>
    function populateElement(selector, defvalue) {
        $(selector).each(function() {
            if($.trim(this.value) == '') {
                this.value = defvalue;
            }
        });

        $(selector).focus(function() {
            if(this.value == defvalue) {
                this.value = '';
                $('#search').attr('color', black);
            }
        });

        $(selector).blur(function() {
            if($.trim(this.value) == '') {
                this.value = defvalue;
                $('#search').attr('color', grey);
            }
        });
    }

    $(document).ready(function(){
        populateElement('#search', '$keyword');
    })
</script>";

?>
<form class="lable-overley-2" id="global-search-form" action="<?php echo site_url('progres/tugasakhir/cari');?>" method="post" style="display: inline;float: left;padding: 0 1em 0 0;">
    <strong>PENCARIAN</strong>
    <div class='detail'>
        <div class='element'>berdasarkan</div>
        <div class='element'>
            <select name="kriteria_search" style="width: 150px; height: 20px;">
            <option value=""> - Semua Kriteria - </option>
            <option value="judul" <?php echo (isset ($kriteria) && $kriteria == "judul" ? "selected" : ""); ?>> Judul TA </option>
            <option value="nama_mhs" <?php echo (isset ($kriteria) && $kriteria == "nama_mhs" ? "selected" : ""); ?>> Nama Mahasiswa </option>
            <option value="nrp_mhs" <?php echo (isset ($kriteria) && $kriteria == "nrp_mhs" ? "selected" : ""); ?>> NRP Mahasiswa </option>
        </select>
        </div>
    </div>
    <div class='detail'>
        <div class='element'>kata kunci</div>
        <div class='element'>
            <input type="text" name="search" value="" id="search" style="height: 20px; width: 300px; margin-left: 0px;"/>
            <input type="submit" name="go" class="hidden"  value="Search"  title="Go to a page with this exact name if exists"/>
        </div>
    </div>
</form>