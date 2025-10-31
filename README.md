Need to fork this repository first, and then write code in the easyswoole folder.

需要先fork这个仓库，然后在easyswoole文件夹下编写代码。
```
git clone https://github.com/dilikeji/php8-easyswoole-docker.git
cd php8-easyswoole-docker
docker compose up -d
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
