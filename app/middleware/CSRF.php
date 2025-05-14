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

final class CSRF extends Middleware {

	/**
	 * Do not un CSRF for these routes
	 * @var array
	 */
	protected $_exempt = ['shorten', 'user/qr/preview', 'api/*', 'admin/languages/translate', 'user/bio/'];
	/**
	 * Error Message
	 * @var string
	 */
	protected $message = "An unexpected error occurred. Please try again.";

	/**
	 * Validate CSRF Token
	 * @author GemPixel <https://gempixel.com>
	 * @version 6.7
	 */
	public function handle(Request $request) {

		// @group Plugin
		$exempts = \Core\Plugin::dispatch('middleware.csrf.exempt');

		self::add($exempts);
		
		if(self::check($request) === false) return true;
		
		if(isset($_SESSION[Helper::CSRFNAME]) && ($_SESSION[Helper::CSRFNAME] == trim($request->_token))) {
			unset($_SESSION[Helper::CSRFNAME]);
			return true;
		}

		if($request->isAjax()){
			(new \Core\Response(['error' => true, 'message' => e($this->message)]))->json();
			exit;
		}
		Helper::redirect()->back()->with("danger", e($this->message));
		exit;
	}
}