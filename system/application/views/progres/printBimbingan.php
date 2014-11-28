<script>
	function printContent(el){
		var restorepage = document.body.innerHTML;
		var printcontent = document.getElementById(el).innerHTML;
		document.body.innerHTML = printcontent;
		window.print();
		document.body.innerHTML = restorepage;
	}
	</script> 


            <a class="cetak" onclick ="printContent('bimbingan')" title="CETAK" href="#" style="text-decoration: none; visibility: hidden"><b>[Cetak Kartu Bimbingan]</b></a>
<div id="bimbingan">         
       <table>
            <tr>
                <td>
                    NRP
                </td>
                <td>
                    :
                </td>
                <td>
                    <?php echo $detailTA->nrp?>
                </td>
            </tr>
            <tr>
                <td>
                    NAMA
                </td>
                <td>
                    :
                </td>
                <td>
                    <?php echo $detailTA->nama_lengkap_mahasiswa?>
                </td>
            </tr>
            <tr>
                <td>
                    JUDUL
                </td>
                <td>
                    :
                </td>
                <td>
                    <?php echo $detailTA->judul_ta?>
                </td>
            </tr>
            <tr>
                <td>
                    PEMBIMBING 1
                </td>
                <td>
                    :
                </td>
                <td>
                    <?php echo $detailTA->pembimbing1?>
                </td>
            </tr>
            <tr>
                <td>
                    PEMBIMBING 2
                </td>
                <td>
                    :
                </td>
                <td>
                    <?php echo $detailTA->pembimbing2?>
                </td>
            </tr>
            <tr>
                <td>
                    KBK
                </td>
                <td>
                    :
                </td>
                <td>
                    <?php echo $detailTA->nama_kbk?>
                </td>
            </tr>
        </table>                         
               
               
        
            
            
        <?php                
        echo "<span id='bimbingan'>";
            $this->load->view("progres/bimbingan");
        echo "</span>";
        
        ?>						                          

        <div style="text-align: center; float:left; margin-left:10px;">
                            <p>Surabaya, <?php echo date("j F Y"); ?>,<br> 
                            Dosen Pembimbing 1
                            <br>
                            <br>
                            <p style="margin-bottom: 60px">(<?php echo $detailTA->pembimbing1; ?>)</p>
                        </div>
        </div>
            <div style="text-align: center; float:right; margin-right: 50px;">
                            <p><br>   
                             Dosen Pembimbing 2   
                            <br>
                            <br>
                            <p style="margin-bottom: 60px">(<?php echo $detailTA->pembimbing2; ?>)</p>
                        </div>
        </div>
            
        
        <script>
            $(document).ready(function()
            {
              $('.cetak').trigger('click');
            });
        </script>