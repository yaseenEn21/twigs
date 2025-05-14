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

namespace User;

use \Core\Helper;
use \Core\View;
use \Core\DB;
use \Core\Auth;
use \Core\Request;

class Export {     
    /**
     * Check if user can export
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     */
    public function __construct(){
        if(\Models\User::where('id', Auth::user()->rID())->first()->has('export') === false){
			return \Models\Plans::notAllowed();
		}
    }
    /**
     * Export Data
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function links(Request $request){      

        if(Auth::user()->teamPermission('export.create') == false){
			return Helper::redirect()->to(route('dashboard'))->with('danger', e('You do not have this permission. Please contact your team administrator.'));
		}  

        $links = DB::url()
                    ->where('userid', Auth::user()->rID())
                    ->whereNull('qrid')
                    ->whereNull('profileid')
                    ->orderByDesc('date')
                    ->findArray();

        return \Core\File::contentDownload('MyLinks-'.date('d-m-Y').'.csv', function() use ($links) {

			echo "Short URL,Long URL,QR Code,Campaign,Date,Clicks,Unique Clicks\n";
            foreach($links as $url){
                $name = null;
                if($url['bundle']){
                    if($campaign = DB::bundle()->first($url['bundle'])){
                        $name = $campaign->name;
                    }
                }
                echo ($url['domain'] ? $url['domain'] : config('url'))."/".$url['alias'].$url['custom'].",\"{$url['url']}\",".(($url['domain'] ? $url['domain'] : config('url'))."/".$url['alias'].$url['custom'])."/qr,{$name},{$url['date']},{$url['click']},{$url['uniqueclick']}\n";
            }
		});
    }
    /**
     * Export Single Stats
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param integer $id
     * @return void
     */
    public function single(int $id){

        if(Auth::user()->teamPermission('export.create') == false){
			return Helper::redirect()->to(route('dashboard'))->with('danger', e('You do not have this permission. Please contact your team administrator.'));
		}  

        if(!$url = DB::url()->select('alias')->select('custom')->select('domain')->where('id', $id)->first()) {
            return Helper::redirect()->back()->with('danger', e('Link does not exist.'));
        }

        $stats = DB::stats()->where("urluserid", Auth::user()->rID())->where('urlid', $id)->orderByDesc('date')->findArray();

        $content = "Short URL,Date,City,Country,Browser,Platform,Language,Domain,Referer\n";
        
        foreach($stats as $data){

            $content .= ($url->domain ? $url->domain : config('url'))."/".$url->alias.$url->custom.",{$data['date']},{$data['city']},{$data['country']},{$data['browser']},{$data['os']},{$data['language']},{$data['domain']},{$data['referer']}\n";
        }

        $response = new \Core\Response($content, 200, ['content-type' => 'text/csv', 'content-disposition' => 'attachment;filename=ReportLink_'.Helper::dtime('now', 'd-m-Y').'.csv']);
        
        return $response->send();
    }

