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

namespace Helpers\Payments;

use Core\DB;
use Core\Auth;
use Core\Helper;
use Core\Request;
use Core\Response;
use Core\View;

class PaypalApi{
    /**
     * Generate Payment Form
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public static function settings(){

        $config = config('paypalapi');

        if(!$config && !isset($config->enabled)){
    
            $settings = DB::settings()->create();

            $settings->config = 'paypalapi';
            $settings->var = json_encode(['enabled' => config('pt') == 'paypalapi', 'secret' => config('ppprivate'), 'public' => config('pppublic')]);
            $settings->save();

            $config = json_decode($settings->var);
        }

        $html = '<div class="form-group">
                    <label for="paypalapi[enabled]" class="form-label fw-bold">'.e('Paypal API Payments').'</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" data-binary="true" id="paypalapi[enabled]" name="paypalapi[enabled]" value="1" '.($config->enabled ? 'checked':'').' data-toggle="togglefield" data-toggle-for="paypalapiholder">
                        <label class="form-check-label" for="paypalapi[enabled]">'.e('Enable').'</label>
                    </div>
                    <p class="form-text">'.e('Collect payments securely with PayPal API.').'</p>
                </div>
                <div id="paypalapiholder" class="toggles '.(!$config->enabled ? 'd-none' : '') .'">
                    <div class="form-group">
                        <label for="paypalapi[public]" class="form-label">'.e('Client ID').'</label>
                        <input type="text" class="form-control" name="paypalapi[public]" placeholder="" id="paypalapi[public]" value="'.$config->public.'">
                        <p class="form-text">'.e('Please enter your live client ID.').'</p>
                    </div>
                    <div class="form-group">
                        <label for="paypalapi[secret]" class="form-label">'.e('Client Secret Key').'</label>
                        <input type="text" class="form-control" name="paypalapi[secret]" placeholder=""  id="paypalapi[secret]" value="'.$config->secret.'">
                        <p class="form-text">'.e('Please enter your live client secret.').'</p>
                    </div>                        
                </div>';
        View::push("<script>$('#paypalapi\\\[enabled\\\]').change(function(){ 
            $('.alert-danger').remove();
            if($(this).is(':checked') && $('#paypal\\\[enabled\\\]').is(':checked')){
                $('#paypalapi\\\[enabled\\\]').parents('.form-group').before('<div class=\"alert alert-danger p-3\">".e('You cannot enable both basic paypal and paypal api at the same time. You must choose one.')."</div>');
            }
         })</script>", 'custom')->toFooter();
        return $html;
    }
    /**
     * Checkout
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public static function checkout(){
        echo '<div id="paypalapi" class="paymentOptions"></div>';
    }
    /**
     * Payment
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public static function payment(Request $request, int $id, string $type){

        if(!config('paypalapi') || !config('paypalapi')->enabled || !config('paypalapi')->public || !config('paypalapi')->secret) {
            
            \GemError::log('Payment system "PaypalAPI" not enabled or configured.');

            return back()->with('danger', e('An error ocurred, please try again. You have not been charged.'));
        }

        if(!$plan = DB::plans()->first($id)){
			return back()->with('danger', e('An error ocurred, please try again. You have not been charged.'));
	  	}			

        $plan->data = json_decode($plan->data);
		
        $user = Auth::user();

        $connection = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                config('paypalapi')->public,
                config('paypalapi')->secret
            )
        );    

        $connection->setConfig(
            [
                'log.LogEnabled' => DEBUG,
                'log.FileName' => LOGS.'/PayPal.log',
                'log.LogLevel' => 'DEBUG',
                'http.CURLOPT_SSL_VERIFYPEER' => DEBUG ? false : true,
                'mode' => DEBUG ? 'sandbox' : 'live'
            ]
        );    

        $coupon = null;
        if($request->coupon && $coupon = DB::coupons()->where('code', clean($request->coupon))->first()){
            
            $valid = true;

            if($coupon->validuntil && strtotime("now") > strtotime(date("Y-m-d 11:59:00", strtotime($coupon->validuntil)))) $valid = false;

            if($coupon->maxuse > 0 && $coupon->used >= $coupon->maxuse) $valid = false;

			if($valid) {	
				$coupon->used++;
				$coupon->save();
				$coupon->data = json_decode($coupon->data);
			}
		}
        
        $tax = DB::taxrates()->whereRaw('countries LIKE ?', ["%".clean($request->country)."%"])->first();
                
        if($type == 'lifetime'){
            
            $price = isset($coupon) ? round((1 - ($coupon->discount / 100)) * $plan->price_lifetime, 2) : $plan->price_lifetime;

            if($tax){
                $price = round($price * (1+($tax->rate / 100)), 2);
            }

            $payer = new \PayPal\Api\Payer();
            $payer->setPaymentMethod('paypal');

            $amount = new \PayPal\Api\Amount();
            $amount->setCurrency(config('currency'))
                    ->setTotal($price);

            $transaction = new \PayPal\Api\Transaction();
            $transaction->setAmount($amount)
                        ->setDescription('userid:'.$user->id);

            $redirect = new \PayPal\Api\RedirectUrls();
            $redirect->setReturnUrl(url("webhook/paypal?success=true&type=lifetime&planid={$plan->id}"))
                    ->setCancelUrl(url("webhook/paypal?success=false"));

            $payment = new \PayPal\Api\Payment();
            $payment->setIntent('sale')
                    ->setPayer($payer)
                    ->setTransactions([$transaction])
                    ->setRedirectUrls($redirect);

            try {
                $payment->create($connection);

                header("Location: {$payment->getApprovalLink()}");
                exit;
            } catch (\Exception $e) {
                \GemError::log('PayPal API Error: '.$e->getMessage());
                return back()->with("danger",e("An issue occurred. You have not been charged."));
            }

        } else {

            $planid = self::createSinglePlan($plan, $type, $coupon, $tax);

            $agreement = new \PayPal\Api\Agreement();

            $agreement->setName($plan->name)
                ->setDescription('userid:'.$user->id)
                ->setStartDate(date("c", strtotime("+2 minutes")));
    
            $pplan = new \PayPal\Api\Plan();
            $pplan->setId($planid);
            $agreement->setPlan($pplan);
    
            $payer = new \PayPal\Api\Payer();
            $payer->setPaymentMethod('paypal');
    
            $payerInfo = new \PayPal\Api\PayerInfo();
            $payerInfo->setEmail($user->email);
            $payerInfo->setFirstName($user->email);
            $payer->setPayerInfo($payerInfo);
    
            $agreement->setPayer($payer); 
    
            try {
                $agreement = $agreement->create($connection);
    
                $approvalUrl = $agreement->getApprovalLink();
                $uniqueid = Helper::rand(16, '', 'abcdef0123456789').$user->id;
    
                $sub = DB::subscription()->create();
                $sub->tid = null;
                $sub->userid = $user->id;
                $sub->plan = $type;
                $sub->planid = $plan->id;
                $sub->status = "Pending";
                $sub->amount = "0";
                $sub->date = Helper::dtime();
                $sub->expiry = Helper::dtime('+5 minutes');
                $sub->lastpayment = Helper::dtime();
                $sub->data = NULL;
                $sub->uniqueid = $uniqueid;
                if($counpon){
                    $sub->coupon = $coupon->id;
                }
                $sub->save();
    
                $user->last_payment = Helper::dtime();
                $user->pro = 1;
                $user->planid = $plan->id;

                $user->save();
    
                header("Location: {$approvalUrl}");
                exit;
            } catch (PayPal\Exception\PayPalConnectionException $ex) {
                \GemError::log('Paypal:' .$ex->getCode());
                \GemError::log('Paypal:' .$ex->getData());
                return back()->with("danger",e("An issue occurred. You have not been charged."));
            } catch (\Exception $e) {
                \GemError::log('Paypal:' .$e->getMessage());
                return back()->with("danger",e("An issue occurred. You have not been charged."));
            }
        }			
    }
    /**
     * Webhook
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param [type] $request
     * @return void
     */
    public static function webhook($request){

        if(!config('paypalapi') || !config('paypalapi')->enabled || !config('paypalapi')->public || !config('paypalapi')->secret) {
            
            \GemError::log('Payment system "PaypalAPI" not enabled or configured.');

            return null;
        }

        $connection = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                config('paypalapi')->public,
                config('paypalapi')->secret
            )
        );    

        $connection->setConfig(
            [
                'log.LogEnabled' => DEBUG,
                'log.FileName' => LOGS.'/PayPal.log',
                'log.LogLevel' => 'DEBUG',
                'http.CURLOPT_SSL_VERIFYPEER' => DEBUG ? false : true,
                'mode' => DEBUG ? 'sandbox' : 'live'
            ]
        );    

        
		if($request->success && $request->success == 'true') {
            
          if($request->type && $request->type == "lifetime"){
                
                $payment = \PayPal\Api\Payment::get($request->paymentId, $connection);
                $execution = new \PayPal\Api\PaymentExecution();
                $execution->setPayerId($request->PayerID);

                try {
                    // Take the payment
                    $payment->execute($execution, $connection);

                    if($payment->state == 'approved'){
                        
                        $userid = str_replace('userid:', '', $payment->transactions[0]->description);
                        
                        if(!$user = DB::user()->where("id", $userid)->first()) return Helper::redirect()->to(route('dashboard'))->with("danger",e("An issue occurred. Please contact us for more info."));

                        $sub = DB::subscription()->create();
                        $sub->tid = Helper::rand(16, '', 'abcdef0123456789').$user->id;
                        $sub->userid = $user->id;
                        $sub->plan = 'lifetime';
                        $sub->planid = $request->planid;
                        $sub->status = "Active";
                        $sub->amount = $payment->transactions[0]->amount->total;
                        $sub->date = Helper::dtime();
                        $sub->expiry = Helper::dtime('+10 years');
                        $sub->lastpayment = Helper::dtime();
                        $sub->data = json_encode(['paymentmethod' => 'PaypalApi']);
                        $sub->uniqueid = Helper::rand(16, '', 'abcdef0123456789').$user->id;
                        $sub->save();

                        $newpayment = DB::payment()->create();
                        $newpayment->date = Helper::dtime('now');
                        $newpayment->cid = $payment->id;
                        $newpayment->tid = Helper::rand(16, '', 'abcdef0123456789').$user->id;
                        $newpayment->amount =  $payment->transactions[0]->amount->total;
                        $newpayment->userid =  $user->id;
                        $newpayment->status = "Completed";
                        $newpayment->expiry =  Helper::dtime('+10 years');
                        $newpayment->data =  json_encode($payment);
        
                        $newpayment->save();
        
                        $user->expiration = Helper::dtime('+10 years');
                        $user->pro = 1;
                        $user->planid = $request->planid;
                        $user->save();

                        \Core\Plugin::dispatch('payment.success', [$user, $request->planid, $newpayment->id]);
                    }

                    return Helper::redirect()->to(route('billing'))->with("success", e("Your payment was successfully made. Thank you."));

                } catch (\PayPal\Exception\PayPalConnectionException $ex) {
                    \GemError::log('Paypal:' .$ex->getCode());
                    \GemError::log('Paypal:' .$ex->getData());
                    return Helper::redirect()->to(route('dashboard'))->with("danger",e("An issue occurred. You have not been charged."));
                } catch (\Exception $ex) {
                    \GemError::log('Paypal:' .$ex->getMessage());
                    return Helper::redirect()->to(route('dashboard'))->with("danger",e("An issue occurred. You have not been charged."));
                }
          }


		  $token = $request->token;
		  $agreement = new \PayPal\Api\Agreement();

		  try {
		        // Execute agreement
		        $response = $agreement->execute($token, $connection)->toArray();

		        $userid = str_replace('userid:', '', $response["description"]);
				
				if(!$user = DB::user()->where("id", $userid)->first()) return Helper::redirect()->to(route('dashboard'))->with("danger",e("An issue occurred. You have not been charged."));

				$subscription = DB::subscription()->where('userid', $user->id)->orderByDesc('date')->first();

				if($response["state"] !== "Active") return Helper::redirect()->to(route('dashboard'))->with("danger",e("An issue occurred. You have not been charged."));

				if($response["plan"]['payment_definitions'][0]['frequency'] == "YEAR"){

					$new_expiry = date("Y-m-d H:i:s", strtotime("+1 year", strtotime($response['start_date'])));

				}else{

					$new_expiry = date("Y-m-d H:i:s", strtotime("+1 month", strtotime($response['start_date'])));
				}

                $payment = DB::payment()->create();
	    		$payment->date = Helper::dtime('now');
	    		$payment->cid = $response['id'];
	    		$payment->tid = Helper::rand(16, '', 'abcdef0123456789').$user->id;
	    		$payment->amount =  $response["plan"]['payment_definitions'][0]['amount']['value'];
	    		$payment->userid =  $user->id;
	    		$payment->status = "Completed";
	    		$payment->expiry =  $new_expiry;
	    		$payment->data =  json_encode($response);

				$payment->save();

				$amount = $subscription->amount + $payment->amount;

				$subscription->amount = $amount;
				$subscription->expiry = $new_expiry;
				$subscription->status = "Active";
				$subscription->save();

				$user->expiration = $new_expiry;
				$user->pro = 1;
                $user->planid = $subscription->planid;
				$user->save();

                \Core\Plugin::dispatch('payment.success', [$user, $subscription->planid, $payment->id]);
				
				return Helper::redirect()->to(route('billing'))->with("success", e("Your payment was successfully made. Thank you."));

		  } catch (\PayPal\Exception\PayPalConnectionException $ex) {
		        \GemError::log('Paypal:' .$ex->getCode());
		        \GemError::log('Paypal:' .$ex->getData());
		        return Helper::redirect()->to(route('dashboard'))->with("danger",e("An issue occurred. You have not been charged."));
		  } catch (\Exception $ex) {
		  	    \GemError::log('Paypal:' .$ex->getMessage());
		        return Helper::redirect()->to(route('dashboard'))->with("danger",e("An issue occurred. You have not been charged."));
		  }
		} else {
                return Helper::redirect()->to(route('dashboard'))->with("warning", e("Your payment has been canceled."));
		}
    }
    /**
     * Create plan
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.1.6
     * @param [type] $plan
     * @return void
     */
    public static function createplan($plan){
        
    }
    /**
     * Create Paypal Plan on demand
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param [type] $plan
     * @return void
     */
    public static function createSinglePlan($plan, $type, $coupon = null, $tax = null){        
       
        $connection = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                config('paypalapi')->public,
                config('paypalapi')->secret
            )
        );    

        $connection->setConfig(
            [
                'log.LogEnabled' => DEBUG,
                'log.FileName' => LOGS.'/PayPal.log',
                'log.LogLevel' => 'DEBUG',
                'http.CURLOPT_SSL_VERIFYPEER' => DEBUG ? false : true,
                'mode' => DEBUG ? 'sandbox' : 'live'
            ]
        );  

        $paypalplan = new \PayPal\Api\Plan();

        $paypalplan->setName($plan->name)
            ->setDescription($plan->name)
            ->setType('INFINITE');

        if($type == 'yearly'){
            $paymentDefinition = new \PayPal\Api\PaymentDefinition();

            $price = $coupon ?  round((1 - ($coupon->discount / 100)) * $plan->price_yearly, 2) : $plan->price_yearly;

            if($tax){
                $price = round($price * (1+($tax->rate / 100)), 2);
            }

            $paymentDefinition->setName('Regular Yearly Payments')
                ->setType('REGULAR')
                ->setFrequency('Year')
                ->setFrequencyInterval("1")                
                ->setAmount(new \PayPal\Api\Currency(['value' => $price, 'currency' => config('currency')]));

        } else {
            $paymentDefinition = new \PayPal\Api\PaymentDefinition();

            $price = $coupon ? round((1 - ($coupon->discount / 100)) * $plan->price_monthly, 2) : $plan->price_monthly;

            if($tax){
                $price = round($price * (1+($tax->rate / 100)), 2);
            }

            $paymentDefinition->setName('Regular Monthly Payments')
                ->setType('REGULAR')
                ->setFrequency('Month')
                ->setFrequencyInterval("1")
                ->setAmount(new \PayPal\Api\Currency(['value' =>  $price, 'currency' => config('currency')]));            
        }          

        $merchantPreferences = new \PayPal\Api\MerchantPreferences();

        $merchantPreferences->setReturnUrl(url("webhook/paypal?success=true"))
            ->setCancelUrl(url("webhook/paypal?success=false"))
            ->setAutoBillAmount("yes")
            ->setInitialFailAmountAction("CONTINUE")
            ->setMaxFailAttempts("0");


        $paypalplan->setPaymentDefinitions([$paymentDefinition]);

        $paypalplan->setMerchantPreferences($merchantPreferences);

        try {
            
            $output = $paypalplan->create($connection);

            $patch = new \PayPal\Api\Patch();

            $value = new \PayPal\Common\PayPalModel('{
                "state":"ACTIVE"
            }');

            $patch->setOp('replace')
                ->setPath('/')
                ->setValue($value);
            $patchRequest = new \PayPal\Api\PatchRequest();
            $patchRequest->addPatch($patch);

            $paypalplan->update($patchRequest, $connection); 
            
            
            return $output->id;

        } catch (\Exception $e) {
            return false;
        }
    }
    /**
     * Update Plan
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param [type] $plan
     * @return void
     */
    public static function updateplan($request, $plan){
        return self::createplan($plan);
    }
    /**
     * Sync Plans
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param [type] $plan
     * @return void
     */
    public static function syncplan($plan){

        // $connection = new \PayPal\Rest\ApiContext(
        //     new \PayPal\Auth\OAuthTokenCredential(
        //         config('paypalapi')->public,
        //         config('paypalapi')->secret
        //     )
        // );      

        // $connection->setConfig(
        //     [
        //         'log.LogEnabled' => DEBUG,
        //         'log.FileName' => LOGS.'/PayPal.log',
        //         'log.LogLevel' => 'DEBUG',
        //         'http.CURLOPT_SSL_VERIFYPEER' => DEBUG ? false : true,
        //         'mode' => DEBUG ? 'sandbox' : 'live'
        //     ]
        // );  

        // print_r(\PayPal\Api\Plan::get($plan->data->paypalapi->month, $connection));

        // exit;

        return self::createplan($plan);
    }
    /**
     * Save Settings
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public static function save($request){

        if(!$request->paypalapi['public'] || !$request->paypalapi['secret']) return false;
        
        $connection = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                $request->paypalapi['public'],
                $request->paypalapi['secret']
            )
        );    

        $connection->setConfig(
            [
                'log.LogEnabled' => DEBUG,
                'log.FileName' => LOGS.'/PayPal.log',
                'log.LogLevel' => 'DEBUG',
                'http.CURLOPT_SSL_VERIFYPEER' => DEBUG ? false : true,
                'mode' => DEBUG ? 'sandbox' : 'live'
            ]
        );  

        $webhook = new \PayPal\Api\Webhook();

        $webhook->setUrl(route('webhook', ['paypal']));

        $webhookEventTypes = array();
        $webhookEventTypes[] = new \PayPal\Api\WebhookEventType(
            '{
                "name":"PAYMENT.SALE.COMPLETED"
            }'
        );
        $webhookEventTypes[] = new \PayPal\Api\WebhookEventType(
            '{
                "name":"PAYMENT.SALE.REFUNDED"
            }'
        );
        $webhookEventTypes[] = new \PayPal\Api\WebhookEventType(
            '{
                "name":"PAYMENT.SALE.REVERSED"
            }'
        );    
        $webhook->setEventTypes($webhookEventTypes);    

        try {
        
            $webhook->create($connection);
        
        } catch (\Exception $e) {

            \GemError::log('PayPal API: '.$e->getMessage());

        }
    }
    /**
     * Cancel
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.4
     * @return void
     */
    public static function cancel($user = null){
        $connection = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                config('paypalapi')->public,
                config('paypalapi')->secret
            )
        );    

        $connection->setConfig(
            [
                'log.LogEnabled' => DEBUG,
                'log.FileName' => LOGS.'/PayPal.log',
                'log.LogLevel' => 'DEBUG',
                'http.CURLOPT_SSL_VERIFYPEER' => DEBUG ? false : true,
                'mode' => DEBUG ? 'sandbox' : 'live'
            ]
        );    

        if(!$user){
            $user = Auth::user();
        }

        $payment = DB::payment()->where('userid', $user->id)->orderByDesc('date')->first();
        
        $agreementStateDescriptor = new \PayPal\Api\AgreementStateDescriptor();
        $agreementStateDescriptor->setNote(request()->reason ?? 'Canceled by user');
    
        try{
            $agreement = \PayPal\Api\Agreement::get($payment->cid, $connection);    

            $agreement->cancel($agreementStateDescriptor, $connection);

        }catch(\Exception $e){
            \GemError::log('PayPal Cancel Error:'.$e->getMessage());            
        }
    }
}