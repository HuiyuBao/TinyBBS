<?php
$inputu = $_POST["user_ID"];
$inputu = addslashes($inputu);
$inputp = $_POST["password"];
$inputp = addslashes($inputp);

$dbhost = 'localhost:3306';  // mysql服务器主机地址
$dbuser = 'root';            // mysql用户名
$dbpass = 'password';          // mysql用户名密码
$dbdb = 'forum';

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbdb);
if(! $conn )
{
    die('Could not connect: ' . mysqli_error($conn));
}
$sql = "select password,level from user where user_ID = '$inputu' and is_delete = 0";
$retval = mysqli_query($conn,$sql);

if(!$retval)
{
    die('Could not read data:'. mysqli_error($conn));
}

if(mysqli_num_rows($retval) == 0)die('wrong user_ID or password');
else
{
        while($row = mysqli_fetch_array($retval,MYSQLI_ASSOC))
        {
              if($row['password'] != $inputp)die('wrong user_ID or password');
              else
              {
                  setcookie("user_ID",$inputu);
                  setcookie("level",$row['level']);
              }
        }
}
mysqli_close($conn);

echo "<meta http-equiv='refresh' content='0.2;url=main.html'>";

?>