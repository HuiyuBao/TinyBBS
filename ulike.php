<?php
$reply_ID = $_GET["reply_ID"];
$post_ID = $_GET["post_ID"];
$user_ID = $_COOKIE["user_ID"];

$dbhost = 'localhost:3306';  // mysql服务器主机地址
$dbuser = 'root';            // mysql用户名
$dbpass = 'password';          // mysql用户名密码
$dbdb = 'forum';

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbdb);
if(! $conn )
{
    die('Could not connect: ' . mysqli_error($conn));
}

$quexre = "select * from reply where reply_ID=$reply_ID and is_delete=0";
$reexre = mysqli_query($conn,$quexre);
if(mysqli_num_rows($reexre)==0)die("no such reply!");

$quli = "select * from ulike where user_ID='$user_ID' and reply_ID=$reply_ID";
$reli = mysqli_query($conn,$quli);
if(mysqli_num_rows($reli)!=0)die("You have praised this reply!");

$inli = "insert into ulike values($reply_ID,'$user_ID')";
mysqli_query($conn,$inli);

$upre = "update reply set reply_like = reply_like + 1 where reply_ID = $reply_ID";
mysqli_query($conn,$upre);

mysqli_close($conn);

echo "<meta http-equiv='refresh' content='0.1;url=post.php?post_ID=".$post_ID."'>";

?>