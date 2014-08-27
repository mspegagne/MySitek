<?php
/*
 * jQuery File Upload Plugin PHP Example 5.14
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

error_reporting(E_ALL | E_STRICT);
require('../../../../../../../lib/Blueimp/Upload/server/php/UploadHandler.php');
$upload_handler = new UploadHandler(array(
    'accept_file_types' => '/\.(gif|jpe?g|png)$/i',
    'script_url' => $_SERVER['PHP_SELF'],
    'upload_dir' => '../../../../../../../data/img/',
    'upload_url' => '../../../../../../../data/img/',
            
            
));

