<?php 
include_once __DIR__.'/database.php';

$settings = $mysqli->query("select * from settings where id = 1")->fetch_assoc();

if(count($settings)){
    $app_name = $settings['app_name'];
    $admin_email = $settings['admin_email'];
}
else {
    $app_name = 'service app';
    $admin_email = 'admin@admin.com';
}
$config = ["app_name" => $app_name,
           "admin_email"=> $admin_email,
           "lang" => "en",
           "dir" => "ltr",
           "app_url"=>"http://127.0.0.1/flexcorses/start/",
           "admin_assets"=>"http://127.0.0.1/flexcorses/start/admin/template/assets"
];