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

use Core\DB;
use Core\View;
use Core\Auth;
use Core\Helper;
use Core\Request;
use Core\Plugin;
use Core\Response;
use Core\Localization;

class Subscription {

    use Traits\Payments;
    /**
     * Constructor
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     */
    public function __construct(){
        if(!config('pro')) stop(404);
    }
    /**
     * Pricing Page
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function pricing(){        
        
        Auth::check();

        $plans = [];

        $default = null;

        $settings = ['monthly' => false, 'yearly' => false, 'lifetime' =>  false, 'discount' => 0];

        foreach(DB::plans()->where('status', 1)->where('free', 1)->where('hidden', 0)->find() as $plan){
            $plans[$plan->id] = [
                "free" => $plan->free,
                "name" => $plan->name,
                "description" => $plan->description,
                "icon" => $plan->icon,
                "trial" => $plan->trial_days,
                "price_monthly" => $plan->price_monthly,
                "price_yearly" => $plan->price_yearly,
                "price_lifetime" => $plan->price_lifetime,
                "urls" => $plan->numurls,
                "clicks" => $plan->numclicks,
                "retention" => $plan->retention,
                "permission" => json_decode($plan->permission),
                'ismonthly' => $plan->counttype == 'monthly',
                'isqrmonthly' => $plan->qrcounttype == 'monthly',
                'ispopular' => $plan->ispopular
            ];   

            if(!isset($plans[$plan->id]['permission']->channels)) {
                $plans[$plan->id]['permission']->channels = new \stdClass;
                $plans[$plan->id]['permission']->channels->enabled = false;
                $plans[$plan->id]['permission']->channels->count = '';
            }

            if(Auth::logged()){
                if(Auth::user()->planid == $plan->id){
                    $plans[$plan->id]['planurl'] = '#';
                    $plans[$plan->id]['plantext'] = e('Current');
                } else {
                    $plans[$plan->id]['planurl'] =  route('checkout', [$plan->id, 'monthly']).($plan->trial_days && !DB::payment()->where('userid', Auth::id())->whereNotNull('trial_days')->first() ? '?trial=1': '');
                    $plans[$plan->id]['plantext'] = ($plan->trial_days && !DB::payment()->where('userid', Auth::id())->whereNotNull('trial_days')->first() ? '<span class="mb-2 d-block">'.e('{d}-Day Free Trial', null, ['d' => $plan->trial_days ]).'</span>': '').e('Upgrade');
                }
            } else {
                $plans[$plan->id]['planurl'] =  route('checkout', [$plan->id, 'monthly']).($plan->trial_days ? '?trial=1': '');
                $plans[$plan->id]['plantext'] = ($plan->trial_days ? '<span class="mb-2 d-block">'.e('{d}-Day Free Trial', null, ['d' => $plan->trial_days ]).'</span>': '').e('Get Started');
            }
        }

        foreach(DB::plans()->where('status', 1)->where('free', 0)->where('hidden', 0)->orderByAsc('price_monthly')->find() as $plan){

            $discountAmount = 0;                               

            if($plan->price_lifetime && $plan->price_lifetime != "0.00") {
                $settings['lifetime'] = true;
                $default = 'lifetime';
                $term = e('lifetime');
            }             
            
            if($plan->price_yearly && $plan->price_yearly != "0.00"){
                $settings['yearly'] = true;
                $discountAmount = $plan->price_monthly > 0 ? round((($plan->price_monthly*12)-$plan->price_yearly)*100/($plan->price_monthly*12),0) : 0;
                $default = 'yearly';
                $term = '/'.e('year');
            }

            if($plan->price_monthly && $plan->price_monthly != "0.00") {
                $settings['monthly'] = true;
                $default = 'monthly';
                $term = '/'.e('month');
            }

            if($discountAmount > $settings['discount']) $settings['discount'] = $discountAmount;       

            $plans[$plan->id] = [                
                "free" => $plan->free,
                "name" => $plan->name,
                "description" => $plan->description,
                "icon" => $plan->icon,
                "trial" => $plan->trial_days,
                "discount" => $discountAmount > 0 ? $discountAmount : null,
                "price_monthly" => $plan->price_monthly,
                "price_yearly" => $plan->price_yearly,
                "price_lifetime" => $plan->price_lifetime,
                "urls" => $plan->numurls,
                "clicks" => $plan->numclicks,
                "retention" => $plan->retention,
                "permission" => json_decode($plan->permission),
                'ismonthly' => $plan->counttype == 'monthly',
                'isqrmonthly' => $plan->qrcounttype == 'monthly',
                'ispopular' => $plan->ispopular
            ];

            if(!isset($plans[$plan->id]['permission']->channels)) {
                $plans[$plan->id]['permission']->channels = new \stdClass;
                $plans[$plan->id]['permission']->channels->enabled = false;
                $plans[$plan->id]['permission']->channels->count = '';
            }

            if(Auth::logged()){
                if(Auth::user()->planid == $plan->id && !Auth::user()->trial){
                    $plans[$plan->id]['planurl'] = '#';
                    $plans[$plan->id]['plantext'] = e('Current');
                } else {
                    $plans[$plan->id]['planurl'] =  route('checkout', [$plan->id, $default]).($plan->trial_days && !DB::payment()->where('userid', Auth::id())->whereNotNull('trial_days')->first() ? '?trial=1': '');
                    $plans[$plan->id]['plantext'] = ($plan->trial_days && !DB::payment()->where('userid', Auth::id())->whereNotNull('trial_days')->first() ? e('Try {d} days for free', null, ['d' => $plan->trial_days ]) : e('Upgrade'));
                }
            } else {
                $plans[$plan->id]['planurl'] =  route('checkout', [$plan->id, $default]).($plan->trial_days ? '?trial=1': '');
                $plans[$plan->id]['plantext'] = ($plan->trial_days ? e('Try {d} days for free', null, ['d' => $plan->trial_days ]) : e('Get Started'));
            }
        }

        $categories = [];

        foreach(Helpers\App::features() as $feature){
            if(!isset($feature['category'])) $feature['category'] = 'management';
            if($feature['category'] == 'qr'){
                $categories[$feature['category']] = e('QR').' '.e('Features');
            }else{
                $categories[$feature['category']] = ucfirst($feature['category']).' '.e('Features');
            }
        }

        $class = 'col-lg-3';
        $count = count($plans);
        
        if($count == 3){
            $class = 'col-md-4';
        }
        if($count <= 2){
            $class = 'col-md-6';
        }

        View::set('title', e('Premium Plan Pricing'));
        View::set('description', e('Transparent pricing without any hidden fees so you always know what you will pa'));
    
        // @group Plugin
        Plugin::dispatch('pricing', $plans);

        return View::with('pricing.index', compact('plans', 'settings', 'class', 'default', 'term', 'categories'))->extend('layouts.main');
    }    
   /**
    * Checkout
    *
    * @author GemPixel <https://gempixel.com> 
    * @version 6.6
    * @param \Core\Request $request
    * @param integer $id
    * @param string $type
    * @return void
    */
    public function checkout(Request $request, int $id, string $type){        
                
        if(!Auth::logged()){
            $request->session('redirect', route('checkout', [$id, $type]).($request->trial ? '?trial=1':''));
            return Helper::redirect()->to(route('register'));
        }

        $user = Auth::user();

        if(Auth::logged() && $user->team()){
            return \Models\Plans::notAllowed();
        }

        if(!in_array($type, ['monthly', 'yearly', 'lifetime'])) $type = "monthly";

        Plugin::dispatch('checkout', [$id, $type]);

        if(\Helpers\App::possible() && $subscription = DB::subscription()->where('userid', $user->id)->where('status', 'Active')->first()){
            if($subscription->plan == 'lifetime') return Helper::redirect()->to(route('billing'))->with('danger', e('Please contact us so we can upgrade your plan since you are on a lifetime plan.'));
        }

        if(!$plan = DB::plans()->where('id', Helper::RequestClean($id))->where('status', '1')->first()) return stop(404);

        if($plan->free){
            $user->pro = "0";
            $user->planid = $plan->id;
            $user->last_payment = date("Y-m-d H:i:s");
            $user->expiration = null;
			$user->save();   

            if(\Helpers\App::possible()){
                if($subscription = DB::subscription()->where('userid', $user->id)->where('status', 'Active')->first()){
                    foreach( $this->processor() as $name => $processor){
                        if(!config($name) || !config($name)->enabled || !$processor['cancel']) continue;
                        call_user_func_array($processor['cancel'], [$user, $subscription]);
                    }
                }
            }
                    
            return Helper::redirect()->to(route('dashboard'))->with('success', e('You have been successfully subscribed.'));
        }

        if($request->trial && $plan->trial_days){
            
            if(DB::payment()->whereNotNull('trial_days')->where('userid', $user->id)->first()){
                return Helper::redirect()->to(route('pricing'))->with("danger", e("You have already used a trial."));
            }


            $user->trial = "1";
            $user->pro = "1";
            $user->planid = $plan->id;
            $user->last_payment = date("Y-m-d H:i:s");
            $user->expiration = date("Y-m-d H:i:s", strtotime("+ {$plan->trial_days} days"));
			$user->save();
            
			$payment             = DB::payment()->create();
    		$payment->date       = Helper::dtime();
    		$payment->tid        = Helper::rand(16);
    		$payment->amount     = "0.00";
    		$payment->trial_days = $plan->trial_days;
    		$payment->userid     = $user->id;
    		$payment->status     = "Completed";
    		$payment->expiry     = date("Y-m-d H:i:s", strtotime("+ {$plan->trial_days} days"));
    		$payment->data       = null;
            $payment->save();

            Plugin::dispatch('trial.success');

            return Helper::redirect()->to(route('dashboard'))->with("success", e("Free trial has been activated! Your trial will expire in {$plan->trial_days} days."));
		}

        $user->address = json_decode($user->address ?? '');        

        View::set('title', 'Checkout');

        \Core\View::push("<script type='text/javascript'>

        $('input[name=payment]').change(function(){
            $('.paymentOptions').hide();
            $('#'+$(this).val()).show();            
        });
        $('.paymentOptions').hide();
        $('.paymentOptions').filter(':first').show();
        
        </script>", "custom")->toFooter();

        $name = 'price_'.$type;

        $plan->price = $plan->$name;

        if($plan->price <= 0) return Helper::redirect()->to(route('pricing'));

        if(!\Helpers\App::possible()){
            $processors['paypal'] = $this->processor('paypal');
        } else {
            $processors = $this->processor();
        }
        
        $tax = null;
        $country = null;
        
        if(isset($user->address->country) && !empty($user->address->country)){
            $country = $user->address->country;           
        }else{
            $country = request()->country()['country'];
        }

        if($country && $tax = DB::taxrates()->whereRaw('countries LIKE ?', ["%{$country}%"])->first()){
            $tax->price = round($plan->price * $tax->rate / 100, 2);
        } 
        
        View::push(assets('frontend/libs/jquery-mask-plugin/dist/jquery.mask.min.js'), 'js')->toFooter();

        return View::with('pricing.checkout', compact('plan', 'type', 'user', 'processors', 'tax'))->extend('layouts.main');
    }
    /**
     * Process Payment
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.8
     * @param \Core\Request $request
     * @param integer $id
     * @param string $type
     * @return void
     */
    public function process(Request $request, int $id, string $type){

        \Gem::addMiddleware('DemoProtect');
        
        $user =  Auth::user();

        if(Auth::logged() && $user->team()){
            return \Models\Plans::notAllowed();
        }

        if(!$request->name || !$request->address || !$request->city || !$request->country || !$request->state) {
            return back()->with('danger',  e('Please fill your billing information.'));
        }
        
        $user->address = json_encode([
            "type"      => $request->type && $request->type == 'business' ? 'business' : 'personal',
            "company" 	=>	$request->company ? clean($request->company) : null,
            "taxid" 	=>	$request->taxid ? clean($request->taxid) : null,
            "address" 	=>	clean($request->address),
            "city" 		=>	clean($request->city), 
            "state" 	=>	clean($request->state),
            "zip" 		=>	clean($request->zip),
            "country" 	=>	clean($request->country)
        ]);
        
        $user->name = clean($request->name);

        $user->save();

        if(\Helpers\App::possible()){
            if($subscription = DB::subscription()->where('userid', $user->id)->where('status', 'Active')->first()){
                foreach( $this->processor() as $name => $processor){
                    if(!config($name) || !config($name)->enabled || !$processor['cancel']) continue;
                    call_user_func_array($processor['cancel'], [$user, $subscription]);
                }
            }
        }

        $process = $this->processor($request->payment, 'payment');        

        if(!empty(config('saleszapier'))){
            \Core\Http::url(config('saleszapier'))
                        ->with('content-type', 'application/json')
                        ->body([
                                "type" 			=> "sales",
                                "name"			=> $user->name,
                                "email"			=> $user->email,
                                "country" 	    => $request->country()['country'],
                                "plan"			=> $id,
                                "type"          => $type,
                                "date"			=> date("Y-m-d H:i:s")
                        ])->post();
        }

        return call_user_func_array($process, [$request, $id, $type]);
    }
    /**
     * Add coupon
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @param integer $id
     * @param string $type
     * @return void
     */
    public function coupon(Request $request, int $id, string $type){

        if($coupon = DB::coupons()->where("code", clean($request->code))->first()){
            
            if($coupon->validuntil && strtotime("now") > strtotime(date("Y-m-d 11:59:00", strtotime($coupon->validuntil)))) return Response::factory(['error' => true, 'message' => e('Promo code has expired. Please try again.')])->json();

            if($coupon->maxuse > 0 && $coupon->used >= $coupon->maxuse) return Response::factory(['error' => true, 'message' => e('Promo code has expired. Please try again.')])->json();
            
            if(!$plan = DB::plans()->where('id', $id)->first()){
                return Response::factory(['error' => true, 'message' => e('Please enter a valid promo code.')])->json();
            }
            
            $data = json_decode($coupon->data, true);

            if(isset($data['plans']) && $data['plans'] && !in_array($id, $data['plans'])) return Response::factory(['error' => true, 'message' => e('Promo code is not valid for this plan.')])->json();

            $name = 'price_'.$type;

            $price = $plan->$name;

            $discountedprice = round((1 - ($coupon->discount/100))*$price, 2);

            $discount = round(($coupon->discount/100)*$price, 2);
            $rate = null;
            if($request->country){
                if($tax = DB::taxrates()->whereRaw('countries LIKE ?', ["%".clean($request->country)."%"])->first()){
                    $rate =  round($discountedprice * $tax->rate / 100, 2);
                    $discountedprice = round($discountedprice * (1 + $tax->rate / 100), 2);                    
                }
            }

            return Response::factory(['error' => false, 'message' => $coupon->description, 'newprice' => Helpers\App::currency(config('currency'), $discountedprice), 'discount' =>  Helpers\App::currency(config('currency'), $discount), 'tax' => Helpers\App::currency(config('currency'), $rate)])->json();
        }
        return Response::factory(['error' => true, 'message' => e('Please enter a valid promo code.')])->json();
    }
    /**
     * Tax Rate
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.2
     * @param \Core\Request $request
     * @param integer $id
     * @param string $type
     * @return void
     */
    public function tax(Request $request, int $id, string $type){

        if(!$plan = DB::plans()->first($id)){
            return Response::factory(['error' => true, 'message' => e('Please enter a valid promo code.')])->json();
        }

        $name = 'price_'.$type;

        $price = $plan->$name;

        if($coupon = DB::coupons()->where("code", clean($request->coupon))->first()){
            
            if(strtotime("now") < strtotime(date("Y-m-d 11:59:00", strtotime($coupon->validuntil)))){
                $price = round((1 - ($coupon->discount/100))*$price, 2);
            }                    
        }

        if($request->country){
            if($tax = DB::taxrates()->whereRaw('countries LIKE ?', ["%".clean($request->country)."%"])->first()){
                $tax->price = round($price * $tax->rate / 100, 2);
                return Response::factory(['html'=>'<div class="form-group mt-4"><div class="row"><div class="col">'.$tax->name.' ('.$tax->rate.'%)</div><div class="col-auto" id="taxamount">'.\Helpers\App::currency(config('currency'), $tax->price).'</div></div></div>', 'newprice' => \Helpers\App::currency(config('currency'), $price + $tax->price)])->json();
            }
        }

        return Response::factory(['html'=>'', 'newprice' => \Helpers\App::currency(config('currency'), $price)])->json();   
    }

    /**
     * Redeem Vouchers
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.7
     * @param \Core\Request $request
     * @return void
     */
    public function redeem(Request $request){

        if(!\Helpers\App::possible()) stop(404);
        
        $user = Auth::user();
        
        if(!$request->code) return back()->with('danger', e('Voucher is invalid or has expired.'));

        if(!$voucher = DB::vouchers()->where('code', strtoupper(clean($request->code)))->first()) return back()->with('danger', e('Voucher is invalid or has expired.'));

        if(strtotime("now") > strtotime(date("Y-m-d 11:59:00", strtotime($voucher->validuntil)))) return back()->with('danger', e('Voucher is invalid or has expired.'));

        if($voucher->maxuse > 0 && $voucher->used >= $voucher->maxuse) return back()->with('danger', e('Voucher is invalid or has expired.'));

        if(DB::payment()->where('cid', 'voucher')->where('tid', strtoupper(clean($request->code)))->where('userid', $user->id)->first()) return back()->with('danger', e('You have already redeemed this voucher once.'));

        $payment = DB::payment()->create();
        $payment->userid = $user->id;
        $payment->cid = 'voucher';
        $payment->tid = $voucher->code;

        [$amount, $period] = explode('-', $voucher->period);

        if($period == 'y'){            
            $payment->amount = '0.00';
            $payment->date = Helper::dtime();
            $payment->expiry = Helper::dtime("+{$amount} years");                
        }elseif($period == 'm'){            
            $payment->amount = '0.00';
            $payment->date = Helper::dtime();
            $payment->expiry = Helper::dtime("+{$amount} months");
        }else{            
            $payment->amount = '0.00';
            $payment->date = Helper::dtime();
            $payment->expiry = Helper::dtime("+{$amount} days");
        }
        $payment->status = 'Completed';
        $payment->data = json_encode(['voucherid' => $voucher->id, 'planid' => $voucher->planid]);
        $payment->save();

        $user->expiration = $payment->expiry;
        $user->last_payment = Helper::dtime();
        $user->pro = 1;
        $user->planid = $voucher->planid;
        $user->save();

        $voucher->used++;
        $voucher->save();

        return Helper::redirect()->to(route('billing'))->with('success', e('You have successfully redeemed a voucher.'));
    }
}