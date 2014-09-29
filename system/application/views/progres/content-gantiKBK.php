<div>
    <?php
    foreach ($list_kbk as $kbk) {
        echo "<div class='detail'>";
        echo "<div class='element'><a href='".site_url("penjadwalan/confirmGantiKBK/$id_proposal/$kbk->ID_KBK")."'>$kbk->NAMA_KBK</a></div>";
        echo "<div class='element wide'>$kbk->KETERANGAN_KBK</div>";
        echo "</div>";
    }
    ?>
</div>
        