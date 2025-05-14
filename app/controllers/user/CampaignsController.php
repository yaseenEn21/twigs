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

use Core\Request;
use Core\Response;
use Core\DB;
use Core\Auth;
use Core\Helper;
use Core\View;
use Models\User;

class Campaigns {
    
    use \Traits\Links;

    /**
     * Verify Permission
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.0.1
     */
    public function __construct(){

        if(User::where('id', Auth::user()->rID())->first()->has('bundle') === false){
			return \Models\Plans::notAllowed();
		}
    }
    /**
     * Campaigns Home
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.0.1
     * @return void
     */
    public function index(){

        $campaigns = [];
        
        foreach(DB::bundle()->where('userid', Auth::user()->rID())->orderByDesc('date')->paginate(15) as $campaign){
            $campaign->urlcount = DB::url()->where('bundle', $campaign->id)->count('id');
            $campaigns[] = $campaign;
        }

        View::set('title', e('Campaigns'));

        View::push(assets('frontend/libs/clipboard/dist/clipboard.min.js'), 'js')->toFooter();

        return View::with('user.campaigns', compact('campaigns'))->extend('layouts.dashboard');
    }
    /**
     * Save Campaign
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.0.1
     * @param \Core\Request $request
     * @return void
     */
    public function save(Request $request){

        $user = Auth::user();
        
        if($user->teamPermission("bundle.create") === false){
            return Helper::redirect()->back()->with("danger", e("You do not have this permission. Please contact your team administrator."));
        }

        if(!$request->name || strlen(clean($request->name)) < 2){
            return back()->with("danger", e("Campaign name cannot be empty and must have at least 2 characters."));
        }
        
        if(DB::bundle()->where('name', clean($request->name))->where('userid', $user->rID())->first()){
            return back()->with("danger", e("You already have a campaign with that name."));
        }

        $slug = Helper::rand(6);

        if($request->slug){
            $slug = Helper::slug($request->slug);
            if(DB::bundle()->where("slug", $slug)->first()){
                return back()->with("danger", e("This slug is currently not available. Please choose another one."));
            }
        }

        $bundle = DB::bundle()->create();

        $bundle->name   = ucfirst(clean($request->name));
        $bundle->slug   = $slug;
        $bundle->access = clean($request->access) == '1' ? 'public' : "private";
        $bundle->userid = $user->rID();
        $bundle->date   = Helper::dtime();
        
        $isvalid = false;

        $host = Helper::parseUrl($request->domain, 'host');
        if($user && $user->has('domain') && DB::domains()->where('userid', $user->rID())->whereRaw("(domain = ? OR domain = ?)", ["http://".$host,"https://".$host])->first()){
            $isvalid = true;
        }

        $domains = explode("\n", config("domain_names"));
        $domains = array_map("rtrim", $domains);
        $domains[] = config("url");

        if($user->has('multiple')) {
            $allowed = null;
            $plan = null;
            if(!$user->admin) {
                if($plan = DB::plans()->where('id', $user->planid)->first()){
                    $plan->permission = json_decode($plan->permission);
                    if(isset($plan->permission->multiple->custom) && !empty($plan->permission->multiple->custom)){
                        $allowed = explode(',', $plan->permission->multiple->custom);
                    }
                }
            }

            if($allowed){
                if(in_array(trim($domain), $allowed)){
                    $isvalid = true;
                }
            }else{
                $isvalid = true;
            }
        }

        $bundle->domain = $isvalid ? clean($request->domain) : null;

		$bundle->save();

        return back()->with("success", e("Campaign was successfully created. You may start adding links to it now."));
    }
    /**
     * Update Campaign
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.0.1
     * @param \Core\Request $request
     * @return void
     */
    public function update(Request $request, int $id){

        $user = Auth::user();
        
        if($user->teamPermission("bundle.edit") === false){
            return Helper::redirect()->back()->with("danger", e("You do not have this permission. Please contact your team administrator."));
        }

        if(!$bundle = DB::bundle()->where('id', $id)->where('userid', $user->rID())->first()){
            return Helper::redirect()->back()->with("danger", e("Campaign does not exist"));
        }

        if(!$request->newname || strlen(clean($request->newname)) < 2){
            return back()->with("danger", e("Campaign name cannot be empty and must have at least 2 characters."));
        }
        
        if(DB::bundle()->where('name', clean($request->newname))->where('userid', $user->rID())->whereNotEqual('id', $bundle->id)->first()){
            return back()->with("danger", e("You already have a campaign with that name."));
        }

        
        if(!$request->newslug){
            $bundle->slug = Helper::rand(6);
        }

        if($request->newslug && $request->newslug != $bundle->slug){
            $bundle->slug = Helper::slug($request->newslug);
            if(DB::bundle()->where("slug", $slug)->first()){
                return back()->with("danger", e("This slug is currently not available. Please choose another one."));
            }
        }

        $bundle->name   = ucfirst(clean($request->newname));
        $bundle->access = clean($request->newaccess) == '1' ? 'public' : "private";
		$bundle->save();

        return back()->with("success", e("Campaign was updated successfully."));
    }
    /**
     * Delete Campaign
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.0.1
     * @param integer $id
     * @param string $nonce
     * @return void
     */
    public function delete(int $id, string $nonce){
        
        \Gem::addMiddleware('DemoProtect');

        if(Auth::user()->teamPermission("bundle.delete") === false){
            return Helper::redirect()->back()->with("danger", e("You do not have this permission. Please contact your team administrator."));
        }

        if(!Helper::validateNonce($nonce, 'campaign.delete')){
            return Helper::redirect()->back()->with('danger', e('An unexpected error occurred. Please try again.'));
        }

        if(!$bundle = DB::bundle()->where('id', $id)->where('userid', Auth::user()->rID())->first()){
            return Helper::redirect()->back()->with('danger', e('Campaign not found. Please try again.'));
        }
        
        DB::url()->where("bundle", $bundle->id)->update(['bundle' => NULL]);
        $bundle->delete();
        return Helper::redirect()->back()->with('success', e('Campaign has been deleted.'));
    }
    /**
     * View Campaign Stats
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.0.1
     * @return void
     */
    public function stats(int $id){

        if(!$bundle = DB::bundle()->where('id', $id)->where('userid', Auth::user()->rID())->first()){
            return Helper::redirect()->back()->with('danger', e('Campaign not found. Please try again.'));
        }

        \Helpers\CDN::load("daterangepicker");

		View::push("<script>$(document).ready(function(){ 		
            $('input[name=range]').daterangepicker({
                locale: {
                    'applyLabel': '".e('Apply')."',
                    'cancelLabel': '".e('Cancel')."',
                    'fromLabel': '".e('From')."',
                    'toLabel': '".e('To')."',
                    'customRangeLabel': '".e('Custom')."',
                    'daysOfWeek': ['".e('Su')."','".e('Mo')."','".e('Tu')."','".e('We')."','".e('Th')."','".e('Fr')."','".e('Sa')."'],
                    'monthNames': ['".e('January')."','".e('February')."','".e('March')."','".e('April')."','".e('May')."','".e('June')."','".e('July')."','".e('August')."','".e('September')."','".e('October')."','".e('November')."','".e('December')."'],
                },
                maxDate: moment(),
                startDate: moment().subtract(14, 'days'),
                endDate: moment(),
                autoUpdateInput: true,
                ranges: {
                    '".e("Last 7 Days")."': [moment().subtract(6, 'days'), moment()],
                    '".e("Last 30 Days")."': [moment().subtract(29, 'days'), moment()],
                    '".e("This Month")."': [moment().startOf('month'), moment().endOf('month')],
                    '".e("Last Month")."': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    '".e("Last 3 Months")."': [moment().subtract(2, 'month').startOf('month'), moment()]
                }
			});
		});</script>", "custom")->toFooter();

