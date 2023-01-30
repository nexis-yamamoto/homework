

## vbox&debianセットアップ

memory 1g
ストレージdisk 20g
debian-11.3.0-amd64-netinst.iso
ブリッジネットワーク 192.168.253.55/24
GW 192.168.253.123
dns 8.8.8.8

## consoleで

```
$ su
# export LANG=C
# apt install sudo
# /sbin/visudo
yamamoto    ALL=(ALL:ALL)   ALL
# logout
$ sudo apt -y install ssh
$ sudo vi /etc/ssh/sshd_config  (確認のみ)
```

以降、puttyでok


編集が素のviでは厳しい
```
$ sudo apt -y install vim
```

## apache2

```
$ sudo apt upgrade
$ sudo apt -y install apache2
$ sudo systemctl status apache2 (確認のみ)
$ sudo apt -y install sqlite3 libsqlite3-dev
```


$ sudo apt -y install build-essential
$ sudo apt -y install ruby-dev
以下の追加パッケージがインストールされます:

  fonts-lato javascript-common libgmp-dev libgmpxx4ldbl libjs-jquery
  libruby2.7 libyaml-0-2 rake ruby ruby-minitest ruby-net-telnet
  ruby-power-assert ruby-rubygems ruby-test-unit ruby-xmlrpc ruby2.7
  ruby2.7-dev ruby2.7-doc rubygems-integration unzip zip


$ sudo gem install bundler


# ソース取得

```
$ sudo apt -y wget
$ wget --no-check-certificate http://www.redmine.org/releases/redmine-5.0.1.tar.gz

$ sudo mkdir /opt/redmine
$ sudo tar xf redmine-5.0.1.tar.gz  -C /opt/redmine/
```


# データのコピー

dodoからデータ取得
```
$ mkdir redmine_data
$ scp -r yamamoto@192.168.253.154:/home/yamamoto/redmine_data/* redmine_data/
```

運用環境に設置
```
$ cp redmine_data/redmine.db /opt/redmine/redmine-5.0.1/db/ 
$ cp -r redmine_data/files/* /opt/redmine/redmine-5.0.1/files/
```

redmine/config/configuration.yml
```
production:
  delivery_method: :smtp
  smtp_settings:
    address: ns.do-koyo.co.jp
    port: 25
    domain: do-koyo.co.jp
    authentication: :none
```

database.yml
```
production:
  adapter: sqlite3
  database: db/redmine.db
```

## bundle install

□ bundle installでgemをたくさんinstallするが、debian標準のruby&gemcommandはsudoでないと動かない
```
$ bundle config set --local without 'development test postgresql mysql'
$ sudo bundle install
```

--withoutオプションは古いので config setをつかえ
yamamoto@redmine11:/opt/redmine/redmine-5.0.1$ bundle install --without development test postgresql mysql
[DEPRECATED] The `--without` flag is deprecated because it relies on being remembered across bundler invocations, which bundler will no longer do in future versions. Instead please use `bundle config set --local without 'development test postgresql mysql'`, and stop using this flag

```
$ bundle exec rake db:migrate RAILS_ENV=production
$ bundle exec rake generate_secret_token
$ bundle exec ruby /usr/local/bin/rails server -u webrick -e production
```
redmineのセットアップと開発用サーバ起動まで


# deploy

## passenger
```
$ sudo apt -y install libapache2-mod-passenger
```
以下のpassenger.confが自動で有効になる。
/etc/apache2/mods-available/passenger.conf
```
<IfModule mod_passenger.c>
  PassengerRoot /usr/lib/ruby/vendor_ruby/phusion_passenger/locations.ini
  PassengerDefaultRuby /usr/bin/ruby
  PassengerUser www-data <--- 追加(apache2の実行ユーザ)
</IfModule>
```

apache2のユーザに所有者を変える
```
$ sudo chown -R www-data: /opt/redmine/redmine-5.0.1/
$ sudo chmod -R 755 /opt/redmine/redmine-5.0.1/files/
$ sudo chmod -R 755 /opt/redmine/redmine-5.0.1/log/
$ sudo chmod -R 755 /opt/redmine/redmine-5.0.1/tmp/
$ sudo chmod -R 755 /opt/redmine/redmine-5.0.1/public/plugin_assets/
$ sudo chown www-data:www-data redmine-5.0.1/Gemfile.lock
```

$ sudo vi /etc/apache2/sites-enabled/000-default.conf
```
<VirtualHost *:80>
        ServerAdmin admin@example.com
        Servername hostname
        DocumentRoot /var/www/html/

        <Location /redmine>
                RailsEnv production
                RackBaseURI /redmine
                Options -MultiViews
        </Location>
</VirtualHost>
```

```
$ sudo systemctl restart apache2
```


# 参考

* https://www.redmine.org/projects/redmine/wiki/HowTo_Install_Redmine_on_Debian_9
* https://www.atlantic.net/dedicated-server-hosting/how-to-install-redmine-4-2-on-debian-10/
* https://chachocool.com/como-instalar-redmine-en-debian-11-bullseye/