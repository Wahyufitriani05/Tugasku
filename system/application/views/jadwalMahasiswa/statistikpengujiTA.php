<?php echo $this->lib_js->chart(); ?>
<div style="width:95%; margin: 20px;">
    <div>
        <canvas id="canvas" height="100"></canvas>
    </div>
</div>
<script>
        var randomScalingFactor = function(){ return Math.round(Math.random()*100)};
        var lineChartData = {
            labels : [<?php foreach ($pengujiTA as $row) { echo "\"".$row[$filter]." \","; } ?>],
            datasets : [
                {
                    label: <?php echo "\"Pembimbing TA\""; ?>,
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

    window.onload = function(){
        var ctx = document.getElementById("canvas").getContext("2d");
        window.myLine = new Chart(ctx).Bar(lineChartData, {
            responsive: true
        });
    }


    </script>