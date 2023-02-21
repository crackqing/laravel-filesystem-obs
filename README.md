# Huawei Cloud OBS for Laravel

[Huawei Cloud OBS](https://www.huaweicloud.com/product/obs.html) storage for Laravel based on [wangqs/laravel-filesystem-obs](https://github.com/wqsacy/laravel-filesystem-obs). 

- 只适用公司产品,修复高版本兼容问题.
- Lumen5.8版本适配能过
# Requirement
- PHP >= 7.3

# Installation

```shell
$ composer require "JkYang/laravel-filesystem-obs" -vvv
```

# Configuration

1. After installing the library, register the `JkYang\Obs\ObsServiceProvider` in your `config/app.php` file:

  ```php
  'providers' => [
      // Other service providers...
      JkYang\Obs\ObsServiceProvider::class,
  ],
  ```

2. Add a new disk to your `config/filesystems.php` config:
 ```php
 <?php

 return [
    'disks' => [
        //...
        'hw_obs' => [
            'driver' => 'obs',
            'key' => env('OBS_ACCESS_ID'), // <AccessKeyId>
            'secret' => env('OBS_ACCESS_KEY'), // <OBS AccessKeySecret>
            'bucket' => env('OBS_BUCKET'), // <OBS bucket name>
            'endpoint' => env('OBS_ENDPOINT'), // <the endpoint of OBS, E.g: (https:// or http://).obs.cn-east-2.myhuaweicloud.com | custom domain, E.g:img.abc.com> 
            'cdn_domain' => env('OBS_CDN_DOMAIN'), //<CDN domain>
            'ssl_verify' => env('OBS_SSL_VERIFY'), // <true|false> true to use 'https://' and false to use 'http://'. default is false,
            'debug' => env('APP_DEBUG'), // <true|false>
        ],
        //...
     ]
 ];
 ```

# Usage

```php
$disk = Storage::disk('hw_obs');

// create a file
$disk->put('avatars/filename.jpg', $fileContents);

// check if a file exists
$exists = $disk->has('file.jpg');

// get timestamp
$time = $disk->lastModified('file1.jpg');
$time = $disk->getTimestamp('file1.jpg');

// copy a file
$disk->copy('old/file1.jpg', 'new/file1.jpg');

// move a file
$disk->move('old/file1.jpg', 'new/file1.jpg');

// get file contents
$contents = $disk->read('folder/my_file.txt');

// fetch url content
$file = $disk->fetch('folder/save_as.txt', $fromUrl);

// get file url
$url = $disk->getUrl('folder/my_file.txt');

// get file upload token
$token = $disk->getUploadToken('folder/my_file.txt');
$token = $disk->getUploadToken('folder/my_file.txt', 3600);

// get private url
$url = $disk->privateDownloadUrl('folder/my_file.txt');
```

[Full API documentation.](http://flysystem.thephpleague.com/api/)

# License

MIT