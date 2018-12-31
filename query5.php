<?php
$seca = $_POST["secA"];
$secb = $_POST["secB"];

$dbhost = 'localhost:3306';  // mysql服务器主机地址
$dbuser = 'root';            // mysql用户名
$dbpass = 'password';          // mysql用户名密码
$dbdb = 'forum';

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbdb);
if(! $conn )
{
    die('Could not connect: ' . mysqli_error($conn));
}

$sql = "select distinct user_ID from send where (select count(post_ID) from send as asend
           where asend.user_ID=send.user_ID and post_ID in (select post_ID from belong where section_ID=".$seca.")) 
             > (select count(post_ID) from send as bsend where bsend.user_ID=send.user_ID 
                and post_ID in (select post_ID from belong where section_ID=".$secb."))";

$revl = mysqli_query($conn,$sql);

echo "<ul>";
while($row = mysqli_fetch_array($revl,MYSQLI_ASSOC))
{
    echo "<li>".$row["user_ID"]."</li>";
}
echo "</ul>";
mysqli_close($conn);

?>