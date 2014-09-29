<?php
if($this->session->userdata('publish') == 1) 
{
    $publish = 0;
    $cmd = "Unpublish";
}
else
{
    $publish = 1;
    $cmd = "Publish";
}
?>
<div id="contentSub"><div id='mw-revisiontag' class='flaggedrevs_short plainlinks noprint'>
    <table border='0' cellspacing='0' style='background: none;'>
        <tr style='white-space:nowrap;'>
            <td>
                <span title="Quality page" class="fr-icon-add"></span>&nbsp;
                <a href="<?php echo site_url("jadwalMahasiswa/publish/$id_sidangTA/$publish")?>" onclick="return confirm('Anda yakin untuk <?php echo $cmd;?> jadwal sidang TA?');"><b> <?php echo $cmd;?></b></a>
            </td>
            <td>
                <span title="Quality page" class="fr-icon-add"></span>&nbsp;
                <a href="javascript:document.majuSidang.submit();" onclick="return confirm('Anda yakin untuk update jadwal sidang TA?');"><b>Update Jadwal Maju Sidang</b></a>
            </td>
        </tr>
    </table>
</div></div>

