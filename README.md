一个课程大作业
是一个小论坛，后端php连接mysql实现


main.html是首页面，要求登陆或者注册
login.php验证登陆
register.html注册页面，数据发送给adduser.php
adduser.php在数据库中增加用户
main.php显示所有的板块
section.php显示板块内容
post.php显示帖子内容
板块页面可以发帖，发的帖子可以通过addpost.php加入数据库
显示帖子页面可以回复，回复通过addreply.php加入数据库
回复可以点赞，通过ulike.php修改数据库对应信息
query.html是查询主页面
query[1-5].php对应5个查询
userinfo.php返回XML文档形式的用户信息
管理员通过deluser.php删除用户
delpost.php可以删除帖子
chanpost.php可以修改帖子内容
delreply.php可以删除回复
