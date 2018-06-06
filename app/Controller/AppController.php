<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package     app.Controller
 * @link        https://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {


    var $pathvars = "";
    public $components = array(
        'Session',
        'Cookie',       
        'Auth' => array(
            'loginAction' => array('controller'=>'users','action'=>'login'),
            'loginRedirect' => array(
                'controller' => 'users',
                'action' => 'index',
                'admin'=>true                
            ),
            'logoutRedirect' => array(
                'controller' => 'users',
                'action' => 'login',               
            ),
            'authError' => 'Access Denied',
            'authenticate' => array(
                'Form' => array(                      
                        'userModel' => 'User',
                        'fields' => array(
                            'username' => 'email',
                            'password' => 'password'
                    )
                )
            )
        )
    );    
    
        function afterFilter() {
    if ($this->response->statusCode() == '404')
    {   
        if (!$this->Auth->user()) {
           $this->redirect('/', 404);
        }
        else {
        $this->redirect('/admin/users', 404);
        }
    }
}



    public function beforeFilter()
    {   
        //Set Base Dir details 
        $this->pathvars["basepath"]     = $this->webroot;
        $this->pathvars["csspath"]      = $this->webroot."css";
        $this->pathvars["jspath"]       = $this->webroot."js";
        $this->pathvars["imagepath"]    = $this->webroot."uploads";
        $this->pathvars["base_url"]     = FULL_BASE_URL.'/admin';
        //echo "<pre>";print_r($this->pathvars);die;
        $this->set("pathvars",$this->pathvars);
        $this->set("basepath",$this->webroot);
        $this->set("base_url" ,FULL_BASE_URL.'/admin');
        define('webUrl',FULL_BASE_URL."/admin");
        //echo webUrl.'/app/webroot/img/Logo_motipotli.png';die;
        
    }
    /** 
     * [send_mail description]
     *  
     */
    public function send_mail($email_data = null)
    {
        $email         = new CakeEmail('default');
        $email_to      = $email_data['to'];
        $email_msg     = $email_data['body'];
        $email_subject = $email_data['subject'];

        $email->to($email_to);
        $email->subject($email_subject);
        $mail_status = @$email->send($email_msg);

        if (!$mail_status) {
            return FALSE;
        }
            return TRUE;
    }

    /**
    * Varification Mail Send
    *
    * @throws NotFoundException
    * @param string $email
    * @return void
    */
    public function varificationMail($email,$mailContent,$emailArray)
    {    


//echo "<pre>";print_r($email);die;
        if (isset($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) 
        {
            // mail send to user after account created
            try{          
                //$logo=$this->fullurl('logo.png',"img/");
                //$header=$this->fullurl('emai-header.png',"img/");
                $rootlink = $this->pathvars["basepath"];
                $arrMail = array(
                    "{USER_NAME}" => $emailArray['username'],
                    "{EMAIL}" =>$emailArray['email'],
                    "{PASSWORD}" => $emailArray['password'],
                     "{WEB_URL}" => webUrl,
                );   
                $msg = @str_replace(array_keys($arrMail), array_values($arrMail), $mailContent);
                $body = $msg;        
                $myarray1=array();
                $myarray1['to'] =$email;
                $myarray1['subject'] = 'Welcome Email !!';
                $myarray1['body'] =$body;

                if($this->send_mail($myarray1))
                {
               // die('send');
                }       
            }catch(Exception $e){

            //echo $e=>getMessage();exit;
            }
        }
    }

/**
    * Varification Mail Send
    *
    * @throws NotFoundException
    * @param string $email
    * @return void
    */
    public function userVarificationMail($email,$mailContent,$emailArray)
    {    


//echo "<pre>";print_r($email);die;
        if (isset($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) 
        {
            // mail send to user after account created
            try{          
                //$logo=$this->fullurl('logo.png',"img/");
                //$header=$this->fullurl('emai-header.png',"img/");
                $rootlink = $this->pathvars["basepath"];
                $arrMail = array(
                    "{USER_NAME}" => $emailArray['username'],                   
                    "{CODE}" => $emailArray['send_url'],
                    "{WEB_URL}" => webUrl,
                );   
                $msg = @str_replace(array_keys($arrMail), array_values($arrMail), $mailContent);
                $body = $msg;        
                $myarray1=array();
                $myarray1['to'] =$email;
                $myarray1['subject'] = 'Activation Email !!';
                $myarray1['body'] =$body;

                if($this->send_mail($myarray1))
                {
               // die('send');
                }       
            }catch(Exception $e){

            //echo $e=>getMessage();exit;
            }
        }
    }
    /**
    * forgetPasswordMail Mail Send
    *
    * @throws NotFoundException
    * @param string $email
    * @return void
    */
    public function forgetPasswordMail($email,$mailContent,$emailArray)
    {

        if (isset($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) 
        {
            // mail send to user after account created
            try{            
                //$logo=$this->fullurl('logo.png',"img/");
                //$header=$this->fullurl('emai-header.png',"img/");
                $rootlink = $this->pathvars["basepath"];
                $arrMail = array(
                    "{USER_NAME}" => $emailArray['name'],
                    "{CODE}" =>$emailArray['send_url'],                   
                );   
                $msg = @str_replace(array_keys($arrMail), array_values($arrMail), $mailContent);
                $body = $msg;        
                $myarray1=array();
                $myarray1['to'] =$email;
                $myarray1['subject'] = 'MotiPotli, Password Request';
                $myarray1['body'] =$body;
                if($this->send_mail($myarray1))
                {
                // die('send');
                }       
            }catch(Exception $e){

            }
        }
    }

    /*#---------------------------------
    # @WebPageFunction: change_status
    # @Developer : Rafi Rizvi
    # @return updated status
    # @param
    #-------------------------------*/
    public function change_status1($cnt=null,$status=null,$id=null)
    {
        //controller 
        $controller=$this->request->data['cnt'];
        // echo $controller;die;
        //Manage model name 
        $model = Inflector::camelize(Inflector::singularize($this->request->data['cnt']));
        $id=$this->request->data['id'];
        $status=$this->request->data['status'];
        $data=array();
        $data[$model]['id'] =$id;
        $data[$model]['status'] =$status;
        //echo json_encode(array('status'=>$data));die;
        $this->loadModel($model);
        if(!$this->request->is('AJAX'))
        {
            return $this->redirect(array('controller' => $controller, 'action' => 'index'));
        }

        if(!$this->$model->save($data))
        {
            echo json_encode(array('status'=>'failure', 'message'=>'Unable to update status at the moment.'));
            die;
        }   
            echo json_encode(array('status'=>'success', 'message'=>'Status updated.'));
            die;
    }


    //full Image URL
    public function fullurl($imgname=null, $folder=null)
    {
        $val= '';//null;
        if(!$imgname)
        {
            return $val;
        }
        else
        {
            $url =Router::url('/', true).''.$folder.''.$imgname; //$folder" . $imgname;
            
            return $url;    
        }
    }
    

/** [send_otp_number description]
     *@param: 
     *
     */
    /*public function send_otp_number($mobileNumber,$MessageOtp)
    {
        //echo $mobileNumber.'</br>';
        //echo $MessageOtp;
        //die;
        try{
                $messageOtp1= urlencode("Your one time Verification OTP is $MessageOtp");//'Your one time Verification OTP is '.$MessageOtp;
                $curl = curl_init();
                $sender = 'motipotli';
                //echo $messageOtp1;
                curl_setopt_array($curl, array(
                
                // CURLOPT_URL => "https://sokt.io/htPiTXZryQqugush3WS6/motipotlisms-motipotliflowsms?message=hellbuddy&mobiles=919219718840&sender=123456",
                CURLOPT_URL => "https://sokt.io/htPiTXZryQqugush3WS6/motipotlisms-motipotliflowsms?message=".$messageOtp1."&mobiles=91".$mobileNumber."&sender=".$sender,
               
               // CURLOPT_URL => "http://api.msg91.com/api/sendhttp.php?sender=MSGIND&route=4&mobiles=9219718840&authkey=&encrypt=&country=0&message=gdfgdfg&flash=&unicode=&schtime=&afterminutes=&response=&campaign=",
                
            

                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "{\"hello\":\"world\"}",
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_HTTPHEADER => array(
                    "authkey: hm48RDY8uKaKKe6s4e72", 
                    "content-type: application/json"),
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);       
                if ($err) {
                    return false;
                //echo "cURL Error #:" . $err;
                } else {
                    return true;
               // echo $response;
                }  
            } catch (Exception $e) {
            echo $e;
            //continue;
        }  
    }*/


    public function send_otp_number($mobileNumber,$MessageOtp)
    {

        try{
                 $messageOtp1= urlencode("Your one time Verification OTP is $MessageOtp");//'Your one time Verification OTP is '.$MessageOtp;
                $curl = curl_init();
                $sender = 'motipotli';
                curl_setopt_array($curl, array(
                
                CURLOPT_URL => "http://api.msg91.com/api/sendhttp.php?sender=MSGIND&route=4&mobiles=91".$mobileNumber."&authkey=200279AxrbQ9C5W5a964ec6&country=0&message=".$messageOtp1,
               

                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "{\"hello\":\"world\"}",
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_HTTPHEADER => array(),
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);          
                if ($err) {
                    return false;
                } else {
                    return true;
                }  
            } catch (Exception $e) {
            echo $e;
        }
    }

}
