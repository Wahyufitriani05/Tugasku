<div id="contentSub"><div id='mw-revisiontag' class='flaggedrevs_short plainlinks noprint'>
    <table border='0' cellspacing='0' style='background: none;'>
        <tr style='white-space:nowrap;'>
            <td>
                <span title="Quality page" class="fr-icon-add"></span>&nbsp;
                 <?php echo $this->pquery->link_to_remote("<b>Auto Slot Waktu</b>",array('url'=>site_url("slot/autoSlotWaktu/$id_sidangTA/$parent_treeid"), 'update'=>"#slot_waktu", 'beforeSend'=>'return confirm("Tambahkan autoslot waktu?")'));?>
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>
                <span title="Quality page" class="fr-icon-add"></span>&nbsp;
                <?php echo $this->pquery->link_to_function('<b>Entry Slot Waktu</b>',$this->pquery->visual_effect("slideToggle","#entry_slotWaktu"));?>
            </td>
        </tr>
    </table>
</div></div>

