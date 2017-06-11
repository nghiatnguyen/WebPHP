<?php
/**
 * Created by PhpStorm.
 * User: TRONGNGHIA
 * Date: 6/11/2017
 * Time: 8:43 PM
 */
include_once '../../../base/includes/db.php';
$today = date("Y-m-d");
$temps = '[';
for ($i = 6; $i >= 0; $i--) {
    $start = date("Y-m-d 00:00:00", strtotime($today . ' -' . $i . ' days'));
    $end = date("Y-m-d 23:59:59", strtotime($today . ' -' . $i . ' days'));

    // GET AVERAGE
    $query = "SELECT AVG(value) AS ave FROM temperature WHERE date BETWEEN '{$start}' AND '{$end}'";
    $result = mysqli_query($con, $query);
    $get = mysqli_fetch_assoc($result);
    $ave = $get['ave'];
    $ave = number_format($ave, 2);
    $temps = $temps.''.$ave.',';
}
$temps[strlen($temps) - 1] = ']';
echo $temps;
?>