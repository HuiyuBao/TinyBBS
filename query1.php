<?php
$dbhost = 'localhost:3306';  // mysql服务器主机地址
$dbuser = 'root';            // mysql用户名
$dbpass = 'password';          // mysql用户名密码
$dbdb = 'forum';

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbdb);
if(! $conn )
{
    die('Could not connect: ' . mysqli_error($conn));
}

$clsql = "select post_ID,title,click_num from post where is_delete=0 order by click_num desc limit 10";
$recl = mysqli_query($conn,$clsql);
echo "<h3>点击数前十：</h3>";
echo "<ol>";
while($row = mysqli_fetch_array($recl,MYSQLI_ASSOC))
{
    echo "<li><a href=post.php?post_ID=".$row["post_ID"].">".$row["title"]."</a>&nbsp&nbsp点击数：".$row["click_num"]."</li>";
}
echo "</ol>";


$resql = "select post_ID,title,reply_num from post where is_delete=0 order by reply_num desc limit 10";
$rere = mysqli_query($conn,$resql);
echo "<h3>回复数前十：</h3>";
echo "<ol>";
while($row = mysqli_fetch_array($rere,MYSQLI_ASSOC))
{
    echo "<li><a href=post.php?post_ID=".$row["post_ID"].">".$row["title"]."</a>&nbsp&nbsp回复数：".$row["reply_num"]."</li>";
}
echo "</ol>";

?>