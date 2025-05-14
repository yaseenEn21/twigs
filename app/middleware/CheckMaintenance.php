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

use Core\Middleware;
use Core\Request;
use Core\Helper;
use Core\View;
use Core\Auth;

final class CheckMaintenance extends Middleware {    
	/**
	 * Check Maintenance mode
	 * @author GemPixel <https://gempixel.com>
	 * @version 6.6
	 */
	public function handle(Request $request) {
        
		$user = Auth::logged() ? Auth::user() : null;
        
        if(config('maintenance') && !$user){
            View::set('title', e('Offline for Maintenance'));
            View::with('maintenance')->extend('layouts.auth'); 
            exit;
        }

        return true;        
	}
}