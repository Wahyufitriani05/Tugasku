<?php

//echo $this->lib_js->thickbox(); 

?>

<script type="text/javascript" src="<?php echo base_url(); ?>/assets/ckeditor/ckeditor.js"></script>

<div id="some-content" class="box box-shadow grid_13 clearfix">

    <!--?=$this->load->view("headerTab-addTopik");?-->

    <!--?=$this->load->view("subContent-addTopik");?-->

    <a name="top" id="top"></a>

    <div class="alpha omega" style="min-height: 450px;">

        <!-- judul halaman + gambar-->

        <h1>Status Proposal TA</h1>

<!--        <h3 id="siteSub">tagline: From openSUSE</h3>-->

<!--        <div class="center">

            <div class="floatnone">

                <a href="/Portal:11.2" title="Portal:11.2"><img alt="openSUSE 11.2 out now!" src="<?php echo base_url()?>assets/images/3/31/OpenSUSE_11.2_728x90.png" width="728" height="90" border="0" /></a>

            </div>

        </div>-->

        <!-- judul halaman + gambar-->

        <br>

        <!--?php echo $this->load->view('proposalTA/redNote');?-->

        <?php

            $error="";

            $error=$this->session->userdata('error');

            if($error!=""){

                $this->load->view('proposalTA/redNote');

                $this->session->unset_userdata('error');

            }



            $sukses="";

            $sukses=$this->session->userdata('sukses');

            if($sukses!=""){

                $this->load->view('kbkDosen/blueNote');

                $this->session->unset_userdata('sukses');

            }

        ?>

        <?php

            //cek apakah ada proposal yang pernah dibuat atau tidak

            if($proposal->num_rows()>0){

                echo "<table class=\"table1\" style=\"width:90%; margin-top:20px; border:1px solid #aaa;\" border=\"1\" cellpadding=\"2\" cellspacing=\"3\">

                    <tr><th>ID Proposal</th><th>Tanggal Masuk</th><th>Judul Proposal</th><th>Pembimbing 1</th><th>Pembimbing 2</th><th>Status</th>";
					//echo "<th>Batal</th>";
					echo "<th>Ubah</th></tr>";

                foreach($proposal->result() as $row){

                    echo "<tr><td align='center'>$row->id_proposal</td><td>$row->tanggal_masuk</td><td>$row->judul_ta</td><td>$row->pembimbing1</td><td>$row->pembimbing2</td>

                          <td>";

                          if($row->status==0)echo "Mendaftar";

                          else if($row->status==1) echo "Tunggu Sidang";

                          else if($row->status==11) echo "Revisi";

                          else if($row->status==12) echo "OK";

                          else if($row->status==13) echo "Ditolak";

                          else if($row->status==2) echo "Batal";

                          else if($row->status==3) echo "Maju Sidang";

                          else if($row->status==31) echo "Lulus";

                          else if($row->status==32) echo "Tidak Lulus";

                    /*echo "</td>

                        <td align='center'>";

                        if($row->status==12)echo "<a href='".site_url('proposal/proposalBatal')."/$row->id_proposal'>batalkan</a>";

                        else echo "-";

                    echo "</td>";*/
					echo "<td align=\"center\">";

                    if($row->status==0 || $row->status==11 || $row->status==1) echo "<a href=\"".site_url('proposal/ubahProposal/'.$row->id_proposal)."?TB_iframe=true&height=450&width=700\" class=\"thickbox\" title=\"Ubah Proposal\">Ubah</a>";

                    else echo "-";

                    echo "</td></tr>";

                }

                echo "</table>";

            }

            //jika belum ada record proposal sama sekali

            else{

                echo "<table class=\"table1\" style=\"width:90%; margin-top:20px; border:1px solid #aaa;\" border=\"1\" cellpadding=\"2\" cellspacing=\"3\">

                    <tr><th>ID Proposal</th><th>Tanggal Masuk</th><th>Judul Proposal</th><th>Pembimbing 1</th><th>Pembimbing 2</th><th>Status</th><th>Ubah</th></tr>

                    <tr><td colspan=\"7\">Anda belum membuat proposal !!!</td></tr>

                    </table>";

            }

        ?>

    </div>

    <br/>

</div>