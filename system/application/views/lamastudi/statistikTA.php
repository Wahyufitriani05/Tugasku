<?php echo $this->lib_js->chart(); ?>
<div style="width:95%; margin: 20px;">
    <div>
        <canvas id="canvas" height="100"></canvas>
    </div>
</div>
<script>
        var randomScalingFactor = function(){ return Math.round(Math.random()*100)};
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
                    data : [<?php foreach ($mahasiswaTA as $row) { echo $row['TOTAL'].","; } ?>]
                }
            ]

        }

    window.onload = function(){
        var ctx = document.getElementById("canvas").getContext("2d");
        window.myLine = new Chart(ctx).Line(lineChartData, {
            responsive: true
        });
    }


    </script>