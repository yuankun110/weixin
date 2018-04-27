<?php

echo "test sinacloud";die;

header("Content-type:text/html;charset=utf-8");
/*
$host = "w.rdc.sae.sina.com.cn:3307";
$user = "4y12ymzz10";
$passwd = "3x024ji2124h3z4y3yxh5w1y0wz52lyi553j5533";
$dbname = "app_2016";


$conn = mysql_connect($host, $user, $passwd);

mysql_select_db($dbname);

$list = array();
$sql = "SELECT * FROM pre_test";
$result = mysql_query($sql);
if($result && mysql_num_rows($result)){
    while($row=mysql_fetch_assoc($result)){
        $list[] = $row;
    }
}

mysql_close();


print_r($list);

*/

$host = "nhphmegdajms.rds.sae.sina.com.cn:10282";
$user = "user1";
$passwd = "654123";
$dbname = "futureinfo";


$conn = mysql_connect($host, $user, $passwd);

mysql_select_db($dbname);

$list = array();
$sql = "SELECT * FROM pre_article2";
$result = mysql_query($sql);
if($result && mysql_num_rows($result)){
    while($row=mysql_fetch_assoc($result)){
        $list[] = $row;
    }
}

mysql_close();


print_r($list);