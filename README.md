# php8-easyswoole-docker

#### yum git curl wget zip unzip epel-release remi-release-8.5.rpm


Need to clone this repository first, and then write code in the easyswoole folder, change repository url and push.

需要先拉取这个仓库，然后在easyswoole文件夹下编写代码，改变仓库地址再推送到自己仓库。
```
git clone https://github.com/dilikeji/php8-easyswoole-docker.git
cd php8-easyswoole-docker
git remote set-url origin https://github.com/YOURSELF/NEW-REPOSITORY.git
git push -u origin master
```

Git pull your new repository on the server，use docker to start.

在服务器上拉取你的新仓库代码，使用docker去启动它。
```
git clone https://github.com/YOURSELF/NEW-REPOSITORY.git
cd NEW-REPOSITORY
docker compose up -d
```
Subsequent code updates with hot reload (no downtime):

后续更新代码重载服务(不停机)：
```
git pull
docker exec -it php8easyswoole /bin/bash
php easyswoole.php server reload -mode=produce
```
Subsequent code updates with service restart (with downtime):

后续更新代码重启服务(停机)：
```
git pull
docker restart php8easyswoole
```
When developing on the Windows platform, you can use composer install --ignore-platform-reqs to install dependency packages conveniently for development.

win平台上开发时，可以使用composer install --ignore-platform-reqs拉取依赖包，方便开发
```
git clone https://github.com/YOURSELF/NEW-REPOSITORY.git
cd NEW-REPOSITORY
composer install --ignore-platform-reqs
```

docker-compose.yml:
```
services:
    app:
        #首次启动需要执行composer install安装依赖，后续启动可以注释掉；
        #php easyswoole.php server restart默认启动dev.php配置文件，通过-mode切换到其他配置文件
        #安装其他扩展可以docker exec -it php8easyswoole /bin/bash 进入容器，执行pecl install
        command: sh -c "composer install && php easyswoole.php server restart -mode=produce"
        stdin_open: true
        tty: true
        container_name: php8easyswoole #这里修改容器名称
        deploy:
            resources:
                limits:
                    cpus: "1" #这里设置CPU核心数
                    memory: 512M #这里设置内存大小
        image: 912104410/php8easyswoole:latest
        network_mode: "host" #这里设置网络模式为host，使用宿主机网络，端口9501
        restart: on-failure:5 #这里设置重启策略为失败时重启，最多重启5次
        volumes:
            - ./easyswoole:/root #这里挂载easyswoole项目
            - ./php-conf:/etc/opt/remi/php84 #挂载php配置文件
            - ./php-bin:/opt/remi/php84 #挂载php可执行文件和扩展,后续安装新扩展也在这里
            - ./libpq.so.5:/usr/lib64/libpq.so.5 #pgsql用到的库，如不用可不挂载
            - ./libpq.so.5.13:/usr/lib64/libpq.so.5.13 #pgsql用到的库，如不用可不挂载
```
