<script>
    function formatDate(date) {
        var day = date.getDate();
        var monthIndex = date.getMonth();
        var year = date.getFullYear();

        return day + '/' + (monthIndex + 1) + '/' + year;
    }
</script>
<hr class="style-four">
<div class="row">
    <div class="col-md-3 col-md-3 col-sm-3">
        <div id="tempGauge" class="gauge float-right"></div>
    </div>
    <?php
    // GET LAST TEMP
    $query = "SELECT value FROM temperature ORDER BY ID DESC LIMIT 1;";
    $result = mysqli_query($con, $query);
    $result = mysqli_fetch_assoc($result);
    $result = $result['value'];
    ?>
    <script>
        var temp = 0;
        var temps_data = [];
        function get_temp_element() {
            $.post("ajax/temp/get_temp.php?last=true", function (data) {
                temp = data;
            });
        }

        function draw_temp_graph() {
            var tempGauge = new JustGage({
                id: "tempGauge",
                value: <?php echo $result; ?>,
                min: -15,
                max: 100,
                title: "Live Temperature",
                label: "Temp",
                gaugeWidthScale: 0.2
            });

            setInterval(function () {
                tempGauge.refresh(temp);
            }, 5000);
        }
        setInterval(get_temp_element, 10000);
    </script>

    <div class="col-md-3 col-md-3 col-sm-3">
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
                            <td id="max_temp"></td>
                            <td id="temp_max_time"></td>
                        </tr>
                        <tr>
                            <td><span class="glyphicon glyphicon-cloud" aria-hidden="true"></span> &nbsp;Min</td>
                            <td id="min_temp"></td>
                            <td id="temp_min_time"></td>
                        </tr>
                        <tr>
                            <td><span class="glyphicon glyphicon-globe" aria-hidden="true"></span> &nbsp;Average</td>
                            <td id="ave_temp"></td>
                            <td>Today</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-md-6 col-sm-6">
        <div class="row">
            <div style="width:100%; padding-left: 20px; padding-right: 20px;">
                <div>
                    <canvas id="canvas-temp" height="75px"></canvas>
                </div>
            </div>

            <script>
                var today = new Date();
                var firstDay = new Date();
                firstDay.setDate(today.getDate() - 7);
                function formatDate(date) {
                    var day = date.getDate();
                    var monthIndex = date.getMonth();
                    var year = date.getFullYear();

                    return day + '/' + (monthIndex + 1) + '/' + year;
                }
                var randomScalingFactor = function () {
                    return Math.round(Math.random() * 100)
                };

                function get_temps_data() {
                    temps_data = [];
                    $.post("ajax/temp/get_avg_temp.php", function (data) {
                        temps_data = JSON.parse(data);
                        var tempChartData = {
                            labels: [formatDate(firstDay), "", "", "", "", "", formatDate(today)],
                            datasets: [
                                {
                                    label: "My Second dataset",
                                    fillColor: "rgba(151,187,205,0.2)",
                                    strokeColor: "rgba(151,187,205,1)",
                                    pointColor: "rgba(151,187,205,1)",
                                    pointStrokeColor: "#fff",
                                    pointHighlightFill: "#fff",
                                    pointHighlightStroke: "rgba(151,187,205,1)",
                                    data: temps_data
                                }
                            ]
                        }
                        var tempCtx = document.getElementById("canvas-temp").getContext("2d");
                        new Chart(tempCtx).Line(tempChartData, {
                            responsive: true
                        });
                    });
                }
            </script>
        </div>
    </div>
</div>

<script>
    function get_day_temp_stat() {
        $.ajax({
            url: 'ajax/temp/get_day_stat.php',
            type: 'POST',
            data: {name: 'test'},
            dataType: 'html',
            success: function (data) {
                //data string format
                //min,min_time,max,temp_max_time,average
                var vals = data.split(",");
                document.getElementById("min_temp").innerHTML = vals[0] + "&deg c";
                document.getElementById("temp_min_time").innerHTML = vals[1];
                document.getElementById("max_temp").innerHTML = vals[2] + "&deg c";
                document.getElementById("temp_max_time").innerHTML = vals[3];
                document.getElementById("ave_temp").innerHTML = vals[4] + "&deg c";
            }, error: function (xhr, ajaxOptions, thrownError) {
                alert("ERROR:" + xhr.responseText + " - " + thrownError);
            }
        });
    }


    // Execute every 5 seconds
    window.setInterval(get_day_temp_stat, 1000);
</script>

<hr class="style-four">
<div class="row">
    <div class="col-md-3 col-md-3 col-sm-3">
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

    <div class="col-md-3 col-md-3 col-sm-3">
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
    <div class="col-md-6 col-md-6 col-sm-6">
        <div class="row">
            <div style="width:100%; padding-left: 20px; padding-right: 20px;">
                <div>
                    <canvas id="canvas-hum" height="75px"></canvas>
                </div>
            </div>

            <script>
                var today = new Date();
                var firstDay = new Date();
                firstDay.setDate(today.getDate() - 6);
                var randomScalingFactor = function () {
                    return Math.round(Math.random() * 100)
                };
                function get_hum_data() {
                    hum_data = [];
                    $.post("ajax/hum/get_avg_hum.php", function (data) {
                        hum_data = JSON.parse(data);
                        var humChartData = {
                            labels: [formatDate(firstDay), "", "", "", "", "", formatDate(today)],
                            datasets: [
                                {
                                    label: "My Second dataset",
                                    fillColor: "rgba(151,187,205,0.2)",
                                    strokeColor: "rgba(151,187,205,1)",
                                    pointColor: "rgba(151,187,205,1)",
                                    pointStrokeColor: "#fff",
                                    pointHighlightFill: "#fff",
                                    pointHighlightStroke: "rgba(151,187,205,1)",
                                    data: hum_data
                                }
                            ]
                        }
                        var humCtx = document.getElementById("canvas-hum").getContext("2d");
                        new Chart(humCtx).Line(humChartData, {
                            responsive: true
                        });
                    });
                }
            </script>
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
</script>

<script>
    window.onload = function () {
        get_hum_element();
        draw_hum_graph();
        get_day_hum_stat();
        get_temp_element();
        draw_temp_graph();
        get_day_temp_stat();

        get_temps_data();
        get_hum_data();
    };
</script>