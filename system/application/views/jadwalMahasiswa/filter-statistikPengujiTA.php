<form id="filter-form" method="post" style="display: inline;float: left;padding: 0 1em 0 0; margin-bottom: 10px" action="<?php echo site_url('jadwalMahasiswa/statistikPengujiTA')?>">
    Filter
	<select onchange="document.forms['filter-form'].submit()" name="filter_statistik_tahun" style="min-width: 150px; height: 20px;">
        <option value=""> - Pilih Tahun - </option>
        <option value="all">Semua Tahun</option>
        <?php
        foreach ($tahun as $row_k) {
            if($row_k->tahun == $this->session->userdata('filter_statistik_tahun'))
                $tanda = " selected ";
            else
                $tanda = " ";
            echo "<option $tanda value='".$row_k->tahun."'>".$row_k->tahun."</option>";
        }
        ?>
    </select>
    <select onchange="document.forms['filter-form'].submit()" name="filter_statistik_dosen" style="min-width: 150px; height: 20px;">
        <option value=""> - Pilih Nama Dosen - </option>
        <option value="all">Semua Dosen</option>
        <?php
        foreach ($dosen as $row_k) {
            if($row_k['nip'] == $this->session->userdata('filter_statistik_dosen'))
                $tanda = " selected ";
            else
                $tanda = " ";
            echo "<option $tanda value='".$row_k['nip']."'>".ucwords(strtolower($row_k['NAMA_DOSEN']))."</option>";
        }
        ?>
    </select>
</form>