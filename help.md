
## 1.规则

### 1.1后台规则

```
1.php 命名空间和绝对路径一致
2.类名的首字母大写 (驼峰命名)
3.除了入口之外，只有一个类
4.变量命名 (匈牙利命名法)
```

### 1.2前台规则

```

接受参数要求：formdata必须是json 字符串


由于使用 JWT 方式，所以前端需要在每次请求的请求头 ，修改头部 

```


## 2. 接口方向



 - [x]   单一入口，自动加载

 - [x]   避免使用 全局函数（public static）最好放在工厂函数中统一创建

 - [x]   使用JWT 风格进行验证登录

 - [ ]  使用restful 方式接口  

         [1] 封装 http

         [2] 封装路由

 

## 3.接口常用代码


```

//错误异常处理
throw new \Com\CoreException(\Com\CoreException::CODE_FAILED_CREATE_OBJ);

throw Factory::getCoreException('CODE_DB_CONNECT_ERROR');

controller :接口对应的分支

Model:控制器中调用，用来操作数据库

Com:公共库

Config:配置信息

```


### 4.已经调试好的接口


```

//测试
http://192.168.0.88/laravel/dcenter/api/?type=index&$dataform={"cur_page":"1"}


//查询消息
http://192.168.0.88/laravel/dcenter/api/?type=getMsg&$dataform={"cur_page":"1"}
//添加或修改消息
//添加
http://192.168.0.88/laravel/dcenter/api/?type=updateMsg&$dataform={"upd_flag":"0","recvid":"13037125104","title":"msg add title","content":"msg content add","attach":""}
//修改
http://192.168.0.88/laravel/dcenter/api/?type=updateMsg&$dataform={"upd_flag":"1","update_id":"1","recvid":"13037125104","title":"msg add title","content":"msg content add","attach":"change"}
//删除
http://192.168.0.88/laravel/dcenter/api/?type=deleteMsg&$dataform={"delete_id":"1"}



//查询联系人
http://192.168.0.88/laravel/dcenter/api/?type=getContacts&$dataform={"cur_page":"1"}
//添加联系人
http://192.168.0.88/laravel/dcenter/api/?type=updateContact&$dataform={"upd_flag":"0","name":"陈明","recvid":"13037125104|13037125104@163.com"}
//修改联系人
http://192.168.0.88/laravel/dcenter/api/?type=updateContact&$dataform={"upd_flag":"1","update_id":"3","name":"陈明","recvid":"13037125104|13037125104@163.com|13037125104@163.com"}
//检查联系人是否唯一 添加的时候最好也请求（失去焦点验证），
http://192.168.0.88/laravel/dcenter/api/?type=checkContactName&$dataform={"name":"cmedit"}
//删除
http://192.168.0.88/laravel/dcenter/api/?type=deleteContact&$dataform={"delete_id":"1"}


//查询联系人
http://192.168.0.88/laravel/dcenter/api/?type=getContacts&$dataform={"cur_page":"1"}
//添加消息 模版
http://192.168.0.88/laravel/dcenter/api/?type=updateMsgModel&$dataform={"upd_flag":"0","title":"this is a title","content":"this is a content"}
//修改消息 模版
http://192.168.0.88/laravel/dcenter/api/?type=updateMsgModel&$dataform={"upd_flag":"1","update_id":"1","title":"change title","content":"change content"}
//删除
http://192.168.0.88/laravel/dcenter/api/?type=deleteMsgModel&$dataform={"delete_id":"1"}


//登录
login

http://192.168.0.88/laravel/dcenter/api/?type=login&$dataform={"ad_uname":"cm","ad_pwd":"123456"}

//token 验证测试

http://192.168.0.88/laravel/dcenter/api/?type=tokenValidate&$dataform={"token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOjE0OTY3Mzc5OTIsImlhdCI6IiIsIm5iZiI6IiIsImV4cCI6MTQ5Njc0NTE5Mn0.0aAuxCEfOC6zE0JTj_v4_FACPjVOQtrkgZXytWShPs4"}


```


### 程序流程

```

接受数据
    
分析数据
    做决策
        
    
返回处理结果


```


### 代码风格

```
json 作为优美的数据结构；可以将其也作为代码的风格；

前端：vue 就是这种形式；

后端：也可以自己封装一个基本类，然后代码的风格就可以学习vue 的风格；

```
