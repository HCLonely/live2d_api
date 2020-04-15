# Live2D API

Live2D 看板娘脚本 (https://github.com/HCLonely/live2d.user.js) 使用的后端 API

### 特性

- 原生 PHP 开发，开箱即用
- 支持 模型、皮肤 的 顺序切换 和 随机切换
- 支持 单模型 单皮肤 切换、多组皮肤 递归穷举
- 支持 同分组 多个模型 或 多个路径 的 加载切换
- 轻量级，只保留 json 文件，模型使用 jsDelivr CDN

## 使用

### 环境要求
- PHP 版本 >= 5.2
- 依赖 PHP 扩展：json

### URL重写

#### Nginx

```conf
location /npm{
    rewrite (.*)$ https://cdn.jsdelivr.net$1 break;
}
```

#### Apache

```conf
RewriteEngine On
RewriteCond %{REQUEST_URI} ^/npm/
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ //cdn.jsdelivr.net/$1
```

### 目录结构

```shell
│  model_list.json              // 模型列表
│
├─npm                           // 模型路径
│  └─GroupName                  // 模组分组
│      └─ModelName              // 模型名称
│          └─*.json             // 模型配置文件
│
├─get                           // 获取模型配置
├─rand                          // 随机切换模型
├─rand_textures                 // 随机切换皮肤
├─switch                        // 顺序切换模型
├─switch_textures               // 顺序切换皮肤
└─tools
        modelList.php           // 列出模型列表
        modelTextures.php       // 列出皮肤列表
        name-to-lower.php       // 文件名格式化
```

### 接口用法
- `/get/?id=1-23` 获取 分组 1 的 第 23 号 皮肤
- `/rand/?id=1` 根据 上一分组 随机切换
- `/switch/?id=1` 根据 上一分组 顺序切换
- `/rand_textures/?id=1-23` 根据 上一皮肤 随机切换 同分组其他皮肤
- `/switch_textures/?id=1-23` 根据 上一皮肤 顺序切换 同分组其他皮肤

## 版权声明

> (>▽<) 都看到这了，点个 Star 吧 ~

**API 内所有模型 版权均属于原作者，仅供研究学习，不得用于商业用途**  

MIT © FGHRSH
