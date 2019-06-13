* [PHP](#php)
* [MySQL](#mysql)
* [Redis](#redis)
* [Kafka](#kafka)
* [Linux](#linux)
* [Nginx](#nginx)
* [网络](#网络)
* [算法](#算法)
* [系统设计](#系统设计)
* [其他](#其他)

### PHP

##### 一，使用过的各个框架的优缺点。

- laravel
  > - 使用了大量设计模式，框架完全符合设计模式的五大基本原则，模块之间耦合度很低，服务容器可以方便的扩展框架功能以及编写测试。
  > - 能快速开发出功能，自带各种方便的服务，比如数据验证、队列、缓存、数据迁移、测试、artisan 命令行等等，还有强大的 ORM 。
  > - 最核心的竞争力在我看来是：开发的高效。
  > - 全栈，该有的都有了，方便快速构建原型。
  > - 扩展齐全，大量的扩展包，有 WordPress 的感觉。
  > - 文档齐全、社区活跃。

- yaf

  > - 用C语言开发的PHP框架, 相比原生的PHP, 几乎不会带来额外的性能开销
  >
  > - 所有的框架类, 不需要编译, 在PHP启动的时候加载, 并常驻内存
  > - 更短的内存周转周期, 提高内存利用率, 降低内存占用率.
  > - 灵巧的自动加载. 支持全局和局部两种加载规则, 方便类库共享
  > - 高性能的视图引擎.
  > - 高度灵活可扩展的框架, 支持自定义视图引擎, 支持插件, 支持自定义路由等等.
  > - 内建多种路由, 可以兼容目前常见的各种路由协议.
  > - 强大而又高度灵活的配置文件支持. 并支持缓存配置文件,避免复杂的配置结构带来的性能损失.
  > - 在框架本身,对危险的操作习惯做了禁止.
  > - 更快的执行速度, 更少的内存占用.

##### 二，PHP类自动加载原理。[参考](https://learnku.com/articles/4681/analysis-of-the-principle-of-php-automatic-loading-function)

##### 三，Laravel源码相关。比如容器是如何实现的？[参考](https://segmentfault.com/a/1190000008892574)

##### 四，Composer是如何实现自动加载的？[参考](https://zhuanlan.zhihu.com/p/30785203)

> composer加载核心思想是通过composer的配置文件在引用入口文件(autoload.php)时,将类和路径的对应关系加载到内存中,最后将具体加载的实现注册到spl_autoload_register函数中.最后将需要的文件包含进来.

##### 五，PHP数组的底层实现。自己如何去实现？[参考](https://juejin.im/post/5bce1c35518825781f7b0935)

> PHP数组底层数据结构式 哈希表结构。

```c
typedef struct _zend_array HashTable;

struct _zend_array {
	// gc 保存引用计数，内存管理相关；本文不涉及
	zend_refcounted_h gc;
	// u 储存辅助信息；本文不涉及
	union {
		struct {
			ZEND_ENDIAN_LOHI_4(
				zend_uchar    flags,
				zend_uchar    nApplyCount,
				zend_uchar    nIteratorsCount,
				zend_uchar    consistency)
		} v;
		uint32_t flags;
	} u;
	// 用于散列函数
	uint32_t          nTableMask;
	// arData 指向储存元素的数组第一个 Bucket，Bucket 为统一的数组元素类型
	Bucket           *arData;
	// 已使用 Bucket 数
	uint32_t          nNumUsed;
	// 数组内有效元素个数
	uint32_t          nNumOfElements;
	// 数组总容量
	uint32_t          nTableSize;
	// 内部指针，用于遍历
	uint32_t          nInternalPointer;
	// 下一个可用数字索引
	zend_long         nNextFreeElement;
	// 析构函数
	dtor_func_t       pDestructor;
};
```

> 既然是hashtable结构，正常的hashtable应该是无序的，而php数组是如何实现有序的呢？
>
> 为了实现 HashTable 的有序性，PHP 为其增加了一张**中间映射表**，该表是一个大小与 Bucket 相同的数组，数组中储存整形数据，用于保存元素实际储存的 Value 在 Bucekt 中的下标。注意，加入了中间映射表后，**Bucekt 中的数据是有序的，而中间映射表中的数据是无序的**。这样顺序读取时只需要访问 Bucket 中的数据即可。

##### 六，一个请求到PHP，Nginx的主要过程。完整描述整个网络请求过程，原理。

[FastCGI、php-fpm的关系](https://www.mantis.vip/posts/2018-02-27-%E6%90%9E%E4%B8%8D%E6%87%82%E7%9A%84PHP-FPM-Fast-CGI%E4%B8%8EPHP%E4%B9%8B%E9%97%B4%E7%9A%84%E5%85%B3%E7%B3%BB.html)。

工作流程：

> 1)、FastCGI进程管理器php-fpm自身初始化，启动主进程php-fpm和启动start_servers个CGI 子进程。主进程php-fpm主要是管理fastcgi子进程，监听9000端口。fastcgi子进程等待来自Web Server的连接。
>
> 2)、当客户端请求到达Web Server Nginx是时，Nginx通过location指令，将所有以php为后缀的文件都交给127.0.0.1:9000来处理，即Nginx通过location指令，将所有以php为后缀的文件都交给127.0.0.1:9000来处理。
>
> 3）FastCGI进程管理器PHP-FPM选择并连接到一个子进程CGI解释器。Web server将CGI环境变量和标准输入发送到FastCGI子进程。
>
> 4)、FastCGI子进程完成处理后将标准输出和错误信息从同一连接返回Web Server。当FastCGI子进程关闭连接时，请求便告处理完成。
>
> 5)、FastCGI子进程接着等待并处理来自FastCGI进程管理器（运行在 WebServer中）的下一个连接。

##### 七，fpm的配置，动/静态，参数相关。

```nginx
pid = /usr/local/var/run/php-fpm.pid
#pid设置，一定要开启,上面是Mac平台的。默认在php安装目录中的var/run/php-fpm.pid。比如centos的在: /usr/local/php/var/run/php-fpm.pid
error_log  = /usr/local/var/log/php-fpm.log
#错误日志，上面是Mac平台的，默认在php安装目录中的var/log/php-fpm.log，比如centos的在: /usr/local/php/var/log/php-fpm.log
log_level = notice
#错误级别. 上面的php-fpm.log纪录的登记。可用级别为: alert（必须立即处理）, error（错误情况）, warning（警告情况）, notice（一般重要信息）, debug（调试信息）. 默认: notice.
emergency_restart_threshold = 60
emergency_restart_interval = 60s
#表示在emergency_restart_interval所设值内出现SIGSEGV或者SIGBUS错误的php-cgi进程数如果超过 emergency_restart_threshold个，php-fpm就会优雅重启。这两个选项一般保持默认值。0 表示 '关闭该功能'. 默认值: 0 (关闭).
process_control_timeout = 0
#设置子进程接受主进程复用信号的超时时间. 可用单位: s(秒), m(分), h(小时), 或者 d(天) 默认单位: s(秒). 默认值: 0.
daemonize = yes
#后台执行fpm,默认值为yes，如果为了调试可以改为no。在FPM中，可以使用不同的设置来运行多个进程池。 这些设置可以针对每个进程池单独设置。
listen = 127.0.0.1:9000
#fpm监听端口，即nginx中php处理的地址，一般默认值即可。可用格式为: 'ip:port', 'port', '/path/to/unix/socket'. 每个进程池都需要设置。如果nginx和php在不同的机器上，分布式处理，就设置ip这里就可以了。
listen.backlog = -1
#backlog数，设置 listen 的半连接队列长度，-1表示无限制，由操作系统决定，此行注释掉就行。backlog含义参考：http://www.3gyou.cc/?p=41
listen.allowed_clients = 127.0.0.1
#允许访问FastCGI进程的IP白名单，设置any为不限制IP，如果要设置其他主机的nginx也能访问这台FPM进程，listen处要设置成本地可被访问的IP。默认值是any。每个地址是用逗号分隔. 如果没有设置或者为空，则允许任何服务器请求连接。
listen.owner = www
listen.group = www
listen.mode = 0666
#unix socket设置选项，如果使用tcp方式访问，这里注释即可。
user = www
group = www
#启动进程的用户和用户组，FPM 进程运行的Unix用户, 必须要设置。用户组，如果没有设置，则默认用户的组被使用。
pm = dynamic 
#php-fpm进程启动模式，pm可以设置为static和dynamic和ondemand
#如果选择static，则进程数就数固定的，由pm.max_children指定固定的子进程数。
#如果选择dynamic，则进程数是动态变化的,由以下参数决定：
pm.max_children = 50 #子进程最大数
pm.start_servers = 2 #启动时的进程数，默认值为: min_spare_servers + (max_spare_servers - min_spare_servers) / 2
pm.min_spare_servers = 1 #保证空闲进程数最小值，如果空闲进程小于此值，则创建新的子进程
pm.max_spare_servers = 3 #，保证空闲进程数最大值，如果空闲进程大于此值，此进行清理
pm.max_requests = 500
#设置每个子进程重生之前服务的请求数. 对于可能存在内存泄漏的第三方模块来说是非常有用的. 如果设置为 '0' 则一直接受请求. 等同于 PHP_FCGI_MAX_REQUESTS 环境变量. 默认值: 0.
pm.status_path = /status
#FPM状态页面的网址. 如果没有设置, 则无法访问状态页面. 默认值: none. munin监控会使用到
ping.path = /ping
#FPM监控页面的ping网址. 如果没有设置, 则无法访问ping页面. 该页面用于外部检测FPM是否存活并且可以响应请求. 请注意必须以斜线开头 (/)。
ping.response = pong
#用于定义ping请求的返回相应. 返回为 HTTP 200 的 text/plain 格式文本. 默认值: pong.
access.log = log/$pool.access.log
#每一个请求的访问日志，默认是关闭的。
access.format = "%R - %u %t \"%m %r%Q%q\" %s %f %{mili}d %{kilo}M %C%%"
#设定访问日志的格式。
slowlog = log/$pool.log.slow
#慢请求的记录日志,配合request_slowlog_timeout使用，默认关闭
request_slowlog_timeout = 10s
#当一个请求该设置的超时时间后，就会将对应的PHP调用堆栈信息完整写入到慢日志中. 设置为 '0' 表示 'Off'
request_terminate_timeout = 0
#设置单个请求的超时中止时间. 该选项可能会对php.ini设置中的'max_execution_time'因为某些特殊原因没有中止运行的脚本有用. 设置为 '0' 表示 'Off'.当经常出现502错误时可以尝试更改此选项。
rlimit_files = 1024
#设置文件打开描述符的rlimit限制. 默认值: 系统定义值默认可打开句柄是1024，可使用 ulimit -n查看，ulimit -n 2048修改。
rlimit_core = 0
#设置核心rlimit最大限制值. 可用值: 'unlimited' 、0或者正整数. 默认值: 系统定义值.
chroot =
#启动时的Chroot目录. 所定义的目录需要是绝对路径. 如果没有设置, 则chroot不被使用.
chdir =
#设置启动目录，启动时会自动Chdir到该目录. 所定义的目录需要是绝对路径. 默认值: 当前目录，或者/目录（chroot时）
catch_workers_output = yes
#重定向运行过程中的stdout和stderr到主要的错误日志文件中. 如果没有设置, stdout 和 stderr 将会根据FastCGI的规则被重定向到 /dev/null . 默认值: 空.
```

##### 八，php多进程如何实现？[PHP多进程编程](https://www.mantis.vip/posts/2018-05-26-PHP%E5%A4%9A%E8%BF%9B%E7%A8%8B%E7%BC%96%E7%A8%8B.html)

##### 九，PHP的魔术方法。

```php
__set() // 在给不可访问属性赋值时，__set()会被调用
__get() // 读取不可访问属性的值时，__get()会被调用
__isset() //当对不可访问属性调用isset()或empty()，__isset()会被调用
__unset() // 当对不可访问属性调用unset()时，__unset()会被调用
__call() // 在对象中调用一个不可访问方法时，__call()会被调用
__callStatic() // 在静态上下文中调用一个不可访问的方法时，__callStatic会被调用
__construct() // 构造函数的类会在每次创建新对象时先调用此方法，所以非常适合在使用对象之前做一些初始化工作。
__destruct() // 析构函数会在到某个对象的所有引用都被删除或者当对象被显式销毁时执行。
__sleep() // serialize()函数会检查类中是否存在一个魔术方法__sleep()，如果存在，该方法会先被调用，然后再执行序列化操作。此功能可以用于清理对象，并返回一个包含对象中所有应被序列化的变量名称的数组。如果该方法未返回任何内容，则 NULL 被序列化，并产生一个 E_NOTICE 级别的错误。
__wakeup() // unserialize()函数会检查是否存在一个__wakeup()方法，如果存在，则会先调用该方法，然后再执行反序列化操作。__wakeup() 经常用在反序列化操作中，例如重新建立数据库连接，或执行其它初始化操作。
```

##### 十，打印目录结构。[源码](./src/php/loopDir.php)

##### 十一，实现字符串反转函数。[源码](./src/php/reverseStr.php)

##### 十二，PHP实现一个双向队列。[源码](./src/php/Deque.php)

##### 十三，常用的设计模式。[参考](https://www.mantis.vip/posts/2017-07-11-php-design-pattern.html)

##### 十四，字符编码UTF8、GBK、GB2312的区别。

> utf8是国际编码。通用性较好。
>
> gbk是国内编码。通用型较utf8差，但是占用数据库比utf8小。
>
> gb2312是一个简体中文字符集的中国国家标准，共收录6763个汉字。

##### 十五，PHP代码运行原理。
##### 

### MySQL

##### 一，MySQL底层的数据结构是什么？最左前缀的原理。

> b+树的数据项是复合的数据结构，比如(name,age,sex)的时候，b+树是按照从左到右的顺序来建立搜索树的，比如当(张三,20,F)这样的数据来检索的时候，b+树会优先比较name来确定下一步的所搜方向，如果name相同再依次比较age和sex，最后得到检索的数据；但当(20,F)这样的没有name的数据来的时候，b+树就不知道第一步该查哪个节点，因为建立搜索树的时候name就是第一个比较因子，必须要先根据name来搜索才能知道下一步去哪里查询.

##### 二，使用索引时需要注意的点有哪些？

> - 不要再查询语句中使用函数计算
> - 索引列不要参与计算
> - like查询%key%不走索引，key%走索引
> - 字符串与数字比较时，不使用索引
> - 如果条件中有or,即使其中有条件带索引也不会使用
> - 索引要建立在经常进行select操作的字段上
> - 索引不会包含有NULL的列；只要列中包含有NULL值，都将不会被包含在索引中，复合索引中只要有一列含有NULL值，那么这一列对于此符合索引就是无效的。
> - mysql查询只使用一个索引，因此如果where子句中已经使用了索引的话，那么order by中的列是不会使用索引的。因此数据库默认排序可以符合要求的情况下不要使用排序操作，尽量不要包含多个列的排序，如果需要最好给这些列建复合索引。
> - 不使用NOT IN 、<>、！=操作，但<,<=，=，>,>=,BETWEEN,IN是可以用到索引的
> - 对于那些定义为text、image和bit数据类型的列不应该增加索引。因为这些列的数据量要么相当大，要么取值很少

##### 三，MySQL底层原理：为什么select*有问题？大字段索引有问题？

> 大字段类型，如text类型的字段建立索引需指定前缀索引长度。如：```alter table test add indexidx_text(aaa(10))```。

##### 四，有过哪些优化MySQL的经验？

##### 五，数据量大的表分页偏移值越大为什么查询越慢？跟底层原理有关。

> MySQL在分页查询时并非是跳过偏移值取后面的数据，而是先把偏移值+要取得条数，然后再把偏移量这一段的数据抛弃掉在返回。所以偏移值越大查询就越慢。
>
> 优化方案：使用where id > offset代替limit offset。如：
>
> ```select * from user limit 1000000,3;```改为 ```select * from user where id > 1000000 limit 3;```

##### 六，MySQL主从同步延迟如何处理？

> - 主从同步的原理：主库会把所有的DDL和DML产生binlog，binlog是顺序写的，效率较高。从库的IO线程(5.6.3之前是单个IO线程，5.3.6之后有多个线程，速度有提升)会去读取主库的binlog并且写到从库的Relay log里面，然后从服务器的SQL thread会一个一个的执行Relay log里面的sql语句，恢复数据。
>
> - 主从延迟的原因：1）大量的并发操作写入，当某个SQL在从服务器上执行的时间稍长或者由于某个SQL要进行锁表就会导致延迟，主库的SQL大量积压，未被同步到从库里，导致延迟。2）硬件条件如磁盘IO、CPU、内存等各方面原因造成复制延迟。3）慢SQL语句过多导致延迟。
>
> - 解决方案：1）主库负责更新操作，对安全性要求较高，所以有些设置可以修改如：sync_binlog=1等，从库对数据安全性没有那么高，可以设置sync_binlog=0或者直接关闭binlog，innodb_flushlog、innodb_flush_log_at_trx_commit设置为0可以很大程度上提高效率。2）从库使用较好的硬件设备。3）对数据是实性要求非常高的数据可以在写入主库时可以将数据直接返回而不用再去查从库。

##### 七，如何分析SQL语句用到了哪些索引，如果是复合索引是否都用到了。

> 使用explain分析。主要需要注意的字段type、possible_key、key、key_len。

```mysql
explain select * from user_auth where ucid = 2000000023473725;
```

| id   | select_type | table     | type  | possible_keys | key       | key_len | ref   | row  | Extra |
| ---- | ----------- | --------- | ----- | ------------- | --------- | ------- | ----- | ---- | ----- |
| 1    | SIMPLE      | user_auth | const | uniq_ucid     | uniq_ucid | 8       | const | 1    | NULL  |

- type（访问类型）字段，从好到坏以此为：NULL > system > const > eq_ref > ref > range > index > all;
- possiable_keys和key：可能用到的索引字段，key为实际使用到的索引字段。
- key_len：索引字段字节数，越短越好。

> 对于复合索引，因为遵循最左前缀原则，所以观察key_len可以确定是否用到了复合索引的全部字段。

##### 八，MySQL字段类型的字段长度。

| 字段类型    | 大小                         | 范围       |
| ----------- | ---------------------------- | ---------- |
| tinyint     | 1字节                        | (-128,127) |
| smallint    | 2字节                        |            |
| mediumint   | 3字节                        |            |
| int/integer | 4字节                        |            |
| bigint      | 8字节                        |            |
| float       | 4字节                        |            |
| double      | 8字节                        |            |
| decimal     | DECIMAL(M,D),M>D:M+2,否则D+2 |            |

>  注意：varchar最大字节数为：65535。这里的最大是指整张表varchar的总大小。

##### 九，MySQL索引字段类型问题。

```sql
CREATE TABLE `test_01` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
    `ucid` varchar(30) NOT NULL,
    `name` varchar(20) DEFAULT NULL,
    PRIMARY KEY(`id`),
    KEY `idx_ucid` (`ucid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8
```

对于上述表结构，我们执行如下SQL：

```sql
explain select * from `test_01` where ucid = 2000000000088491;
```

> 发现并没有用到索引，这是因为```ucid```字段是varchar类型的，查询时使用的是int类型，这里会有一个隐式转换的问题，隐式转换会导致全表扫描。
>
> 注意：如果表定义的是int类型的，传入的是字符串，则不会发生隐式转换。

##### 十，MySQL默认的排序方式是什么？

> MyIsam存储引擎：在没有任何删除，修改的操作下，执行select不带order by那么会按照插入的顺序下进行排序。
>
> InnDB存储引擎：在相同的情况下，select不带order by会根据主键来排序，从小到大。

##### 十一，MySQL多个索引列使用的顺序是怎样的？如users，中有普通索引name，age，email，sql语句select * from users where name = 'jack' and age = 20 and email = 'xxxx@gmail.com'；

##### 十二，MySQL编码utf8和utf8mb4，Emoji表情需要使用utf8mb4来存储。[参考](http://ourmysql.com/archives/1402)

##### 十三，MySQL建表注意事项。

##### 十四，做过哪些MySQL的优化工作。自由发挥。

### Redis

##### 一，Redis五大数据类型对应的底层数据结构是什么？[参考](https://www.cnblogs.com/jaycekon/p/6227442.html)

##### 二，Redis Sentinel哨兵模式。[参考](https://juejin.im/post/5b7d226a6fb9a01a1e01ff64)

##### 三，Redis分布式锁的实现。[参考](https://www.cnblogs.com/wenxiong/p/3954174.html)

##### 四，Redis用过哪些数据结构。自由发挥。

##### 五，Redis集群如何做。

##### 六，Redis集群如何插入一台新机器。

##### 七，Redis集群如何查数据在哪台机器。

### Kafka

##### 一，Kafka消息类型有哪些。

##### 二，Kafka的pub/sub消息类型如何保证消息送达。

### Linux

##### 一，分析access.log日志中前100的url。

##### 二，Linux的I/O多路复用。

> IO多路复用就是我们说的select、poll、epoll。select/epoll好处在于单个process可以同时处理多个网络连接的IO. 基本原理是select、poll、epoll这个function会不断的轮询所负责的所有socket，当某个socket有数据到达时，就通知用户进程。

##### 三，进程，线程，协程是什么？如何切换的？

> 进程和线程的主要区别是：进程独享地址空间和资源，线程则共享地址空间和资源，多线程就是多栈。
>
> 1、进程
>
> 进程是具有一定独立功能的程序关于某个数据集合上的一次运行活动,进程是系统进行资源分配和调度的一个独立单位。每个进程都有自己的独立内存空间，不同进程通过进程间通信来通信。由于进程比较重量，占据独立的内存，所以上下文进程间的切换开销（栈、寄存器、虚拟内存、文件句柄等）比较大，但相对比较稳定安全。
>
> 2、线程
>
> 线程是进程的一个实体,是CPU调度和分派的基本单位,它是比进程更小的能独立运行的基本单位.线程自己基本上不拥有系统资源,只拥有一点在运行中必不可少的资源(如程序计数器,一组寄存器和栈),但是它可与同属一个进程的其他的线程共享进程所拥有的全部资源。线程间通信主要通过共享内存，上下文切换很快，资源开销较少，但相比进程不够稳定容易丢失数据。
>
> 3、协程
>
> 协程是一种用户态的轻量级线程，协程的调度完全由用户控制。协程拥有自己的寄存器上下文和栈。协程调度切换时，将寄存器上下文和栈保存到其他地方，在切回来的时候，恢复先前保存的寄存器上下文和栈，直接操作栈则基本没有内核切换的开销，可以不加锁的访问全局变量，所以上下文的切换非常快。

##### 四，nginx.log文件格式如下，统计当天某个接口的uv。
```shell
2019/05/28 10:00:01 127.0.0.1 GET /api/user/22 ......
2019/05/28 10:00:01 10.33.148.143 GET /api/user/22 ......
2019/05/28 10:00:01 127.0.0.1 GET /api/user/22 ......
2019/05/28 10:00:01 10.22.16.65 GET /api/user/22 ......
2019/05/28 10:00:01 127.0.0.1 GET /api/user/22 ......
```

```shell
cat nginx.log | grep "/api/user/" | awk '{print $3}' | sort | uniq -c | sort -nr | wc -l
```

### Nginx

##### 一，Nginx性能优化；openresty相关等。

##### 二，服务器负载均衡的实现。[参考](https://www.mantis.vip/posts/2017-07-24-%E3%80%90Nginx%E3%80%91%E5%AE%9E%E7%8E%B0%E8%B4%9F%E8%BD%BD%E5%9D%87%E8%A1%A1%E7%9A%84%E5%87%A0%E7%A7%8D%E6%96%B9%E6%B3%95.html)

##### 三，Nginx的I/O模型。

### 网络

##### 一，OSI七层网络模型。
- 物理层：建立、维护、断开物理连接
- 数据链路层：建立逻辑链接、进行硬件地址寻址、差错校验等功能
- 网络层：进行逻辑地址寻址，实现不同网络之间的路径选择
- 传输层：定义传输数据的协议端口号，以及流程和差错校验；协议有：TCP,UDP，数据包一旦离开网卡即进入网络传输层
- 会话层：建立、管理、终止会话
- 表示层：数据的表示、安全、压缩
- 应用层：网络服务与最终用户的一个接口；协议有：HTTP、FTP、TFTP、SMTP、DNS、TELNET、HTTPS、POP3、DHCP

##### 二，TCP/UDP的区别。

> TCP

- TCP是一种面向连接的、可靠的、基于字节流的传输层通信协议
- TCP面向连接，提供可靠地数据服务
- TCP首部开销20字节
- TCP逻辑通信信道是全双工的可靠信道
- TCP连接只能是点到点的

> UDP

- UDP是参考模型中一种无连接的传输层协议，提供面向事务的简单不可靠的信息传递服务
- UDP无连接，不可靠
- UDP首部开销8字节
- UDP逻辑通信信道是不可靠信道
- UDP没有拥塞机制，因此网络出现拥堵不会使源主机的发送效率降低
- UDP支持一对一，多对一，多对多的交互通信

##### 三，TCP连接三次握手、四次挥手。[参考](https://blog.csdn.net/qq_38950316/article/details/81087809)

##### 四，TCP如何保证可靠传输。[参考](https://blog.csdn.net/liuchenxia8/article/details/80428157)

### 算法

##### 一，找出数组中出现一次的元素。10 10 11 11 12 13 12 13 16 只出现一次的数字。要求时间复杂度尽可能低。[源码](./src/algorithms/onlyOne.php)

##### 二，消消乐816。如下:

1）字符818166816消除816后为空。

2）字符81816816816消除后是81。

##### 三，最长公共子串。[源码](./src/algorithms/maxComStr.php)

##### 四，各种排序算法。

- 快速排序。[源码](./src/algorithms/quickSort.php)

  > 最坏情况出现在每次切分所选的切分元素总是当前切分数组的最小值时，因为其在排序过程中，会交换元素打乱数组原本的相对顺序，所以快速排序是不稳定的算法。
  >
  > 最坏时间复杂度：O(n^2)，平均时间复杂度：O(n*log2n)。空间复杂度O(n)，平均空间复杂度O(log2n)。

- 冒泡排序。[源码](./src/algorithms/bubbleSort.php)

  > 时间复杂度：O(n^2)。

- 插入排序。[源码](./src/algorithms/insertSort.php)

  > 时间复杂度：O(n^2)，空间复杂度O(1)。

- 选择排序。[源码](./src/algorithms/selectSort.php)

  > 时间复杂度O(n^2),空间复杂度O(1)。

- 希尔排序。[源码](./src/algorithms/shellSort.php)

  > 时间复杂度O(n^2)，平均时间复杂度O(n*log2n),空间复杂度O(1) 。

##### 五，各种查找算法。

- 二分查找。时间复杂度：O(log2n)。[源码](./src/algorithms/binarySearch.php)
- 顺序查找。时间复杂度：O(n)。[源码](./src/algorithms/sequenceSearch.php)

##### 六，Excel给定一个数据，如何查到它在第几列？(excel头部有规律：A | B | C | D | E | …… | Z | AA | AB | AC | AD | AE | …… | AZ | ……) [源码](./src/algorithms/excelFindCol.php)

1 -> A  

2 -> B 

3 -> C

…...

26 -> Z

27 -> AA

28 -> AB

….

##### 七，二叉树遍历(先根、中根、后根、反转、深度遍历、还原)。[源码](./src/algorithms/BinaryTree.php)

##### 八，二叉树反转/镜像。[源码](./src/algorithms/reverseTree.php)

##### 九，猴子选大王(约瑟夫环)。[源码](./src/algorithms/MonkeyKing.php)

##### 十，求两个链表的第一个公共节点。[源码](./src/algorithms/ListFirstCommonNode.php)

##### 十一，求n以内的质数。[源码](./src/algorithms/prime.php)

##### 十二，判断两个有序数组是否有公共元素。[源码](./src/algorithms/common.php)

##### 十三，单链表反转。[源码](./src/algorithms/LinkList.php)

##### 十四，敏感词过滤算法。[DFA(有穷自动机)](./src/algorithms/DFA.php)

##### 十五，给定一棵二叉树，知道它的根节点$root，某个节点$kNode，找出与$kNode高度相差$k的所有节点。

##### 十六，两个有序链表合并成一个有序链表。[源码](./src/algorithms/MergeLinkList.php)

##### 十七，一个无序不重复的数组$arr，找出所有$arr[$i] + $arr[$j] + $arr[$k] = $m的元素。

### 系统设计

##### 一，短链接如何设计？[参考](https://segmentfault.com/a/1190000012088345)

##### 二，接口访问限制。每30分钟只能访问100次，两种情况(1，如果在10:00开始到10:02访问了100次，则直到10:30这段时间内都不能访问，知道10:31开始才恢复访问；2，如果在10:00开始到10:02时已访问了100次，则在10:03-10:33分钟内只能访问100次。)。[参考](https://juejin.im/entry/57cce5d379bc440063066d09)

##### 三，LRU如何实现？[参考](https://www.twblogs.net/a/5b7f0b662b717767c6ad6c42/zh-cn)

##### 四，订单表订单ID如何设计生成？[Leaf——美团点评分布式ID生成系统](https://tech.meituan.com/2017/04/21/mt-leaf.html)

##### 五，一致性hash问题。[参考](https://www.jianshu.com/p/e8fb89bb3a61)

### 其他

##### 一，工作中遇到过比较难的问题是什么？如何解决的？
##### 二，比较有成就感的项目、难点。
