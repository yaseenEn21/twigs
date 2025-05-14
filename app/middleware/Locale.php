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

namespace Middleware;

use Core\Helper;
use Core\Request;
use Core\Localization;
use Core\Response;

final class Locale {
	/**
	 * Handle Locales
	 * @author GemPixel <https://gempixel.com>
	 * @version 1.0
	 * @return  [type] [description]
	 */
	public function handle() { }
	/**
	 * Change Admin Locale
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 1.0
	 * @return void
	 */
	public function admin(){		
        Localization::setFile('admin');
        Localization::update();
	}	
}