<?php echo $this->lib_js->chart(); ?>
<div style="width:95%; margin: 20px;">
    <div>
        <canvas id="canvas" height="100"></canvas>
        <div id="legend"></div>
    </div>
</div>
<script>
        var lineChartData = {
            labels : [<?php foreach ($mahasiswaTA as $row) { echo "\"".$row['SEMESTER_SIDANG_TA']." ".$row['TAHUN_SIDANG_TA']."\","; } ?>],
            datasets : [
                {
                    label: <?php echo "\"Mahasiswa TA\""; ?>,
                    fillColor : "rgba(220,220,220,0.2)",
                    strokeColor : "rgba(220,220,220,1)",
                    pointColor : "rgba(220,220,220,1)",
                    pointStrokeColor : "#fff",
                    pointHighlightFill : "#fff",
                    pointHighlightStroke : "rgba(220,220,220,1)",
                    data : [<?php for($i = 0; $i<sizeof($mahasiswaTA); $i++) { echo $mahasiswaTA[$i]['TOTAL']; if ($i != sizeof($mahasiswaTA) -1) {echo ",";}} ?>]
                },
                {
                    label: "Mahasiswa TA Lulus",
                    fillColor : "rgba(151,187,205,0.2)",
                    strokeColor : "rgba(151,187,205,1)",
                    pointColor : "rgba(151,187,205,1)",
                    pointStrokeColor : "#fff",
                    pointHighlightFill : "#fff",
                    pointHighlightStroke : "rgba(151,187,205,1)",
                    data : [<?php for($i = 0; $i<sizeof($mahasiswaTALulus); $i++) { echo $mahasiswaTALulus[$i]['TOTAL']; if ($i != sizeof($mahasiswaTALulus) -1) {echo ",";}} ?>]
                }
            ]
        }

    window.onload = function(){
        var ctx = document.getElementById("canvas").getContext("2d");
        window.myLine = new Chart(ctx).Line(lineChartData, {
            responsive: true,
            legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<lineChartData.datasets.length; i++){%><li><span style=\"background-color:<%=lineChartData.datasets[i].strokeColor%>\">&nbsp;&nbsp;&nbsp;&nbsp;</span> = <%if(lineChartData.datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"
        });
        $("#legend").html(myLine.generateLegend());
        console.log(myLine.generateLegend());
    }


    </script>