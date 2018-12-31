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

$sql1 = "select distinct user_ID from send where post_ID in (select post_ID from belong where section_ID=".$section_ID.");";
$rev1 = mysqli_query($conn,$sql1);

echo "<ul>";
while($rrow = mysqli_fetch_array($rev1,MYSQLI_ASSOC))
{
     $name = $rrow["user_ID"];
     $sqlu = "select gender,birthdate from user where user_ID='$name'";
     $revu = mysqli_query($conn,$sqlu);
     $row = mysqli_fetch_array($revu,MYSQLI_ASSOC);

     echo "<li><h5>".$name."</h5>";
     $nowtime = date('Y');
     $birtime = date('Y',strtotime($row["birthdate"]));
     $pr = $nowtime - $birtime;
     echo "&nbsp&nbsp&nbspGender:";
     if($row["gender"])echo "男";
     else echo "女";
     echo "&nbsp&nbsp&nbsp&nbsp&nbspAge:".$pr;
     echo "</li>";
}
echo "</ul>";

echo "<br><br><h3>按发帖总数排序：</h3>";
$sql2 = "select distinct user_ID from send where post_ID in (select post_ID from belong 
              where section_ID=".$section_ID.")order by (select count(post_ID) from send as asend 
                     where asend.user_ID=send.user_ID) desc;";
$rev2 = mysqli_query($conn,$sql2);
echo "<ol>";
while($row = mysqli_fetch_array($rev2,MYSQLI_ASSOC))
{
    echo "<li>".$row["user_ID"]."</li>";
}
echo "</ol>";

echo "<br><br><h3>按回复总数排序：</h3>";
$sql3 = "select distinct user_ID from send where post_ID in (select post_ID from belong 
                where section_ID=".$section_ID.") order by (select count(reply_ID) from reply 
                   where reply.user_ID = send.user_ID) desc;";
$rev3 = mysqli_query($conn,$sql3);
echo "<ol>";
while($row = mysqli_fetch_array($rev3,MYSQLI_ASSOC))
{
    echo "<li>".$row["user_ID"]."</li>";
}
echo "</ol>";

mysqli_close($conn);
?>