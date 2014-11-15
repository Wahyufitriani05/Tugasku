<script>
	function printContent(el){
		var restorepage = document.body.innerHTML;
		var printcontent = document.getElementById(el).innerHTML;
		document.body.innerHTML = printcontent;
		window.print();
		document.body.innerHTML = restorepage;
	}
	</script> 

<div id='mw-revisiontag' class='plainlinks noprint' >
    <table border='0' cellspacing='0' style='background: none;'>
        <tr style='white-space:nowrap;'><td>
            <span title="Quality page" class="fr-icon-download"></span>&nbsp;            
            <a class="" onclick ="printContent('bimbingan')" title="<b>CETAK</b>" href="#"><b>Cetak Kartu Bimbingan</b></a>
        </td></tr>
    </table>
</div>        

<div id="bimbingan">    
    <br/>    
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

</div>