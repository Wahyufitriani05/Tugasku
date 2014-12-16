<form id="filter-form" method="get" style="display: inline;float: left;padding: 0 1em 0 0; margin-bottom: 10px" action="<?php echo site_url('lamastudi/statistikPengujiTA')?>">
    Filter
	<select onchange="document.forms['filter-form'].submit()" name="filter_tahun" style="min-width: 150px; height: 20px;">
        <option value=""> - Pilih Tahun - </option>
        <option value="all">Semua Tahun</option>
        <?php
        foreach ($tahun as $row_k) {
            if($filter_tahun==$row_k->tahun)
                $tanda = " selected ";
            else
                $tanda = " ";
            echo "<option $tanda value='".$row_k->tahun."'>".$row_k->tahun."</option>";
        }
        ?>
    </select>
    <!--<select onchange="document.forms['filter-form'].submit()" name="filter_dosen" style="min-width: 150px; height: 20px;">
        <option value=""> - Pilih Nama Dosen - </option>
        <option value="all">Semua Dosen</option>
        <?php
        foreach ($dosen as $row_k) {
            if($filter_dosen==$row_k['nip'])
                $tanda = " selected ";
            else
                $tanda = " ";
            echo "<option $tanda value='".$row_k['nip']."'>".ucwords(strtolower($row_k['NAMA_DOSEN']))."</option>";
        }
        ?>
    </select>-->
     <select onchange="document.forms['filter-form'].submit()" name="filter_tipe" style="min-width: 150px; height: 20px;">        
        <option value="pembimbing" <?php if ($filter_tipe=="" || $filter_tipe=="pembimbing") echo "Selected"; ?> >Dosen Pembimbing</option>
        <option value="penguji" <?php if ($filter_tipe=="penguji") echo "Selected"; ?>>Dosen Penguji</option>
        
        
    </select>
</form>
