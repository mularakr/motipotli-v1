<?php

class SendNotificationComponent extends Component {

    var $Controller;

    public function startup(Controller $controller) {
        $this->Controller = $controller;
    }

   /** [send_otp_number description]
     *@param: 
     *
     */
  
    public function send_notification($tokens=null,$badge=null)
    {
        // API access key from Google API's Console 

        define('API_ACCESS_KEY', 'AAAAA2urIeA:APA91bHfN6q-3y-AAiMOAUv6kQICnGJyzpEMTs1A0D4U8fnnLK_k3BlYKYiqVEOxJojESwFje-UguS8IRwmr1NKCSVr1Y5S_eqG27fGoEQPNt0d1jhxpfNiCRmr2wRqQfMjxIGYQ1-G5');     
    $randomNum=1;
    $ttl=10;
        foreach($tokens as $token){       
            try {
      
                $registrationIds = array($token['device_token']); // prep the bundle 

               /* $msg = array ( 
                    'body' => 'here is a message', 
                    'custom_fields' => $badge
                ); 

                //$fields = array ( 'registration_ids' => $registrationIds, 'data' => array('notification'=> $msg) ); 
                $fields = array ( 'registration_ids' => $registrationIds, 
                  'data' => array('notification'=> $msg,
                   "title" => "motipotli",
                    //"click_action" => "https://www.motipotli.com" 
                  //"click_action" => "FCM_PLUGIN_ACTIVITY"           
                  )
                  );*/
       $fields = array (         
          'registration_ids' => $registrationIds,
          'notification' => array (
            "title" => "Motipotli",
                        "custom_fields" => $badge,
            "body" => $token['message'], 
            "sound" => "default",
            "click_action" => ($token['device_type'] != 'web') ? "" : "https://www.motipotli.com/notification",
            "time_to_live" => $ttl,
            "collapse_key"=>$randomNum
          ),
          "priority" =>"high",
        );
                $headers = array ( 'Authorization: key='.API_ACCESS_KEY, 'Content-Type: application/json' ); 
                $ch = curl_init(); 
                curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send'); // //
                curl_setopt( $ch,CURLOPT_POST, true ); 
                curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers ); 
                curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true ); 
                curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false ); 
                curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode($fields) ); 
                $result = curl_exec($ch );
                
                if(curl_error($ch)){
                    throw new Exception();
                }
                
                curl_close( $ch ); 
                // echo $result;
                 
                
            } catch (Exception $e) {
                echo $e;
                continue;
            }
        }
      return true;
      // if ($result) {
            return true;             
        //}/* else {
            return false;            
       // }

    }
}

?>