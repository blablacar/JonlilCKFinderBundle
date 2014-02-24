<?php
/**
 * User: jonas
 * Date: 2013-03-03
 * Time: 11:27
 *
 * Use with love
 */

namespace Jonlil\CKFinderBundle\Connector;

use Symfony\Component\HttpFoundation\Request;


class s3 extends AbstractConnector
{
    private $mustHave = array(
        'base_url',
        'base_dir',
        'access_key',
        'secret',
        'bucket',
        'thumbnails_file',
        'thumbnails_enabled',
        'direct_access',
        'file_delete',
        'file_view',
        'file_upload',
        'file_rename',
        'folder_view',
        'folder_create',
        'folder_rename',
        'folder_delete',
    );

    protected function build_config ()
    {
        foreach($this->mustHave as $key) {
            if (!array_key_exists($key, $this->parameters['amazon'])) {
                throw new \Exception(sprintf('Amazon %s must be set', $key));
            }
        }

        $base_url = preg_replace('/https*:\/\/(.*)\.amazonaws\.com.*/', '\1.amazonaws.com', $this->parameters['amazon']['base_url']);
        $sslUse = preg_match('/https/', $this->parameters['amazon']['base_url']);
        $GLOBALS['config']['AmazonS3'] = array(
            'AccessKey' => $this->parameters['amazon']['access_key'],
            'SecretKey' => $this->parameters['amazon']['secret'],
            'Bucket' => $this->parameters['amazon']['bucket'],
            'BaseUrl' => $base_url,
            'SslUse' => $sslUse
        );

        $GLOBALS['config']['LicenseName'] = $this->parameters['license']['name'];
        $GLOBALS['config']['LicenseKey'] = $this->parameters['license']['key'];

        $thumnailsSuffix = $this->parameters['amazon']['thumbnails_file']? '_thumbs': '';
        $GLOBALS['config']['Thumbnails'] = Array(
            'url' => $this->parameters['baseUrl'] . '/' . $this->parameters['amazon']['bucket'] . '/' . $this->parameters['baseDir'] . '/' . $thumnailsSuffix . '/',
            'directory' => $this->parameters['baseDir'] . $thumnailsSuffix,
            'enabled' => $this->parameters['amazon']['thumbnails_enabled'],
            'directAccess' => $this->parameters['amazon']['direct_access'],
            'maxWidth' => 100,
            'maxHeight' => 100,
            'bmpSupported' => false,
            'quality' => 80
        );

        $GLOBALS['config']['Images'] = Array(
            'maxWidth' => 1600,
            'maxHeight' => 1200,
            'quality' => 80
        );

        $GLOBALS['config']['RoleSessionVar'] = 'CKFinder_UserRole';

        $GLOBALS['config']['AccessControl'][] = Array(
            'role' => '*',
            'resourceType' => '*',
            'folder' => '/',

            'folderView' => $this->parameters['amazon']['folder_view'],
            'folderCreate' => $this->parameters['amazon']['folder_create'],
            'folderRename' => $this->parameters['amazon']['folder_rename'],
            'folderDelete' => $this->parameters['amazon']['folder_delete'],

            'fileView' => $this->parameters['amazon']['file_view'],
            'fileUpload' => $this->parameters['amazon']['file_upload'],
            'fileRename' => $this->parameters['amazon']['file_rename'],
            'fileDelete' => $this->parameters['amazon']['file_delete']
        );

        $GLOBALS['config']['DefaultResourceTypes'] = '';
        $GLOBALS['config']['ResourceType'][] = Array(
            'name' => 'Files',				// Single quotes not allowed
            'url' => $this->parameters['baseUrl'] . '/' . $this->parameters['amazon']['bucket'] . '/files',
            'directory' => $this->parameters['baseDir'] . 'files',
            'maxSize' => 0,
            'allowedExtensions' => '7z,aiff,asf,avi,bmp,csv,doc,docx,fla,flv,gif,gz,gzip,jpeg,jpg,mid,mov,mp3,mp4,mpc,mpeg,mpg,ods,odt,pdf,png,ppt,pptx,pxd,qt,ram,rar,rm,rmi,rmvb,rtf,sdc,sitd,swf,sxc,sxw,tar,tgz,tif,tiff,txt,vsd,wav,wma,wmv,xls,xlsx,zip',
            'deniedExtensions' => ''
        );

        $GLOBALS['config']['ResourceType'][] = Array(
            'name' => 'Images',
            'url' => $this->parameters['baseUrl'] . '/' . $this->parameters['amazon']['bucket'] . '/images',
            'directory' => $this->parameters['baseDir'] . 'images',
            'maxSize' => 0,
            'allowedExtensions' => 'bmp,gif,jpeg,jpg,png',
            'deniedExtensions' => ''
        );

        $GLOBALS['config']['ResourceType'][] = Array(
            'name' => 'Flash',
            'url' => $this->parameters['baseUrl'] . '/' . $this->parameters['amazon']['bucket'] . '/flash',
            'directory' => $this->parameters['baseDir'] . 'flash',
            'maxSize' => 0,
            'allowedExtensions' => 'swf,flv',
            'deniedExtensions' => ''
        );

        $GLOBALS['config']['CheckDoubleExtension'] = true;
        $GLOBALS['config']['DisallowUnsafeCharacters'] = false;
        $GLOBALS['config']['FilesystemEncoding'] = 'UTF-8';
        $GLOBALS['config']['SecureImageUploads'] = true;
        $GLOBALS['config']['CheckSizeAfterScaling'] = true;
        $GLOBALS['config']['HtmlExtensions'] = array('html', 'htm', 'xml', 'js');
        $GLOBALS['config']['HideFolders'] = Array(".*", "CVS");
        $GLOBALS['config']['HideFiles'] = Array(".*");
        $GLOBALS['config']['ChmodFiles'] = 0777 ;
        $GLOBALS['config']['ChmodFolders'] = 0755 ;
        $GLOBALS['config']['ForceAscii'] = false;
        $GLOBALS['config']['XSendfile'] = false;

        $GLOBALS['config']['plugin_imageresize']['smallThumb'] = '90x90';
        $GLOBALS['config']['plugin_imageresize']['mediumThumb'] = '120x120';
        $GLOBALS['config']['plugin_imageresize']['largeThumb'] = '180x180';

    }


