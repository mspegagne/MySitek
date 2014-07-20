<?php



// init
ob_start(); 
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
ini_set('display_errors', 1);
@set_time_limit(0);
 
/**
 * @brief Setup class with a few helper functions
 *
 */ 
class Install {

 
	/**
	* @brief Checks if all the ownCloud dependencies are installed
	* @return string with error messages
	*/ 
	public function checkdependencies() {
		$error='';
		
		// do we have PHP 5.3.2 or newer?
                if(version_compare(PHP_VERSION, '5.3.2', '<')) {
			$error.='PHP 5.3.2 is required. Please ask your server administrator to update PHP to version 5.3.2 or higher. PHP 5.2 is no longer supported by ownCloud and the PHP community.';
		}
		
		// do we have the zip module?
		if(!class_exists('ZipArchive')){
			$error.='PHP module zip not installed. Please ask your server administrator to install the module.';
		}

		// do we have the curl module?
		if(!function_exists('curl_exec')){
			$error.='PHP module curl not installed. Please ask your server administrator to install the module.';
		}
		
		// do we have write permission?
		if(!is_writable('.')) {
			$error.='Can\'t write to the current directory. Please fix this by giving the webserver user write access to the directory.';
		}

		// is safe_mode enabled?
		if(ini_get('safe_mode')) {
			$error.='PHP Safe Mode is enabled. ownCloud requires that it is disabled to work properly.';
		}
		
		return($error);
	}


	/**
	* @brief Check the cURL version
	* @return bool status of CURLOPT_CERTINFO implementation
	*/ 
	public function iscertinfoavailable(){
		$curlDetails =  curl_version();
		return version_compare($curlDetails['version'], '7.19.1') != -1;
	}


 
	/**
	* @brief Performs the ownCloud install. 
	* @return string with error messages
	*/ 
       public static function installation($file, $type, $app) {	
		$error='';
		
		// downloading latest release
		$error.=Install::getfile('http://download.mysitek.com/'.$type.'/'.$file.'.zip',''.$file.'.zip');
		
		// unpacking into owncloud folder
		$zip = new ZipArchive;
		$res = $zip->open(''.$file.'.zip');
		if ($res==true) {
			$zip->extractTo('apps/'.$type.'/');
			$zip->close();

		} else {
			$error.='Extraction du zip a échoué.';
		}

		// deleting zip file
		$result=@unlink(''.$file.'.zip');
		if($result==false) $error.='La suppression du zip a échoué.';
                
                include_once __DIR__ . '/../../apps/' . $type . '/' . $file . '/setup.php';

                // deleting setup file
		$result=@unlink(__DIR__ . '/../../apps/' . $type . '/' . $file . '/setup.php');
		if($result==false) $error.='La suppresion du fichier setup a échoué.';
                
		return($error);                
	}

	 
	/**
	* @brief Downloads a file and stores it in the local filesystem
	* @param url $url
	* @param path $path	
	* @return string with error messages
	*/ 
	public static function getfile($url,$path) {
		$error='';

		$fp = fopen ($path, 'w+');
		$ch = curl_init($url); 
		curl_setopt($ch, CURLOPT_TIMEOUT, 0);
		curl_setopt($ch, CURLOPT_FILE, $fp); 
		curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		if (Install::iscertinfoavailable()){
			curl_setopt($ch, CURLOPT_CERTINFO, TRUE); 
		}
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE); 
		$data=curl_exec($ch);
		$curlerror=curl_error($ch);
		curl_close($ch);
		fclose($fp);
 
		if($data==false){
			$error.='Le téléchargement à partir des serveurs de MySitek a échoué.'.$curlerror;	
		}
		return($error.$curlerror);

	}
 
  
	

	/**
	* @brief Shows the check dependencies screen
	*/ 
	public static function showcheckdependencies(){
		$error=Install::checkdependencies();
		if($error=='') {
			$txt='Le système est prêt pour l\'installation.';
		}else{
			$txt='Le système n\'est pas configuré l\'installation.'.$error;
		}
                return($txt);                
	}


	/**
	* @brief Shows the install screen
	*/ 
	public static function showinstall($file, $type, $app){
		$error=Install::installation($file, $type, $app);
	
		if($error=='') {
			$txt='Le fichier est maintenant installé';
		}else{
			$txt='L\'installation a échouée'.$error;
		}
                return($txt);    
	}


	
}


?>
