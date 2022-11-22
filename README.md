## Documment

#I. Các bước cơ bản để tạo 1 plugin
1. Cấu tạo cơ bản
-HelloWorldBundle/
  Assets/
    images/
      earth.png
      mars.png
    helloworld.js
    helloworld.css
  Config/
    config.php
  Controller/
    DefaultController.php
  Model/
    ContactModel.php
    WorldModel.php
  Translations/
    en_US/
      messages.ini
  Views/
    Contact/
      form.html.php
    World/
      index.html.php
      list.html.php
    HelloWorldBundle.php
2. Với file HelloWorldBundle.php 
- Cần 2 hàm chính là onPluginInstall:(Chạy lần đầu khi plugin được nạp vào hệ thống) và onPluginUpdate:(dùng để câpj nhật plugin khi vision được thay đổi)
- Cấu tạo 2 hàm:
static public function onPluginInstall(Plugin $plugin, MauticFactory $factory, $metadata = null)
    {
        if ($metadata !== null) {
            self::installPluginSchema($metadata, $factory);
        }

        // Do other install stuff
    }

4. Các sự kiện cần bắt 
