        <?php
        if(!empty($list_proposal)) {
            foreach ($list_proposal as $prop) {
                    /* alowwed size:
                     * 1 --> 7.5 pt
                     * 2 --> 10 pt
                     * 3 --> 12 pt
                     * 4 --> 13.5 pt
                     * 5 --> 18 pt
                     * 6 --> 24 pt
                     * 7 --> 36 pt
                     */
            header("Content-type: application/vnd.ms-word");
            header("Content-Disposition: attachment;Filename=Berita_Acara_".$prop->NRP.".doc");
            echo "<html
            xmlns:o='urn:schemas-microsoft-com:office:office'
            xmlns:w='urn:schemas-microsoft-com:office:word'
            xmlns:v='urn:schemas-microsoft-com:vml'
            xmlns='http://www.w3.org/TR/REC-html40'>
            <head><title>Cetak Cover Proposal</title>
              <meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">
              <[if gte mso 9]>
                 <xml>
                     <w:WordDocument>
                     <w:View>Print</w:View>
                     <w:Zoom>100</w:Zoom>
                     <w:DoNotOptimizeForBrowser/>
                     </w:WordDocument>
                 </xml>
             <![endif]>
             <style>
                 < /* Style Definitions */
                     @page Section1
                     {size:8.27in 11.69in;
                     margin:1.18in 1.0in 1.0in 1.0in ;
                     mso-header-margin:.5in;
                     mso-footer-margin:.5in; mso-paper-source:0;}
                     div.Section1
                     {page:Section1;}
                 >
             </style>
            </head>
            <body>
            <div class=Section1>";
				//halaman pertama berita acara
				echo "<table border='0' width=\"600\">
				<tr><td colspan=\"3\" align=\"center\"><h3>BERITA ACARA</h3></td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td colspan=\"3\">Pada hari ini $prop->WAKTU telah diselenggarakan UJIAN TUGAS AKHIR bagi mahasiswa berikut:</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td width=\"100\">NAMA</td><td>:</td><td>$prop->NAMA_LENGKAP_MAHASISWA</td></tr>
				<tr><td>NOMOR POKOK</td><td>:</td><td>$prop->NRP</td></tr>
				<tr><td style=\"vertical-align:top\">JUDUL</td><td>:</td><td>$prop->JUDUL_TA</td></tr>
				<tr><td>RUANG</td><td>:</td><td>$prop->DESKRIPSI</td></tr>
				<tr><td>&nbsp;</td></tr>
				</table>
				<table border='0' width=\"600\">
				<tr><td colspan=\"2\">Dengan tim penguji sebagai berikut:</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td width=\"500\">Nama Penguji</td><td align=\"right\" width=\"100\">Tanda Tangan</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>1. Ketua&nbsp;&nbsp;&nbsp; : $prop->PENGUJI1</td><td align=\"right\">_______________</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>2. Anggota&nbsp;&nbsp;&nbsp; : $prop->PENGUJI2</td><td align=\"right\">_______________</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td colspan=\"2\" align=\"right\">Surabaya, $prop->TGL</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				</table>
				<table border='0' width=\"600\">
				<tr><td align=\"center\" width=\"300\">Dosen Pembimbing I,</td><td align=\"center\" width=\"300\">Dosen Pembimbing II</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td align=\"center\" width=\"300\">($prop->NAMA_PEMBIMBING1)</td><td align=\"center\">($prop->NAMA_PEMBIMBING2)</td></tr>
				</table>";
				echo "<div style=\"page-break-before:always\"/>";

				
				//halaman 2 nilai evaluasi mahasiswa bimbingan
				echo "<table border='0' width=\"600\">
				<tr><td colspan=\"3\" align=\"center\"><h3>EVALUASI NILAI BIMBINGAN</h3></td></tr>
				<tr><td colspan=\"3\" align=\"center\"><h3>TUGAS AKHIR</h3></td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td colspan=\"3\">Evaluasi Nilai Bimbingan TUGAS AKHIR bagi mahasiswa berikut:</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td width=\"100\">NAMA</td><td>:</td><td>$prop->NAMA_LENGKAP_MAHASISWA</td></tr>
				<tr><td>NOMOR POKOK</td><td>:</td><td>$prop->NRP</td></tr>
				<tr><td style=\"vertical-align:top\">JUDUL</td><td>:</td><td>$prop->JUDUL_TA</td></tr>
				<tr><td>TANGGAL</td><td>:</td><td>$prop->TGL</td></tr>
				<tr><td>JAM</td><td>:</td><td>$prop->jam_sidang</td></tr>
				<tr><td>RUANG</td><td>:</td><td>$prop->DESKRIPSI</td></tr>
				<tr><td><br></td></tr>
				<tr>
					<td colspan=\"3\">
						<table border=\"1\" align=\"center\" >
							<tr>
								<td align=\"center\">NO.</td>
								<td align=\"center\">SASARAN PENILAIAN</td>
								<td align=\"center\">NILAI HURUF <br> (A - E)</td>
							</tr>
							<tr>
								<td align=\"center\">1.</td>
								<td>MATERI TUGAS AKHIR<br>(Desain, Analisis, Uji Coba dan Demo Aplikasi)</td>
								<td></td>
							</tr>
							<tr>
								<td align=\"center\">2.</td>
								<td>PENGUASAAN MATERI<br>(Ketepatan Menjawab Pertanyaan)</td>
								<td></td>
							</tr>
							<tr>
								<td align=\"center\">3.</td>
								<td>KEMAMPUAN PRESENTASI<br>(Komunikasi, Pengendalian Waktu, Penyajian)</td>
								<td></td>
							</tr>
							<tr>
								<td align=\"center\">4.</td>
								<td>TATA TULIS BUKU TUGAS AKHIR<br>(Format, Typo, Referensi, Tabel/Gambar, Kelengkapan)</td>
								<td></td>
							</tr>
							<tr>
								<td></td>
								<td align=\"center\">TOTAL  = (1 + 2 + 3 + 4) / 4</td>
								<td style=\"font-size: 9pt; font-family: 'Times New Roman';\"><br><br><br>*diisi oleh Koord. TA</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr><td>Catatan :</td></tr>
				<tr><td colspan=\"3\">A=4&nbsp;&nbsp;&nbsp;AB=3,5&nbsp;&nbsp;&nbsp;B=3&nbsp;&nbsp;&nbsp;BC=2,5&nbsp;&nbsp;&nbsp;C=2&nbsp;&nbsp;&nbsp;D=1&nbsp;&nbsp;&nbsp;E=0</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td colspan=\"3\" align=\"right\" style=\"padding-left:50px;\">Surabaya, $prop->TGL</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td align=\"right\" colspan=\"3\">Dosen Pembimbing,</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td align=\"right\" colspan=\"3\">($prop->NAMA_PEMBIMBING1)</td></tr>
				</table>";
				echo "<div style=\"page-break-before:always\"/>";
				
				//halaman 3 nilai evaluasi mahasiswa bimbingan
				if($prop->NAMA_PEMBIMBING2!="--"){
					echo "<table border='0' width=\"600\">
					<tr><td colspan=\"3\" align=\"center\"><h3>EVALUASI NILAI BIMBINGAN</h3></td></tr>
					<tr><td colspan=\"3\" align=\"center\"><h3>TUGAS AKHIR</h3></td></tr>
					<tr><td>&nbsp;</td></tr>
					<tr><td>&nbsp;</td></tr>
					<tr><td colspan=\"3\">Evaluasi Nilai Bimbingan TUGAS AKHIR bagi mahasiswa berikut:</td></tr>
					<tr><td>&nbsp;</td></tr>
					<tr><td width=\"100\">NAMA</td><td>:</td><td>$prop->NAMA_LENGKAP_MAHASISWA</td></tr>
					<tr><td>NOMOR POKOK</td><td>:</td><td>$prop->NRP</td></tr>
					<tr><td style=\"vertical-align:top\">JUDUL</td><td>:</td><td>$prop->JUDUL_TA</td></tr>
					<tr><td>TANGGAL</td><td>:</td><td>$prop->TGL</td></tr>
					<tr><td>JAM</td><td>:</td><td>$prop->jam_sidang</td></tr>
					<tr><td>RUANG</td><td>:</td><td>$prop->DESKRIPSI</td></tr>
					<tr><td><br></td></tr>
					<tr>
						<td colspan=\"3\">
							<table border=\"1\" align=\"center\" >
								<tr>
									<td align=\"center\">NO.</td>
									<td align=\"center\">SASARAN PENILAIAN</td>
									<td align=\"center\">NILAI HURUF <br> (A - E)</td>
								</tr>
								<tr>
									<td align=\"center\">1.</td>
									<td>MATERI TUGAS AKHIR<br>(Desain, Analisis, Uji Coba dan Demo Aplikasi)</td>
									<td></td>
								</tr>
								<tr>
									<td align=\"center\">2.</td>
									<td>PENGUASAAN MATERI<br>(Ketepatan Menjawab Pertanyaan)</td>
									<td></td>
								</tr>
								<tr>
									<td align=\"center\">3.</td>
									<td>KEMAMPUAN PRESENTASI<br>(Komunikasi, Pengendalian Waktu, Penyajian)</td>
									<td></td>
								</tr>
								<tr>
									<td align=\"center\">4.</td>
									<td>TATA TULIS BUKU TUGAS AKHIR<br>(Format, Typo, Referensi, Tabel/Gambar, Kelengkapan)</td>
									<td></td>
								</tr>
								<tr>
									<td></td>
									<td align=\"center\">TOTAL  = (1 + 2 + 3 + 4) / 4</td>
									<td style=\"font-size: 9pt; font-family: 'Times New Roman';\"><br><br><br>*diisi oleh Koord. TA</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr><td>Catatan :</td></tr>
					<tr><td colspan=\"3\">A=4&nbsp;&nbsp;&nbsp;AB=3,5&nbsp;&nbsp;&nbsp;B=3&nbsp;&nbsp;&nbsp;BC=2,5&nbsp;&nbsp;&nbsp;C=2&nbsp;&nbsp;&nbsp;D=1&nbsp;&nbsp;&nbsp;E=0</td></tr>
					<tr><td>&nbsp;</td></tr>
					<tr><td colspan=\"3\" align=\"right\" style=\"padding-left:50px;\">Surabaya, $prop->TGL</td></tr>
					<tr><td>&nbsp;</td></tr>
					<tr><td align=\"right\" colspan=\"3\">Dosen Pembimbing,</td></tr>
					<tr><td>&nbsp;</td></tr>
					<tr><td>&nbsp;</td></tr>
					<tr><td>&nbsp;</td></tr>
					<tr><td align=\"right\" colspan=\"3\">($prop->NAMA_PEMBIMBING2)</td></tr>
					</table>";
					echo "<div style=\"page-break-before:always\"/>";
				}
					
					//halaman 4 evaluasi seminar dan ujian lisan tugas akhir
					echo "<table border='0' width=\"600\">
					<tr><td colspan=\"3\" align=\"center\"><h3>EVALUASI SEMINAR DAN UJIAN LISAN</h3></td></tr>
					<tr><td colspan=\"3\" align=\"center\"><h3>TUGAS AKHIR</h3></td></tr>
					<tr><td>&nbsp;</td></tr>
					<tr><td colspan=\"3\">Hasil Seminar dan Ujian Lisan dalam UJIAN TUGAS AKHIR untuk mahasiswa :</td></tr>
					<tr><td>&nbsp;</td></tr>
					<tr><td width=\"100\">NAMA</td><td>:</td><td>$prop->NAMA_LENGKAP_MAHASISWA</td></tr>
					<tr><td>NOMOR POKOK</td><td>:</td><td>$prop->NRP</td></tr>
					<tr><td style=\"vertical-align:top\">JUDUL</td><td>:</td><td>$prop->JUDUL_TA</td></tr>
					<tr><td>TANGGAL</td><td>:</td><td>$prop->TGL</td></tr>
					<tr><td>JAM</td><td>:</td><td>$prop->jam_sidang</td></tr>
					<tr><td>RUANG</td><td>:</td><td>$prop->DESKRIPSI</td></tr>
					<tr><td>&nbsp;</td></tr>
					<tr><td>adalah sebagai berikut:</td></tr>
					<tr>
						<td colspan=\"3\">
							<table border=\"1\" align=\"center\" >
								<tr>
									<td align=\"center\">NO.</td>
									<td align=\"center\">SASARAN PENILAIAN</td>
									<td align=\"center\">NILAI HURUF <br> (A - E)</td>
								</tr>
								<tr>
									<td align=\"center\">1.</td>
									<td>MATERI TUGAS AKHIR<br>(Desain, Analisis, Uji Coba dan Demo Aplikasi)</td>
									<td></td>
								</tr>
								<tr>
									<td align=\"center\">2.</td>
									<td>PENGUASAAN MATERI<br>(Ketepatan Menjawab Pertanyaan)</td>
									<td></td>
								</tr>
								<tr>
									<td align=\"center\">3.</td>
									<td>KEMAMPUAN PRESENTASI<br>(Komunikasi, Pengendalian Waktu, Penyajian)</td>
									<td></td>
								</tr>
								<tr>
									<td align=\"center\">4.</td>
									<td>TATA TULIS BUKU TUGAS AKHIR<br>(Format, Typo, Referensi, Tabel/Gambar, Kelengkapan)</td>
									<td></td>
								</tr>
								<tr>
									<td></td>
									<td align=\"center\">TOTAL  = (1 + 2 + 3 + 4) / 4</td>
									<td style=\"font-size: 9pt; font-family: 'Times New Roman';\"><br><br><br>*diisi oleh Koord. TA</td>
								</tr>
								<tr>
									<td></td>
									<td align=\"center\">TOTAL  = (A + B + C + D) / 4</td>
									<td style=\"font-size: 9pt; font-family: 'Times New Roman';\"><br><br><br>*diisi oleh Koord. TA</td>
								</tr>
							</table>
						</td>
					</tr>

					<tr><td>Catatan :</td></tr>
					<tr><td colspan=\"3\">A=4&nbsp;&nbsp;&nbsp;AB=3,5&nbsp;&nbsp;&nbsp;B=3&nbsp;&nbsp;&nbsp;BC=2,5&nbsp;&nbsp;&nbsp;C=2&nbsp;&nbsp;&nbsp;D=1&nbsp;&nbsp;&nbsp;E=0</td></tr>
					<tr><td>&nbsp;</td></tr>
					<tr><td colspan=\"3\" align=\"right\" style=\"padding-left:50px;\">Surabaya, $prop->TGL</td></tr>
					<tr><td>&nbsp;</td></tr>
					<tr><td align=\"right\" colspan=\"3\">Dosen Penguji,</td></tr>
					<tr><td>&nbsp;</td></tr>
					<tr><td>&nbsp;</td></tr>
					<tr><td>&nbsp;</td></tr>
					<tr><td align=\"right\" colspan=\"3\">($prop->PENGUJI1)</td></tr>
					</table>";
					echo "<div style=\"page-break-before:always\"/>";
						
					//halaman 5 evaluasi seminar dan ujian lisan tugas akhir
					if($prop->PENGUJI2!="--"){
						echo "<table border='0' width=\"600\">
						<tr><td colspan=\"3\" align=\"center\"><h3>EVALUASI SEMINAR DAN UJIAN LISAN</h3></td></tr>
						<tr><td colspan=\"3\" align=\"center\"><h3>TUGAS AKHIR</h3></td></tr>
						<tr><td>&nbsp;</td></tr>
						<tr><td colspan=\"3\">Hasil Seminar dan Ujian Lisan dalam UJIAN TUGAS AKHIR untuk mahasiswa :</td></tr>
						<tr><td>&nbsp;</td></tr>
						<tr><td width=\"100\">NAMA</td><td>:</td><td>$prop->NAMA_LENGKAP_MAHASISWA</td></tr>
						<tr><td>NOMOR POKOK</td><td>:</td><td>$prop->NRP</td></tr>
						<tr><td style=\"vertical-align:top\">JUDUL</td><td>:</td><td>$prop->JUDUL_TA</td></tr>
						<tr><td>TANGGAL</td><td>:</td><td>$prop->TGL</td></tr>
						<tr><td>JAM</td><td>:</td><td>$prop->jam_sidang</td></tr>
						<tr><td>RUANG</td><td>:</td><td>$prop->DESKRIPSI</td></tr>
						<tr><td>&nbsp;</td></tr>
						<tr><td>adalah sebagai berikut:</td></tr>
						<tr>
							<td colspan=\"3\">
								<table border=\"1\" align=\"center\" >
									<tr>
										<td align=\"center\">NO.</td>
										<td align=\"center\">SASARAN PENILAIAN</td>
										<td align=\"center\">NILAI HURUF <br> (A - E)</td>
									</tr>
									<tr>
										<td align=\"center\">1.</td>
										<td>MATERI TUGAS AKHIR<br>(Desain, Analisis, Uji Coba dan Demo Aplikasi)</td>
										<td></td>
									</tr>
									<tr>
										<td align=\"center\">2.</td>
										<td>PENGUASAAN MATERI<br>(Ketepatan Menjawab Pertanyaan)</td>
										<td></td>
									</tr>
									<tr>
										<td align=\"center\">3.</td>
										<td>KEMAMPUAN PRESENTASI<br>(Komunikasi, Pengendalian Waktu, Penyajian)</td>
										<td></td>
									</tr>
									<tr>
										<td align=\"center\">4.</td>
										<td>TATA TULIS BUKU TUGAS AKHIR<br>(Format, Typo, Referensi, Tabel/Gambar, Kelengkapan)</td>
										<td></td>
									</tr>
									<tr>
										<td></td>
										<td align=\"center\">TOTAL  = (1 + 2 + 3 + 4) / 4</td>
										<td style=\"font-size: 9pt; font-family: 'Times New Roman';\"><br><br><br>*diisi oleh Koord. TA</td>
									</tr>
									<tr>
										<td></td>
										<td align=\"center\">TOTAL  = (A + B + C + D) / 4</td>
										<td style=\"font-size: 9pt; font-family: 'Times New Roman';\"><br><br><br>*diisi oleh Koord. TA</td>
									</tr>
								</table>
						</td>
					</tr>
						<tr><td>Catatan :</td></tr>
						<tr><td colspan=\"3\">A=4&nbsp;&nbsp;&nbsp;AB=3,5&nbsp;&nbsp;&nbsp;B=3&nbsp;&nbsp;&nbsp;BC=2,5&nbsp;&nbsp;&nbsp;C=2&nbsp;&nbsp;&nbsp;D=1&nbsp;&nbsp;&nbsp;E=0</td></tr>
						<tr><td>&nbsp;</td></tr>
						<tr><td colspan=\"3\" align=\"right\" style=\"padding-left:50px;\">Surabaya, $prop->TGL</td></tr>
						<tr><td>&nbsp;</td></tr>
						<tr><td align=\"right\" colspan=\"3\">Dosen Penguji,</td></tr>
						<tr><td>&nbsp;</td></tr>
						<tr><td>&nbsp;</td></tr>
						<tr><td>&nbsp;</td></tr>
						<tr><td align=\"right\" colspan=\"3\">($prop->PENGUJI2)</td></tr>
						</table>";
						echo "<div style=\"page-break-before:always\"/>";
					}
				
				//halaman 6 lembar revisi tugas akhir
				echo "<table border='0' width=\"600\">
				<tr><td colspan=\"3\" align=\"center\"><h3>LEMBAR REVISI TUGAS AKHIR</h3></td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>NAMA MAHASISWA</td><td>:</td><td>$prop->NAMA_LENGKAP_MAHASISWA</td></tr>
				<tr><td>NOMOR POKOK</td><td>:</td><td>$prop->NRP</td></tr>
				<tr><td style=\"vertical-align:top\">JUDUL TUGAS AKHIR</td><td>:</td><td>$prop->JUDUL_TA</td></tr>
				<tr><td>DOSEN PEMBIMBING</td><td>:</td><td>1. $prop->NAMA_PEMBIMBING1</td></tr>";
				if($prop->NAMA_PEMBIMBING2!="--")echo "<tr><td colspan=\"2\">&nbsp;</td><td>2. $prop->NAMA_PEMBIMBING2</td></tr>";
				echo "<tr><td colspan =\"3\">&nbsp;</td></tr>
				<tr><td colspan=\"3\">
					<table border=\"1\" align=\"center\" width=\"500\">
						<tr><td>No.</td><td>REVISI</td></tr>
						<tr height=\"300\"><td width=\"30\">&nbsp;</td><td></td></tr>
					</table>
				</td></tr>
				<tr><td colspan=\"3\">Catatan :Dosen penguji memberikan tanda tangan setelah mahasiswa ybs merevisi buku Tugas Akhir</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td colspan=\"3\" align=\"right\" style=\"padding-left:50px;\">Surabaya, $prop->TGL</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td align=\"right\" colspan=\"3\">Dosen Penguji,</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td align=\"right\" colspan=\"3\">($prop->PENGUJI1)</td></tr>
				</table>";
				echo "<div style=\"page-break-before:always\"/>";
				
				//halaman 7 lembar revisi tugas akhir
				if($prop->PENGUJI2){
					echo "<table border='0' width=\"600\">
					<tr><td colspan=\"3\" align=\"center\"><h3>LEMBAR REVISI TUGAS AKHIR</h3></td></tr>
					<tr><td>&nbsp;</td></tr>
					<tr><td>&nbsp;</td></tr>
					<tr><td>NAMA MAHASISWA</td><td>:</td><td>$prop->NAMA_LENGKAP_MAHASISWA</td></tr>
					<tr><td>NOMOR POKOK</td><td>:</td><td>$prop->NRP</td></tr>
					<tr><td style=\"vertical-align:top\">JUDUL TUGAS AKHIR</td><td>:</td><td>$prop->JUDUL_TA</td></tr>
					<tr><td>DOSEN PEMBIMBING</td><td>:</td><td>1. $prop->NAMA_PEMBIMBING1</td></tr>";
					if($prop->NAMA_PEMBIMBING2!="--")echo "<tr><td colspan=\"2\">&nbsp;</td><td>2. $prop->NAMA_PEMBIMBING2</td></tr>";
					echo "<tr><td colspan =\"3\">&nbsp;</td></tr>
					<tr><td colspan=\"3\">
						<table border=\"1\" align=\"center\" width=\"500\">
							<tr><td>No.</td><td>REVISI</td></tr>
							<tr height=\"300\"><td width=\"30\">&nbsp;</td><td></td></tr>
						</table>
					</td></tr>
					<tr><td colspan=\"3\">Catatan :Dosen penguji memberikan tanda tangan setelah mahasiswa ybs merevisi buku Tugas Akhir</td></tr>
					<tr><td>&nbsp;</td></tr>
					<tr><td colspan=\"3\" align=\"right\" style=\"padding-left:50px;\">Surabaya, $prop->TGL</td></tr>
					<tr><td>&nbsp;</td></tr>
					<tr><td align=\"right\" colspan=\"3\">Dosen Penguji,</td></tr>
					<tr><td>&nbsp;</td></tr>
					<tr><td>&nbsp;</td></tr>
					<tr><td>&nbsp;</td></tr>
					<tr><td align=\"right\" colspan=\"3\">($prop->PENGUJI2)</td></tr>
					</table>";
					echo "<div style=\"page-break-before:always\"/>";
				}
			}
            echo "</div></body></html>";
        }
        ?>