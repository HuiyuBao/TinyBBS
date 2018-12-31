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
$sql1 = "select post.post_ID from post natural join belong 
             where post.click_num >= (select avg(click_num) from post) 
                and section_ID = ".$section_ID.";";
$revl = mysqli_query($conn,$sql1);

echo "<h3>点击数大于平均点击数的帖子：</h3>";
echo "<ul>";
while($rrow = mysqli_fetch_array($revl,MYSQLI_ASSOC))
{
      $post_ID = $rrow["post_ID"];
      $sqlna = "select title from post where post_ID=".$post_ID;
      $retna = mysqli_query($conn,$sqlna);
      $na = mysqli_fetch_array($retna,MYSQLI_ASSOC);
      echo "<li><a href=post.php?post_ID=".$post_ID.">".$na["title"]."</a></li>";
}
echo "</ul><br>";

$sql2 = "with T(user_ID,coreply) as (select user_ID,count(reply_ID) from reply 
            where post_ID in (select post_ID from belong where section_ID = ".$section_ID.") 
                group by user_ID) select user_ID from T 
                   where coreply > (select avg(coreply) from T);";
$revl2 = mysqli_query($conn,$sql2);

echo "<h3>回复数大于平均回复数的用户：</h3>";
echo "<ul>";
while($rrow = mysqli_fetch_array($revl2,MYSQLI_ASSOC))
{
     echo "<li>".$rrow["user_ID"]."</li>";
}
echo "</ul>";

mysqli_close($conn);
?>