
>1. 用户登录
---
URL：http://www.tp55.com/index/api/login

参数 |是否必须 | 说明
---|---|---
username|是|用户名
pwd|是|密码

>2. 用户注册
---
URL：http://www.tp55.com/index/api/regist

参数 |是否必须 | 说明
---|---|---
username|是|用户名
pwd|是|密码

>3. 用户密码重置
---
URL：http://www.tp55.com/index/api/reset

参数 |是否必须 | 说明
---|---|---
username|是|用户名

>4. 首页banner
---
URL：http://www.tp55.com/index/api/banner

参数 |是否必须 | 说明
---|---|---
adKind|是|广告类型id

>5. 秒杀商品
---
URL：http://www.tp55.com/index/api/seckill

参数 |是否必须 | 说明
---|---|---
无|否|返回秒杀商品信息

>6. 猜你喜欢
---
URL：http://www.tp55.com/index/api/getYourFav

参数 |是否必须 | 说明
---|---|---
无|否|返回商品信息

>7. 商品信息
---
URL：http://www.tp55.com/index/api/productInfo

参数 |是否必须 | 说明
---|---|---
id|是|返回具体商品信息

>8. 获取省份
---
URL：http://www.tp55.com/index/api/province

参数 |是否必须 | 说明
---|---|---
无|是|返回地址省份

>9. 获取城市
---
URL：http://www.tp55.com/index/api/city

参数 |是否必须 | 说明
---|---|---
province|是|返回地址城市

>10. 获取地区
---
URL：http://www.tp55.com/index/api/area

参数 |是否必须 | 说明
---|---|---
city|是|返回地区

>11. 获取订单详细
---
URL：http://www.tp55.com/index/api/getOrderDetail

参数 |是否必须 | 说明
---|---|---
userId|是|返回订单具体信息详情
id|是|返回具体订单