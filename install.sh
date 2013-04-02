#!/bin/bash
sudo rm -R  app/cache
cp /home/vasea/work/wimp/public/application.css /home/vasea/work/wimp_srv/src/Wimp/AppBundle/Resources/public/css/style.css
cp /home/vasea/work/wimp/public/application.js /home/vasea/work/wimp_srv/src/Wimp/AppBundle/Resources/public/js/app.js
cp /home/vasea/work/wimp/public/images/* /home/vasea/work/wimp_srv/src/Wimp/AppBundle/Resources/public/css/images/
composer install
sudo chmod -R 0777 app/cache
php app/console cache:clear -env=prod
php app/console assets:install -env=prod --symlink
php app/console assetic:dump -env=prod
sudo chmod -R 0777 app/cache