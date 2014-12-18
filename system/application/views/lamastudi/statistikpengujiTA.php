<?php echo $this->lib_js->chartNew(); ?>
<div style="width:95%; margin: 20px;">
    <div>
        <canvas id="canvas" height="100"></canvas>
    </div>
</div>

<script>
        var tahun = <?php echo json_encode($filter_tahun)?>;
        var tipe = <?php echo json_encode($filter_tipe)?>;
        if(tipe==false) tipe = 'pembimbing';
        
        var lineChartData = {
            labels : [<?php foreach ($pengujiTA as $row) { echo "\"".$row[$filter]." \","; } ?>],
            datasets : [
                {
                    label: <?php echo "\"Penguji TA\""; ?>,
                    fillColor : "rgba(220,220,220,0.2)",
                    strokeColor : "rgba(220,220,220,1)",
                    pointColor : "rgba(220,220,220,1)",
                    pointStrokeColor : "#fff",
                    pointHighlightFill : "#fff",
                    pointHighlightStroke : "rgba(220,220,220,1)",
                    data : [<?php foreach ($pengujiTA as $row) { echo $row['jumlah_penguji'].","; } ?>]
                }
            ]

        }

        function fctMouseDownLeft(event,ctx,config,data,other)
        {
  
            if(other != null)
                window.open("<?php echo base_url().'index.php/lamastudi/detailMahasiswa?nama=';?>"+data.labels[other.v12]+"&tahun="+tahun+"&tipe="+tipe);
                //window.alert("["+data.labels[other.v12]+","+data.datasets[other.v11].data[other.v12]+"]");
            //else window.alert("Data yang ");
        }
        
        var startWithDataset =1;
        var startWithData =1;

        var opt1 = {
                responsive: true,
              animationStartWithDataset : startWithDataset,
              animationStartWithData : startWithData,
              animationSteps : 100,

              legend : true,
              yAxisMinimumInterval : 5,
              annotateDisplay : true,
              graphTitleFontSize: 18,
              annotateLabel: "<%= v2 + ' : ' + v3%>",
              mouseDownLeft : fctMouseDownLeft

        }

    window.onload = function(){
        var ctx = document.getElementById("canvas").getContext("2d");
        window.myLine = new Chart(ctx).Bar(lineChartData,opt1
        );  
    }



    </script>