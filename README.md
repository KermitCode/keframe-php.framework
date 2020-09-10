# keframe-php.framework
一个简单的PHP框架（By kermit）


1，程序文件夹中包含了demo网站：即 http://www.04007.cn 的源代码（此网站用的此框架）<br>
2，下载后请导入SQL文件入Mysql数据库，修改application/config/dbconfig.php 中的MYSQL连接配置<br>
3，如果你的环境未配置urlwrite，请修改配置文件application/config/config.php中的url_rewrite 项下的rewrite_open为false.<br>
   &nbsp;&nbsp;&nbsp;&nbsp;如果你的环境支持urlwrite,请确定.htaccess中的rewrite目录正确。<br>
4，框架仍在完善，如有不足之处，敬请包涵。欢迎FORK

框架的主页：<a href="http://keframework.04007.cn">http://keframework.04007.cn</a>

友情提醒：因整个程序文件夹中带了SQL数据库文件以及DEMO网站的图片等数据，有点大。


2016-08-02的一些更新：

1，网站增加了一些功能；

2，修复了框架一些BUG；

3，移动了框架的日志/缓存目录至storage目录下，以方便使用一些持续集成系统。

4，评论增加了敏感词过滤

5，WEB右侧栏目增加了历史上的今天模块，调用：http://history.04007.cn/HisMain/interface

小事记.
1、2007年开始编程使用asp、php做整站开发 
2、2012年开始使用YII，CI，ThinkPhp，Laravel框架
3、2014年12月开始写KeFrame1.0版
4、2015年11月开始升级KeFrame2.0版
