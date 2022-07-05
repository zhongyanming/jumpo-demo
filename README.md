#### jumpo代码挑战 部署文档
- 使用php7.0以上版本
- 确保mysql数据库能连上，且已为本项目创建了对应的数据库
- 修改environments/dev内文件配置
    - common/config/main-local.php修改数据库配置
    
- 项目根目录下执行初始化命令(linux)
```
# yii项目初始化
php init
# 选择develop环境
# 项目初始化完成后执行数据库迁移
php yii migrate
```
- 配置好你的网站域名指向backend/web
- 访问域名即可