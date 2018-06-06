<?php


/**
@SWG\Swagger(
        basePath="/",
        host="192.168.3.31",
        schemes={"http"},
        produces={"application/json"},
        consumes={"application/json"},
        @SWG\Info(
            title="Moti Potli",
            description="motipotli App Version 1.0",
            termsOfService="http://swagger.io/terms/",
            @SWG\Contact(name="Evon API Team"),
            @SWG\License(name="MIT"),
            version="1.0.0"
        ),
        @SWG\Definition(
           definition="errorModel",
           required={"code", "message"},
           @SWG\Property(
               property="code",
               type="integer",
               format="int32"
           ),
           @SWG\Property(
               property="message",
               type="string"
           )
       )
    )
*/

/**
* @SWG\Post(path="/motipotli/api/v1.0/ping",
*   tags={"Ping"},
*   summary="Get Articles",
*   description="",
*   operationId="ping",
*   produces={"application/xml", "application/json"},      
*   @SWG\Response(response=400, description="testing API")
* )
*/

/**
* @SWG\Post(path="/motipotli/api/v1.0/app_signUp",
*   tags={"Register User"},
*   summary="Save User Details",
*   description="",
*   operationId="SaveUser",
*   produces={"application/xml", "application/json"},
*   @SWG\Parameter(
*     name="name",
*     in="formData",
*     description="Full Name",
*     required=true,
*     type="string",
*     default=""
*   ),
*   @SWG\Parameter(
*     name="phone",
*     in="formData",
*     description="Phone Number",
*     required=true,
*     type="integet",
*     default=""
*   ),
*   @SWG\Parameter(
*     name="email",
*     in="formData",
*     description="Email ID",
*     required=true,
*     type="string",
*     default=""
*   ),
*   @SWG\Parameter(
*     name="password",
*     in="formData",
*     description="Password",
*     required=true,
*     type="string",
*     default=""
*   ),
*   @SWG\Parameter(
*     name="state_id",
*     in="formData",
*     description="State Name",
*     type="string",   
*     default=""
*   ),
*   @SWG\Parameter(
*     name="city_id",
*     in="formData",
*     description="City Name",
*     type="integer",
*     default=""
*   ),   
*   @SWG\Parameter(
*     name="device_token",
*     in="formData",
*     description="Device Token",
*     type="integer",
*     default=""
*   ),        
*    @SWG\Parameter(
*     name="device_type",
*     in="formData",
*     description="Device Type",
*     type="integer",
*     default=""
*   ), 
*  @SWG\Parameter(
*     name="access_token",
*     in="formData",
*     description="Access Token",
*     type="integer",
*     default=""
*   ),     
*   @SWG\Response(response=400, description="Invalid username/password supplied")
* )
*/

/**
* @SWG\Post(path="/motipotli/api/v1.0/app_login",
*   tags={"User Login"},
*   summary="User Login",
*   description="",
*   operationId="UserLogin",
*   produces={"application/xml", "application/json"},
*   @SWG\Parameter(
*     name="email",
*     in="formData",
*     description="Email ID",
*     required=true,
*     type="string",
*     default=""
*   ),
*   @SWG\Parameter(
*     name="password",
*     in="formData",
*     description="Password",
*     required=true,
*     type="string",
*     default=""
*   ), 
*   @SWG\Parameter(
*     name="login_type",
*     in="formData",
*     description="login Type(employer,employee)",
*     required=true,
*     type="string",
*     default=""
*   ),
*   @SWG\Response(response=400, description="Invalid username/password supplied")
* )
*/
    
     
   

?>
