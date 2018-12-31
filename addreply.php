<?php
$inputc = $_POST["context"];
$inputc = addslashes($inputc);
$post_ID = $_POST["post_ID"];
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

$upporenu = "update post set reply_num = reply_num + 1 where post_ID=".$post_ID.";";
mysqli_query($conn,$upporenu);
# post回复数加1

$old = "select reply_num as numreply from post where post_ID=".$post_ID.";";
$numre = mysqli_query($conn,$old);

while($row = mysqli_fetch_array($numre,MYSQLI_ASSOC))
{
    $floor = $row["numreply"];
}
$time = date('Y-m-d H:i:s');

$inre = "insert into reply (post_ID,floor,user_ID,reply_context,reply_time,reply_like) values(".$post_ID.",".$floor.",'".$user_ID."','".$inputc."','".$time."',0);";
mysqli_query($conn,$inre);

$que = "select max(reply_ID) as reply_ID from reply;";
$revl = mysqli_query($conn,$que);

while($row = mysqli_fetch_array($revl,MYSQLI_ASSOC))
{
    $tmp = $row["reply_ID"];
    $inaf = "insert into affiliate values(".$post_ID.",".$tmp.");";
    mysqli_query($conn,$inaf);
}
mysqli_close($conn);

echo "<meta http-equiv='refresh' content='0.1;url=post.php?post_ID=$post_ID'>";

?>