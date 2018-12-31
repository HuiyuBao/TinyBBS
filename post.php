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

$sql = "select * from post where post_ID=$post_ID and is_delete = 0";
$pode = mysqli_query($conn,$sql);
if(mysqli_num_rows($pode) == 0)die("no such post!");


if(!strpos($_SERVER["HTTP_REFERER"],"addreply.php")&&!strpos($_SERVER["HTTP_REFERER"],"ulike.php"))
{
    $upclnu = "update post set click_num = click_num + 1 where post_ID=$post_ID";
    mysqli_query($conn,$upclnu);
}

$seer = "select sectioner from belong natural join section where post_ID=$post_ID";

$reer = mysqli_query($conn,$seer);
$seerid = mysqli_fetch_array($reer,MYSQLI_ASSOC);
$candlt = $_COOKIE["level"]==2 || $_COOKIE["user_ID"]==$seerid["sectioner"];

if($candlt)
{
    echo "<a href=delpost.php?post_ID=$post_ID>删除该帖</a><br>";
}
if($_COOKIE["level"]==2)
{
    echo "<a href=chanpost.html?post_ID=$post_ID>修改帖子</a><br>";
}

while($row = mysqli_fetch_array($pode,MYSQLI_ASSOC))
{
     echo '<h2>',$row["title"],'</h2>';
     $sqlse = "select user_ID from send where post_ID=$post_ID";
     $rese = mysqli_query($conn,$sqlse);
     $ele = mysqli_fetch_array($rese,MYSQLI_ASSOC);
     echo '<h3>发帖人：',$ele["user_ID"],'</h3>';
     echo '<p>',$row["time"],'</p>';
     echo '<h5>点击数：',$row["click_num"],'</h5>';
     echo '<p>'.$row["context"].'</p>';
     echo '<h4>回复：</h4>';
     $sqlre = "select * from reply where post_ID=$post_ID and is_delete = 0 order by floor asc;";
     $rpvl = mysqli_query($conn,$sqlre);
     while($rrow = mysqli_fetch_array($rpvl,MYSQLI_ASSOC))
     {
          $context = $rrow["reply_context"];
          $floor = $rrow["floor"];
          $user = $rrow["user_ID"];
          $time = $rrow["reply_time"];
          $like = $rrow["reply_like"];
          echo "<p>楼层：".$floor."    回复人：".$user."     回复时间：".$time."       点赞数：".$like."<br>";
          echo $context."</p>";
          echo "<a href=ulike.php?reply_ID=".$rrow["reply_ID"]."&post_ID=".$post_ID.">点赞</a>";
          if($candlt)
          {
              $reid = $rrow["reply_ID"];
              echo "&nbsp&nbsp&nbsp&nbsp <a href=delre.php?reply_ID=$reid>删除该回复</a><br>";
          }
     }
}

echo '<br><br><h6>我要回复：</h6>';

echo '
<form action="/addreply.php" method="post">
    内容：<br>
    <textarea name="context" value="" style="width:400px; height:200px;"></textarea><br>
    <input type="hidden" name="post_ID" value=',$post_ID,'>
    <input type="submit" value="Submit">
</form>
';

mysqli_close($conn);


?>