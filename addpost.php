<?php
$inputt = $_POST["title"];
$inputt = addslashes($inputt);
$inputc = $_POST["context"];
$inputc = addslashes($inputc);
$inputs = $_POST["section_ID"];
$inputs = addslashes($inputs);
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

$time = date('Y-m-d H:i:s');
$sql = "insert into post (title,context,time,click_num,reply_num,is_delete) values('".$inputt."','".$inputc."','$time',0,0,0);";
mysqli_query($conn,$sql);
$que = "select max(post_ID) as post_ID from post;";
$retval = mysqli_query($conn,$que);

while($row = mysqli_fetch_array($retval,MYSQLI_ASSOC))
{
      $tmp = $row['post_ID'];
      $sql1 = "insert into send values('$user_ID',$tmp);";
      $sql2 = "insert into belong values($tmp,$inputs);";
      mysqli_query($conn,$sql1);
      mysqli_query($conn,$sql2);
}

mysqli_close($conn);

echo "<meta http-equiv='refresh' content='0.1;url=section.php?section_ID=$inputs'>";

?>