<hr class="style-four">
<div class="row">
    <div class="col-md-6 col-md-6 col-sm-6">
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
            function get_temp_element() {
                $.post( "ajax/temp/get_temp.php?last=true", function( data ) {
                    temp = data;
                });
            }       
            
            function draw_temp_graph(){
                var tempGauge = new JustGage({
                    id: "tempGauge", 
                    value: <?php echo $result; ?>, 
                    min: -15,
                    max: 100,
                    title: "Live Temperature",
                    label: "Temp",    
                    gaugeWidthScale: 0.2          
                });
                
                setInterval(function() {
                    tempGauge.refresh(temp);
                    }, 5000); 
            }
            setInterval(get_temp_element,10000); 
        </script>

    <div class="col-md-6 col-md-6 col-sm-6">
        <div class="box  box-stat">
            <div class="box-body">
                <div style="display: block;">
                    <h4><small class="pull-right"> Statistic</small></h4>
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
</div>

<script>
    function get_day_temp_stat(){
        $.ajax({
            url: 'ajax/temp/get_day_stat.php',
            type: 'POST',
            data: {name: 'test'},
            dataType: 'html',
            success: function(data){
                //data string format
                //min,min_time,max,temp_max_time,average
                var vals = data.split(",");
                console.log(vals[0]);
                console.log("min time " + vals[1]);
                console.log(vals[2]);
                console.log(vals[3]);
                console.log(vals[4]);
                document.getElementById("min_temp").innerHTML = vals[0]+"&deg c";
                document.getElementById("temp_min_time").innerHTML = vals[1];
                document.getElementById("max_temp").innerHTML = vals[2]+"&deg c";
                document.getElementById("temp_max_time").innerHTML = vals[3];
                document.getElementById("ave_temp").innerHTML = vals[4]+"&deg c";
                },error: function (xhr, ajaxOptions, thrownError) {alert("ERROR:" + xhr.responseText+" - "+thrownError);}
        });
    }
        
    
	// Execute every 5 seconds
    window.setInterval(get_day_temp_stat, 1000);
    window.onload = function() {
        get_temp_element();
        draw_temp_graph();
        get_day_temp_stat();
    };
</script>











