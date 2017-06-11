<div id="sidebar-wrapper">  
    <div class="user-panel">
        <div class="image pull-left">
            <a href=""><img src="../base/img/rocket.jpg" class="img-circle" alt="User Image"></a>
        </div>
        <div class="slogan pull-right">
            <h3 class="pull-left">Arduino</h3>
            <br>
            <h5 class="pull-left">Monitoring Systems</h5>
        </div>
    </div>
    <ul class="sidebar-nav">
        <?php
            echo "<li>";
            echo '<a href="../dashboard/index.php?mod=in"><span class="glyphicon glyphicon-cd"></span>&nbsp; Dashboard</a>';
            echo '<a href="../config/index.php?mod=base&menu=db"><span class="glyphicon glyphicon-cd"></span>&nbsp; Database</a>';
            echo "</li>";
            // FOR BASE MODULE STATIC MENU
            if($module == "base" && $_SESSION['username']=="admin"){
                echo "<li>";
                    echo "<h3>CONFIGURATION</h3>";
                echo "</li>";
                echo "<li "; if($module == "base" && ($menu=="db"|| $menu==null)) echo 'id="active"'; echo '>';
                    echo '<a href="../config/index.php?mod=base&menu=db"><span class="glyphicon glyphicon-cd"></span>&nbsp; Database</a>';
                echo "</li>";
            }
            if($con && $module == "base" && $_SESSION['username']=="admin"){
                echo "<li "; if($module == "base" && $menu=="tbl") echo 'id="active"'; echo '>';
                    echo '<a href="../config/index.php?mod=base&menu=tbl"><span class="glyphicon glyphicon-th-list"></span>&nbsp; Tables</a>';
                echo "</li>";
                echo "<li "; if($module == "base" && $menu=="usr") echo 'id="active"'; echo '>';
                    echo '<a href="../config/index.php?mod=base&menu=usr"><span class="glyphicon glyphicon-user"></span>&nbsp; Users</a>';
                echo "</li>";
                echo "<li "; if($module == "base" && $menu=="gr") echo 'id="active"'; echo '>';
                    echo '<a href="../config/index.php?mod=base&menu=gr"><span class="glyphicon glyphicon-tower"></span>&nbsp; Groups</a>';
                echo "</li>";
                echo "<li "; if($module == "base" && $menu=="mo") echo 'id="active"'; echo '>';
                    echo '<a href="../config/index.php?mod=base&menu=mo"><span class="glyphicon glyphicon glyphicon-th-large"></span>&nbsp; Modules</a>';
                echo "</li>";
                echo "<li "; if($module == "base" && $menu=="me") echo 'id="active"'; echo '>';
                    echo '<a href="../config/index.php?mod=base&menu=me"><span class="glyphicon glyphicon glyphicon-list-alt"></span>&nbsp; Menu</a>';
                echo "</li>";
                echo "<li>";
                    echo "<h3>ARDUINO</h3>";
                echo "</li>";
                echo "<li "; if($module == "base" && $menu=="sw") echo 'id="active"'; echo '>';
                    echo '<a href="../config/index.php?mod=base&menu=sw"><span class="glyphicon glyphicon glyphicon-sort"></span>&nbsp; Switches</a>';
                echo "</li>";
                echo "<li "; if($module == "base" && $menu=="ar") echo 'id="active"'; echo '>';
                    echo '<a href="../config/index.php?mod=base&menu=ar"><span class="glyphicon glyphicon glyphicon-send"></span>&nbsp; Arduino IP</a>';
                echo "</li>";
                echo "<li "; if($module == "base" && $menu=="log") echo 'id="active"'; echo '>';
                    echo '<a href="../config/index.php?mod=base&menu=log"><span class="glyphicon glyphicon glyphicon-time"></span>&nbsp; Logs</a>';
                echo "</li>";
                echo "<li>";
                    echo "<h3>DOCUMENTATION</h3>";
                echo "</li>";
                echo "<li "; if($module == "base" && $menu=="doc") echo 'id="active"'; echo '>';
                    echo '<a href="../config/index.php?mod=base&menu=doc"><span class="glyphicon glyphicon glyphicon-book"></span>&nbsp; Documentation</a>';
                echo "</li>";
                
            }
            if(($module=="base" && isset($_GET['menu']) || isset($_GET['user'])) && $_SESSION['username']!='admin'){
                    echo "<li "; if($module == "base" && isset($_GET['menu']) || isset($_GET['user'])) echo 'id="active"'; echo '>';
                    echo '<a href="../config/profile.php?mod=base&menu=prof"><span class="glyphicon glyphicon-user"></span>&nbsp; Profile</a>';
                }
            
        ?>
        <?php
            // DYNAMIC MENU
            if($con && $module != "base"){
                echo "<li>";
                    echo "<h3>DASHBOARD</h3>";
                echo "</li>";
                echo "<li ";
                if($module == "in") echo 'id="active"';
                echo ">";
                echo '<a href="/webPHP1/dashboard/index.php?mod=in">IN</a>';
                echo "</li>";
                echo "<li ";
                if($module == "out") echo 'id="active"';
                echo ">";
                echo '<a href="/webPHP1/dashboard/index.php?mod=out">OUT</a>';
                echo "</li>";
            }
        ?>
    </ul>
</div>