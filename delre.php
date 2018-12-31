<?php
$reply_ID = $_GET["reply_ID"];

$dbhost = 'localhost:3306';  // mysql服务器主机地址
$dbuser = 'root';            // mysql用户名
$dbpass = 'password';          // mysql用户名密码
$dbdb = 'forum';

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbdb);
if(! $conn )
{
    die('Could not connect: ' . mysqli_error($conn));
}

$sql = "update reply set is_delete=1 where reply_ID=$reply_ID";
mysqli_query($conn,$sql);

$sql2 = "select post_ID from affiliate where reply_ID=$reply_ID";
$revl = mysqli_query($conn,$sql2);
$row = mysqli_fetch_array($revl,MYSQLI_ASSOC);
$post_ID = $row["post_ID"];

mysqli_close($conn);

echo "<meta http-equiv='refresh' content='0.2;url=post.php?post_ID=".$post_ID."'>";

?>