<hr class="style-four">
<div class="row">
    <div class="col-md-6 col-md-6 col-sm-6">
        <div id="humGauge" class="gauge float-right"></div>
    </div>
    <?php
    // GET LAST HUMIDITY
    $query = "SELECT value FROM humidity ORDER BY ID DESC LIMIT 1;";
    $result = mysqli_query($con, $query);
    $result = mysqli_fetch_assoc($result);
    $result = $result['value'];
    ?>
    <script>
        var humidity = 0;
        function get_hum_element() {
            $.post("ajax/hum/get_hum.php?last=true", function (data) {
                humidity = data;
            });
        }

        function draw_hum_graph() {
            var humGauge = new JustGage({
                id: "humGauge",
                value: <?php echo $result; ?>,
                min: -15,
                max: 100,
                title: "Live Humidity",
                label: "%",
                gaugeWidthScale: 0.2
            });

            setInterval(function () {
                humGauge.refresh(humidity);
            }, 5000);
        }
        setInterval(get_hum_element, 10000);
    </script>

    <div class="col-md-6 col-md-6 col-sm-6">
        <div class="box  box-stat">
            <div class="box-body">
                <div style="display: block;">
                    <h4>
                        <small class="pull-right"> Statistic</small>
                    </h4>
                    <table class="table table-condensed">
                        <tbody>
                        <tr>
                            <td><span class="glyphicon glyphicon-certificate" aria-hidden="true"></span> &nbsp;Max</td>
                            <td id="max_hum"></td>
                            <td id="hum_max_time"></td>
                        </tr>
                        <tr>
                            <td><span class="glyphicon glyphicon-cloud" aria-hidden="true"></span> &nbsp;Min</td>
                            <td id="min_hum"></td>
                            <td id="hum_min_time"></td>
                        </tr>
                        <tr>
                            <td><span class="glyphicon glyphicon-globe" aria-hidden="true"></span> &nbsp;Average</td>
                            <td id="ave_hum"></td>
                            <td>Today</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<hr class="style-four">

<div class="spacer"></div>

<script>
    function get_day_hum_stat() {
        $.ajax({
            url: 'ajax/hum/get_day_stat.php',
            type: 'POST',
            data: {name: 'test'},
            dataType: 'html',
            success: function (data) {
                //data string format
                //min,hum_min_time,max,hum_max_time,average
                var vals = data.split(",");
                console.log(vals[0]);
                console.log(vals[1]);
                console.log(vals[2]);
                console.log(vals[3]);
                console.log(vals[4]);
                document.getElementById("min_hum").innerHTML = vals[0] + "%";
                document.getElementById("hum_min_time").innerHTML = vals[1];
                document.getElementById("max_hum").innerHTML = vals[2] + "%";
                document.getElementById("hum_max_time").innerHTML = vals[3];
                document.getElementById("ave_hum").innerHTML = vals[4] + "%";
            }, error: function (xhr, ajaxOptions, thrownError) {
                alert("ERROR:" + xhr.responseText + " - " + thrownError);
            }
        });
    }


    // Execute every 5 seconds
    window.setInterval(get_day_hum_stat, 1000);
    window.onload = function () {
        console.log("Onload");
        get_hum_element();
        draw_hum_graph();
        get_day_hum_stat();
    };
</script>











