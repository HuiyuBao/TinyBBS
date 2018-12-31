<?php
$user_ID = $_GET["user_ID"];

$dbhost = 'localhost:3306';  // mysql服务器主机地址
$dbuser = 'root';            // mysql用户名
$dbpass = 'password';          // mysql用户名密码
$dbdb = 'forum';

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbdb);
if(! $conn )
{
    die('Could not connect: ' . mysqli_error($conn));
}

if($_COOKIE["level"] == 2 && $user_ID != $_COOKIE["user_ID"])
{
     echo "<a href=deluser.php?user_ID='$user_ID'>删除该用户</a><br>";
}

$sqluser = "select * from user where user_ID='$user_ID' and is_delete = 0";
$retuser = mysqli_query($conn,$sqluser);
if(mysqli_num_rows($retuser) == 0)die("no such user");

$rowuser = mysqli_fetch_array($retuser,MYSQLI_ASSOC);


$xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><Users/>');
$nowtime = date('Y');
$birtime = date('Y',strtotime($rowuser["birthdate"]));

$user = $xml->addChild("User");
$user->addChild("UserName",$user_ID);
$info = $user->addChild("Info");
    $basinfo = $info->addChild("BasciInfo");
        if($rowuser["gender"])$basinfo->addChild("Gender","男");
        else $basinfo->addChild("Gender","女");
        $basinfo->addChild("age",$nowtime-$birtime);
        $basinfo->addChild("level",$rowuser["level"]);
        $basinfo->addChild("Birthday",$rowuser["birthdate"]);
    $othinfo = $info->addChild("OtherInfo");
        $posts = $othinfo->addChild("Posts");
            $sqlpost = "select post_ID from send where user_ID='$user_ID'";
            $retpost = mysqli_query($conn,$sqlpost);
            while($rrow = mysqli_fetch_array($retpost,MYSQLI_ASSOC))
            {
                $quepo = "select * from post where post_ID=".$rrow["post_ID"]." and is_delete = 0";
                $retpo = mysqli_query($conn,$quepo);
                if(mysqli_num_rows($retpo)==0)continue;
                $row = mysqli_fetch_array($retpo,MYSQLI_ASSOC);

                $post = $posts->addChild("Post");
                $post->addChild("No",$row["post_ID"]);
                $quese = "select name from section where section_ID=(select section_ID from belong where post_ID=".$row['post_ID'].");";
                $retse = mysqli_query($conn,$quese);
                $sename = mysqli_fetch_array($retse,MYSQLI_ASSOC);
                $post->addChild("Block",$sename["name"]);
                $post->addChild("PostUser",$user_ID);
                $post->addChild("Title",$row["title"]);
                $post->addChild("Content",$row["context"]);
                $post->addChild("Clicks",$row["click_num"]);
                $post->addChild("ReplyNum",$row["reply_num"]);
            }
        $replies = $othinfo->addChild("Replies");
            $sqlrep = "select * from reply where user_ID='$user_ID' and is_delete = 0";
            $retrep = mysqli_query($conn,$sqlrep);
            while($row = mysqli_fetch_array($retrep,MYSQLI_ASSOC))
            {
                  $reply = $replies->addChild("Reply");
                  $reply->addChild("OriginalNo",$row["post_ID"]);
                  $reply->addChild("Floor",$row["floor"]);
                  $reply->addChild("ReplyUser",$row["user_ID"]);
                  $reply->addChild("ReplyContent",$row["reply_context"]);
                  $reply->addChild("ReplyTime",$row["reply_time"]);
                  $reply->addChild("PraiseNum",$row["reply_like"]);
            }

echo $xml->asXml();
mysqli_close($conn);

?>