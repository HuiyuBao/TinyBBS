<?php
$inputu = $_POST["user_ID"];
$inputn = $_POST["nickname"];
$inputd = $_POST["birthdate"];
$inputp = $_POST["password"];
$inputg = $_POST["gender"];
$inputa = $_POST["age"];
$inpute = $_POST["email"];

$dbhost = 'localhost:3306';  // mysql服务器主机地址
$dbuser = 'root';            // mysql用户名
$dbpass = 'password';          // mysql用户名密码
$dbdb = 'forum';

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbdb);
if(! $conn )
{
    die('Could not connect: ' . mysqli_error($conn));
}

if(strpos($inputu,';'))
{
    die("invalid user_ID");
}
$sql1 = "select * from user where user_ID='$inputu'";
$retval = mysqli_query($conn,$sql1);
if(mysqli_num_rows($retval) > 0)
{
    die("This user_ID has been used!");
}

$time = date('Y-m-d H:i:s');
$sql = "insert into user values('$inputu','$inputn','$inputd','$inputp','$inputg','$inputa','$inpute',0,'$time',0);";
mysqli_query($conn,$sql);

mysqli_close($conn);

echo "<meta http-equiv='refresh' content='0.2;url=index.html'>";

?>