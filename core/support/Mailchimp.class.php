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
 * @package Core\Support
 * @author GemPixel (http://gempixel.com)
 * @copyright 2023 GemPixel
 * @license http://gempixel.com/license
 * @link http://gempixel.com  
 * @since 7.0
 */
namespace Core\Support;

use Core\Http;
use GemError;

final class Mailchimp {

    private $url = null;
    /**
     * Sending Domain
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.0
     */
    private $domain = null;
    /**
     * Private Key
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.0
     */
    private $key = null;    

    /**
     * Data
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.0
     */
    private $data = ['to' => [], 'from' => ''];

    /**
     * Template
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.3.3
     */
    private $template = null;


    /**
     * Send as Mailchimp
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.0
     * @param string $domain
     * @param string $key
     */
    public function __construct($config, $endpoint = null){

        if(is_array($config)) {
            $this->key = $config['key'];
		}

		if(is_object($config)){
            $this->domain = $config->domain;
            $this->key = $config->key;
		}

        $this->url = $endpoint ?? 'https://mandrillapp.com/api/1.0';
        return $this;
    }

	/**
	 * To user
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 7.0
	 * @param mixed $user
	 * @return void
	 */
	public function to($user){				
		if(is_array($user)){
            $this->data['to'][] = ['name' => $user[1], 'email' => $user[0]];
        } else {
            $this->data['to'][] = $user;
        }
		return $this;
	}
	/**
	 * Sender information
	 *
	 * @author GemPixel <https://gempixel.com> 
	 * @version 7.0
	 * @param mixed $sender
	 * @return void
	 */
	public function from($sender){		
		if(is_array($sender)){
            $this->data['from'] = ['from_name' => $sender[1], 'from_email' => $sender[0]];
        } else {
            $this->data['from'] = ['from_email' => $sender];
        }
		return $this;
	}
    /**
     * Reply to
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.0
     * @param array $contact
     * @return void
     */
    public function replyto($contact){
        $this->data['replyto'] = $contact;
		return $this;
	}
    /**
	 * Fetch Template - using this method requires a closure as $data["message"] using $this->template
	 * Email::parse can be used to replace placeholders in templates
	 *
	 * @author GemPixel <https://gempixel.com>
	 * @version 7.0
	 * @param   [type] $name [description]
	 * @return  [type]       [description]
	 */
	public function template($name){
		if(!file_exists($name)){
			$name =  STORAGE."/themes/".appConfig('app.default_theme')."/email.php";
		}
		$this->template = file_get_contents($name);
		return $this;
	}
    /**
	 * Parse template shortcodes: {{ shortcode }}
	 * 
	 * @author GemPixel <https://gempixel.com>
	 * @version 7.0
	 * @param   string $template
	 * @param   array  $parseArray  
	 * @return  string            
	 */
	public static function parse($template, array $parseArray) : string {

		foreach ($parseArray as $key => $value) {
			$template = preg_replace('#{{\t?\s?\t?'.$key.'\t?\s?\t?}}#', $value, $template);
		}

		return $template;
	}
   /**
    * Send as Mailchimp
    *
    * @author GemPixel <https://gempixel.com> 
    * @version 7.0
    * @param array $data
    * @return void
    */
    public function send(array $data){

        if(is_callable($data["message"]))	{
			$message = $data["message"]($this->template, $data);	
		} else {
			$message = $data["message"];	
		}

        $content = [
            'key' => $this->key,
            'message' => [
                'to' => [$this->data['to']],
                'subject' => $data['subject'],
                'html' => $message,
                'track_opens' => true,
                'track_clicks' => true,
            ]
        ];     
        $content['message'] += $this->data['from'];

        $http = Http::url($this->url.'/messages/send')
                    ->with('content-type', 'application/json')
                    ->body($content)
                    ->post();
                    
        if($http->httpCode() == 200) return true;

        GemError::log('Mailchimp API Error: '.$http->httpCode().' '.$http->getBody());
    
        $this->fallback($content);

        return false;
    }

    /**
     * Fallback
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 7.0
     * @param array $data
     * @return void
     */
    public function fallback(array $data){

        $headers  = "From:  {$this->data['message']['from_email']}\r\n";

		$headers .= "MIME-Version: 7.0\r\n";
		$headers .= "Content-type: text/html; charset=utf-8\r\n";

		mail($this->data["message"]['to'][0], $data["subject"], $data["html"], $headers);
	}

}