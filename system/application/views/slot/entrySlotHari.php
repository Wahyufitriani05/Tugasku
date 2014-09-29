<script type='text/javascript'>

    $(function() {

        $( '#tgl' ).datepicker({

            changeMonth: true,

            changeYear: true,

            dateFormat: 'yy-mm-dd'

        });

    });

</script>

<div style="display: none;" id="entry_slotHari">  

    <form action="<?php echo site_url("slot/entrySlotHari/$id_sidangTA/$parent_treeid"); ?>" method="POST">

        <div class='detail'>

            <div class='element'><b>Tanggal</b></div>

            <div class='element mini'>:</div>

            <div class='element wide'><input class='input small' type='text' id='tgl' name='tgl'/></div>

        </div>

        <div class='detail'>

            <div class='element'>&nbsp;</div>

            <div class='element wide' style='margin:1em; text-align:right'>

                    <input type='hidden' name='sjhdas73438'/>

                    <input type='button' value='Batal'  style='width: 150px' onclick='self.parent.tb_remove()'/>

                    <input type='submit' value='Simpan' style='width: 150px' onclick='self.parent.tb_remove()'/>

            </div>

        </div>

    </form>

</div>