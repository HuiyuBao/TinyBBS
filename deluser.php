<?php
$user_ID = $_GET["user_ID"];

$dbhost = 'localhost:3306';  // mysql服务器主机地址
$dbuser = 'root';            // mysql用户名
$dbpass = 'password';          // mysql用户名密码
$dbdb = 'forum';

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbdb);
if(! $conn )
{
    die('Could not connect: ' . mysqli_error($conn));
}

$deusql = "update user set is_delete=1 where user_ID=$user_ID";
mysqli_query($conn,$deusql);

mysqli_close($conn);

echo "<meta http-equiv='refresh' content='0.2;url=main.html'>";

?>