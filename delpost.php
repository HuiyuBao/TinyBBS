<?php
$post_ID = $_GET["post_ID"];

$dbhost = 'localhost:3306';  // mysql服务器主机地址
$dbuser = 'root';            // mysql用户名
$dbpass = 'password';          // mysql用户名密码
$dbdb = 'forum';

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbdb);
if(! $conn )
{
    die('Could not connect: ' . mysqli_error($conn));
}

$sqldp = "update post set is_delete = 1 where post_ID=$post_ID";
mysqli_query($conn,$sqldp);

$sqlre = "update reply set is_delete = 1 where post_ID=$post_ID";
mysqli_query($conn,$sqlre);

$sqlse = "select section_ID from belong where post_ID=$post_ID";
$rese = mysqli_query($conn,$sqlse);
$row = mysqli_fetch_array($rese,MYSQLI_ASSOC);

mysqli_close($conn);

echo "<meta http-equiv='refresh' content='0.2;url=section.php?section_ID=".$row["section_ID"]."'>";

?>