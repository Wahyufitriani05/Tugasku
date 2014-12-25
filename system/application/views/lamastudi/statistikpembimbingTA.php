<?php echo $this->lib_js->chartNew(); ?>

<div style="width:95%; margin: 20px;">
    <div>
        <canvas id="canvas" height="125" ></canvas>
    </div>
</div>
<script>

        var tahun = <?php echo json_encode($filter_tahun)?>;
        var tipe = <?php echo json_encode($filter_tipe)?>;
        var rmk = <?php echo json_encode($filter_rmk)?>;
        if(tipe==false) tipe = 'pembimbing';
        
        var lineChartData = {
            labels : [<?php foreach ($pembimbingTA as $row) { echo "\"".$row[$filter]." \","; } ?>],
            datasets : [
                {
                    
                    fillColor : "rgba(220,220,220,0.2)",
                    strokeColor : "rgba(220,220,220,1)",
                    pointColor : "rgba(220,220,220,1)",
                    pointStrokeColor : "#fff",
                    pointHighlightFill : "#fff",
                    pointHighlightStroke : "rgba(220,220,220,1)",
                    data : [<?php foreach ($pembimbingTA as $row) { echo $row['jumlah1'].","; } ?>],
                    title : "Pembimbing 1"
                },
                {
                    fillColor : "rgba(151,187,205,0.5)",
                    strokeColor : "rgba(151,187,205,1)",
                    pointColor : "green",
                    pointstrokeColor : "yellow",
                    data : [<?php foreach ($pembimbingTA as $row) { echo $row['jumlah2'].","; } ?>],
                    title : "Pembimbing 2"
		}
             
            ]

        }
        function fctMouseDownLeft(event,ctx,config,data,other)
        {
  
            if(other != null)
                window.location.href = "<?php echo base_url().'index.php/lamastudi/detailMahasiswa?nama=';?>"+data.labels[other.v12]+"&tahun="+tahun+"&tipe="+tipe+"&rmk="+rmk;
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
              annotateLabel: "<%=v2 + ' : ' + v3 + ' ('+v1+')'%>",
              mouseDownLeft : fctMouseDownLeft

        }

    window.onload = function(){
        var ctx = document.getElementById("canvas").getContext("2d");
        window.myLine = new Chart(ctx).StackedBar(lineChartData,opt1
        );  
    }


    </script>