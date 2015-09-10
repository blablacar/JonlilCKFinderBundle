#### JonlilCKFinderBundle

- Check out the [documentation on CKFinder](http://cksource.com/ckfinder).
- If you plan to configure ckeditor a little bit more, look at the [IvoryCKeditorBundle](https://github.com/egeloen/IvoryCKEditorBundle).

1) Installation
-------------------------

Add the following line in the `require` section of your `composer.json`:

for using CKEditor 4.4.6 and greater:
```json
"jonlil/ckfinder-bundle": "3.*"
```

for using CKEditor 4.4.5 and less:
```json
"jonlil/ckfinder-bundle": "2.*"
```

Register the bundle in the `app/AppKernel.php`:
```php
public function registerBundles()
{
    $bundles = array(
        new Ivory\CKEditorBundle\IvoryCKEditorBundle(),
        new Jonlil\CKFinderBundle\JonlilCKFinderBundle('IvoryCKEditorBundle'),
    );
}
```

2) Configuration
--------------------------

##### Routing
```yaml
# app/config/routing.yml

ck_finder:
    resource: "@JonlilCKFinderBundle/Resources/config/routing/routing.yml"
    prefix: /ckfinder
```

##### For usage with amazon s3
```yaml
# app/config/config.yml

jonlil_ck_finder:
    license:
        key: ""
        name: ""
    baseDir: "/"
    baseUrl: "http://s3.amazonaws.com"
    service: "s3"
    accessKey: ""
    secret: ""
    bucket: ""
```

There are also some optional parameters :

"thumbnailsEnabled": if you want to display thumbnails on the different images

"thumbnailsFile": to use a specific thumbnails to make a preview

"directAccess": if you have a direct access to the file forthe preview

"fileDelete", "fileRename", "fileUpload", "fileView": if you want to prevent some file action

"folderRename", "folderDelete", "folderCreate", "folderView": If you want to prevent some action on the folder

##### For usage with native php storage
```yaml
jonlil_ck_finder:
    license: # optional, can be used in demo mode also
        key: ""
        name: ""
    baseDir: "%assetic.read_from%"
    baseUrl: "/userfiles/"  # path where your files will be stored
    service: "php"
```

##### Authentication
```yaml
# app/config/config.yml

parameters:
    jonlil.ckfinder.customAuthentication: %kernel.root_dir%/...path your custom config.php or any other file
```
Write your own function CheckAuthentication() in your custom config.php 

Examlple:

```php
function CheckAuthentication()
{
	isset($_SESSION['IsAuthorized']) && $_SESSION['IsAuthorized'];

}
```


3) Usage
--------------------------
```php

# in your symfony2 form - add this
public function buildForm (FormBuilderInterface $builder, array $options)
{
    $builder
        ->add('title')
        ->add('text', 'ckfinder')
        ->add('createdAt')
        ->add('updatedAt')
    ;
}
```

4) Testing
---------------------------
This bundle provides a set of integration tests you should run whenever you make changes in the source code.

- Git clone the bundle.
- Execute `composer update`
- Run `php vendor/bin/phpunit`

5) Todos
---------------------------
Fix amazon s3 thumbnails - Refer to this project https://github.com/jonlil/ckfinder

Security should be managed in `CheckAuthentication()`. Look at the `config.php` file for further details.