    /**
     * Export User Stats
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.9.3
     * @param \Core\Request $request
     * @param integer $id
     * @return void
     */
    public function stats(Request $request){

        if(Auth::user()->teamPermission('export.create') == false){
			return Helper::redirect()->to(route('dashboard'))->with('danger', e('You do not have this permission. Please contact your team administrator.'));
		}  
        
        if(!$request->range) return Helper::redirect()->back()->with('danger', e('Please specify a range.')); 

        $range = explode(' - ', $request->range);       

        $stats = DB::stats()->where("urluserid", Auth::user()->rID())->orderByDesc('date');

        if($range && strtotime($range[0]) && strtotime($range[1])) {
            $stats->whereRaw("DATE(date) BETWEEN '".date('Y-m-d', strtotime($range[0]))." 00:00:00' AND '".date('Y-m-d', strtotime($range[1]))." 23:59:59'");
        }

        $content = "Short URL,Date,City,Country,Browser,Platform,Language,Domain,Referer\n";
        
        foreach($stats->findArray() as $data){

            if(!$url = DB::url()->select('alias')->select('custom')->select('domain')->where('id', $data['urlid'])->first()) continue;

            $content .= ($url->domain ? $url->domain : config('url'))."/".$url->alias.$url->custom.",{$data['date']},{$data['city']},{$data['country']},{$data['browser']},{$data['os']},{$data['language']},{$data['domain']},{$data['referer']}\n";
        }

        $response = new \Core\Response($content, 200, ['content-type' => 'text/csv', 'content-disposition' => 'attachment;filename=ReportAll_'.Helper::dtime('now', 'd-m-Y').'.csv']);
        
        return $response->send();
    }  
    /**
     * Export Campaign Stats
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.9.3
     * @param \Core\Request $request
     * @param integer $id
     * @return void
     */
    public function campaign(Request $request, int $id){

        if(Auth::user()->teamPermission('export.create') == false){
			return Helper::redirect()->to(route('dashboard'))->with('danger', e('You do not have this permission. Please contact your team administrator.'));
		}  

        
        if(!\Core\Auth::user()->has('export')){
            return \Models\Plans::notAllowed();
        }

        if(!$request->range) return Helper::redirect()->back()->with('danger', e('Please specify a range.')); 

        $range = explode(' - ', $request->range);

        if(!$bundle = DB::bundle()->where('id', $id)->where('userid', Auth::user()->rID())->first()){
            return Response::factory('', 404)->json();
        }

        $urls = [];
        foreach(DB::url()->select('id')->where('bundle', $id)->find() as $url){
            $urls[] = ['urlid' => $url->id];
        }

        $stats = DB::stats()->where("urluserid", Auth::user()->rID())->whereAnyIs($urls)->orderByDesc('date');

        $content = "Short URL,Date,City,Country,Browser,Platform,Language,Domain,Referer\n";

        if($range && strtotime($range[0]) && strtotime($range[1])) {
            $stats->whereRaw("DATE(date) BETWEEN '".date('Y-m-d', strtotime($range[0]))." 00:00:00' AND '".date('Y-m-d', strtotime($range[1]))." 23:59:59'");
        }
        
        foreach($stats->findArray() as $data){
            if(!$url = DB::url()->select('alias')->select('custom')->select('domain')->where('id', $data['urlid'])->first()) continue;

            $content .= ($url->domain ? $url->domain : config('url'))."/".$url->alias.$url->custom.",{$data['date']},{$data['city']},{$data['country']},{$data['browser']},{$data['os']},{$data['language']},{$data['domain']},{$data['referer']}\n";
        }

        $response = new \Core\Response($content, 200, ['content-type' => 'text/csv', 'content-disposition' => 'attachment;filename=ReportCampaign_'.Helper::dtime('now', 'd-m-Y').'.csv']);
        
        return $response->send();
    }
    /**
	 * Export Selected
	 *
	 * @author GemPixel <https://gempixel.com>
	 * @version 7.4.3
	 * @param \Core\Request $request
	 * @return void
	 */
	public function exportSelected(Request $request){
        if(Auth::user()->teamPermission('export.create') == false){
			return Helper::redirect()->to(route('dashboard'))->with('danger', e('You do not have this permission. Please contact your team administrator.'));
		}  

        $ids = json_decode($request->selected);
        
        if(!$ids){
			return back()->with('danger', e('You need to select at least 1 link.'));
		}


        $links = DB::url()
                    ->where('userid', Auth::user()->rID())
                    ->whereNull('qrid')
                    ->whereNull('profileid')
                    ->whereIdIn($ids)
                    ->orderByDesc('date')
                    ->findArray();

        return \Core\File::contentDownload('MyLinks-'.date('d-m-Y').'.csv', function() use ($links) {

			echo "Short URL,Long URL,QR Code,Campaign,Date,Clicks,Unique Clicks\n";
            foreach($links as $url){
                $name = null;
                if($url['bundle']){
                    if($campaign = DB::bundle()->first($url['bundle'])){
                        $name = $campaign->name;
                    }
                }
                echo ($url['domain'] ? $url['domain'] : config('url'))."/".$url['alias'].$url['custom'].",\"{$url['url']}\",".(($url['domain'] ? $url['domain'] : config('url'))."/".$url['alias'].$url['custom'])."/qr,{$name},{$url['date']},{$url['click']},{$url['uniqueclick']}\n";
            }
		});

	}
}