    protected function req()
    {
        parent::req();

        require_once CKFINDER_CONNECTOR_LIB_DIR.'/Utils/AmazonS3.php';
    }

    protected function setup_defined_params()
    {
        define('IN_CKFINDER', true);
        define('CKFINDER_CONNECTOR_ERROR_NONE',0);
        define('CKFINDER_CONNECTOR_ERROR_CUSTOM_ERROR',1);
        define('CKFINDER_CONNECTOR_ERROR_INVALID_COMMAND',10);
        define('CKFINDER_CONNECTOR_ERROR_TYPE_NOT_SPECIFIED',11);
        define('CKFINDER_CONNECTOR_ERROR_INVALID_TYPE',12);
        define('CKFINDER_CONNECTOR_ERROR_INVALID_NAME',102);
        define('CKFINDER_CONNECTOR_ERROR_UNAUTHORIZED',103);
        define('CKFINDER_CONNECTOR_ERROR_ACCESS_DENIED',104);
        define('CKFINDER_CONNECTOR_ERROR_INVALID_EXTENSION',105);
        define('CKFINDER_CONNECTOR_ERROR_INVALID_REQUEST',109);
        define('CKFINDER_CONNECTOR_ERROR_UNKNOWN',110);
        define('CKFINDER_CONNECTOR_ERROR_CREATED_FILE_TOO_BIG',111);
        define('CKFINDER_CONNECTOR_ERROR_ALREADY_EXIST',115);
        define('CKFINDER_CONNECTOR_ERROR_FOLDER_NOT_FOUND',116);
        define('CKFINDER_CONNECTOR_ERROR_FILE_NOT_FOUND',117);
        define('CKFINDER_CONNECTOR_ERROR_SOURCE_AND_TARGET_PATH_EQUAL',118);
        define('CKFINDER_CONNECTOR_ERROR_UPLOADED_FILE_RENAMED',201);
        define('CKFINDER_CONNECTOR_ERROR_UPLOADED_INVALID',202);
        define('CKFINDER_CONNECTOR_ERROR_UPLOADED_TOO_BIG',203);
        define('CKFINDER_CONNECTOR_ERROR_UPLOADED_CORRUPT',204);
        define('CKFINDER_CONNECTOR_ERROR_UPLOADED_NO_TMP_DIR',205);
        define('CKFINDER_CONNECTOR_ERROR_UPLOADED_WRONG_HTML_FILE',206);
        define('CKFINDER_CONNECTOR_ERROR_UPLOADED_INVALID_NAME_RENAMED', 207);
        define('CKFINDER_CONNECTOR_ERROR_MOVE_FAILED',300);
        define('CKFINDER_CONNECTOR_ERROR_COPY_FAILED',301);
        define('CKFINDER_CONNECTOR_ERROR_DELETE_FAILED',302);
        define('CKFINDER_CONNECTOR_ERROR_ZIP_FAILED',303);
        define('CKFINDER_CONNECTOR_ERROR_CONNECTOR_DISABLED',500);
        define('CKFINDER_CONNECTOR_ERROR_THUMBNAILS_DISABLED',501);

        define('CKFINDER_CONNECTOR_DEFAULT_USER_FILES_PATH', $this->parameters['baseUrl'] . '/'.$this->parameters['amazon']['bucket'].'/');
        define('CKFINDER_CONNECTOR_LANG_PATH', $this->parameters['path'] . $this->parameters['connector'] . "lang");
        define('CKFINDER_CONNECTOR_CONFIG_FILE_PATH', __DIR__ . "/../config.php");

        if (version_compare(phpversion(), '6', '>=')) {
            define('CKFINDER_CONNECTOR_PHP_MODE', 6);
        }
        else {
            define('CKFINDER_CONNECTOR_PHP_MODE', 5);
        }

        define('CKFINDER_CONNECTOR_LIB_DIR', $this->parameters['path'] . $this->parameters['connector'] . "php5");

        define('CKFINDER_CHARS', '123456789ABCDEFGHJKLMNPQRSTUVWXYZ');
        define('CKFINDER_REGEX_IMAGES_EXT', '/\.(jpg|gif|png|bmp|jpeg)$/i');
        define('CKFINDER_REGEX_INVALID_PATH', ",(/\.)|[[:cntrl:]]|(//)|(\\\\)|([\\:\*\?\"\<\>\|]),");
        define('CKFINDER_REGEX_INVALID_FILE', ",[[:cntrl:]]|[/\\:\*\?\"\<\>\|],");
    }
}