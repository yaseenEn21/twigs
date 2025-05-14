<?php  
/**
 * =======================================================================================
 *                           GemFramework (c) GemPixel                                     
 * ---------------------------------------------------------------------------------------
 *  This software is packaged with an exclusive framework as such distribution
 *  or modification of this framework is not allowed before prior consent from
 *  GemPixel. If you find that this framework is packaged in a software not distributed 
 *  by GemPixel or authorized parties, you must not use this software and contact GemPixel
 *  at https://gempixel.com/contact to inform them of this misuse.
 * =======================================================================================
 *
 * @package GemPixel\Premium-URL-Shortener
 * @author GemPixel (https://gempixel.com) 
 * @license https://gempixel.com/licenses
 * @link https://gempixel.com  
 */

namespace Helpers;

class AutoUpdate {

	/**
	 * Constant
	 */
	const latestVersion = "1.0";
	const serverURL = "https://cdn.gempixel.com/updater";
	/**
	 * Private
	 * @var null
	 */
	private $endpoint = NULL;	
	private $purchaseKey = NULL;
	private $error = NULL;

	/**
	 * [__construct description]
	 * @author KBRmedia <https://gempixel.com>
	 * @version 1.0
	 */
	
	public function __construct($key) {		
		$this->purchaseKey = $key;
	}
	/**
	 * [install description]
	 * @author KBRmedia <https://gempixel.com>
	 * @version 1.0
	 * @return  [type] [description]
	 */
	public function install(){
		// Check to make sure everything is OK
		$this->check();
		
		if($this->verify()){
			return true;
		}

		$this->error = "An unexpected error occurred. Please update manually.";
		throw new \Exception($this->error);		
		return false;		
	}
	/**
	 * [check description]
	 * @author KBRmedia <https://gempixel.com>
	 * @version 1.0
	 * @return  [type] [description]
	 */
	private function check(){		
		// Check cURL
		if(!in_array('curl', get_loaded_extensions())){ 
			$this->error = "cURL library is not available. Please update manually.";
			throw new \Exception($this->error);			
			return false;
		}

		// Check ZipArchive
		if(!class_exists("ZipArchive")){
			$this->error = "ZipArchive library is not available. Please update manually.";
			throw new \Exception($this->error);			
			return false;
		}

		// Check Permission
		if(!is_writable(ROOT)){
			$this->error = ROOT." is not writable. Please change the permission to 775.";
			throw new \Exception($this->error);			
			return false;
		}

		// Check Key
		if(is_null($this->purchaseKey) || empty($this->purchaseKey)){
			$this->error = "Purchase key is invalid. You can find your purchase key in the downloads section of codecanyon.";
			throw new \Exception($this->error);			
			return false;			
		}
	}
	/**
	 * [getMessage description]
	 * @author KBRmedia <https://gempixel.com>
	 * @version 1.0
	 * @return  [type] [description]
	 */
	public function getMessage(){
			return $this->error;
	}
	/**
	 * [verify description]
	 * @author KBRmedia <https://gempixel.com>
	 * @version 1.0
	 * @return  [type] [description]
	 */
	private function verify(){	

		$this->endpoint = self::serverURL."/".self::latestVersion."/";
		
		$response = $this->http(["data" => ["url" => \url()]]);

		$http = json_decode($response);

		if(isset($http->status) && $http->status == "validated"){
			return $this->download($http->download);
		}

		$this->error = "An error occurred: {$http->message}";
		throw new \Exception($this->error);		
		return false;
	}

	/**
	 * [download description]
	 * @author KBRmedia <https://gempixel.com>
	 * @version 1.0
	 * @return  [type] [description]
	 */
	protected function download($link){
		$this->endpoint = $link;
		
		$content = $this->http();

		if(!file_put_contents(ROOT."/main-auto.zip", $content)){
			$this->error = "The file cannot be downloaded due to server permission. Please change directory permission or update manually.";
			throw new \Exception($this->error);		
			return false;			    
		}
		
		return $this->extract();
	}

	/**
	 * [extract description]
	 * @author KBRmedia <https://gempixel.com>
	 * @version 1.0
	 * @return  [type] [description]
	 */
	protected function extract(){
	
		$zip = new \ZipArchive();
		$file = $zip->open(ROOT."/main-auto.zip");

		if($file === true) {
      
			if(!$zip->extractTo(ROOT."/")){
					$this->error = "The file was downloaded but cannot be extracted due to server permission. Please extract it manually.";
					throw new \Exception($this->error);		
					return false;	
			}

			$zip->close();
      
    	} else {
			$this->error = "The file cannot be extracted due to server permission. Please extract it manually.";
			throw new \Exception($this->error);		
			return false;	    	
	  	}

	 	 return $this->update();
	}
	/**
	 * [update description]
	 * @author KBRmedia <https://gempixel.com>
	 * @version 1.0
	 * @return  [type] [description]
	 */
	protected function update(){
		$this->endpoint = \url()."update?update=true&privatekey=".md5('update.'.AuthToken);
		$this->http();
		return $this->clean();
	}

	/**
	 * [clean description]
	 * @author KBRmedia <https://gempixel.com>
	 * @version 1.0
	 * @return  [type] [description]
	 */
	protected function clean(){
		if(file_exists(ROOT."/main-auto.zip")){
			unlink(ROOT."/main-auto.zip");
			return true;
		}
	}
	/**
	 * [http description]
	 * @author KBRmedia <https://gempixel.com>
	 * @version 1.0
	 * @param   [type] $url    [description]
	 * @param   array  $option [description]
	 * @return  [type]         [description]
	 */
	protected function http($option = []){  

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $this->endpoint);

		if(isset($option["data"]) && is_array($option["data"])){
			
			$fields = "";
			foreach($option["data"] as $key => $value) { $fields .= $key.'='.$value.'&'; }
			rtrim($fields, '&');       

			curl_setopt($curl, CURLOPT_POST, count($option["data"]));
			curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);
		}

		curl_setopt($curl, CURLOPT_HTTPHEADER, [
			"X-Authorization: TOKEN ".$this->purchaseKey,
			"X-Script: Premium URL Shortener",
			"X-Version: ".config('version')
		]);

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$response = curl_exec($curl);
		curl_close($curl);

		return $response;
	}  	
}