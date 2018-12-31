<?php
$section_ID = $_GET["section_ID"];

$dbhost = 'localhost:3306';  // mysql服务器主机地址
$dbuser = 'root';            // mysql用户名
$dbpass = 'password';          // mysql用户名密码
$dbdb = 'forum';

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbdb);
if(! $conn )
{
    die('Could not connect: ' . mysqli_error($conn));
}

$sql = "with T(post_ID,mtime) as (select post.post_ID,max(reply_time-post.time) 
              as mtime from post natural join reply natural join belong
                 where section_ID=".$section_ID." group by post_ID) select post_ID from T 
                     where mtime = (select max(mtime) from T);";
$retvl = mysqli_query($conn,$sql);
$pos = mysqli_fetch_array($retvl,MYSQLI_ASSOC);

$sqlna = "select title from post where post_ID=".$pos["post_ID"];
$retna = mysqli_query($conn,$sqlna);
$na = mysqli_fetch_array($retna,MYSQLI_ASSOC);

echo "<h4>热度最高贴：</h4>";
echo "<p><a href=post.php?post_ID=".$pos["post_ID"].">".$na["title"]."</a></p><br>";

echo "<h5>回复了该贴的用户昵称：</h5>";
$sqlre = "select distinct user_ID from reply where post_ID=".$pos["post_ID"];
$rere = mysqli_query($conn,$sqlre);
echo "<ul>";
while($rrow = mysqli_fetch_array($rere,MYSQLI_ASSOC))
{
     $sqlni = "select nickname from user where user_ID='".$rrow["user_ID"]."'";
     $reni = mysqli_query($conn,$sqlni);
     $row = mysqli_fetch_array($reni,MYSQLI_ASSOC);
     echo "<li>".$row["nickname"]."</li>";
}
echo "</ul>";

mysqli_close($conn);
?>