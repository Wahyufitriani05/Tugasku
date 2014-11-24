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
    </head>
    <body style="overflow-x: hidden">
        <div class="container">
            <div class="row" id="cetak">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <h2 class="text-center"><strong>EVALUASI NILAI BIMBINGAN<br>TUGAS AKHIR</strong></h2>
                    <p>Evaluasi Nilai Bimbingan TUGAS AKHIR bagi mahasiswa berikut :</p>
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
                            <form id="form-penilaian" method="post" action="<?php echo $this->uri->uri_string(); ?>">
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
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align: middle; text-align: center">II</td>
                                            <td>PENGUASAAN MATERI<br>(Ketepatan Menjawab Pertanyaan)</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align: middle; text-align: center">III</td>
                                            <td>KEMAMPUAN PRESENTASI<br>(Komunikasi, Pengendalian Waktu, Penyajian)</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align: middle; text-align: center">IV</td>
                                            <td>TATA TULIS BUKU TUGAS AKHIR dan POMITS<br>(Format,Typo, Referensi, Tabel/Gambar, Kelengkapan)</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td style="vertical-align: middle; text-align: center">TOTAL  = (I + II + III + IV) / 4</td>
                                            <td><br><xsall br><small cr><mdall>*diisi oleh Koord.TA</xsall TA</small cA</mdall></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                    <p>Catatan:<br>
                    A = 100 – 81    AB = 80 – 71    B = 70 – 66    BC = 61 – 65    C = 56 – 60</p>
                    <p class="text-right">Surabaya, <?php echo date("j F Y"); ?></p>
                    <p class="text-right">Dosen Pembimbing,</p>
                    <br>
                    <br>
                    <p class="text-right" style="margin-bottom: 60px">(Nama Dosen)</p>
                </div>
            </div>
        </div>
        <div class="row" style="position: fixed; bottom: 0px; width: 100%; padding: 30px;">
            <div class="col-md-8 col-md-offset-2">
                <input type="submit" value="Simpan" class="btn btn-primary" id="simpan" onclick="document.forms["filter-form"].submit();">
                <button type="button" class="btn btn-default" onclick="printDiv();">Cetak</button>
            </div>
        </div>
    </body>
    <script>
    function printDiv() {
          var printContents = document.getElementById("cetak").innerHTML;     
       var originalContents = document.body.innerHTML;       
       document.body.innerHTML = printContents;      
       window.print();      
       document.body.innerHTML = originalContents;
       }
    </script>
</html>