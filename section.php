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

$sql = "select * from belong where section_ID=$section_ID order by post_ID desc";
$retval = mysqli_query($conn,$sql);

echo "<ol>";
while($row = mysqli_fetch_array($retval,MYSQLI_ASSOC))
{
      $pid = $row['post_ID'];
      $sqlq = "select * from post where post_ID=$pid and is_delete = 0";
      $po = mysqli_query($conn,$sqlq);
      while($rrow = mysqli_fetch_array($po,MYSQLI_ASSOC))
      {
           $ttmp = $rrow["title"];
           echo "<li><a href='post.php?post_ID=$pid'>$ttmp</a></li><br>";
      }
}

echo "</ol>";

echo "<br><br>";
echo "<p4>发帖：</p4><br><br>";

echo '
<form action="/addpost.php" method="post">
    标题：
    <input type="text" name="title" value="" style="width:300px; height:20px;"><br><br>
    内容：<br>
    <textarea name="context" value="" style="width:400px; height:200px;"></textarea><br>
    <input type="hidden" name="section_ID" value=',$section_ID,'>
    <input type="submit" value="Submit">
</form>
';

echo "<p4>板块内查询：</p4><br><br>";
echo "<a href=\"query2.php?section_ID=".$section_ID."\">在此板块发过贴的用户</a><br><br>";
echo "<a href=\"query3.php?section_ID=".$section_ID."\">热度最高贴</a><br><br>";
echo "<a href=\"query4.php?section_ID=".$section_ID."\">点击数大于平均数的帖子，回复数大于平均数的用户</a><br><br>";
?>