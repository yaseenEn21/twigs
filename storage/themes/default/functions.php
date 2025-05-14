<?php
/**
 * =======================================================================================
 *                           GemFramework (c) GemPixel                                     
 * ---------------------------------------------------------------------------------------
 *  This software is packaged with an exclusive framework as such distribution
 *  or modification of this framework is not allowed before prior consent from
 *  GemPixel. If you find that this framework is packaged in a software not distributed 
 *  by GemPixel or authorized parties, you must not use this software and contact gempixel
 *  at https://gempixel.com/contact to inform them of this misuse.
 * =======================================================================================
 *
 * @package GemPixel\Premium-URL-Shortener
 * @author GemPixel (https://gempixel.com) 
 * @license https://gempixel.com/licenses
 * @link https://gempixel.com  
 */
use Core\Plugin;

Gem::post('/admin/themes/settings/update', 'themeSettings@update')->name('admin.themes.update')->middleware('Auth@admin');

Plugin::register('admin.theme.getoptions', [themeSettings::class, 'settings']);

Plugin::register('homemenu', [themeSettings::class, 'menu']);


if(isset(config('theme_config')->siteimage) && config('theme_config')->siteimage){
    \Core\View::set('image', uploads(config('theme_config')->siteimage));
}