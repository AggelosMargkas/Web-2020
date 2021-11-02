<?php
$con = mysqli_connect('localhost', 'root', '') or die(mysqli_connect_errno());

mysqli_select_db($con, 'web');

$q1 ="SELECT DISTINCT `REQ_isp` AS ISP FROM `requestdata` WHERE `REQ_isp` IS NOT NULL";
$res = mysqli_query($con, $q1);

$fetchData = mysqli_fetch_all($res, MYSQLI_ASSOC);

$createTable = '<select name="isps" onchange=trigerData_b(value)>';
$createTable .= '<option value="">--Select ISP-- </option>';
$createTable .= '<option value="">All ISPs</option>';


foreach($fetchData as $paroxoi)
    {

        $createTable .= '<option value="'.$paroxoi['ISP'].'">'.$paroxoi['ISP'].'</option>';
   
    }

    $createTable .= '</select>';

echo $createTable;
mysqli_close($con);

?>