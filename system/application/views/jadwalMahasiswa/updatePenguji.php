<div class="duplicate"></div>
<form method="post" action="<?php echo site_url("jadwalMahasiswa/updatePenguji")?>" id="pilihPenguji">
    <input type=hidden name=ID_JDW_MHS value='<?php echo $parameter['ID_JDW_MHS']?>'>
    <input type=hidden name=idkbk value='<?php echo $parameter['IDKBK']?>'>
    <input type=hidden name=idslot value='<?php echo $parameter['IDSLOT']?>'>
    <input type=hidden name=sidangta value='<?php echo $parameter['SIDANGTA']?>'>
    <input type=hidden name=nip value='<?php echo $parameter['NIP']?>'>
    
    <?php
    foreach ($list_dosen_free as $dosen) {
        ?>
        <input type=checkbox class="pengujiselect" name=nipx_<?php echo $dosen->ID_JDW_AVAIL?>_<?php echo $dosen->NIP?>> &nbsp; <?php echo $dosen->NAMA_DOSEN?>&nbsp;(<?php echo $dosen->NIP?>)<BR>
        <?php
    }
    ?>
        
    <input type="submit" value="OK" >
</form>


<script>
     $('#pilihPenguji').submit(function (e) {
        //var sList = "";
        var jum = 0;
        $('input[type=checkbox]').each(function () {
            //var sThisVal = (this.checked ? "1" : "0");
            //sList += (sList=="" ? sThisVal : "," + sThisVal);
            if(this.checked==1) jum++; 
        });
        if(jum!=1)            
        {
            e.preventDefault();
            if(!($("div[class='error']").length))
             {
                $("div[class='duplicate']").append(  '<div class="error">Pilih Penguji Sebanyak 1</div>' );
             }
        }
        //console.log (sList);
        
});
</script>