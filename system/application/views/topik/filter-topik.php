Filter &nbsp;
<form style="display: inline" action="<?php echo site_url('topik/lihatTopik');?>" method="post">
    <select id="kbk" name="kbk" style="min-width: 120px; height: 20px;">
        <option value="0"> - Bidang Minat - </option>
        <?php
        foreach($kbk as $row_kbk)
        {
            echo "<option value=\"$row_kbk->id_kbk\"";
            if($id_kbk==$row_kbk->id_kbk)echo " selected ";
            echo">$row_kbk->nama_kbk</option>";
        }
        ?>
    </select>
    <select id="status" name="status" style="min-width: 120px; height: 20px;">
        <option value="5"> - Status - </option>
        <option value="1" <?php if($id_status==1)echo "selected";?>>Diambil</option>
        <option value="0" <?php if($id_status==0)echo "selected";?>>Belum Diambil</option>
    </select>
    <input type="submit" value="OK"/>
</form>