        $links = DB::url()->where('bundle', $bundle->id)->orderByDesc('click')->findMany();

        $total = 0;

        foreach($links as $link){
            $total += $link->click;
        }

        View::push(assets('frontend/libs/jsvectormap/dist/js/jsvectormap.min.js'), "script")->toFooter();
        View::push(assets('frontend/libs/jsvectormap/dist/maps/world.js'), "script")->toFooter();
        View::push(assets('frontend/libs/jsvectormap/dist/css/jsvectormap.min.css'), "css")->toHeader();
        View::push(assets('Chart.min.js'), "script")->toFooter();
        View::push(assets('charts.min.js')."?v=1.1", 'script')->toFooter();
        View::set('title', e('Campaign Statistics').' '.$bundle->name);
    
        return View::with('user.campaignstats', compact('bundle', 'links', 'total'))->extend('layouts.dashboard');
    }
    /**
     * Clicks
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.0.1
     * @param integer $id
     * @return void
     */
    public function statsClicks(int $id){
        
        if(!$bundle = DB::bundle()->where('id', $id)->where('userid', Auth::user()->rID())->first()){
            return Response::factory('', 404)->json();
        }

        $urls = DB::url()->select('id', 'urlid')->where('bundle', $bundle->id)->findArray();

        if(!$urls) return null;

        $response = ['label' => e('Clicks')];

        $timestamp = strtotime('now');
        for ($i = 12 ; $i >= 0; $i--) {
            $d = $i*28;
            $timestamp = \strtotime("-{$d} days");            
            $response['data'][e(date('F', $timestamp))] = 0;
        }

        $results = DB::stats()->selectExpr('COUNT(MONTH(date))', 'count')->selectExpr('DATE_FORMAT(date, "%Y-%m")', 'newdate')->where("urluserid", Auth::user()->rID())->whereRaw('(date >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH))')->whereAnyIs($urls)->groupByExpr('newdate')->findArray();
        
        foreach($results as $data){
            $response['data'][e(Helper::dtime($data['newdate'], 'F'))] = (int) $data['count'];
        }   
        
        return (new Response($response))->json(); 
    }

    /**
     * Get Clicks Map
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.0.1
     * @return void
     */
    public function statsMap(int $id){

        if(!$bundle = DB::bundle()->where('id', $id)->where('userid', Auth::user()->rID())->first()){
            return Response::factory('', 404)->json();
        }

        $urls = DB::url()->select('id', 'urlid')->where('bundle', $bundle->id)->findArray();

        if(!$urls) return null;

        $countries = DB::stats()->selectExpr('COUNT(country)', 'count')->selectExpr('country', 'country')->where("urluserid", Auth::user()->rID())->whereAnyIs($urls)->groupByExpr('country')->orderByDesc('count')->findArray();

        $i = 0;
        $topCountries = [];
        $country  = [];

        foreach ($countries as $list) {
          
            $name = $list["country"] ? Helper::Country(ucwords($list["country"]), false, true) : 'unknown';

            $country[$name] = $list["count"];

            if($i <= 10){
                if(empty($list["country"])) $list["country"] = e('Unknown');

                $topCountries[$name] = ['name' => ucwords($list["country"]), 'count' => $list["count"]];
            }
            $i++;
        }    

        return (new Response(['list' => $country, 'top' => $topCountries]))->json();  
    }
    /**
     * Browser Stats
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.0.1
     * @param integer $id
     * @return void
     */
    public function statsBrowser(int $id){

        if(!$bundle = DB::bundle()->where('id', $id)->where('userid', Auth::user()->rID())->first()){
            return Response::factory('', 404)->json();
        }

        $urls = DB::url()->select('id', 'urlid')->where('bundle', $bundle->id)->findArray();

        if(!$urls) return null;

        $browsers = DB::stats()->selectExpr('COUNT(browser)', 'count')->selectExpr('browser', 'browser')->where("urluserid", Auth::user()->rID())->whereAnyIs($urls)->groupByExpr('browser')->orderByDesc('count')->findArray();

        $response = [];

        foreach($browsers as $browser){
            $response['chart'][$browser['browser']] = $browser['count'];
        }

        return (new Response($response))->json();  
    }
    /**
     * Os Stats
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.0.1
     * @param integer $id
     * @return void
     */
    public function statsOs(int $id){

        if(!$bundle = DB::bundle()->where('id', $id)->where('userid', Auth::user()->rID())->first()){
            return Response::factory('', 404)->json();
        }

        $urls = DB::url()->select('id', 'urlid')->where('bundle', $bundle->id)->findArray();

        if(!$urls) return null;

        $oses = DB::stats()->selectExpr('COUNT(os)', 'count')->selectExpr('os', 'os')->where("urluserid", Auth::user()->rID())->whereAnyIs($urls)->groupByExpr('os')->orderByDesc('count')->findArray();

        $response = [];

        foreach($oses as $os){
            $response['chart'][$os['os']] = $os['count'];
        }

        return (new Response($response))->json();  
    }    
}