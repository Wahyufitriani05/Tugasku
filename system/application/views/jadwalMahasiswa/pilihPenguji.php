<form method="post" action="<?php echo site_url("jadwalMahasiswa/pilihPenguji")?>">
    <input type=hidden name=idproposal value='<?php echo $parameter['IDPROPOSAL']?>'>
    <input type=hidden name=idkbk value='<?php echo $parameter['IDKBK']?>'>
    <input type=hidden name=idslot value='<?php echo $parameter['IDSLOT']?>'>
    <input type=hidden name=sidangta value='<?php echo $parameter['SIDANGTA']?>'>
    <input type=hidden name=nip1 value='<?php echo $parameter['NIP1']?>'>
    <input type=hidden name=availnip1 value='<?php echo $parameter['AVAILNIP1']?>'>
    <input type=hidden name=nip2 value='<?php echo $parameter['NIP2']?>'>
    <input type=hidden name=availnip2 value='<?php echo $parameter['AVAILNIP1']?>'>
    <input type=hidden name=idjdwruangavail value='<?php echo $parameter['IDJDWRUANGAVAIL']?>'>
    <?php
    foreach ($list_dosen_free as $dosen) {
        ?>
        <input type=checkbox name=nipx_<?php echo $dosen->ID_JDW_AVAIL?>_<?php echo $dosen->NIP?>> &nbsp; <?php echo $dosen->NAMA_DOSEN?>&nbsp;(<?php echo $dosen->NIP?>)<BR>
        <?php
    }
    ?>
    <input type="submit" value="OK">
</form>
