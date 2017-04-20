这个脚本只适用于ubuntu14.04系统，其他系统不要实验。


首先下载最新代码，压缩成auth-server.zip 并且里面的文件必须叫auth-server这个名字，如果不是，请修改。不要使用这个文件中的auth-server.zip代码，这个代码是2015年的，太老了。
之后执行“sudo apt-get update”
然后切换超级用户权限（这一步尤为注意，一定要在root权限下执行）执行installex.sh
这个脚本自动会把mysql的密码设置成123456，如果你之前安装过mysql而且密码不是123456的话请修改成123456。

数据库的访问控制在.env.php这个里面 ，这个里面还有rabbitmq的访问控制；

等脚本跑完了脚本之后，在rabbitmq上创建用户名iscas密码是iscas321，当然你也可以随意设置用户名，只要保证.env.php这里面的和你的配置是一样的就行了。
关于rabbitmq的设置，可以问我，这个无法用语言说出来。我可以给你演示一下。


执行脚本的时候会显示fail，不用管它，只要不是脚本中断都算正确。脚本执行到最后会显示success

启动这个服务的方法就是，apachectl start命令。如果开机的时候自动启动了apache（用ps -A| grep apache查看）用kill杀掉之后再用apachectl start启动

启动apache之后，启动mysql和rabbitmq-server 用service mysql start        service rabbitmq-server start这两个命令启动  然后打开网页https://127.0.0.1就可以了。