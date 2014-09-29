<table style="width:96.5%;background:#ffcccc; border:2px solid #AA0000;" cellpadding="5px" cellspacing="0">
    <tr style="height: 75px;">
        <!--td style="width:36px;"><img alt="" src="<?php echo base_url()?>assets/images/thumb/b/be/Icon-trash.png/32px-Icon-trash.png" width="32" height="32" border="0" /></td-->
        <td style="width:36px;"><img alt="" src="<?php echo base_url()?>assets/images/thumb/b/be/cross_icon.png" width="32" height="32" border="0" style="padding-left: 10px;padding-right: 10px;"/></td>
        <td style="vertical-align: middle;"><?php echo $this->session->userdata['error'];?></td>
    </tr>
</table>