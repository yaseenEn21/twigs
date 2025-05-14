<?php 
/**
 * ====================================================================================
 *                           GemFramework (c) GemPixel
 * ----------------------------------------------------------------------------------
 *  This software is packaged with an exclusive framework owned by GemPixel Inc as such
 *  distribution or modification of this framework is not allowed before prior consent
 *  from GemPixel administrators. If you find that this framework is packaged in a 
 *  software not distributed by GemPixel or authorized parties, you must not use this
 *  software and contact GemPixel at https://gempixel.com/contact to inform them of this
 *  misuse otherwise you risk of being prosecuted in courts.
 * ====================================================================================
 *
 * @package GemFramework
 * @author GemPixel (http://gempixel.com) 
 * @license http://gempixel.com/license
 * @link http://gempixel.com  
 * @since 1.0
 */

namespace Models;

use Gem;
use Core\Model;

class Settings extends Model {

	public static $_table = DBprefix.'settings';
    
	/**
	 * Fetch and format settings from DB
	 * 
	 * @author GemPixel <https://gempixel.com>
	 * @version 1.0
	 * @return  object Settings table results as associated object
	 */
	public static function getSettings() : object {
		
		\Core\Support\ORM::configure('id_column_overrides', array(
			self::$_table  => 'config'
		));

		$config = new \stdCLass;	

		try{
			$settings = \Core\DB::settings()->findMany();
		}catch(\Exception $e){
			die(\GemError::trigger('500', 'Cannot find the settings table. Please make sure the tables are imported correctly.'));
		}
		
		foreach ($settings as $row) {
			$config->{$row->config} = parseIfJSON($row->var);
		}

		date_default_timezone_set(!empty($config->timezone) ? $config->timezone : TIMEZONE);

		$lang = $config->default_lang;

		$request = request();

		if(appConfig('app.browserbasedlang') && $accept_language = $request->server('http_accept_language')){
			if(\Core\Localization::exists(substr($accept_language, 0, 2))){
				$lang = substr($accept_language, 0, 2);
			}
		}

        if($request->cookie('language')){
            $lang = $request->cookie('language');
        }

        if($request->lang && is_string($request->lang)){
            $request->cookie('language', $request->lang, 60*24);
            $lang = $request->lang;
        }

		if(in_array(request()->segment(1), \Core\Localization::listArray())){
			$lang = request()->segment(1);
		}

		\Core\Localization::setLocale($lang);
		\Core\Localization::bootstrap();

		if(isset($config->cdn) && 
			$config->cdn->enabled && 
			!empty($config->cdn->key) &&
			!empty($config->cdn->secret) &&
			!empty($config->cdn->region)
		) {
			
			\Core\Request::setCDN(\Helpers\CDN::class);
			
			if(!defined('CDNCUSTOMURL')) {
				define('CDNCUSTOMURL', !empty($config->cdn->url) ? $config->cdn->url : \Helpers\CDN::url($config->cdn));
			}
		}
		$config->title = e($config->title);
		$config->description = e($config->description);

		return $config;		
	}	
	/**
	 * Write setting to database
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @param [type] $name
	 * @param [type] $value
	 * @return void
	 */
	public static function setSetting($name, $value){
		
		\Core\Support\ORM::configure('id_column_overrides', array(
			self::$_table  => 'config'
		));

		if($setting = \Core\DB::settings()->where('config', $name)->first()){
			$setting->var = $value;
			$setting->save();
			return true;
		}

		return false;
	}
	/**
	 * Update Settings
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 6.0
	 * @return void
	 */
	public static function updateSettings(){	
		\Core\Helper::set("config", self::getSettings());
	}
}