<?php setlocale(LC_ALL, "id_ID"); ?>
<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $title; ?></title>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" media="print">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" media="screen">
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style type="text/css">
            .input-nilai {
                border: none;
                text-align: center;
                box-shadow: none;
            }
            .input-nilai:focus {
                border: none;
                box-shadow: none;
            }
        </style>
    </head>
    <body style="overflow-x: hidden">
    <form id="form-penilaian" method="post" action="<?php echo base_url(); ?>index.php/jadwalMahasiswa/masukkanNilai">
        <input type="hidden" value="<?php echo $detail_proposal->ID_PROPOSAL; ?>" name="id_proposal">
        <input type="hidden" value="<?php echo $nip_dosen; ?>" name="nip_dosen">        
        <div class="container">
            <div class="row" id="cetak">
                <div class="col-xs-12 col-sm-12 col-md-12">                    
                    <?php if ($tipe=='pembimbing') {?>
                    <h2 class="text-center"><strong>EVALUASI NILAI BIMBINGAN<br>TUGAS AKHIR</strong></h2>                    
                    <p>Evaluasi Nilai Bimbingan TUGAS AKHIR bagi mahasiswa berikut :</p>
                    <?php } else { ?>
                     <h2 class="text-center"><strong>EVALUASI SEMINAR DAN UJIAN LISAN TUGAS AKHIR</strong></h2>
                    <p>Hasil Seminar dan Ujian Lisan dalam UJIAN TUGAS AKHIR untuk mahasiswa :</p>
                    <?php }?>
                    <div class="row">
                        <div class="col-xs-4" col-sm-4" col-md-4">
                            NAMA
                        </div>
                        <div class="col-xs-1" col-sm-1" col-md-1" style="width: 33px">
                            :
                        </div>
                        <div class="col-xs-7" col-sm-7" col-md-7">
                            <?php echo $detail_proposal->NAMA_LENGKAP_MAHASISWA; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4" col-sm-4" col-md-4">
                            NOMOR POKOK
                        </div>
                        <div class="col-xs-1" col-sm-1" col-md-1" style="width: 33px">
                            :
                        </div>
                        <div class="col-xs-7" col-sm-7" col-md-7">
                            <?php echo $detail_proposal->NRP; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4" col-sm-4" col-md-4">
                            JUDUL TA
                        </div>
                        <div class="col-xs-1" col-sm-1" col-md-1" style="width: 33px">
                            :
                        </div>
                        <div class="col-xs-7" col-sm-7" col-md-7">
                            <?php echo $detail_proposal->JUDUL_TA; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4" col-sm-4" col-md-4">
                            TANGGAL SIDANG
                        </div>
                        <div class="col-xs-1" col-sm-1" col-md-1" style="width: 33px">
                            :
                        </div>
                        <div class="col-xs-7" col-sm-7" col-md-7">
                            <?php echo $detail_proposal->WAKTU_SIDANG; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4" col-sm-4" col-md-4">
                            JAM
                        </div>
                        <div class="col-xs-1" col-sm-1" col-md-1" style="width: 33px">
                            :
                        </div>
                        <div class="col-xs-7" col-sm-7" col-md-7">
                            <?php echo $detail_proposal->JAMTEPAT; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4" col-sm-4" col-md-4">
                            RUANG
                        </div>
                        <div class="col-xs-1" col-sm-1" col-md-1" style="width: 33px">
                            :
                        </div>
                        <div class="col-xs-7" col-sm-7" col-md-7">
                            <?php echo $detail_proposal->DESKRIPSI; ?>
                        </div>
                    </div>
                    <p>Adalah sebagai berikut:</p>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="vertical-align: middle; text-align: center">UNSUR</th>
                                            <th style="vertical-align: middle; text-align: center">SASARAN PENILAIAN</th>
                                            <th style="vertical-align: middle; text-align: center">NILAI ANGKA<br>(56-100)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="vertical-align: middle; text-align: center">I</td>
                                            <td>MATERI TUGAS AKHIR<br>(Desain, Analisa, Uji Coba dan Demo Aplikasi)</td>
                                            <td class="hidden-print">
                                                <div class="form-group" style="margin-bottom: 0px;">
                                                    <input type="text" name="nilai1" id="nilai1" class="form-control input-nilai" placeholder="Masukkan Nilai Angka" onchange="updateNilai(1,this.value)" <?php if (!empty($detail_lembar_penilaian)) { ?>value="<?php echo $detail_lembar_penilaian->UNSUR_1; } ?>">
                                                </div>
                                            </td>
                                            <td class="visible-print" style="vertical-align: middle; text-align: center">
                                                <span id="value1"><?php $total = 0; if (!empty($detail_lembar_penilaian)) { ?><?php echo $detail_lembar_penilaian->UNSUR_1; $total = $total + $detail_lembar_penilaian->UNSUR_1; } ?></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align: middle; text-align: center">II</td>
                                            <td>PENGUASAAN MATERI<br>(Ketepatan Menjawab Pertanyaan)</td>
                                            <td class="hidden-print">
                                                <div class="form-group" style="margin-bottom: 0px;">
                                                    <input type="text" name="nilai2" id="nilai2" class="form-control input-nilai" placeholder="Masukkan Nilai Angka" onchange="updateNilai(2,this.value)" <?php if (!empty($detail_lembar_penilaian)) { ?>value="<?php echo $detail_lembar_penilaian->UNSUR_2; } ?>">
                                                </div>
                                            </td>
                                            <td class="visible-print" style="vertical-align: middle; text-align: center">
                                                <span id="value2"><?php if (!empty($detail_lembar_penilaian)) { ?><?php echo $detail_lembar_penilaian->UNSUR_2; $total = $total + $detail_lembar_penilaian->UNSUR_2; } ?></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align: middle; text-align: center">III</td>
                                            <td>KEMAMPUAN PRESENTASI<br>(Komunikasi, Pengendalian Waktu, Penyajian)</td>
                                            <td class="hidden-print">
                                                <div class="form-group" style="margin-bottom: 0px;">
                                                    <input type="text" name="nilai3" id="nilai3" class="form-control input-nilai" placeholder="Masukkan Nilai Angka" onchange="updateNilai(3,this.value)" <?php if (!empty($detail_lembar_penilaian)) { ?>value="<?php echo $detail_lembar_penilaian->UNSUR_3; } ?>">
                                                </div>
                                            </td>
                                            <td class="visible-print" style="vertical-align: middle; text-align: center">
                                                <span id="value3"><?php if (!empty($detail_lembar_penilaian)) { ?><?php echo $detail_lembar_penilaian->UNSUR_3; $total = $total + $detail_lembar_penilaian->UNSUR_3; } ?></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align: middle; text-align: center">IV</td>
                                            <td>TATA TULIS BUKU TUGAS AKHIR dan POMITS<br>(Format,Typo, Referensi, Tabel/Gambar, Kelengkapan)</td>
                                            <td class="hidden-print">
                                                <div class="form-group" style="margin-bottom: 0px;">
                                                    <input type="text" name="nilai4" id="nilai4" class="form-control input-nilai" placeholder="Masukkan Nilai Angka" onchange="updateNilai(4,this.value)" <?php if (!empty($detail_lembar_penilaian)) { ?>value="<?php echo $detail_lembar_penilaian->UNSUR_4; } ?>">
                                                </div>
                                            </td>
                                            <td class="visible-print" style="vertical-align: middle; text-align: center">
                                                <span id="value4"><?php if (!empty($detail_lembar_penilaian)) { ?><?php echo $detail_lembar_penilaian->UNSUR_4; $total = $total + $detail_lembar_penilaian->UNSUR_4;} ?></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align: middle; text-align: center"></td>
                                            <td>Total</td>
                                            <td style="vertical-align: middle; text-align: center">
                                                <?php echo $total/4; ?>
                                            </td>                                            
                                        </tr>                                        
                                    </tbody>
                                </table>
                        </div>
                    </div>
                    <p>Catatan:<br>
                    A = 100 – 81    AB = 80 – 71    B = 70 – 66    BC = 61 – 65    C = 56 – 60</p><br>
                    <div class="pull-right text-center">
                        <p>Surabaya, <?php echo date("j F Y"); ?><br>
                        Dosen <?php echo $tipe; ?>,</p>
                        <br>
                        <br>
                        <p style="margin-bottom: 60px">(<?php echo $nama_dosen; ?>)</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row hidden-print" style="position: fixed; bottom: 0px; width: 100%; padding: 30px;">
            
            <div class="col-md-8 col-md-offset-2">       
                <?php if($this->session->userdata['type']=='dosen'&& $nip_dosen == $this->session->userdata['nip']){  ?>
                <input type="submit" value="Simpan" class="btn btn-primary" id="simpan" onclick="document.forms["form-penilaian"].submit();">
                        <?php }?>
                <!-- <button type="button" class="btn btn-primary" onclick="document.forms["form-penilaian"].submit();">Simpan</button> -->
                <button type="button" class="btn btn-default" onclick="printDiv();">Cetak</button>
                
            </div>
           
        </div>
        </form>
    </body>
    <script>
        function printDiv() {
            window.print();
        }
        function updateNilai(id, nilai) {
            var namaField = "value"+id;
            document.getElementById(namaField).innerHTML = nilai;
        }
    </script>
</html>