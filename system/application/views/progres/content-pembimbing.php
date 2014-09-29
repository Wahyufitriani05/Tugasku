<div id="contentSub"><div id='mw-revisiontag' class='flaggedrevs_short plainlinks noprint'>
    <table border='0' cellspacing='0' style='background: none;'>
        <tr style='white-space:nowrap;'><td>
            <span title="Quality page" class="fr-icon-add"></span>&nbsp;
            <a href="<?php echo site_url("penjadwalan/confirmGantiPembimbing/$no/$id_proposal")?>">Hapus Pembimbing <?php echo $no?></a>
        </td></tr>
    </table>
</div></div>
<div>
    <?php
    foreach ($pembimbing as $row) {
        echo "<div class='detail'>";
        echo "<div class='element wide'><a href='".site_url("penjadwalan/confirmGantiPembimbing/$no/$id_proposal/$row->NIP")."'>$row->NAMA_LENGKAP_DOSEN</a></div>";
        echo "</div>";
    }
    ?>
</div>
        