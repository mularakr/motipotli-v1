if(window.location.hostname == "localhost")
{
	

	var _ROOT = "http://"+window.location.hostname+"/motipotli/"	;

	var _FOLDERROOT = "http://"+window.location.hostname+"/motipotli/";
}
else
{
	
	var _ROOT = "http://"+window.location.hostname+"/motipotli/";	
	var _FOLDERROOT = "http://"+window.location.hostname+"/motipotli/";
}

$(document).ready(function()
{

	/*$("input[name='profileid']").click(function(){
var var_name = $("input[name='profileid']:checked").val();
alert(var_name);
if(var_name==1){
$("#form-register2").reset();
}
if(var_name==2){
$("#form-register").reset();
}
});*/

	$.validator.addMethod("CELL", function(value, element) { 
	//alert(document.getElementById('cellphone1').value.length);
	//alert(document.getElementById('cellphone2').value.length);
	//alert(document.getElementById('cellphone3').value.length);
	
		if(document.getElementById('cellphone1').value.length >0 || document.getElementById('cellphone2').value.length >0 || document.getElementById('cellphone3').value.length >0){
			
			//if(document.getElementById('cellphone1').value.length > 3){
			
			//}
			//alert('aaaa');
			if(document.getElementById('cellphone1').value.length ==3 &&  document.getElementById('cellphone2').value.length ==3 && document.getElementById('cellphone3').value.length ==4)
			{
				
				return true;
			}
		}else{
		return true;
		}
	//alert('asdasdasdasdasdasdasdasdasdasdasdsdasdsdsdsd'); return false;
        //return this.optional(element) || /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*\.(\w{2}|(com|net|org|edu|int|mil|gov|arpa|biz|aero|name|coop|info|pro|museum))$/i.test(value);  
    }, "Please providessssssss a valid cell phone222222222222222222"); 
	
	$.validator.addMethod("PASSWORD", function(value, element) {  
        return this.optional(element) || /^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])([a-zA-Z0-9]{8,})$/i.test(value);  
    }, ""); 
	$.validator.addMethod("PRIMARYEMAIL", function(value, element) {  
        return this.optional(element) || /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*\.(\w{2}|(com|net|org|edu|int|mil|gov|arpa|biz|aero|name|coop|info|pro|museum))$/i.test(value);  
    }, ""); 
	$.validator.addMethod("SECONDARYEMAIL", function(value, element) {  
        return this.optional(element) || /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*\.(\w{2}|(com|net|org|edu|int|mil|gov|arpa|biz|aero|name|coop|info|pro|museum))$/i.test(value);  
    }, "Please provide a valid Email Address"); 
	$.validator.addMethod("USERNAME", function(value, element) {  
        return this.optional(element) || /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*\.(\w{2}|(com|net|org|edu|int|mil|gov|arpa|biz|aero|name|coop|info|pro|museum))$/i.test(value);  
    }, "Please enter valid Email Address"); 
	$.validator.addMethod("EMAILNEW", function(value, element) {  
        return this.optional(element) || /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*\.(\w{2}|(com|net|org|edu|int|mil|gov|arpa|biz|aero|name|coop|info|pro|museum))$/i.test(value);  
    }, "Invalid Email Address"); 
	$.validator.addMethod("EMAIL", function(value, element) {  
        return this.optional(element) || /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*\.(\w{2}|(com|net|org|edu|int|mil|gov|arpa|biz|aero|name|coop|info|pro|museum))$/i.test(value);  
    }, ""); 
	
	$.validator.addMethod("FRIENDEMAIL", function(value, element) {  
        return this.optional(element) || /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*\.(\w{2}|(com|net|org|edu|int|mil|gov|arpa|biz|aero|name|coop|info|pro|museum))$/i.test(value);  
    }, ""); 
	$.validator.addMethod("FirstCharacter", function(value, element) {  
         return this.optional(element) || /^[a-zA-Z]/i.test(value);  
     }, "First letter should be character"); 
	 
	 //Phone Number validation
	 $.validator.addMethod("PhoneNumber", function(value, element) {  
         return this.optional(element) || /^((\+\d{1,3}(-| )?\(?\d\)?(-| )?\d{1,5})|(\(?\d{2,6}\)?))(-| )?(\d{3,4})(-| )?(\d{4})(( x| ext)\d{1,5}){0,1}$/i.test(value);  
     }, "Phone must contain only numbers, + and -."); 
	 
	 $.validator.addMethod("NoSpace", function(value, element) {  
         return this.optional(element) || /^[^\s]+$/i.test(value);  
     }, "Spaces are not allowed.");
	 
	 $.validator.addMethod("EMAIL", function(value, element) {  
         return this.optional(element) || /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*\.(\w{2}|(com|net|org|edu|int|mil|gov|arpa|biz|aero|name|coop|info|pro|museum))$/i.test(value);  
     }, "Please enter valid email address"); 
	 
	  $.validator.addMethod("RECEMAIL", function(value, element) {  
         return this.optional(element) || /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*\.(\w{2}|(com|net|org|edu|int|mil|gov|arpa|biz|aero|name|coop|info|pro|museum))$/i.test(value);  
     }, "Please enter valid email address"); 
	 
	
	 
	 $.validator.addMethod("CharactersSpace", function(value, element) {  
         return this.optional(element) || /^[a-zA-Z\s]+$/i.test(value);  
     }, "Phone must contain only numbers, + and -.");
	 
	
	/* $("#usereditFrm").validate({rules:{name: {required: true,FirstCharacter :true},email: {required: true,email: true}, user_number: {required: true,number: true},address: {required: true,maxlength:100}},
		messages: {name: {required: "Name is required."},email: {required: "Email is required."}, user_number: {required: "Number is required."},address: {required: "Address is requred"}}
		

	});	*/
	
	
	/*	 $("#signup").bind("invalid-form.validate", function(e, validator) {		 
			
		 var errors = validator.numberOfInvalids();
			
			if (errors) 
			{
				var message = errors == 1
				? 'You missed to fill compulsory field(s). It has been highlighted below'
				: 'You missed to fill compulsory field(s). They have been highlighted below';
				$("div.error span").html(message);
				$("div.error").show();
			} 
			else 
			{
				$("div.error").hide();
			}});*/
	
	 $("#resetfrm").validate(
									{	
										rules:	{
												
													"data[User][password]": {required: true,minlength: 8},
													"data[User][confirmpassword]": {required: true,minlength: 8,equalTo: "#password"},
												
													//"data[User][password]": {required: true},
													//"data[User][password]": {required: true,PASSWORD: true},
													//"data[User][confirmpassword]": {required: true,minlength: 8,equalTo: "#password"},
												

												
												},
										messages: {
													
												
														"data[User][password]": {required: "Please enter your Password" ,minlength: "Your password must be atleast 8 characters long."},
													"data[User][confirmpassword]": {required: "Please confirm your Password",minlength: "Your password must be atleast 8 characters long.",equalTo: "This does not match the password entered above."},
													//"data[User][password]": {required: "Please enter your Password"},
													//"data[User][confirmpassword]": {required: "Please confirm your Password",minlength: "Your password must be atleast 8 characters long.",equalTo: "This does not match the password entered above."},
												
														
												  }			
									});	
	
	/* $("#pincodefrm").validate(
									{	
										rules:	{
												
												
													"data[User][pincode]": {required: true},
												
												
												},
										messages: {
													
												
												
													"data[User][pincode]": {required: ""},
												
														
												  }			
									});	*/
									
									
					jQuery.validator.addMethod("lettersonly", function(value, element) {
  return this.optional(element) || /^[a-z]+$/i.test(value);
}, "Letters only please");
									
					$("#UserAdminAddForm").validate(
									{	
									     
																									
										rules:	{

												"data[User][name]": {required: true,minlength: 5,lettersonly:true,maxlength: 25},												
												"data[User][email]": {required: true, EMAIL: true ,remote:_ROOT+'users/ajaxemail'},
												"data[User][password]": {required: true,minlength: 5,maxlength: 15},
												"data[User][state_id]": {required: true},
												"data[User][city_id]": {required: true},
												"data[User][phone]": {required: true,number:true,minlength:10,maxlength: 13},
												},
										messages: {
													
												"data[User][name]": {required: "Please enter your Name"},
												"data[User][email]": {required: "Please enter your Email"},
												"data[User][password]": {required: "Please enter your password"},
												"data[User][state_id]": {required: "Please enter your State"},
												"data[User][city_id]": {required: "Please enter your City"},
												"data[User][phone]": {required: "Please enter your Phone"},												
												 }
                                                                                              
									});

									$("#UserAdminEditForm").validate(
									{	
									     
																									
										rules:	{

												"data[User][name]": {required: true,lettersonly:true,minlength: 5,maxlength: 25},												
												"data[User][email]": {required: true,EMAIL: true},
												"data[User][password]": {required: true,minlength: 5,maxlength: 50},
												"data[User][state_id]": {required: true},
												"data[User][city_id]": {required: true},
												"data[User][phone]": {required: true,number:true,minlength:10,maxlength: 13},
												},
										messages: {
													
												"data[User][name]": {required: "Please enter your Name"},
												"data[User][email]": {required: "Please enter your Email"},
												"data[User][password]": {required: "Please enter your password"},
												"data[User][state_id]": {required: "Please enter your State"},
												"data[User][city_id]": {required: "Please enter your City"},
												"data[User][phone]": {required: "Please enter your Phone"},												
												 }
                                                                                              
									});	

														
				
									
	
	/* $("#signup").validate(
									{	
									     groups: {
                                                                                                         phoneGroup: "data[User][homephone1] data[User][homephone2] data[User][homephone3]",
																										    phoneGroup2: "data[User][ce11phone1] data[User][cellphone2] data[User][cellphone3]",
                                                                                                    },
																									
																									
										rules:	{
												
													"data[User][username]": {required: true, USERNAME: true ,remote:_ROOT+'users/ajaxemail'},
													//"data[User][password]": {required: true,PASSWORD: true},
													"data[User][password]": {required: true,minlength: 8},
													"data[User][confirm_password]": {required: true,minlength: 8,equalTo: "#password"},
													"data[User][socialsecurity]": {number:true,minlength: 9,maxlength: 9},
													"data[User][firstname]": {required: true},
													"data[User][lastname]": {required: true},
													"data[User][address1]": {required: true},

													"data[User][city]": {required: true},
													"data[User][state]": {required: true},
													"data[User][zipcode]": {required: true,number:true,minlength: 5,maxlength: 5},
													"data[User][primaryemail]": {required: true, PRIMARYEMAIL: true},
													"data[User][secondaryemail]": {SECONDARYEMAIL: true},
													"data[User][homephone1]": {required: true,number:true,minlength: 3,maxlength: 3},
													"data[User][homephone2]": {required: true,number:true,minlength: 3,maxlength: 3},
													"data[User][homephone3]": {required: true,number:true,minlength: 4,maxlength: 4},
													"data[User][cellphone1]": {number:true,minlength: 3,maxlength: 3,CELL:true},
													"data[User][cellphone2]": {number:true,minlength: 3,maxlength: 3,CELL:true},
													"data[User][cellphone3]": {number:true,minlength: 4,maxlength: 4,CELL:true},
													"data[User][subscriptiontype]": {required: true},
													"data[User][agree]": {required: true}

												
												},
                   
                        
                        
										messages: {
													
												
													"data[User][username]": {required: "Please enter your Email Address", remote:jQuery.format("This email address is already in use. Please try another one")},
													"data[User][password]": {required: "Please enter your Password" ,minlength: "Your password must be atleast 8 characters long."},
													"data[User][confirm_password]": {required: "Please confirm your Password",minlength: "Your password must be atleast 8 characters long.",equalTo: "This does not match the password entered above."},
													"data[User][socialsecurity]": {number:"Please provide a valid Social Security",minlength: "Please provide a valid Social Security",maxlength:"Please provide a valid Social Security"},
													"data[User][firstname]": {required: "Please enter your First Name"},
													"data[User][lastname]": {required: "Please enter your Last Name"},
													"data[User][address1]": {required: "Please enter your Address"},
													"data[User][city]": {required: "Please enter your City"},
													"data[User][state]": {required: "Please select your State"},
													"data[User][zipcode]": {required: "Please enter your Zip Code",number:"Please provide a valid Zip Code",minlength: "Please provide a valid Zip Code",maxlength:"Please provide a valid Zip Code"},
													"data[User][primaryemail]": {required: "Please enter your Email Address",PRIMARYEMAIL: "Please provide  a valid Email Address"},
													"data[User][homephone1]": {required: "Please enter your home phone",number:"Please provide a valid home phone",minlength: "Please provide a valid home phone",maxlength: "Please provide a valid home phone"},
													"data[User][homephone2]": {required: "Please enter your home phone",number:"Please provide a valid home phone",minlength: "Please provide a valid home phone",maxlength: "Please provide a valid home phone"},
													"data[User][homephone3]": {required: "Please enter your home phone",number:"Please provide a valid home phone",minlength: "Please provide a valid home phone",maxlength: "Please provide a valid home phone"},
													"data[User][cellphone1]": {number:"Please provide a valid cell phone",minlength: "Please provide a valid cell phone",maxlength: "Please provide a valid cell phone"},
													"data[User][cellphone2]": {number:"Please provide a valid cell phone",minlength: "Please provide a valid cell phone",maxlength: "Please provide a valid cell phone"},
													"data[User][cellphone3]": {number:"Please provide a valid cell phone",minlength: "Please provide a valid cell phone",maxlength: "Please provide a valid cell phone"},
													"data[User][subscriptiontype]": {required: ""},
														"data[User][agree]": {required: "<div style='position: absolute;left:35px;top: 2px;font-size:12px;width:220px;'>Terms of Use must be checked.</div>"}
														
												  }
                                                                                              
									});	
									*/
		 $("#adfrm").validate(
									{	
										rules:	{
												
													
													"data[firstname]": {required: true},
												

												
												},
										messages: {
													
												
												
													"data[firstname]": {required: "ssgdasgadgsdgdsagdsagdsagdsadgsadggsdagsdasdgasadgsdgasgdasdg"},
													
												
														
												  }			
									});	

		$("#recipientfrm").validate(
									{	
										rules:	{
													"info[1][name]": {required: true},
													"info[2][name]": {required: true},
													"info[3][name]": {required: true},
													"info[4][name]": {required: true},
													"info[5][name]": {required: true},
													"info[6][name]": {required: true},
													"info[7][name]": {required: true},
													"info[8][name]": {required: true},
													"info[9][name]": {required: true},
													"info[10][name]": {required: true},
													"info[1][lastname]": {required: true},
													"info[2][lastname]": {required: true},
													"info[3][lastname]": {required: true},
													"info[4][lastname]": {required: true},
													"info[5][lastname]": {required: true},
													"info[6][lastname]": {required: true},
													"info[7][lastname]": {required: true},
													"info[8][lastname]": {required: true},
													"info[9][lastname]": {required: true},
													"info[10][lastname]": {required: true},
												"info[1][email]": {required: true , RECEMAIL: true,remote:_ROOT+'users/ajaxinfoemail1'},
													"info[2][email]": {required: true , RECEMAIL: true,remote:_ROOT+'users/ajaxinfoemail2'},
													"info[3][email]": {required: true , RECEMAIL: true,remote:_ROOT+'users/ajaxinfoemail3'},
													"info[4][email]": {required: true , RECEMAIL: true,remote:_ROOT+'users/ajaxinfoemail4'},
													"info[5][email]": {required: true , RECEMAIL: true,remote:_ROOT+'users/ajaxinfoemail5'},
													"info[6][email]": {required: true , RECEMAIL: true,remote:_ROOT+'users/ajaxinfoemail6'},
													"info[7][email]": {required: true , RECEMAIL: true,remote:_ROOT+'users/ajaxinfoemail7'},
													"info[8][email]": {required: true , RECEMAIL: true,remote:_ROOT+'users/ajaxinfoemail8'},
													"info[9][email]": {required: true , RECEMAIL: true,remote:_ROOT+'users/ajaxinfoemail9'},
													"info[10][email]": {required: true , RECEMAIL: true,remote:_ROOT+'users/ajaxinfoemail10'},
													
													"info[1][phone]": {number:true,minlength: 10,maxlength: 10},
													"info[2][phone]": {number:true,minlength: 10,maxlength: 10},
													"info[3][phone]": {number:true,minlength: 10,maxlength: 10},
													"info[4][phone]": {number:true,minlength: 10,maxlength: 10},
													"info[5][phone]": {number:true,minlength: 10,maxlength: 10},
													"info[6][phone]": {number:true,minlength: 10,maxlength: 10},
													"info[7][phone]": {number:true,minlength: 10,maxlength: 10},		
													"info[8][phone]": {number:true,minlength: 10,maxlength: 10},
													"info[9][phone]": {number:true,minlength: 10,maxlength: 10},
													"info[10][phone]": {number:true,minlength: 10,maxlength: 10},
												},
										messages: {
													
													"info[1][name]": {required: "Please enter First Name"},
													"info[2][name]": {required: "Please enter First Name"},
													"info[3][name]": {required: "Please enter First Name"},
													"info[4][name]": {required: "Please enter First Name"},
													
													"info[5][name]": {required: "Please enter First Name"},
													"info[6][name]": {required: "Please enter First Name"},
													"info[7][name]": {required: "Please enter First Name"},
													"info[8][name]": {required: "Please enter First Name"},
													"info[9][name]": {required: "Please enter First Name"},
													"info[10][name]": {required: "Please enter First Name"},
													"info[1][lastname]": {required: "Please enter Last Name"},
													"info[2][lastname]": {required: "Please enter Last Name"},
													"info[3][lastname]": {required: "Please enter Last Name"},
													"info[4][lastname]": {required: "Please enter Last Name"},
													"info[5][lastname]": {required: "Please enter Last Name"},
													"info[6][lastname]": {required: "Please enter Last Name"},
													"info[7][lastname]": {required: "Please enter Last Name"},
													"info[8][lastname]": {required: "Please enter Last Name"},
													"info[9][lastname]": {required: "Please enter Last Name"},
													"info[10][lastname]": {required: "Please enter Last Name"},
													
													"info[1][email]": {required: "Please enter Email", remote:jQuery.format("Email exists in the Information Recipient <br/>section. Please delete the existing record and<br/> try again.")},
													"info[2][email]": {required: "Please enter Email", remote:jQuery.format("Email exists in the Information Recipient <br/>section. Please delete the existing record and<br/> try again.")},
													"info[3][email]": {required: "Please enter Email" , remote:jQuery.format("Email exists in the Information Recipient <br/>section. Please delete the existing record and<br/> try again.")},
													"info[4][email]": {required: "Please enter Email", remote:jQuery.format("Email exists in the Information Recipient<br/> section. Please delete the existing record and<br/> try again.")},
													"info[5][email]": {required: "Please enter Email", remote:jQuery.format("Email exists in the Information Recipient<br/> section. Please delete the existing record and<br/> try again.")},
													"info[6][email]": {required: "Please enter Email", remote:jQuery.format("Email exists in the Information Recipient <br/>section. Please delete the existing record and<br/> try again.")},
													"info[7][email]": {required: "Please enter Email", remote:jQuery.format("Email exists in the Information Recipient <br/>section. Please delete the existing record and<br/> try again.")},
													"info[8][email]": {required: "Please enter Email", remote:jQuery.format("Email exists in the Information Recipient <br/>section. Please delete the existing record and<br/> try again.")},
													"info[9][email]": {required: "Please enter Email", remote:jQuery.format("Email exists in the Information Recipient <br/>section. Please delete the existing record and<br/> try again.")},
													"info[10][email]": {required: "Please enter Email", remote:jQuery.format("Email exists in the Information Recipient <br/>section. Please delete the existing record and <br/>try again.")},
													
													"info[1][phone]": {required: "Please enter phone",number:"Please enter valid phone number",minlength: "Please enter valid phone number",maxlength:"Please enter valid phone number"},
													"info[2][phone]": {required: "Please enter phone",number:"Please enter valid phone number",minlength: "Please enter valid phone number",maxlength:"Please enter valid phone number"},
													"info[3][phone]": {required: "Please enter phone",number:"Please enter valid phone number",minlength: "Please enter valid phone number",maxlength:"Please enter valid phone number"},
													"info[4][phone]": {required: "Please enter phone",number:"Please enter valid phone number",minlength: "Please enter valid phone number",maxlength:"Please enter valid phone number"},
												    "info[5][phone]": {required: "Please enter phone",number:"Please enter valid phone number",minlength: "Please enter valid phone number",maxlength:"Please enter valid phone number"},
													"info[6][phone]": {required: "Please enter phone",number:"Please enter valid phone number",minlength: "Please enter valid phone number",maxlength:"Please enter valid phone number"},
													"info[7][phone]": {required: "Please enter phone",number:"Please enter valid phone number",minlength: "Please enter valid phone number",maxlength:"Please enter valid phone number"},
													"info[8][phone]": {required: "Please enter phone",number:"Please enter valid phone number",minlength: "Please enter valid phone number",maxlength:"Please enter valid phone number"},
													"info[9][phone]": {required: "Please enter phone",number:"Please enter valid phone number",minlength: "Please enter valid phone number",maxlength:"Please enter valid phone number"},
													"info[10][phone]": {required: "Please enter phone",number:"Please enter valid phone number",minlength: "Please enter valid phone number",maxlength:"Please enter valid phone number"},
												  }			
									});	
									
									
					$("#assetsfrm").validate(
									{	
										rules:	{
													"info[1][bankname]": {required: true},
													"info[2][bankname]": {required: true},
													"info[3][bankname]": {required: true},
													"info[4][bankname]": {required: true},
													"info[5][bankname]": {required: true},
													"info[6][bankname]": {required: true},
													"info[7][bankname]": {required: true},
													"info[8][bankname]": {required: true},
													"info[9][bankname]": {required: true},
													"info[10][bankname]": {required: true},
													"info[11][bankname]": {required: true},
													"info[12][bankname]": {required: true},
													"info[13][bankname]": {required: true},
													"info[14][bankname]": {required: true},
													"info[15][bankname]": {required: true},
													"info[16][bankname]": {required: true},
													"info[17][bankname]": {required: true},
													"info[18][bankname]": {required: true},
													"info[19][bankname]": {required: true},
													"info[20][bankname]": {required: true},
													"info[21][bankname]": {required: true},
													"info[22][bankname]": {required: true},
													"info[23][bankname]": {required: true},
													"info[24][bankname]": {required: true},
													"info[25][bankname]": {required: true},
													
													
													
													"info[1][branchname]": {required: true},
													"info[2][branchname]": {required: true},
													"info[3][branchname]": {required: true},
													"info[4][branchname]": {required: true},
													"info[5][branchname]": {required: true},
													"info[6][branchname]": {required: true},
													"info[7][branchname]": {required: true},
													"info[8][branchname]": {required: true},
													"info[9][branchname]": {required: true},
													"info[10][branchname]": {required: true},
													"info[11][branchname]": {required: true},
													"info[12][branchname]": {required: true},
													"info[13][branchname]": {required: true},
													"info[14][branchname]": {required: true},
													"info[15][branchname]": {required: true},
													"info[16][branchname]": {required: true},
													"info[17][branchname]": {required: true},
													"info[18][branchname]": {required: true},
													"info[19][branchname]": {required: true},
													"info[20][branchname]": {required: true},
													"info[21][branchname]": {required: true},
													"info[22][branchname]": {required: true},
													"info[23][branchname]": {required: true},
													"info[24][branchname]": {required: true},
													"info[25][branchname]": {required: true},
													
													
													
													"info[1][account]": {required: true },
													"info[2][account]": {required: true },
													"info[3][account]": {required: true },
													"info[4][account]": {required: true },
													"info[5][account]": {required: true },
													"info[6][account]": {required: true },
													"info[7][account]": {required: true },
													"info[8][account]": {required: true },
													"info[9][account]": {required: true },
													"info[10][account]": {required: true },
													"info[11][account]": {required: true },
													"info[12][account]": {required: true },
													"info[13][account]": {required: true },
													"info[14][account]": {required: true },
													"info[15][account]": {required: true },
													"info[16][account]": {required: true },
													"info[17][account]": {required: true },
													"info[18][account]": {required: true },
													"info[19][account]": {required: true },
													"info[20][account]": {required: true },
													"info[21][account]": {required: true },
													"info[22][account]": {required: true },
													"info[23][account]": {required: true },
													"info[24][account]": {required: true },
													"info[25][account]": {required: true },
											
												},
										messages: {
													
													"info[1][bankname]": {required: "Please enter Institution Name"},
													"info[2][bankname]": {required: "Please enter Institution Name"},
													"info[3][bankname]": {required: "Please enter Institution Name"},
													"info[4][bankname]": {required: "Please enter Institution Name"},
													
													"info[5][bankname]": {required: "Please enter Institution Name"},
													"info[6][bankname]": {required: "Please enter Institution Name"},
													"info[7][bankname]": {required: "Please enter Institution Name"},
													"info[8][bankname]": {required: "Please enter Institution Name"},
													"info[9][bankname]": {required: "Please enter Institution Name"},
													"info[10][bankname]": {required: "Please enter Institution Name"},
													"info[11][bankname]": {required: "Please enter Institution Name"},
													"info[12][bankname]": {required: "Please enter Institution Name"},
													"info[13][bankname]": {required: "Please enter Institution Name"},
													"info[14][bankname]": {required: "Please enter Institution Name"},
													"info[15][bankname]": {required: "Please enter Institution Name"},
													"info[16][bankname]": {required: "Please enter Institution Name"},
													"info[17][bankname]": {required: "Please enter Institution Name"},
													"info[18][bankname]": {required: "Please enter Institution Name"},
													"info[19][bankname]": {required: "Please enter Institution Name"},
													"info[20][bankname]": {required: "Please enter Institution Name"},
													"info[21][bankname]": {required: "Please enter Institution Name"},
													"info[22][bankname]": {required: "Please enter Institution Name"},
													"info[23][bankname]": {required: "Please enter Institution Name"},
													"info[24][bankname]": {required: "Please enter Institution Name"},
													"info[25][bankname]": {required: "Please enter Institution Name"},
													
													
													
													
													
													"info[1][branchname]": {required: "Please enter Branch Name"},
													"info[2][branchname]": {required: "Please enter Branch Name"},
													"info[3][branchname]": {required: "Please enter Branch Name"},
													"info[4][branchname]": {required: "Please enter Branch Name"},
													"info[5][branchname]": {required: "Please enter Branch Name"},
													"info[6][branchname]": {required: "Please enter Branch Name"},
													"info[7][branchname]": {required: "Please enter Branch Name"},
													"info[8][branchname]": {required: "Please enter Branch Name"},
													"info[9][branchname]": {required: "Please enter Branch Name"},
													"info[10][branchname]": {required: "Please enter Branch Name"},
													"info[11][branchname]": {required: "Please enter Branch Name"},
													"info[12][branchname]": {required: "Please enter Branch Name"},
													"info[13][branchname]": {required: "Please enter Branch Name"},
													"info[14][branchname]": {required: "Please enter Branch Name"},
													"info[15][branchname]": {required: "Please enter Branch Name"},
													"info[16][branchname]": {required: "Please enter Branch Name"},
													"info[17][branchname]": {required: "Please enter Branch Name"},
													"info[18][branchname]": {required: "Please enter Branch Name"},
													"info[19][branchname]": {required: "Please enter Branch Name"},
													"info[20][branchname]": {required: "Please enter Branch Name"},
													"info[21][branchname]": {required: "Please enter Branch Name"},
													"info[22][branchname]": {required: "Please enter Branch Name"},
													"info[23][branchname]": {required: "Please enter Branch Name"},
													"info[24][branchname]": {required: "Please enter Branch Name"},
													"info[25][branchname]": {required: "Please enter Branch Name"},
													
													
													
												    "info[1][account]": {required: "Please enter Account Number"},
													"info[2][account]": {required: "Please enter Account Number"},
													"info[3][account]": {required: "Please enter Account Number"},
													"info[4][account]": {required: "Please enter Account Number"},
													"info[5][account]": {required: "Please enter Account Number"},
													"info[6][account]": {required: "Please enter Account Number"},
													"info[7][account]": {required: "Please enter Account Number"},
													"info[8][account]": {required: "Please enter Account Number"},
													"info[9][account]": {required: "Please enter Account Number"},
													"info[10][account]": {required: "Please enter Account Number"},
												     "info[11][account]": {required: "Please enter Account Number"},
													"info[12][account]": {required: "Please enter Account Number"},
													"info[13][account]": {required: "Please enter Account Number"},
													"info[14][account]": {required: "Please enter Account Number"},
													"info[15][account]": {required: "Please enter Account Number"},
													"info[16][account]": {required: "Please enter Account Number"},
													"info[17][account]": {required: "Please enter Account Number"},
													"info[18][account]": {required: "Please enter Account Number"},
													"info[19][account]": {required: "Please enter Account Number"},
													"info[20][account]": {required: "Please enter Account Number"},
												     "info[21][account]": {required: "Please enter Account Number"},
													"info[22][account]": {required: "Please enter Account Number"},
													"info[23][account]": {required: "Please enter Account Number"},
													"info[24][account]": {required: "Please enter Account Number"},
													"info[25][account]": {required: "Please enter Account Number"},
												
												
												  }			
									});
						$("#socialmediafrm").validate(
									{	
										rules:	{
													"info[1][username]": {required: true},
													"info[2][username]": {required: true},
													"info[3][username]": {required: true},
													"info[4][username]": {required: true},
													"info[5][username]": {required: true},
													"info[6][username]": {required: true},
													"info[7][username]": {required: true},
													"info[8][username]": {required: true},
													"info[9][username]": {required: true},
													"info[10][username]": {required: true},
													"info[11][username]": {required: true},
													"info[12][username]": {required: true},
													"info[13][username]": {required: true},
													"info[14][username]": {required: true},
													"info[15][username]": {required: true},
													"info[16][username]": {required: true},
													"info[17][username]": {required: true},
													"info[18][username]": {required: true},
													"info[19][username]": {required: true},
													"info[20][username]": {required: true},
													"info[21][username]": {required: true},
													"info[22][username]": {required: true},
													"info[23][username]": {required: true},
													"info[24][username]": {required: true},
													"info[25][username]": {required: true},
													
													
													
													"info[1][passwd]": {required: true},
													"info[2][passwd]": {required: true},
													"info[3][passwd]": {required: true},
													"info[4][passwd]": {required: true},
													"info[5][passwd]": {required: true},
													"info[6][passwd]": {required: true},
													"info[7][passwd]": {required: true},
													"info[8][passwd]": {required: true},
													"info[9][passwd]": {required: true},
													"info[10][passwd]": {required: true},
													"info[11][passwd]": {required: true},
													"info[12][passwd]": {required: true},
													"info[13][passwd]": {required: true},
													"info[14][passwd]": {required: true},
													"info[15][passwd]": {required: true},
													"info[16][passwd]": {required: true},
													"info[17][passwd]": {required: true},
													"info[18][passwd]": {required: true},
													"info[19][passwd]": {required: true},
													"info[20][passwd]": {required: true},
													"info[21][passwd]": {required: true},
													"info[22][passwd]": {required: true},
													"info[23][passwd]": {required: true},
													"info[24][passwd]": {required: true},
													"info[25][passwd]": {required: true},
													
													
													
													"info[1][weburl]": {required: true },
													"info[2][weburl]": {required: true },
													"info[3][weburl]": {required: true },
													"info[4][weburl]": {required: true },
													"info[5][weburl]": {required: true },
													"info[6][weburl]": {required: true },
													"info[7][weburl]": {required: true },
													"info[8][weburl]": {required: true },
													"info[9][weburl]": {required: true },
													"info[10][weburl]": {required: true },
													"info[11][weburl]": {required: true },
													"info[12][weburl]": {required: true },
													"info[13][weburl]": {required: true },
													"info[14][weburl]": {required: true },
													"info[15][weburl]": {required: true },
													"info[16][weburl]": {required: true },
													"info[17][weburl]": {required: true },
													"info[18][weburl]": {required: true },
													"info[19][weburl]": {required: true },
													"info[20][weburl]": {required: true },
													"info[21][weburl]": {required: true },
													"info[22][weburl]": {required: true },
													"info[23][weburl]": {required: true },
													"info[24][weburl]": {required: true },
													"info[25][weburl]": {required: true },
													
												},
										messages: {
													
													"info[1][username]": {required: "Please enter Username"},
													"info[2][username]": {required: "Please enter Username"},
													"info[3][username]": {required: "Please enter Username"},
													"info[4][username]": {required: "Please enter Username"},
													
													"info[5][username]": {required: "Please enter Username"},
													"info[6][username]": {required: "Please enter Username"},
													"info[7][username]": {required: "Please enter Username"},
													"info[8][username]": {required: "Please enter Username"},
													"info[9][username]": {required: "Please enter Username"},
													"info[10][username]": {required: "Please enter Username"},
													"info[11][username]": {required: "Please enter Username"},
													"info[12][username]": {required: "Please enter Username"},
													"info[13][username]": {required: "Please enter Username"},
													"info[14][username]": {required: "Please enter Username"},
													"info[15][username]": {required: "Please enter Username"},
													"info[16][username]": {required: "Please enter Username"},
													"info[17][username]": {required: "Please enter Username"},
													"info[18][username]": {required: "Please enter Username"},
													"info[19][username]": {required: "Please enter Username"},
													"info[20][username]": {required: "Please enter Username"},
													"info[21][username]": {required: "Please enter Username"},
													"info[22][username]": {required: "Please enter Username"},
													"info[23][username]": {required: "Please enter Username"},
													"info[24][username]": {required: "Please enter Username"},
													"info[25][username]": {required: "Please enter Username"},
													
													
													
													
													
													"info[1][passwd]": {required: "Please enter Password"},
													"info[2][passwd]": {required: "Please enter Password"},
													"info[3][passwd]": {required: "Please enter Password"},
													"info[4][passwd]": {required: "Please enter Password"},
													"info[5][passwd]": {required: "Please enter Password"},
													"info[6][passwd]": {required: "Please enter Password"},
													"info[7][passwd]": {required: "Please enter Password"},
													"info[8][passwd]": {required: "Please enter Password"},
													"info[9][passwd]": {required: "Please enter Password"},
													"info[10][passwd]": {required: "Please enter Password"},
													"info[11][passwd]": {required: "Please enter Password"},
													"info[12][passwd]": {required: "Please enter Password"},
													"info[13][passwd]": {required: "Please enter Password"},
													"info[14][passwd]": {required: "Please enter Password"},
													"info[15][passwd]": {required: "Please enter Password"},
													"info[16][passwd]": {required: "Please enter Password"},
													"info[17][passwd]": {required: "Please enter Password"},
													"info[18][passwd]": {required: "Please enter Password"},
													"info[19][passwd]": {required: "Please enter Password"},
													"info[20][passwd]": {required: "Please enter Password"},
													"info[21][passwd]": {required: "Please enter Password"},
													"info[22][passwd]": {required: "Please enter Password"},
													"info[23][passwd]": {required: "Please enter Password"},
													"info[24][passwd]": {required: "Please enter Password"},
													"info[25][passwd]": {required: "Please enter Password"},
													
													
													
												    "info[1][weburl]": {required: "Please enter Website URL"},
													"info[2][weburl]": {required: "Please enter Website URL"},
													"info[3][weburl]": {required: "Please enter Website URL"},
													"info[4][weburl]": {required: "Please enter Website URL"},
													"info[5][weburl]": {required: "Please enter Website URL"},
													"info[6][weburl]": {required: "Please enter Website URL"},
													"info[7][weburl]": {required: "Please enter Website URL"},
													"info[8][weburl]": {required: "Please enter Website URL"},
													"info[9][weburl]": {required: "Please enter Website URL"},
													"info[10][weburl]": {required: "Please enter Website URL"},
												     "info[11][weburl]": {required: "Please enter Website URL"},
													"info[12][weburl]": {required: "Please enter Website URL"},
													"info[13][weburl]": {required: "Please enter Website URL"},
													"info[14][weburl]": {required: "Please enter Website URL"},
													"info[15][weburl]": {required: "Please enter Website URL"},
													"info[16][weburl]": {required: "Please enter Website URL"},
													"info[17][weburl]": {required: "Please enter Website URL"},
													"info[18][weburl]": {required: "Please enter Website URL"},
													"info[19][weburl]": {required: "Please enter Website URL"},
													"info[20][weburl]": {required: "Please enter Website URL"},
												     "info[21][weburl]": {required: "Please enter Website URL"},
													"info[22][weburl]": {required: "Please enter Website URL"},
													"info[23][weburl]": {required: "Please enter Website URL"},
													"info[24][weburl]": {required: "Please enter Website URL"},
													"info[25][weburl]": {required: "Please enter Website URL"},
												
												
												
												  }			
									});						
						$("#entertainmentfrm").validate(
									{	
										rules:	{
													"info[1][username]": {required: true},
													"info[2][username]": {required: true},
													"info[3][username]": {required: true},
													"info[4][username]": {required: true},
													"info[5][username]": {required: true},
													"info[6][username]": {required: true},
													"info[7][username]": {required: true},
													"info[8][username]": {required: true},
													"info[9][username]": {required: true},
													"info[10][username]": {required: true},
													"info[11][username]": {required: true},
													"info[12][username]": {required: true},
													"info[13][username]": {required: true},
													"info[14][username]": {required: true},
													"info[15][username]": {required: true},
													"info[16][username]": {required: true},
													"info[17][username]": {required: true},
													"info[18][username]": {required: true},
													"info[19][username]": {required: true},
													"info[20][username]": {required: true},
													"info[21][username]": {required: true},
													"info[22][username]": {required: true},
													"info[23][username]": {required: true},
													"info[24][username]": {required: true},
													"info[25][username]": {required: true},
													
													
													
													"info[1][passwd]": {required: true},
													"info[2][passwd]": {required: true},
													"info[3][passwd]": {required: true},
													"info[4][passwd]": {required: true},
													"info[5][passwd]": {required: true},
													"info[6][passwd]": {required: true},
													"info[7][passwd]": {required: true},
													"info[8][passwd]": {required: true},
													"info[9][passwd]": {required: true},
													"info[10][passwd]": {required: true},
													"info[11][passwd]": {required: true},
													"info[12][passwd]": {required: true},
													"info[13][passwd]": {required: true},
													"info[14][passwd]": {required: true},
													"info[15][passwd]": {required: true},
													"info[16][passwd]": {required: true},
													"info[17][passwd]": {required: true},
													"info[18][passwd]": {required: true},
													"info[19][passwd]": {required: true},
													"info[20][passwd]": {required: true},
													"info[21][passwd]": {required: true},
													"info[22][passwd]": {required: true},
													"info[23][passwd]": {required: true},
													"info[24][passwd]": {required: true},
													"info[25][passwd]": {required: true},
													
													
													
													"info[1][weburl]": {required: true },
													"info[2][weburl]": {required: true },
													"info[3][weburl]": {required: true },
													"info[4][weburl]": {required: true },
													"info[5][weburl]": {required: true },
													"info[6][weburl]": {required: true },
													"info[7][weburl]": {required: true },
													"info[8][weburl]": {required: true },
													"info[9][weburl]": {required: true },
													"info[10][weburl]": {required: true },
													"info[11][weburl]": {required: true },
													"info[12][weburl]": {required: true },
													"info[13][weburl]": {required: true },
													"info[14][weburl]": {required: true },
													"info[15][weburl]": {required: true },
													"info[16][weburl]": {required: true },
													"info[17][weburl]": {required: true },
													"info[18][weburl]": {required: true },
													"info[19][weburl]": {required: true },
													"info[20][weburl]": {required: true },
													"info[21][weburl]": {required: true },
													"info[22][weburl]": {required: true },
													"info[23][weburl]": {required: true },
													"info[24][weburl]": {required: true },
													"info[25][weburl]": {required: true },
													
												},
										messages: {
													
													"info[1][username]": {required: "Please enter Username"},
													"info[2][username]": {required: "Please enter Username"},
													"info[3][username]": {required: "Please enter Username"},
													"info[4][username]": {required: "Please enter Username"},
													
													"info[5][username]": {required: "Please enter Username"},
													"info[6][username]": {required: "Please enter Username"},
													"info[7][username]": {required: "Please enter Username"},
													"info[8][username]": {required: "Please enter Username"},
													"info[9][username]": {required: "Please enter Username"},
													"info[10][username]": {required: "Please enter Username"},
													"info[11][username]": {required: "Please enter Username"},
													"info[12][username]": {required: "Please enter Username"},
													"info[13][username]": {required: "Please enter Username"},
													"info[14][username]": {required: "Please enter Username"},
													"info[15][username]": {required: "Please enter Username"},
													"info[16][username]": {required: "Please enter Username"},
													"info[17][username]": {required: "Please enter Username"},
													"info[18][username]": {required: "Please enter Username"},
													"info[19][username]": {required: "Please enter Username"},
													"info[20][username]": {required: "Please enter Username"},
													"info[21][username]": {required: "Please enter Username"},
													"info[22][username]": {required: "Please enter Username"},
													"info[23][username]": {required: "Please enter Username"},
													"info[24][username]": {required: "Please enter Username"},
													"info[25][username]": {required: "Please enter Username"},
													
													
													
													
													
													"info[1][passwd]": {required: "Please enter Password"},
													"info[2][passwd]": {required: "Please enter Password"},
													"info[3][passwd]": {required: "Please enter Password"},
													"info[4][passwd]": {required: "Please enter Password"},
													"info[5][passwd]": {required: "Please enter Password"},
													"info[6][passwd]": {required: "Please enter Password"},
													"info[7][passwd]": {required: "Please enter Password"},
													"info[8][passwd]": {required: "Please enter Password"},
													"info[9][passwd]": {required: "Please enter Password"},
													"info[10][passwd]": {required: "Please enter Password"},
													"info[11][passwd]": {required: "Please enter Password"},
													"info[12][passwd]": {required: "Please enter Password"},
													"info[13][passwd]": {required: "Please enter Password"},
													"info[14][passwd]": {required: "Please enter Password"},
													"info[15][passwd]": {required: "Please enter Password"},
													"info[16][passwd]": {required: "Please enter Password"},
													"info[17][passwd]": {required: "Please enter Password"},
													"info[18][passwd]": {required: "Please enter Password"},
													"info[19][passwd]": {required: "Please enter Password"},
													"info[20][passwd]": {required: "Please enter Password"},
													"info[21][passwd]": {required: "Please enter Password"},
													"info[22][passwd]": {required: "Please enter Password"},
													"info[23][passwd]": {required: "Please enter Password"},
													"info[24][passwd]": {required: "Please enter Password"},
													"info[25][passwd]": {required: "Please enter Password"},
													
													
													
												    "info[1][weburl]": {required: "Please enter Website URL"},
													"info[2][weburl]": {required: "Please enter Website URL"},
													"info[3][weburl]": {required: "Please enter Website URL"},
													"info[4][weburl]": {required: "Please enter Website URL"},
													"info[5][weburl]": {required: "Please enter Website URL"},
													"info[6][weburl]": {required: "Please enter Website URL"},
													"info[7][weburl]": {required: "Please enter Website URL"},
													"info[8][weburl]": {required: "Please enter Website URL"},
													"info[9][weburl]": {required: "Please enter Website URL"},
													"info[10][weburl]": {required: "Please enter Website URL"},
												     "info[11][weburl]": {required: "Please enter Website URL"},
													"info[12][weburl]": {required: "Please enter Website URL"},
													"info[13][weburl]": {required: "Please enter Website URL"},
													"info[14][weburl]": {required: "Please enter Website URL"},
													"info[15][weburl]": {required: "Please enter Website URL"},
													"info[16][weburl]": {required: "Please enter Website URL"},
													"info[17][weburl]": {required: "Please enter Website URL"},
													"info[18][weburl]": {required: "Please enter Website URL"},
													"info[19][weburl]": {required: "Please enter Website URL"},
													"info[20][weburl]": {required: "Please enter Website URL"},
												     "info[21][weburl]": {required: "Please enter Website URL"},
													"info[22][weburl]": {required: "Please enter Website URL"},
													"info[23][weburl]": {required: "Please enter Website URL"},
													"info[24][weburl]": {required: "Please enter Website URL"},
													"info[25][weburl]": {required: "Please enter Website URL"},
												
												
												
												  }			
									});	

$("#onlinebusinessfrm").validate(
									{	
										rules:	{
													"info[1][username]": {required: true},
													"info[2][username]": {required: true},
													"info[3][username]": {required: true},
													"info[4][username]": {required: true},
													"info[5][username]": {required: true},
													"info[6][username]": {required: true},
													"info[7][username]": {required: true},
													"info[8][username]": {required: true},
													"info[9][username]": {required: true},
													"info[10][username]": {required: true},
													"info[11][username]": {required: true},
													"info[12][username]": {required: true},
													"info[13][username]": {required: true},
													"info[14][username]": {required: true},
													"info[15][username]": {required: true},
													"info[16][username]": {required: true},
													"info[17][username]": {required: true},
													"info[18][username]": {required: true},
													"info[19][username]": {required: true},
													"info[20][username]": {required: true},
													"info[21][username]": {required: true},
													"info[22][username]": {required: true},
													"info[23][username]": {required: true},
													"info[24][username]": {required: true},
													"info[25][username]": {required: true},
													
													
													
													"info[1][passwd]": {required: true},
													"info[2][passwd]": {required: true},
													"info[3][passwd]": {required: true},
													"info[4][passwd]": {required: true},
													"info[5][passwd]": {required: true},
													"info[6][passwd]": {required: true},
													"info[7][passwd]": {required: true},
													"info[8][passwd]": {required: true},
													"info[9][passwd]": {required: true},
													"info[10][passwd]": {required: true},
													"info[11][passwd]": {required: true},
													"info[12][passwd]": {required: true},
													"info[13][passwd]": {required: true},
													"info[14][passwd]": {required: true},
													"info[15][passwd]": {required: true},
													"info[16][passwd]": {required: true},
													"info[17][passwd]": {required: true},
													"info[18][passwd]": {required: true},
													"info[19][passwd]": {required: true},
													"info[20][passwd]": {required: true},
													"info[21][passwd]": {required: true},
													"info[22][passwd]": {required: true},
													"info[23][passwd]": {required: true},
													"info[24][passwd]": {required: true},
													"info[25][passwd]": {required: true},
													
													
													
													"info[1][weburl]": {required: true },
													"info[2][weburl]": {required: true },
													"info[3][weburl]": {required: true },
													"info[4][weburl]": {required: true },
													"info[5][weburl]": {required: true },
													"info[6][weburl]": {required: true },
													"info[7][weburl]": {required: true },
													"info[8][weburl]": {required: true },
													"info[9][weburl]": {required: true },
													"info[10][weburl]": {required: true },
													"info[11][weburl]": {required: true },
													"info[12][weburl]": {required: true },
													"info[13][weburl]": {required: true },
													"info[14][weburl]": {required: true },
													"info[15][weburl]": {required: true },
													"info[16][weburl]": {required: true },
													"info[17][weburl]": {required: true },
													"info[18][weburl]": {required: true },
													"info[19][weburl]": {required: true },
													"info[20][weburl]": {required: true },
													"info[21][weburl]": {required: true },
													"info[22][weburl]": {required: true },
													"info[23][weburl]": {required: true },
													"info[24][weburl]": {required: true },
													"info[25][weburl]": {required: true },
													
												},
										messages: {
													
													"info[1][username]": {required: "Please enter Username"},
													"info[2][username]": {required: "Please enter Username"},
													"info[3][username]": {required: "Please enter Username"},
													"info[4][username]": {required: "Please enter Username"},
													
													"info[5][username]": {required: "Please enter Username"},
													"info[6][username]": {required: "Please enter Username"},
													"info[7][username]": {required: "Please enter Username"},
													"info[8][username]": {required: "Please enter Username"},
													"info[9][username]": {required: "Please enter Username"},
													"info[10][username]": {required: "Please enter Username"},
													"info[11][username]": {required: "Please enter Username"},
													"info[12][username]": {required: "Please enter Username"},
													"info[13][username]": {required: "Please enter Username"},
													"info[14][username]": {required: "Please enter Username"},
													"info[15][username]": {required: "Please enter Username"},
													"info[16][username]": {required: "Please enter Username"},
													"info[17][username]": {required: "Please enter Username"},
													"info[18][username]": {required: "Please enter Username"},
													"info[19][username]": {required: "Please enter Username"},
													"info[20][username]": {required: "Please enter Username"},
													"info[21][username]": {required: "Please enter Username"},
													"info[22][username]": {required: "Please enter Username"},
													"info[23][username]": {required: "Please enter Username"},
													"info[24][username]": {required: "Please enter Username"},
													"info[25][username]": {required: "Please enter Username"},
													
													
													
													
													
													"info[1][passwd]": {required: "Please enter Password"},
													"info[2][passwd]": {required: "Please enter Password"},
													"info[3][passwd]": {required: "Please enter Password"},
													"info[4][passwd]": {required: "Please enter Password"},
													"info[5][passwd]": {required: "Please enter Password"},
													"info[6][passwd]": {required: "Please enter Password"},
													"info[7][passwd]": {required: "Please enter Password"},
													"info[8][passwd]": {required: "Please enter Password"},
													"info[9][passwd]": {required: "Please enter Password"},
													"info[10][passwd]": {required: "Please enter Password"},
													"info[11][passwd]": {required: "Please enter Password"},
													"info[12][passwd]": {required: "Please enter Password"},
													"info[13][passwd]": {required: "Please enter Password"},
													"info[14][passwd]": {required: "Please enter Password"},
													"info[15][passwd]": {required: "Please enter Password"},
													"info[16][passwd]": {required: "Please enter Password"},
													"info[17][passwd]": {required: "Please enter Password"},
													"info[18][passwd]": {required: "Please enter Password"},
													"info[19][passwd]": {required: "Please enter Password"},
													"info[20][passwd]": {required: "Please enter Password"},
													"info[21][passwd]": {required: "Please enter Password"},
													"info[22][passwd]": {required: "Please enter Password"},
													"info[23][passwd]": {required: "Please enter Password"},
													"info[24][passwd]": {required: "Please enter Password"},
													"info[25][passwd]": {required: "Please enter Password"},
													
													
													
												    "info[1][weburl]": {required: "Please enter Website URL"},
													"info[2][weburl]": {required: "Please enter Website URL"},
													"info[3][weburl]": {required: "Please enter Website URL"},
													"info[4][weburl]": {required: "Please enter Website URL"},
													"info[5][weburl]": {required: "Please enter Website URL"},
													"info[6][weburl]": {required: "Please enter Website URL"},
													"info[7][weburl]": {required: "Please enter Website URL"},
													"info[8][weburl]": {required: "Please enter Website URL"},
													"info[9][weburl]": {required: "Please enter Website URL"},
													"info[10][weburl]": {required: "Please enter Website URL"},
												     "info[11][weburl]": {required: "Please enter Website URL"},
													"info[12][weburl]": {required: "Please enter Website URL"},
													"info[13][weburl]": {required: "Please enter Website URL"},
													"info[14][weburl]": {required: "Please enter Website URL"},
													"info[15][weburl]": {required: "Please enter Website URL"},
													"info[16][weburl]": {required: "Please enter Website URL"},
													"info[17][weburl]": {required: "Please enter Website URL"},
													"info[18][weburl]": {required: "Please enter Website URL"},
													"info[19][weburl]": {required: "Please enter Website URL"},
													"info[20][weburl]": {required: "Please enter Website URL"},
												     "info[21][weburl]": {required: "Please enter Website URL"},
													"info[22][weburl]": {required: "Please enter Website URL"},
													"info[23][weburl]": {required: "Please enter Website URL"},
													"info[24][weburl]": {required: "Please enter Website URL"},
													"info[25][weburl]": {required: "Please enter Website URL"},
												
												
												
												  }			
									});						
															
						$("#utilitiesfrm").validate(
									{	
										rules:	{
													"info[1][username]": {required: true},
													"info[2][username]": {required: true},
													"info[3][username]": {required: true},
													"info[4][username]": {required: true},
													"info[5][username]": {required: true},
													"info[6][username]": {required: true},
													"info[7][username]": {required: true},
													"info[8][username]": {required: true},
													"info[9][username]": {required: true},
													"info[10][username]": {required: true},
													"info[11][username]": {required: true},
													"info[12][username]": {required: true},
													"info[13][username]": {required: true},
													"info[14][username]": {required: true},
													"info[15][username]": {required: true},
													"info[16][username]": {required: true},
													"info[17][username]": {required: true},
													"info[18][username]": {required: true},
													"info[19][username]": {required: true},
													"info[20][username]": {required: true},
													"info[21][username]": {required: true},
													"info[22][username]": {required: true},
													"info[23][username]": {required: true},
													"info[24][username]": {required: true},
													"info[25][username]": {required: true},
													
													
													
													"info[1][passwd]": {required: true},
													"info[2][passwd]": {required: true},
													"info[3][passwd]": {required: true},
													"info[4][passwd]": {required: true},
													"info[5][passwd]": {required: true},
													"info[6][passwd]": {required: true},
													"info[7][passwd]": {required: true},
													"info[8][passwd]": {required: true},
													"info[9][passwd]": {required: true},
													"info[10][passwd]": {required: true},
													"info[11][passwd]": {required: true},
													"info[12][passwd]": {required: true},
													"info[13][passwd]": {required: true},
													"info[14][passwd]": {required: true},
													"info[15][passwd]": {required: true},
													"info[16][passwd]": {required: true},
													"info[17][passwd]": {required: true},
													"info[18][passwd]": {required: true},
													"info[19][passwd]": {required: true},
													"info[20][passwd]": {required: true},
													"info[21][passwd]": {required: true},
													"info[22][passwd]": {required: true},
													"info[23][passwd]": {required: true},
													"info[24][passwd]": {required: true},
													"info[25][passwd]": {required: true},
													
													
													
													"info[1][weburl]": {required: true },
													"info[2][weburl]": {required: true },
													"info[3][weburl]": {required: true },
													"info[4][weburl]": {required: true },
													"info[5][weburl]": {required: true },
													"info[6][weburl]": {required: true },
													"info[7][weburl]": {required: true },
													"info[8][weburl]": {required: true },
													"info[9][weburl]": {required: true },
													"info[10][weburl]": {required: true },
													"info[11][weburl]": {required: true },
													"info[12][weburl]": {required: true },
													"info[13][weburl]": {required: true },
													"info[14][weburl]": {required: true },
													"info[15][weburl]": {required: true },
													"info[16][weburl]": {required: true },
													"info[17][weburl]": {required: true },
													"info[18][weburl]": {required: true },
													"info[19][weburl]": {required: true },
													"info[20][weburl]": {required: true },
													"info[21][weburl]": {required: true },
													"info[22][weburl]": {required: true },
													"info[23][weburl]": {required: true },
													"info[24][weburl]": {required: true },
													"info[25][weburl]": {required: true },
													
												},
										messages: {
													
													"info[1][username]": {required: "Please enter Username"},
													"info[2][username]": {required: "Please enter Username"},
													"info[3][username]": {required: "Please enter Username"},
													"info[4][username]": {required: "Please enter Username"},
													
													"info[5][username]": {required: "Please enter Username"},
													"info[6][username]": {required: "Please enter Username"},
													"info[7][username]": {required: "Please enter Username"},
													"info[8][username]": {required: "Please enter Username"},
													"info[9][username]": {required: "Please enter Username"},
													"info[10][username]": {required: "Please enter Username"},
													"info[11][username]": {required: "Please enter Username"},
													"info[12][username]": {required: "Please enter Username"},
													"info[13][username]": {required: "Please enter Username"},
													"info[14][username]": {required: "Please enter Username"},
													"info[15][username]": {required: "Please enter Username"},
													"info[16][username]": {required: "Please enter Username"},
													"info[17][username]": {required: "Please enter Username"},
													"info[18][username]": {required: "Please enter Username"},
													"info[19][username]": {required: "Please enter Username"},
													"info[20][username]": {required: "Please enter Username"},
													"info[21][username]": {required: "Please enter Username"},
													"info[22][username]": {required: "Please enter Username"},
													"info[23][username]": {required: "Please enter Username"},
													"info[24][username]": {required: "Please enter Username"},
													"info[25][username]": {required: "Please enter Username"},
													
													
													
													
													
													"info[1][passwd]": {required: "Please enter Password"},
													"info[2][passwd]": {required: "Please enter Password"},
													"info[3][passwd]": {required: "Please enter Password"},
													"info[4][passwd]": {required: "Please enter Password"},
													"info[5][passwd]": {required: "Please enter Password"},
													"info[6][passwd]": {required: "Please enter Password"},
													"info[7][passwd]": {required: "Please enter Password"},
													"info[8][passwd]": {required: "Please enter Password"},
													"info[9][passwd]": {required: "Please enter Password"},
													"info[10][passwd]": {required: "Please enter Password"},
													"info[11][passwd]": {required: "Please enter Password"},
													"info[12][passwd]": {required: "Please enter Password"},
													"info[13][passwd]": {required: "Please enter Password"},
													"info[14][passwd]": {required: "Please enter Password"},
													"info[15][passwd]": {required: "Please enter Password"},
													"info[16][passwd]": {required: "Please enter Password"},
													"info[17][passwd]": {required: "Please enter Password"},
													"info[18][passwd]": {required: "Please enter Password"},
													"info[19][passwd]": {required: "Please enter Password"},
													"info[20][passwd]": {required: "Please enter Password"},
													"info[21][passwd]": {required: "Please enter Password"},
													"info[22][passwd]": {required: "Please enter Password"},
													"info[23][passwd]": {required: "Please enter Password"},
													"info[24][passwd]": {required: "Please enter Password"},
													"info[25][passwd]": {required: "Please enter Password"},
													
													
													
												    "info[1][weburl]": {required: "Please enter Website URL"},
													"info[2][weburl]": {required: "Please enter Website URL"},
													"info[3][weburl]": {required: "Please enter Website URL"},
													"info[4][weburl]": {required: "Please enter Website URL"},
													"info[5][weburl]": {required: "Please enter Website URL"},
													"info[6][weburl]": {required: "Please enter Website URL"},
													"info[7][weburl]": {required: "Please enter Website URL"},
													"info[8][weburl]": {required: "Please enter Website URL"},
													"info[9][weburl]": {required: "Please enter Website URL"},
													"info[10][weburl]": {required: "Please enter Website URL"},
												     "info[11][weburl]": {required: "Please enter Website URL"},
													"info[12][weburl]": {required: "Please enter Website URL"},
													"info[13][weburl]": {required: "Please enter Website URL"},
													"info[14][weburl]": {required: "Please enter Website URL"},
													"info[15][weburl]": {required: "Please enter Website URL"},
													"info[16][weburl]": {required: "Please enter Website URL"},
													"info[17][weburl]": {required: "Please enter Website URL"},
													"info[18][weburl]": {required: "Please enter Website URL"},
													"info[19][weburl]": {required: "Please enter Website URL"},
													"info[20][weburl]": {required: "Please enter Website URL"},
												     "info[21][weburl]": {required: "Please enter Website URL"},
													"info[22][weburl]": {required: "Please enter Website URL"},
													"info[23][weburl]": {required: "Please enter Website URL"},
													"info[24][weburl]": {required: "Please enter Website URL"},
													"info[25][weburl]": {required: "Please enter Website URL"},
												
												
												
												  }			
									});						
									
					$("#accountemailfrm").validate(
									{	
										rules:	{
													"info[1][username]": {required: true},
													"info[2][username]": {required: true},
													"info[3][username]": {required: true},
													"info[4][username]": {required: true},
													"info[5][username]": {required: true},
													"info[6][username]": {required: true},
													"info[7][username]": {required: true},
													"info[8][username]": {required: true},
													"info[9][username]": {required: true},
													"info[10][username]": {required: true},
													"info[11][username]": {required: true},
													"info[12][username]": {required: true},
													"info[13][username]": {required: true},
													"info[14][username]": {required: true},
													"info[15][username]": {required: true},
													"info[16][username]": {required: true},
													"info[17][username]": {required: true},
													"info[18][username]": {required: true},
													"info[19][username]": {required: true},
													"info[20][username]": {required: true},
													"info[21][username]": {required: true},
													"info[22][username]": {required: true},
													"info[23][username]": {required: true},
													"info[24][username]": {required: true},
													"info[25][username]": {required: true},
													
													
													
													"info[1][passwd]": {required: true},
													"info[2][passwd]": {required: true},
													"info[3][passwd]": {required: true},
													"info[4][passwd]": {required: true},
													"info[5][passwd]": {required: true},
													"info[6][passwd]": {required: true},
													"info[7][passwd]": {required: true},
													"info[8][passwd]": {required: true},
													"info[9][passwd]": {required: true},
													"info[10][passwd]": {required: true},
													"info[11][passwd]": {required: true},
													"info[12][passwd]": {required: true},
													"info[13][passwd]": {required: true},
													"info[14][passwd]": {required: true},
													"info[15][passwd]": {required: true},
													"info[16][passwd]": {required: true},
													"info[17][passwd]": {required: true},
													"info[18][passwd]": {required: true},
													"info[19][passwd]": {required: true},
													"info[20][passwd]": {required: true},
													"info[21][passwd]": {required: true},
													"info[22][passwd]": {required: true},
													"info[23][passwd]": {required: true},
													"info[24][passwd]": {required: true},
													"info[25][passwd]": {required: true},
													
													
													
													"info[1][weburl]": {required: true },
													"info[2][weburl]": {required: true },
													"info[3][weburl]": {required: true },
													"info[4][weburl]": {required: true },
													"info[5][weburl]": {required: true },
													"info[6][weburl]": {required: true },
													"info[7][weburl]": {required: true },
													"info[8][weburl]": {required: true },
													"info[9][weburl]": {required: true },
													"info[10][weburl]": {required: true },
													"info[11][weburl]": {required: true },
													"info[12][weburl]": {required: true },
													"info[13][weburl]": {required: true },
													"info[14][weburl]": {required: true },
													"info[15][weburl]": {required: true },
													"info[16][weburl]": {required: true },
													"info[17][weburl]": {required: true },
													"info[18][weburl]": {required: true },
													"info[19][weburl]": {required: true },
													"info[20][weburl]": {required: true },
													"info[21][weburl]": {required: true },
													"info[22][weburl]": {required: true },
													"info[23][weburl]": {required: true },
													"info[24][weburl]": {required: true },
													"info[25][weburl]": {required: true },
											
												},
										messages: {
													
													"info[1][username]": {required: "Please enter Username"},
													"info[2][username]": {required: "Please enter Username"},
													"info[3][username]": {required: "Please enter Username"},
													"info[4][username]": {required: "Please enter Username"},
													
													"info[5][username]": {required: "Please enter Username"},
													"info[6][username]": {required: "Please enter Username"},
													"info[7][username]": {required: "Please enter Username"},
													"info[8][username]": {required: "Please enter Username"},
													"info[9][username]": {required: "Please enter Username"},
													"info[10][username]": {required: "Please enter Username"},
													"info[11][username]": {required: "Please enter Username"},
													"info[12][username]": {required: "Please enter Username"},
													"info[13][username]": {required: "Please enter Username"},
													"info[14][username]": {required: "Please enter Username"},
													"info[15][username]": {required: "Please enter Username"},
													"info[16][username]": {required: "Please enter Username"},
													"info[17][username]": {required: "Please enter Username"},
													"info[18][username]": {required: "Please enter Username"},
													"info[19][username]": {required: "Please enter Username"},
													"info[20][username]": {required: "Please enter Username"},
													"info[21][username]": {required: "Please enter Username"},
													"info[22][username]": {required: "Please enter Username"},
													"info[23][username]": {required: "Please enter Username"},
													"info[24][username]": {required: "Please enter Username"},
													"info[25][username]": {required: "Please enter Username"},
													
													
													
													"info[1][passwd]": {required: "Please enter Password"},
													"info[2][passwd]": {required: "Please enter Password"},
													"info[3][passwd]": {required: "Please enter Password"},
													"info[4][passwd]": {required: "Please enter Password"},
													"info[5][passwd]": {required: "Please enter Password"},
													"info[6][passwd]": {required: "Please enter Password"},
													"info[7][passwd]": {required: "Please enter Password"},
													"info[8][passwd]": {required: "Please enter Password"},
													"info[9][passwd]": {required: "Please enter Password"},
													"info[10][passwd]": {required: "Please enter Password"},
													"info[11][passwd]": {required: "Please enter Password"},
													"info[12][passwd]": {required: "Please enter Password"},
													"info[13][passwd]": {required: "Please enter Password"},
													"info[14][passwd]": {required: "Please enter Password"},
													"info[15][passwd]": {required: "Please enter Password"},
													"info[16][passwd]": {required: "Please enter Password"},
													"info[17][passwd]": {required: "Please enter Password"},
													"info[18][passwd]": {required: "Please enter Password"},
													"info[19][passwd]": {required: "Please enter Password"},
													"info[20][passwd]": {required: "Please enter Password"},
													"info[21][passwd]": {required: "Please enter Password"},
													"info[22][passwd]": {required: "Please enter Password"},
													"info[23][passwd]": {required: "Please enter Password"},
													"info[24][passwd]": {required: "Please enter Password"},
													"info[25][passwd]": {required: "Please enter Password"},
													
													
													
												    "info[1][weburl]": {required: "Please enter Website URL"},
													"info[2][weburl]": {required: "Please enter Website URL"},
													"info[3][weburl]": {required: "Please enter Website URL"},
													"info[4][weburl]": {required: "Please enter Website URL"},
													"info[5][weburl]": {required: "Please enter Website URL"},
													"info[6][weburl]": {required: "Please enter Website URL"},
													"info[7][weburl]": {required: "Please enter Website URL"},
													"info[8][weburl]": {required: "Please enter Website URL"},
													"info[9][weburl]": {required: "Please enter Website URL"},
													"info[10][weburl]": {required: "Please enter Website URL"},
												     "info[11][weburl]": {required: "Please enter Website URL"},
													"info[12][weburl]": {required: "Please enter Website URL"},
													"info[13][weburl]": {required: "Please enter Website URL"},
													"info[14][weburl]": {required: "Please enter Website URL"},
													"info[15][weburl]": {required: "Please enter Website URL"},
													"info[16][weburl]": {required: "Please enter Website URL"},
													"info[17][weburl]": {required: "Please enter Website URL"},
													"info[18][weburl]": {required: "Please enter Website URL"},
													"info[19][weburl]": {required: "Please enter Website URL"},
													"info[20][weburl]": {required: "Please enter Website URL"},
												     "info[21][weburl]": {required: "Please enter Website URL"},
													"info[22][weburl]": {required: "Please enter Website URL"},
													"info[23][weburl]": {required: "Please enter Website URL"},
													"info[24][weburl]": {required: "Please enter Website URL"},
													"info[25][weburl]": {required: "Please enter Website URL"},
												
												
												  }			
									});				
									
					$("#assetsredimfrm").validate(
									{	
										rules:	{
													"info[1][email]": {required: true,EMAILNEW: true ,remote:_ROOT+'users/ajaxemail1'},
													"info[2][email]": {required: true,EMAILNEW: true ,remote:_ROOT+'users/ajaxemail2'},
													"info[3][email]": {required: true,EMAILNEW: true ,remote:_ROOT+'users/ajaxemail3'},
													"info[4][email]": {required: true,EMAILNEW: true ,remote:_ROOT+'users/ajaxemail4'},
													"info[5][email]": {required: true,EMAILNEW: true ,remote:_ROOT+'users/ajaxemail5'},
													"info[6][email]": {required: true,EMAILNEW: true ,remote:_ROOT+'users/ajaxemail6'},
													"info[7][email]": {required: true,EMAILNEW: true ,remote:_ROOT+'users/ajaxemail7'},
													"info[8][email]": {required: true,EMAILNEW: true ,remote:_ROOT+'users/ajaxemail8'},
													"info[9][email]": {required: true,EMAILNEW: true ,remote:_ROOT+'users/ajaxemail9'},
													"info[10][email]": {required: true,EMAILNEW: true ,remote:_ROOT+'users/ajaxemail10'},
													"info[11][email]": {required: true,EMAILNEW: true ,remote:_ROOT+'users/ajaxemail11'},
													"info[12][email]": {required: true,EMAILNEW: true ,remote:_ROOT+'users/ajaxemail12'},
													"info[13][email]": {required: true,EMAILNEW: true ,remote:_ROOT+'users/ajaxemail13'},
													"info[14][email]": {required: true,EMAILNEW: true ,remote:_ROOT+'users/ajaxemail14'},
													"info[15][email]": {required: true,EMAILNEW: true ,remote:_ROOT+'users/ajaxemail15'},
													"info[16][email]": {required: true,EMAILNEW: true ,remote:_ROOT+'users/ajaxemail16'},
													"info[17][email]": {required: true,EMAILNEW: true ,remote:_ROOT+'users/ajaxemail17'},
													"info[18][email]": {required: true,EMAILNEW: true ,remote:_ROOT+'users/ajaxemail18'},
													"info[19][email]": {required: true,EMAILNEW: true ,remote:_ROOT+'users/ajaxemail19'},
													"info[20][email]": {required: true,EMAILNEW: true ,remote:_ROOT+'users/ajaxemail20'},
													"info[21][email]": {required: true,EMAILNEW: true ,remote:_ROOT+'users/ajaxemail21'},
													"info[22][email]": {required: true,EMAILNEW: true ,remote:_ROOT+'users/ajaxemail22'},
													"info[23][email]": {required: true,EMAILNEW: true ,remote:_ROOT+'users/ajaxemail23'},
													"info[24][email]": {required: true,EMAILNEW: true ,remote:_ROOT+'users/ajaxemail24'},
													"info[25][email]": {required: true,EMAILNEW: true ,remote:_ROOT+'users/ajaxemail25'},
													
													
													
												
												},
										messages: {
													
													"info[1][email]": {required: "Please enter Email",remote:jQuery.format("This is a registered user")},
													"info[2][email]": {required: "Please enter Email"},
													"info[3][email]": {required: "Please enter Email"},
													"info[4][email]": {required: "Please enter Email"},
													"info[5][email]": {required: "Please enter Email"},
													"info[6][email]": {required: "Please enter Email"},
													"info[7][email]": {required: "Please enter Email"},
													"info[8][email]": {required: "Please enter Email"},
													"info[9][email]": {required: "Please enter Email"},
													"info[10][email]": {required: "Please enter Email"},
													"info[11][email]": {required: "Please enter Email"},
													"info[12][email]": {required: "Please enter Email"},
													"info[13][email]": {required: "Please enter Email"},
													"info[14][email]": {required: "Please enter Email"},
													"info[15][email]": {required: "Please enter Email"},
													"info[16][email]": {required: "Please enter Email"},
													"info[17][email]": {required: "Please enter Email"},
													"info[18][email]": {required: "Please enter Email"},
													"info[19][email]": {required: "Please enter Email"},
													"info[20][email]": {required: "Please enter Email"},
													"info[21][email]": {required: "Please enter Email"},
													"info[22][email]": {required: "Please enter Email"},
													"info[23][email]": {required: "Please enter Email"},
													"info[24][email]": {required: "Please enter Email"},
													"info[25][email]": {required: "Please enter Email"},
													
												
												  }			
									});
									
									
							$("#assetsinsurefrm").validate(
									{	
										rules:	{
													"info[1][bankname]": {required: true},
													"info[2][bankname]": {required: true},
													"info[3][bankname]": {required: true},
													"info[4][bankname]": {required: true},
													"info[5][bankname]": {required: true},
													"info[6][bankname]": {required: true},
													"info[7][bankname]": {required: true},
													"info[8][bankname]": {required: true},
													"info[9][bankname]": {required: true},
													"info[10][bankname]": {required: true},
														"info[11][bankname]": {required: true},
													"info[12][bankname]": {required: true},
													"info[13][bankname]": {required: true},
													"info[14][bankname]": {required: true},
													"info[15][bankname]": {required: true},
													"info[16][bankname]": {required: true},
													"info[17][bankname]": {required: true},
													"info[18][bankname]": {required: true},
													"info[19][bankname]": {required: true},
													"info[20][bankname]": {required: true},
													"info[21][bankname]": {required: true},
													"info[22][bankname]": {required: true},
													"info[23][bankname]": {required: true},
													"info[24][bankname]": {required: true},
													"info[25][bankname]": {required: true},
													
													
													
												
													"info[1][country]": {required: true},
													"info[2][country]": {required: true},
													"info[3][country]": {required: true},
													"info[4][country]": {required: true},
													"info[5][country]": {required: true},
													"info[6][country]": {required: true},
													"info[7][country]": {required: true},
													"info[8][country]": {required: true},
													"info[9][country]": {required: true},
													
													"info[10][country]": {required: true},
														"info[11][country]": {required: true},
													"info[12][country]": {required: true},
													"info[13][country]": {required: true},
													"info[14][country]": {required: true},
													"info[15][country]": {required: true},
													"info[16][country]": {required: true},
													"info[17][country]": {required: true},
													"info[18][country]": {required: true},
													"info[19][country]": {required: true},
													
													"info[20][country]": {required: true},
													"info[21][country]": {required: true},
													"info[22][country]": {required: true},
													"info[23][country]": {required: true},
													"info[24][country]": {required: true},
													"info[25][country]": {required: true},
													
													
													
													
													"info[1][policyno]": {required: true },
													"info[2][policyno]": {required: true },
													"info[3][policyno]": {required: true },
													"info[4][policyno]": {required: true },
													"info[5][policyno]": {required: true },
													"info[6][policyno]": {required: true },
													"info[7][policyno]": {required: true },
													"info[8][policyno]": {required: true },
													"info[9][policyno]": {required: true },
													"info[10][policyno]": {required: true },
														"info[11][policyno]": {required: true },
													"info[12][policyno]": {required: true },
													"info[13][policyno]": {required: true },
													"info[14][policyno]": {required: true },
													"info[15][policyno]": {required: true },
													"info[16][policyno]": {required: true },
													"info[17][policyno]": {required: true },
													"info[18][policyno]": {required: true },
													"info[19][policyno]": {required: true },
													"info[20][policyno]": {required: true },
														"info[21][policyno]": {required: true },
													"info[22][policyno]": {required: true },
													"info[23][policyno]": {required: true },
													"info[24][policyno]": {required: true },
														"info[25][policyno]": {required: true },
													
											
												},
										messages: {
													
													"info[1][bankname]": {required: "Please enter Institution Name"},
													"info[2][bankname]": {required: "Please enter Institution Name"},
													"info[3][bankname]": {required: "Please enter Institution Name"},
													"info[4][bankname]": {required: "Please enter Institution Name"},
													
													"info[5][bankname]": {required: "Please enter Institution Name"},
													"info[6][bankname]": {required: "Please enter Institution Name"},
													"info[7][bankname]": {required: "Please enter Institution Name"},
													"info[8][bankname]": {required: "Please enter Institution Name"},
													"info[9][bankname]": {required: "Please enter Institution Name"},
													"info[10][bankname]": {required: "Please enter Institution Name"},
														"info[11][bankname]": {required: "Please enter Institution Name"},
													"info[12][bankname]": {required: "Please enter Institution Name"},
													"info[13][bankname]": {required: "Please enter Institution Name"},
													"info[14][bankname]": {required: "Please enter Institution Name"},
													"info[15][bankname]": {required: "Please enter Institution Name"},
													"info[16][bankname]": {required: "Please enter Institution Name"},
													"info[17][bankname]": {required: "Please enter Institution Name"},
													"info[18][bankname]": {required: "Please enter Institution Name"},
													"info[19][bankname]": {required: "Please enter Institution Name"},
													"info[20][bankname]": {required: "Please enter Institution Name"},
													"info[21][bankname]": {required: "Please enter Institution Name"},
													"info[22][bankname]": {required: "Please enter Institution Name"},
													"info[23][bankname]": {required: "Please enter Institution Name"},
													"info[24][bankname]": {required: "Please enter Institution Name"},
													"info[25][bankname]": {required: "Please enter Institution Name"},
													
													"info[1][country]": {required: "Please enter Country"},
													"info[2][country]": {required: "Please enter Country"},
													"info[3][country]": {required: "Please enter Country"},
													"info[4][country]": {required: "Please enter Country"},
													"info[5][country]": {required: "Please enter Country"},
													"info[6][country]": {required: "Please enter Country"},
													"info[7][country]": {required: "Please enter Country"},
													"info[8][country]": {required: "Please enter Country"},
													"info[9][country]": {required: "Please enter country"},
													"info[10][country]": {required: "Please enter Country"},
														"info[11][country]": {required: "Please enter Country"},
													"info[12][country]": {required: "Please enter Country"},
													"info[13][country]": {required: "Please enter Country"},
													"info[14][country]": {required: "Please enter Country"},
													"info[15][country]": {required: "Please enter Country"},
													"info[16][country]": {required: "Please enter Country"},
													"info[17][country]": {required: "Please enter Country"},
													"info[18][country]": {required: "Please enter Country"},
													"info[19][country]": {required: "Please enter Country"},
													"info[20][country]": {required: "Please enter Country"},
													"info[21][country]": {required: "Please enter Country"},
													"info[22][country]": {required: "Please enter Country"},
													"info[23][country]": {required: "Please enter Country"},
													"info[24][country]": {required: "Please enter Country"},
													"info[25][country]": {required: "Please enter Country"},
													
												    "info[1][policyno]": {required: "Please enter Policy Number"},
													"info[2][policyno]": {required: "Please enter Policy Number"},
													"info[3][policyno]": {required: "Please enter Policy Number"},
													"info[4][policyno]": {required: "Please enter Policy Number"},
													"info[5][policyno]": {required: "Please enter Policy Number"},
													"info[6][policyno]": {required: "Please enter Policy Number"},
													"info[7][policyno]": {required: "Please enter Policy Number"},
													"info[8][policyno]": {required: "Please enter Policy Number"},
													"info[9][policyno]": {required: "Please enter Policy Number"},
													"info[10][policyno]": {required: "Please enter Policy Number"},
													"info[11][policyno]": {required: "Please enter Policy Number"},
													"info[12][policyno]": {required: "Please enter Policy Number"},
													"info[13][policyno]": {required: "Please enter Policy Number"},
													"info[14][policyno]": {required: "Please enter Policy Number"},
													"info[15][policyno]": {required: "Please enter Policy Number"},
													"info[16][policyno]": {required: "Please enter Policy Number"},
													"info[17][policyno]": {required: "Please enter Policy Number"},
													"info[18][policyno]": {required: "Please enter Policy Number"},
													"info[19][policyno]": {required: "Please enter Policy Number"},
													"info[20][policyno]": {required: "Please enter Policy Number"},
													"info[21][policyno]": {required: "Please enter Policy Number"},
													"info[22][policyno]": {required: "Please enter Policy Number"},
													"info[23][policyno]": {required: "Please enter Policy Number"},
													"info[24][policyno]": {required: "Please enter Policy Number"},
													"info[25][policyno]": {required: "Please enter Policy Number"},
												
												  }			
									});	
									
							$("#fixdepositfrm").validate(
									{	
										rules:	{
													"info[1][bankname]": {required: true},
													"info[2][bankname]": {required: true},
													"info[3][bankname]": {required: true},
													"info[4][bankname]": {required: true},
													"info[5][bankname]": {required: true},
													"info[6][bankname]": {required: true},
													"info[7][bankname]": {required: true},
													"info[8][bankname]": {required: true},
													"info[9][bankname]": {required: true},
													"info[10][bankname]": {required: true},
													 "info[11][bankname]": {required: true},
													"info[12][bankname]": {required: true},
													"info[13][bankname]": {required: true},
													"info[14][bankname]": {required: true},
													"info[15][bankname]": {required: true},
													"info[16][bankname]": {required: true},
													"info[17][bankname]": {required: true},
													"info[18][bankname]": {required: true},
													"info[19][bankname]": {required: true},
													"info[20][bankname]": {required: true},
													"info[21][bankname]": {required: true},
													"info[22][bankname]": {required: true},
													"info[23][bankname]": {required: true},
													"info[24][bankname]": {required: true},
													"info[25][bankname]": {required: true},
													
													
													"info[1][branchname]": {required: true},
													"info[2][branchname]": {required: true},
													"info[3][branchname]": {required: true},
													"info[4][branchname]": {required: true},
													"info[5][branchname]": {required: true},
													"info[6][branchname]": {required: true},
													"info[7][branchname]": {required: true},
													"info[8][branchname]": {required: true},
													"info[9][branchname]": {required: true},
													"info[10][branchname]": {required: true},
														"info[11][branchname]": {required: true},
													"info[12][branchname]": {required: true},
													"info[13][branchname]": {required: true},
													"info[14][branchname]": {required: true},
													"info[15][branchname]": {required: true},
													"info[16][branchname]": {required: true},
													"info[17][branchname]": {required: true},
													"info[18][branchname]": {required: true},
													"info[19][branchname]": {required: true},
													"info[20][branchname]": {required: true},
													"info[21][branchname]": {required: true},
													"info[22][branchname]": {required: true},
													"info[23][branchname]": {required: true},
													"info[24][branchname]": {required: true},
													"info[25][branchname]": {required: true},
													
													
													"info[1][account]": {required: true },
													"info[2][account]": {required: true },
													"info[3][account]": {required: true },
													"info[4][account]": {required: true },
													"info[5][account]": {required: true },
													"info[6][account]": {required: true },
													"info[7][account]": {required: true },
													"info[8][account]": {required: true },
													"info[9][account]": {required: true },
													"info[10][account]": {required: true },
													"info[11][account]": {required: true },
													"info[12][account]": {required: true },
													"info[13][account]": {required: true },
													"info[14][account]": {required: true },
													"info[15][account]": {required: true },
													"info[16][account]": {required: true },
													"info[17][account]": {required: true },
													"info[18][account]": {required: true },
													"info[19][account]": {required: true },
													"info[20][account]": {required: true },
													"info[21][account]": {required: true },
													"info[22][account]": {required: true },
													"info[23][account]": {required: true },
													"info[24][account]": {required: true },
													"info[25][account]": {required: true },
													
											
												},
										messages: {
													
													"info[1][bankname]": {required: "Please enter Institution Name"},
													"info[2][bankname]": {required: "Please enter Institution Name"},
													"info[3][bankname]": {required: "Please enter Institution Name"},
													"info[4][bankname]": {required: "Please enter Institution Name"},
													
													"info[5][bankname]": {required: "Please enter Institution Name"},
													"info[6][bankname]": {required: "Please enter Institution Name"},
													"info[7][bankname]": {required: "Please enter Institution Name"},
													"info[8][bankname]": {required: "Please enter Institution Name"},
													"info[9][bankname]": {required: "Please enter Institution Name"},
													"info[10][bankname]": {required: "Please enter Institution Name"},
														"info[11][bankname]": {required: "Please enter Institution Name"},
													"info[12][bankname]": {required: "Please enter Institution Name"},
													"info[13][bankname]": {required: "Please enter Institution Name"},
													"info[14][bankname]": {required: "Please enter Institution Name"},
													"info[15][bankname]": {required: "Please enter Institution Name"},
													"info[16][bankname]": {required: "Please enter Institution Name"},
													"info[17][bankname]": {required: "Please enter Institution Name"},
													"info[18][bankname]": {required: "Please enter Institution Name"},
													"info[19][bankname]": {required: "Please enter Institution Name"},
													"info[20][bankname]": {required: "Please enter Institution Name"},
													"info[21][bankname]": {required: "Please enter Institution Name"},
													"info[22][bankname]": {required: "Please enter Institution Name"},
													"info[23][bankname]": {required: "Please enter Institution Name"},
													"info[24][bankname]": {required: "Please enter Institution Name"},
													"info[25][bankname]": {required: "Please enter Institution Name"},
													
													
													"info[1][branchname]": {required: "Please enter Branch Name"},
													"info[2][branchname]": {required: "Please enter Branch Name"},
													"info[3][branchname]": {required: "Please enter Branch Name"},
													"info[4][branchname]": {required: "Please enter Branch Name"},
													"info[5][branchname]": {required: "Please enter Branch Name"},
													"info[6][branchname]": {required: "Please enter Branch Name"},
													"info[7][branchname]": {required: "Please enter Branch Name"},
													"info[8][branchname]": {required: "Please enter Branch Name"},
													"info[9][branchname]": {required: "Please enter Branch Name"},
													"info[10][branchname]": {required: "Please enter Branch Name"},
													"info[11][branchname]": {required: "Please enter Branch Name"},
													"info[12][branchname]": {required: "Please enter Branch Name"},
													"info[13][branchname]": {required: "Please enter Branch Name"},
													"info[14][branchname]": {required: "Please enter Branch Name"},
													"info[15][branchname]": {required: "Please enter Branch Name"},
													"info[16][branchname]": {required: "Please enter Branch Name"},
													"info[17][branchname]": {required: "Please enter Branch Name"},
													"info[18][branchname]": {required: "Please enter Branch Name"},
													"info[20][branchname]": {required: "Please enter Branch Name"},
													"info[21][branchname]": {required: "Please enter Branch Name"},
													"info[22][branchname]": {required: "Please enter Branch Name"},
													"info[23][branchname]": {required: "Please enter Branch Name"},
													"info[24][branchname]": {required: "Please enter Branch Name"},
													"info[25][branchname]": {required: "Please enter Branch Name"},
													
												    "info[1][account]": {required: "Please enter Account Number"},
													"info[2][account]": {required: "Please enter Account Number"},
													"info[3][account]": {required: "Please enter Account Number"},
													"info[4][account]": {required: "Please enter Account Number"},
													"info[5][account]": {required: "Please enter Account Number"},
													"info[6][account]": {required: "Please enter Account Number"},
													"info[7][account]": {required: "Please enter Account Number"},
													"info[8][account]": {required: "Please enter Account Number"},
													"info[9][account]": {required: "Please enter Account Number"},
													"info[10][account]": {required: "Please enter Account Number"},
													"info[11][account]": {required: "Please enter Account Number"},
													"info[12][account]": {required: "Please enter Account Number"},
													"info[13][account]": {required: "Please enter Account Number"},
													"info[14][account]": {required: "Please enter Account Number"},
													"info[15][account]": {required: "Please enter Account Number"},
													"info[16][account]": {required: "Please enter Account Number"},
													"info[17][account]": {required: "Please enter Account Number"},
													"info[18][account]": {required: "Please enter Account Number"},
													"info[19][account]": {required: "Please enter Account Number"},
													"info[20][account]": {required: "Please enter Account Number"},
													"info[21][account]": {required: "Please enter Account Number"},
													"info[22][account]": {required: "Please enter Account Number"},
													"info[23][account]": {required: "Please enter Account Number"},
													"info[24][account]": {required: "Please enter Account Number"},
													"info[25][account]": {required: "Please enter Account Number"},
												
												  }			
									});
										
						$("#tradingfrm").validate(
									{	
										rules:	{
													"info[1][bankname]": {required: true},
													"info[2][bankname]": {required: true},
													"info[3][bankname]": {required: true},
													"info[4][bankname]": {required: true},
													"info[5][bankname]": {required: true},
													"info[6][bankname]": {required: true},
													"info[7][bankname]": {required: true},
													"info[8][bankname]": {required: true},
													"info[9][bankname]": {required: true},
													"info[10][bankname]": {required: true},
													  "info[11][bankname]": {required: true},
													"info[12][bankname]": {required: true},
													"info[13][bankname]": {required: true},
													"info[14][bankname]": {required: true},
													"info[15][bankname]": {required: true},
													"info[16][bankname]": {required: true},
													"info[17][bankname]": {required: true},
													"info[18][bankname]": {required: true},
													"info[19][bankname]": {required: true},
													"info[20][bankname]": {required: true},
													"info[21][bankname]": {required: true},
													"info[22][bankname]": {required: true},
													"info[23][bankname]": {required: true},
													"info[24][bankname]": {required: true},
													"info[25][bankname]": {required: true},
													
													"info[1][branchname]": {required: true},
													"info[2][branchname]": {required: true},
													"info[3][branchname]": {required: true},
													"info[4][branchname]": {required: true},
													"info[5][branchname]": {required: true},
													"info[6][branchname]": {required: true},
													"info[7][branchname]": {required: true},
													"info[8][branchname]": {required: true},
													"info[9][branchname]": {required: true},
													"info[10][branchname]": {required: true},
															"info[11][branchname]": {required: true},
													"info[12][branchname]": {required: true},
													"info[13][branchname]": {required: true},
													"info[14][branchname]": {required: true},
													"info[15][branchname]": {required: true},
													"info[16][branchname]": {required: true},
													"info[17][branchname]": {required: true},
													"info[18][branchname]": {required: true},
													"info[19][branchname]": {required: true},
													"info[20][branchname]": {required: true},
													"info[21][branchname]": {required: true},
													"info[22][branchname]": {required: true},
													"info[23][branchname]": {required: true},
													"info[24][branchname]": {required: true},
													"info[25][branchname]": {required: true},
													
													"info[1][account]": {required: true },
													"info[2][account]": {required: true },
													"info[3][account]": {required: true },
													"info[4][account]": {required: true },
													"info[5][account]": {required: true },
													"info[6][account]": {required: true },
													"info[7][account]": {required: true },
													"info[8][account]": {required: true },
													"info[9][account]": {required: true },
													"info[10][account]": {required: true },
														"info[11][account]": {required: true },
													"info[12][account]": {required: true },
													"info[13][account]": {required: true },
													"info[14][account]": {required: true },
													"info[15][account]": {required: true },
													"info[16][account]": {required: true },
													"info[17][account]": {required: true },
													"info[18][account]": {required: true },
													"info[19][account]": {required: true },
													"info[20][account]": {required: true },
													"info[21][account]": {required: true },
													"info[22][account]": {required: true },
													"info[23][account]": {required: true },
													"info[24][account]": {required: true },
													"info[25][account]": {required: true },
													
											
												},
										messages: {
													
													"info[1][bankname]": {required: "Please enter Institution Name"},
													"info[2][bankname]": {required: "Please enter Institution Name"},
													"info[3][bankname]": {required: "Please enter Institution Name"},
													"info[4][bankname]": {required: "Please enter Institution Name"},
													
													"info[5][bankname]": {required: "Please enter Institution Name"},
													"info[6][bankname]": {required: "Please enter Institution Name"},
													"info[7][bankname]": {required: "Please enter Institution Name"},
													"info[8][bankname]": {required: "Please enter Institution Name"},
													"info[9][bankname]": {required: "Please enter Institution Name"},
													"info[10][bankname]": {required: "Please enter Institution Name"},
														"info[11][bankname]": {required: "Please enter Institution Name"},
													"info[12][bankname]": {required: "Please enter Institution Name"},
													"info[13][bankname]": {required: "Please enter Institution Name"},
													"info[14][bankname]": {required: "Please enter Institution Name"},
													"info[15][bankname]": {required: "Please enter Institution Name"},
													"info[16][bankname]": {required: "Please enter Institution Name"},
													"info[17][bankname]": {required: "Please enter Institution Name"},
													"info[18][bankname]": {required: "Please enter Institution Name"},
													"info[19][bankname]": {required: "Please enter Institution Name"},
													"info[20][bankname]": {required: "Please enter Institution Name"},
													"info[21][bankname]": {required: "Please enter Institution Name"},
													"info[22][bankname]": {required: "Please enter Institution Name"},
													"info[23][bankname]": {required: "Please enter Institution Name"},
													"info[24][bankname]": {required: "Please enter Institution Name"},
													"info[25][bankname]": {required: "Please enter Institution Name"},
													
													
													"info[1][branchname]": {required: "Please enter Branch Name"},
													"info[2][branchname]": {required: "Please enter Branch Name"},
													"info[3][branchname]": {required: "Please enter Branch Name"},
													"info[4][branchname]": {required: "Please enter Branch Name"},
													"info[5][branchname]": {required: "Please enter Branch Name"},
													"info[6][branchname]": {required: "Please enter Branch Name"},
													"info[7][branchname]": {required: "Please enter Branch Name"},
													"info[8][branchname]": {required: "Please enter Branch Name"},
													"info[9][branchname]": {required: "Please enter Branch Name"},
													"info[10][branchname]": {required: "Please enter Branch Name"},
														"info[11][branchname]": {required: "Please enter Branch Name"},
													"info[12][branchname]": {required: "Please enter Branch Name"},
													"info[13][branchname]": {required: "Please enter Branch Name"},
													"info[14][branchname]": {required: "Please enter Branch Name"},
													"info[15][branchname]": {required: "Please enter Branch Name"},
													"info[16][branchname]": {required: "Please enter Branch Name"},
													"info[17][branchname]": {required: "Please enter Branch Name"},
													"info[18][branchname]": {required: "Please enter Branch Name"},
													"info[19][branchname]": {required: "Please enter Branch Name"},
													"info[20][branchname]": {required: "Please enter Branch Name"},
													"info[21][branchname]": {required: "Please enter Branch Name"},
													"info[22][branchname]": {required: "Please enter Branch Name"},
													"info[23][branchname]": {required: "Please enter Branch Name"},
													"info[24][branchname]": {required: "Please enter Branch Name"},
													"info[25][branchname]": {required: "Please enter Branch Name"},
													
												    "info[1][account]": {required: "Please enter Account Number"},
													"info[2][account]": {required: "Please enter Account Number"},
													"info[3][account]": {required: "Please enter Account Number"},
													"info[4][account]": {required: "Please enter Account Number"},
													"info[5][account]": {required: "Please enter Account Number"},
													"info[6][account]": {required: "Please enter Account Number"},
													"info[7][account]": {required: "Please enter Account Number"},
													"info[8][account]": {required: "Please enter Account Number"},
													"info[9][account]": {required: "Please enter Account Number"},
													"info[10][account]": {required: "Please enter Account Number"},
															  "info[11][account]": {required: "Please enter Account Number"},
													"info[12][account]": {required: "Please enter Account Number"},
													"info[13][account]": {required: "Please enter Account Number"},
													"info[14][account]": {required: "Please enter Account Number"},
													"info[15][account]": {required: "Please enter Account Number"},
													"info[16][account]": {required: "Please enter Account Number"},
													"info[17][account]": {required: "Please enter Account Number"},
													"info[18][account]": {required: "Please enter Account Number"},
													"info[19][account]": {required: "Please enter Account Number"},
													"info[20][account]": {required: "Please enter Account Number"},
													"info[21][account]": {required: "Please enter Account Number"},
													"info[22][account]": {required: "Please enter Account Number"},
													"info[23][account]": {required: "Please enter Account Number"},
													"info[24][account]": {required: "Please enter Account Number"},
													"info[25][account]": {required: "Please enter Account Number"},
												
												  }			
									});
									
									
				$("#othersfrm").validate(
									{	
										rules:	{
													"info[1][bankname]": {required: true},
													"info[2][bankname]": {required: true},
													"info[3][bankname]": {required: true},
													"info[4][bankname]": {required: true},
													"info[5][bankname]": {required: true},
													"info[6][bankname]": {required: true},
													"info[7][bankname]": {required: true},
													"info[8][bankname]": {required: true},
													"info[9][bankname]": {required: true},
													"info[10][bankname]": {required: true},
															"info[11][bankname]": {required: true},
													"info[12][bankname]": {required: true},
													"info[13][bankname]": {required: true},
													"info[14][bankname]": {required: true},
													"info[15][bankname]": {required: true},
													"info[16][bankname]": {required: true},
													"info[17][bankname]": {required: true},
													"info[18][bankname]": {required: true},
													"info[19][bankname]": {required: true},
													"info[20][bankname]": {required: true},
													"info[21][bankname]": {required: true},
													"info[22][bankname]": {required: true},
													"info[23][bankname]": {required: true},
													"info[24][bankname]": {required: true},
													"info[25][bankname]": {required: true},
													
													
													"info[1][branchname]": {required: true},
													"info[2][branchname]": {required: true},
													"info[3][branchname]": {required: true},
													"info[4][branchname]": {required: true},
													"info[5][branchname]": {required: true},
													"info[6][branchname]": {required: true},
													"info[7][branchname]": {required: true},
													"info[8][branchname]": {required: true},
													"info[9][branchname]": {required: true},
													"info[10][branchname]": {required: true},
													"info[1][account]": {required: true },
													"info[2][account]": {required: true },
													"info[3][account]": {required: true },
													"info[4][account]": {required: true },
													"info[5][account]": {required: true },
													"info[6][account]": {required: true },
													"info[7][account]": {required: true },
													"info[8][account]": {required: true },
													"info[9][account]": {required: true },
													"info[10][account]": {required: true },
													
											
												},
										messages: {
													
													"info[1][bankname]": {required: "Please enter Institution Name"},
													"info[2][bankname]": {required: "Please enter Institution Name"},
													"info[3][bankname]": {required: "Please enter Institution Name"},
													"info[4][bankname]": {required: "Please enter Institution Name"},
													
													"info[5][bankname]": {required: "Please enter Institution Name"},
													"info[6][bankname]": {required: "Please enter Institution Name"},
													"info[7][bankname]": {required: "Please enter Institution Name"},
													"info[8][bankname]": {required: "Please enter Institution Name"},
													"info[9][bankname]": {required: "Please enter Institution Name"},
													"info[10][bankname]": {required: "Please enter Institution Name"},
														"info[11][bankname]": {required: "Please enter Institution Name"},
													"info[12][bankname]": {required: "Please enter Institution Name"},
													"info[13][bankname]": {required: "Please enter Institution Name"},
													"info[14][bankname]": {required: "Please enter Institution Name"},
													"info[15][bankname]": {required: "Please enter Institution Name"},
													"info[16][bankname]": {required: "Please enter Institution Name"},
													"info[17][bankname]": {required: "Please enter Institution Name"},
													"info[18][bankname]": {required: "Please enter Institution Name"},
													"info[19][bankname]": {required: "Please enter Institution Name"},
													"info[20][bankname]": {required: "Please enter Institution Name"},
													"info[21][bankname]": {required: "Please enter Institution Name"},
													"info[22][bankname]": {required: "Please enter Institution Name"},
													"info[23][bankname]": {required: "Please enter Institution Name"},
													"info[24][bankname]": {required: "Please enter Institution Name"},
													"info[25][bankname]": {required: "Please enter Institution Name"},
													
													
													"info[1][branchname]": {required: "Please enter Branch Name"},
													"info[2][branchname]": {required: "Please enter Branch Name"},
													"info[3][branchname]": {required: "Please enter Branch Name"},
													"info[4][branchname]": {required: "Please enter Branch Name"},
													"info[5][branchname]": {required: "Please enter Branch Name"},
													"info[6][branchname]": {required: "Please enter Branch Name"},
													"info[7][branchname]": {required: "Please enter Branch Name"},
													"info[8][branchname]": {required: "Please enter Branch Name"},
													"info[9][branchname]": {required: "Please enter Branch Name"},
													"info[10][branchname]": {required: "Please enter Branch Name"},
														"info[11][branchname]": {required: "Please enter Branch Name"},
													"info[12][branchname]": {required: "Please enter Branch Name"},
													"info[13][branchname]": {required: "Please enter Branch Name"},
													"info[14][branchname]": {required: "Please enter Branch Name"},
													"info[15][branchname]": {required: "Please enter Branch Name"},
													"info[16][branchname]": {required: "Please enter Branch Name"},
													"info[17][branchname]": {required: "Please enter Branch Name"},
													"info[18][branchname]": {required: "Please enter Branch Name"},
													"info[19][branchname]": {required: "Please enter Branch Name"},
													"info[20][branchname]": {required: "Please enter Branch Name"},
													"info[21][branchname]": {required: "Please enter Branch Name"},
													"info[22][branchname]": {required: "Please enter Branch Name"},
													"info[23][branchname]": {required: "Please enter Branch Name"},
													"info[24][branchname]": {required: "Please enter Branch Name"},
													"info[25][branchname]": {required: "Please enter Branch Name"},
													
												    "info[1][account]": {required: "Please enter Account Number"},
													"info[2][account]": {required: "Please enter Account Number"},
													"info[3][account]": {required: "Please enter Account Number"},
													"info[4][account]": {required: "Please enter Account Number"},
													"info[5][account]": {required: "Please enter Account Number"},
													"info[6][account]": {required: "Please enter Account Number"},
													"info[7][account]": {required: "Please enter Account Number"},
													"info[8][account]": {required: "Please enter Account Number"},
													"info[9][account]": {required: "Please enter Account Number"},
													"info[10][account]": {required: "Please enter Account Number"},
													  "info[11][account]": {required: "Please enter Account Number"},
													"info[12][account]": {required: "Please enter Account Number"},
													"info[13][account]": {required: "Please enter Account Number"},
													"info[14][account]": {required: "Please enter Account Number"},
													"info[15][account]": {required: "Please enter Account Number"},
													"info[16][account]": {required: "Please enter Account Number"},
													"info[17][account]": {required: "Please enter Account Number"},
													"info[18][account]": {required: "Please enter Account Number"},
													"info[19][account]": {required: "Please enter Account Number"},
													"info[20][account]": {required: "Please enter Account Number"},
													"info[21][account]": {required: "Please enter Account Number"},
													"info[22][account]": {required: "Please enter Account Number"},
													"info[23][account]": {required: "Please enter Account Number"},
													"info[24][account]": {required: "Please enter Account Number"},
													"info[25][account]": {required: "Please enter Account Number"},
												
												  }			
									});
									
				$("#creditfrm").validate(
									{	
										rules:	{
													"info[1][bankname]": {required: true},
													"info[2][bankname]": {required: true},
													"info[3][bankname]": {required: true},
													"info[4][bankname]": {required: true},
													"info[5][bankname]": {required: true},
													"info[6][bankname]": {required: true},
													"info[7][bankname]": {required: true},
													"info[8][bankname]": {required: true},
													"info[9][bankname]": {required: true},
													"info[10][bankname]": {required: true},
													"info[11][bankname]": {required: true},
													"info[12][bankname]": {required: true},
													"info[13][bankname]": {required: true},
													"info[14][bankname]": {required: true},
													"info[15][bankname]": {required: true},
													"info[16][bankname]": {required: true},
													"info[17][bankname]": {required: true},
													"info[18][bankname]": {required: true},
													"info[19][bankname]": {required: true},
													"info[20][bankname]": {required: true},
													"info[21][bankname]": {required: true},
													"info[22][bankname]": {required: true},
													"info[23][bankname]": {required: true},
													"info[24][bankname]": {required: true},
													"info[25][bankname]": {required: true},
													
													
													"info[1][account]": {required: true },
													"info[2][account]": {required: true },
													"info[3][account]": {required: true },
													"info[4][account]": {required: true },
													"info[5][account]": {required: true },
													"info[6][account]": {required: true },
													"info[7][account]": {required: true },
													"info[8][account]": {required: true },
													"info[9][account]": {required: true },
													"info[10][account]": {required: true },
													"info[11][account]": {required: true },
													"info[12][account]": {required: true },
													"info[13][account]": {required: true },
													"info[14][account]": {required: true },
													"info[15][account]": {required: true },
													"info[16][account]": {required: true },
													"info[17][account]": {required: true },
													"info[18][account]": {required: true },
													"info[19][account]": {required: true },
													"info[20][account]": {required: true },
													"info[21][account]": {required: true },
													"info[22][account]": {required: true },
													"info[23][account]": {required: true },
													"info[24][account]": {required: true },
													"info[25][account]": {required: true },
													
											
												},
										messages: {
													
													"info[1][bankname]": {required: "Please enter Institution Name"},
													"info[2][bankname]": {required: "Please enter Institution Name"},
													"info[3][bankname]": {required: "Please enter Institution Name"},
													"info[4][bankname]": {required: "Please enter Institution Name"},
													
													"info[5][bankname]": {required: "Please enter Institution Name"},
													"info[6][bankname]": {required: "Please enter Institution Name"},
													"info[7][bankname]": {required: "Please enter Institution Name"},
													"info[8][bankname]": {required: "Please enter Institution Name"},
													"info[9][bankname]": {required: "Please enter Institution Name"},
													"info[10][bankname]": {required: "Please enter Institution Name"},
													"info[11][bankname]": {required: "Please enter Institution Name"},
													"info[12][bankname]": {required: "Please enter Institution Name"},
													"info[13][bankname]": {required: "Please enter Institution Name"},
													"info[14][bankname]": {required: "Please enter Institution Name"},
													
													"info[15][bankname]": {required: "Please enter Institution Name"},
													"info[16][bankname]": {required: "Please enter Institution Name"},
													"info[17][bankname]": {required: "Please enter Institution Name"},
													"info[18][bankname]": {required: "Please enter Institution Name"},
													"info[19][bankname]": {required: "Please enter Institution Name"},
													"info[20][bankname]": {required: "Please enter Institution Name"},
														"info[21][bankname]": {required: "Please enter Institution Name"},
													"info[22][bankname]": {required: "Please enter Institution Name"},
													"info[23][bankname]": {required: "Please enter Institution Name"},
													"info[24][bankname]": {required: "Please enter Institution Name"},
													"info[25][bankname]": {required: "Please enter Institution Name"},
													
													
												    "info[1][account]": {required: "Please enter Account Number"},
													"info[2][account]": {required: "Please enter Account Number"},
													"info[3][account]": {required: "Please enter Account Number"},
													"info[4][account]": {required: "Please enter Account Number"},
													"info[5][account]": {required: "Please enter Account Number"},
													"info[6][account]": {required: "Please enter Account Number"},
													"info[7][account]": {required: "Please enter Account Number"},
													"info[8][account]": {required: "Please enter Account Number"},
													"info[9][account]": {required: "Please enter Account Number"},
													"info[10][account]": {required: "Please enter Account Number"},
													 "info[11][account]": {required: "Please enter Account Number"},
													"info[12][account]": {required: "Please enter Account Number"},
													"info[13][account]": {required: "Please enter Account Number"},
													"info[14][account]": {required: "Please enter Account Number"},
													"info[15][account]": {required: "Please enter Account Number"},
													"info[16][account]": {required: "Please enter Account Number"},
													"info[17][account]": {required: "Please enter Account Number"},
													"info[18][account]": {required: "Please enter Account Number"},
													"info[19][account]": {required: "Please enter Account Number"},
													"info[20][account]": {required: "Please enter Account Number"},
														"info[21][account]": {required: "Please enter Account Number"},
													"info[22][account]": {required: "Please enter Account Number"},
													"info[23][account]": {required: "Please enter Account Number"},
													"info[24][account]": {required: "Please enter Account Number"},
													"info[25][account]": {required: "Please enter Account Number"},
												
												  }			
									});
											
						$("#debitfrm").validate(
									{	
										rules:	{
													"info[1][bankname]": {required: true},
													"info[2][bankname]": {required: true},
													"info[3][bankname]": {required: true},
													"info[4][bankname]": {required: true},
													"info[5][bankname]": {required: true},
													"info[6][bankname]": {required: true},
													"info[7][bankname]": {required: true},
													"info[8][bankname]": {required: true},
													"info[9][bankname]": {required: true},
													"info[10][bankname]": {required: true},
													"info[11][bankname]": {required: true},
													"info[12][bankname]": {required: true},
													"info[13][bankname]": {required: true},
													"info[14][bankname]": {required: true},
													"info[15][bankname]": {required: true},
													"info[16][bankname]": {required: true},
													"info[17][bankname]": {required: true},
													"info[18][bankname]": {required: true},
													"info[19][bankname]": {required: true},
													"info[20][bankname]": {required: true},
													"info[21][bankname]": {required: true},
													"info[22][bankname]": {required: true},
													"info[23][bankname]": {required: true},
													"info[24][bankname]": {required: true},
													"info[25][bankname]": {required: true},
													
													"info[1][payeeaccountno]": {required: true },
													"info[2][payeeaccountno]": {required: true },
													"info[3][payeeaccountno]": {required: true },
													"info[4][payeeaccountno]": {required: true },
													"info[5][payeeaccountno]": {required: true },
													"info[6][payeeaccountno]": {required: true },
													"info[7][payeeaccountno]": {required: true },
													"info[8][payeeaccountno]": {required: true },
													"info[9][payeeaccountno]": {required: true },
													"info[10][payeeaccountno]": {required: true },
													"info[11][payeeaccountno]": {required: true },
													"info[12][payeeaccountno]": {required: true },
													"info[13][payeeaccountno]": {required: true },
													"info[14][payeeaccountno]": {required: true },
													"info[15][payeeaccountno]": {required: true },
													"info[16][payeeaccountno]": {required: true },
													"info[17][payeeaccountno]": {required: true },
													"info[18][payeeaccountno]": {required: true },
													"info[19][payeeaccountno]": {required: true },
													"info[20][payeeaccountno]": {required: true },
														"info[21][payeeaccountno]": {required: true },
													"info[22][payeeaccountno]": {required: true },
													"info[23][payeeaccountno]": {required: true },
													"info[24][payeeaccountno]": {required: true },
													"info[25][payeeaccountno]": {required: true },
													
													"info[1][category]": {required: true},
													"info[2][category]": {required: true},
													"info[3][category]": {required: true},
													"info[4][category]": {required: true},
													"info[5][category]": {required: true},
													"info[6][category]": {required: true},
													"info[7][category]": {required: true},
													"info[8][category]": {required: true},
													"info[9][category]": {required: true},
													"info[10][category]": {required: true},
													"info[11][category]": {required: true},
													"info[12][category]": {required: true},
													"info[13][category]": {required: true},
													"info[14][category]": {required: true},
													"info[15][category]": {required: true},
													"info[16][category]": {required: true},
													"info[17][category]": {required: true},
													"info[18][category]": {required: true},
													"info[19][category]": {required: true},
													"info[20][category]": {required: true},
													"info[21][category]": {required: true},
													"info[22][category]": {required: true},
													"info[23][category]": {required: true},
													"info[24][category]": {required: true},
													"info[25][category]": {required: true},
													
											
												},
										messages: {
													
													"info[1][bankname]": {required: "Please enter Institution Name"},
													"info[2][bankname]": {required: "Please enter Institution Name"},
													"info[3][bankname]": {required: "Please enter Institution Name"},
													"info[4][bankname]": {required: "Please enter Institution Name"},
													
													"info[5][bankname]": {required: "Please enter Institution Name"},
													"info[6][bankname]": {required: "Please enter Institution Name"},
													"info[7][bankname]": {required: "Please enter Institution Name"},
													"info[8][bankname]": {required: "Please enter Institution Name"},
													"info[9][bankname]": {required: "Please enter Institution Name"},
													"info[10][bankname]": {required: "Please enter Institution Name"},
													"info[11][bankname]": {required: "Please enter Institution Name"},
													"info[12][bankname]": {required: "Please enter Institution Name"},
													"info[13][bankname]": {required: "Please enter Institution Name"},
													"info[14][bankname]": {required: "Please enter Institution Name"},
													
													"info[15][bankname]": {required: "Please enter Institution Name"},
													"info[16][bankname]": {required: "Please enter Institution Name"},
													"info[17][bankname]": {required: "Please enter Institution Name"},
													"info[18][bankname]": {required: "Please enter Institution Name"},
													"info[19][bankname]": {required: "Please enter Institution Name"},
													"info[20][bankname]": {required: "Please enter Institution Name"},
														"info[21][bankname]": {required: "Please enter Institution Name"},
													"info[22][bankname]": {required: "Please enter Institution Name"},
													"info[23][bankname]": {required: "Please enter Institution Name"},
													"info[24][bankname]": {required: "Please enter Institution Name"},
													"info[25][bankname]": {required: "Please enter Institution Name"},
													
													
													
													
												    "info[1][payeeaccountno]": {required: "Please enter Payee Acc No"},
													"info[2][payeeaccountno]": {required: "Please enter Payee Acc No"},
													"info[3][payeeaccountno]": {required: "Please enter Payee Acc No"},
													"info[4][payeeaccountno]": {required: "Please enter Payee Acc No"},
													"info[5][payeeaccountno]": {required: "Please enter Payee Acc No"},
													"info[6][payeeaccountno]": {required: "Please enter Payee Acc No"},
													"info[7][payeeaccountno]": {required: "Please enter Payee Acc No"},
													"info[8][payeeaccountno]": {required: "Please enter Payee Acc No"},
													"info[9][payeeaccountno]": {required: "Please enter Payee Acc No"},
													"info[10][payeeaccountno]": {required: "Please enter Payee Acc No"},
													"info[11][payeeaccountno]": {required: "Please enter Payee Acc No"},
													"info[12][payeeaccountno]": {required: "Please enter Payee Acc No"},
													"info[13][payeeaccountno]": {required: "Please enter Payee Acc No"},
													"info[14][payeeaccountno]": {required: "Please enter Payee Acc No"},
													"info[15][payeeaccountno]": {required: "Please enter Payee Acc No"},
													"info[16][payeeaccountno]": {required: "Please enter Payee Acc No"},
													"info[17][payeeaccountno]": {required: "Please enter Payee Acc No"},
													"info[18][payeeaccountno]": {required: "Please enter Payee Acc No"},
													"info[19][payeeaccountno]": {required: "Please enter Payee Acc No"},
													"info[20][payeeaccountno]": {required: "Please enter Payee Acc No"},
													"info[21][payeeaccountno]": {required: "Please enter Payee Acc No"},
													"info[22][payeeaccountno]": {required: "Please enter Payee Acc No"},
													"info[23][payeeaccountno]": {required: "Please enter Payee Acc No"},
													"info[24][payeeaccountno]": {required: "Please enter Payee Acc No"},
													"info[25][payeeaccountno]": {required: "Please enter Payee Acc No"},
													
													   "info[1][category]": {required: "Please enter Category"},
													"info[2][category]": {required: "Please enter Category"},
													"info[3][category]": {required: "Please enter Category"},
													"info[4][category]": {required: "Please enter Category"},
													"info[5][category]": {required: "Please enter Category"},
													"info[6][category]": {required: "Please enter Category"},
													"info[7][category]": {required: "Please enter Category"},
													"info[8][category]": {required: "Please enter Category"},
													"info[9][category]": {required: "Please enter Category"},
													"info[10][category]": {required: "Please enter Category"},
													 "info[11][category]": {required: "Please enter Category"},
													"info[12][category]": {required: "Please enter Category"},
													"info[13][category]": {required: "Please enter Category"},
													"info[14][category]": {required: "Please enter Category"},
													"info[15][category]": {required: "Please enter Category"},
													"info[16][category]": {required: "Please enter Category"},
													"info[17][category]": {required: "Please enter Category"},
													"info[18][category]": {required: "Please enter Category"},
													"info[19][category]": {required: "Please enter Category"},
													"info[20][category]": {required: "Please enter Category"},
													"info[21][category]": {required: "Please enter Category"},
													"info[22][category]": {required: "Please enter Category"},
													"info[23][category]": {required: "Please enter Category"},
													"info[24][category]": {required: "Please enter Category"},
													"info[25][category]": {required: "Please enter Category"},
												
												
												  }			
									});
											
								$("#loanfrm").validate(
									{	
										rules:	{
													"info[1][bankname]": {required: true},
													"info[2][bankname]": {required: true},
													"info[3][bankname]": {required: true},
													"info[4][bankname]": {required: true},
													"info[5][bankname]": {required: true},
													"info[6][bankname]": {required: true},
													"info[7][bankname]": {required: true},
													"info[8][bankname]": {required: true},
													"info[9][bankname]": {required: true},
													"info[10][bankname]": {required: true},
													"info[11][bankname]": {required: true},
													"info[12][bankname]": {required: true},
													"info[13][bankname]": {required: true},
													"info[14][bankname]": {required: true},
													"info[15][bankname]": {required: true},
													"info[16][bankname]": {required: true},
													"info[17][bankname]": {required: true},
													"info[18][bankname]": {required: true},
													"info[19][bankname]": {required: true},
													"info[20][bankname]": {required: true},
													"info[16][bankname]": {required: true},
													"info[17][bankname]": {required: true},
													"info[18][bankname]": {required: true},
													"info[19][bankname]": {required: true},
													"info[20][bankname]": {required: true},
												    "info[21][bankname]": {required: true},
													"info[22][bankname]": {required: true},
													"info[23][bankname]": {required: true},
													"info[24][bankname]": {required: true},
													"info[25][bankname]": {required: true},
													
													
													"info[1][account]": {required: true },
													"info[2][account]": {required: true },
													"info[3][account]": {required: true },
													"info[4][account]": {required: true },
													"info[5][account]": {required: true },
													"info[6][account]": {required: true },
													"info[7][account]": {required: true },
													"info[8][account]": {required: true },
													"info[9][account]": {required: true },
													"info[10][account]": {required: true },
													"info[11][account]": {required: true },
													"info[12][account]": {required: true },
													"info[13][account]": {required: true },
													"info[14][account]": {required: true },
													"info[15][account]": {required: true },
													"info[16][account]": {required: true },
													"info[17][account]": {required: true },
													"info[18][account]": {required: true },
													"info[19][account]": {required: true },
													"info[20][account]": {required: true },
													"info[21][account]": {required: true },
													"info[22][account]": {required: true },
													"info[23][account]": {required: true },
													"info[24][account]": {required: true },
													"info[25][account]": {required: true },
													
													"info[1][loantype]": {required: true},
													"info[2][loantype]": {required: true},
													"info[3][loantype]": {required: true},
													"info[4][loantype]": {required: true},
													"info[5][loantype]": {required: true},
													"info[6][loantype]": {required: true},
													"info[7][loantype]": {required: true},
													"info[8][loantype]": {required: true},
													"info[9][loantype]": {required: true},
													"info[10][loantype]": {required: true},
													"info[11][loantype]": {required: true},
													"info[12][loantype]": {required: true},
													"info[13][loantype]": {required: true},
													"info[14][loantype]": {required: true},
													"info[15][loantype]": {required: true},
													"info[16][loantype]": {required: true},
													"info[17][loantype]": {required: true},
													"info[18][loantype]": {required: true},
													"info[19][loantype]": {required: true},
													"info[20][loantype]": {required: true},
													"info[21][loantype]": {required: true},
													"info[22][loantype]": {required: true},
													"info[23][loantype]": {required: true},
													"info[24][loantype]": {required: true},
													"info[25][loantype]": {required: true},
													
											
												},
										messages: {
													
														"info[1][bankname]": {required: "Please enter Institution Name"},
													"info[2][bankname]": {required: "Please enter Institution Name"},
													"info[3][bankname]": {required: "Please enter Institution Name"},
													"info[4][bankname]": {required: "Please enter Institution Name"},
													
													"info[5][bankname]": {required: "Please enter Institution Name"},
													"info[6][bankname]": {required: "Please enter Institution Name"},
													"info[7][bankname]": {required: "Please enter Institution Name"},
													"info[8][bankname]": {required: "Please enter Institution Name"},
													"info[9][bankname]": {required: "Please enter Institution Name"},
													"info[10][bankname]": {required: "Please enter Institution Name"},
													"info[11][bankname]": {required: "Please enter Institution Name"},
													"info[12][bankname]": {required: "Please enter Institution Name"},
													"info[13][bankname]": {required: "Please enter Institution Name"},
													"info[14][bankname]": {required: "Please enter Institution Name"},
													
													"info[15][bankname]": {required: "Please enter Institution Name"},
													"info[16][bankname]": {required: "Please enter Institution Name"},
													"info[17][bankname]": {required: "Please enter Institution Name"},
													"info[18][bankname]": {required: "Please enter Institution Name"},
													"info[19][bankname]": {required: "Please enter Institution Name"},
													"info[20][bankname]": {required: "Please enter Institution Name"},
														"info[21][bankname]": {required: "Please enter Institution Name"},
													"info[22][bankname]": {required: "Please enter Institution Name"},
													"info[23][bankname]": {required: "Please enter Institution Name"},
													"info[24][bankname]": {required: "Please enter Institution Name"},
													"info[25][bankname]": {required: "Please enter Institution Name"},
													
												  "info[1][account]": {required: "Please enter Account Number"},
													"info[2][account]": {required: "Please enter Account Number"},
													"info[3][account]": {required: "Please enter Account Number"},
													"info[4][account]": {required: "Please enter Account Number"},
													"info[5][account]": {required: "Please enter Account Number"},
													"info[6][account]": {required: "Please enter Account Number"},
													"info[7][account]": {required: "Please enter Account Number"},
													"info[8][account]": {required: "Please enter Account Number"},
													"info[9][account]": {required: "Please enter Account Number"},
													"info[10][account]": {required: "Please enter Account Number"},
													 "info[11][account]": {required: "Please enter Account Number"},
													"info[12][account]": {required: "Please enter Account Number"},
													"info[13][account]": {required: "Please enter Account Number"},
													"info[14][account]": {required: "Please enter Account Number"},
													"info[15][account]": {required: "Please enter Account Number"},
													"info[16][account]": {required: "Please enter Account Number"},
													"info[17][account]": {required: "Please enter Account Number"},
													"info[18][account]": {required: "Please enter Account Number"},
													"info[19][account]": {required: "Please enter Account Number"},
													"info[20][account]": {required: "Please enter Account Number"},
														"info[21][account]": {required: "Please enter Account Number"},
													"info[22][account]": {required: "Please enter Account Number"},
													"info[23][account]": {required: "Please enter Account Number"},
													"info[24][account]": {required: "Please enter Account Number"},
													"info[25][account]": {required: "Please enter Account Number"},
													
													
													   "info[1][loantype]": {required: "Please enter Loan Type"},
													"info[2][loantype]": {required: "Please enter Loan Type"},
													"info[3][loantype]": {required: "Please enter Loan Type"},
													"info[4][loantype]": {required: "Please enter Loan Type"},
													"info[5][loantype]": {required: "Please enter Loan Type"},
													"info[6][loantype]": {required: "Please enter Loan Type"},
													"info[7][loantype]": {required: "Please enter Loan Type"},
													"info[8][loantype]": {required: "Please enter Loan Type"},
													"info[9][loantype]": {required: "Please enter Loan Type"},
													"info[10][loantype]": {required: "Please enter Loan Type"},
														
													   "info[11][loantype]": {required: "Please enter Loan Type"},
													"info[12][loantype]": {required: "Please enter Loan Type"},
													"info[13][loantype]": {required: "Please enter Loan Type"},
													"info[14][loantype]": {required: "Please enter Loan Type"},
													"info[15][loantype]": {required: "Please enter Loan Type"},
													"info[16][loantype]": {required: "Please enter Loan Type"},
													"info[17][loantype]": {required: "Please enter Loan Type"},
													"info[18][loantype]": {required: "Please enter Loan Type"},
													"info[19][loantype]": {required: "Please enter Loan Type"},
													"info[20][loantype]": {required: "Please enter Loan Type"},
													"info[21][loantype]": {required: "Please enter Loan Type"},
													"info[22][loantype]": {required: "Please enter Loan Type"},
													"info[23][loantype]": {required: "Please enter Loan Type"},
													"info[24][loantype]": {required: "Please enter Loan Type"},
													"info[25][loantype]": {required: "Please enter Loan Type"},
												
												  }			
									});
																					
								$("#informationfrm").validate(
									{	
										rules:	{
													"info[1][others]": {required: true},
													"info[2][others]": {required: true},
													"info[3][others]": {required: true},
													"info[4][others]": {required: true},
													"info[5][others]": {required: true},
													"info[6][others]": {required: true},
													"info[7][others]": {required: true},
													"info[8][others]": {required: true},
													"info[9][others]": {required: true},
													"info[10][others]": {required: true},
													"info[11][others]": {required: true},
													"info[12][others]": {required: true},
													"info[13][others]": {required: true},
													"info[14][others]": {required: true},
													"info[15][others]": {required: true},
													"info[16][others]": {required: true},
													"info[17][others]": {required: true},
													"info[18][others]": {required: true},
													"info[19][others]": {required: true},
													"info[20][others]": {required: true},
													"info[21][others]": {required: true},
													"info[22][others]": {required: true},
													"info[23][others]": {required: true},
													"info[24][others]": {required: true},
													"info[25][others]": {required: true},
													
													
													
											
												},
										messages: {
													
														"info[1][others]": {required: "Please enter comments"},
													"info[2][others]": {required: "Please enter comments"},
													"info[3][others]": {required: "Please enter comments"},
													"info[4][others]": {required: "Please enter comments"},
													
													"info[5][others]": {required: "Please enter comments"},
													"info[6][others]": {required: "Please enter comments"},
													"info[7][others]": {required: "Please enter comments"},
													"info[8][others]": {required: "Please enter comments"},
													"info[9][others]": {required: "Please enter comments"},
													"info[10][others]": {required: "Please enter comments"},
													"info[11][others]": {required: "Please enter comments"},
													"info[12][others]": {required: "Please enter comments"},
													"info[13][others]": {required: "Please enter comments"},
													"info[14][others]": {required: "Please enter comments"},
													
													"info[15][others]": {required: "Please enter comments"},
													"info[16][others]": {required: "Please enter comments"},
													"info[17][others]": {required: "Please enter comments"},
													"info[18][others]": {required: "Please enter comments"},
													"info[19][others]": {required: "Please enter comments"},
													"info[20][others]": {required: "Please enter comments"},
													"info[21][others]": {required: "Please enter comments"},
													"info[22][others]": {required: "Please enter comments"},
													"info[23][others]": {required: "Please enter comments"},
													"info[24][others]": {required: "Please enter comments"},
													"info[25][others]": {required: "Please enter comments"},
												
													
													
												
												  }			
									});	
									
									
							$("#informationfrm2").validate(
									{	
										rules:	{
													"info[1][others]": {required: true},
													"info[2][others]": {required: true},
													"info[3][others]": {required: true},
													"info[4][others]": {required: true},
													"info[5][others]": {required: true},
													"info[6][others]": {required: true},
													"info[7][others]": {required: true},
													"info[8][others]": {required: true},
													"info[9][others]": {required: true},
													"info[10][others]": {required: true},
													"info[11][others]": {required: true},
													"info[12][others]": {required: true},
													"info[13][others]": {required: true},
													"info[14][others]": {required: true},
													"info[15][others]": {required: true},
													"info[16][others]": {required: true},
													"info[17][others]": {required: true},
													"info[18][others]": {required: true},
													"info[19][others]": {required: true},
													"info[20][others]": {required: true},
													"info[21][others]": {required: true},
													"info[22][others]": {required: true},
													"info[23][others]": {required: true},
													"info[24][others]": {required: true},
													"info[25][others]": {required: true},
											
											
												},
										messages: {
													
													"info[1][others]": {required: "Please enter comments"},
													"info[2][others]": {required: "Please enter comments"},
													"info[3][others]": {required: "Please enter comments"},
													"info[4][others]": {required: "Please enter comments"},
													
													"info[5][others]": {required: "Please enter comments"},
													"info[6][others]": {required: "Please enter comments"},
													"info[7][others]": {required: "Please enter comments"},
													"info[8][others]": {required: "Please enter comments"},
													"info[9][others]": {required: "Please enter comments"},
													"info[10][others]": {required: "Please enter comments"},
													"info[11][others]": {required: "Please enter comments"},
													"info[12][others]": {required: "Please enter comments"},
													"info[13][others]": {required: "Please enter comments"},
													"info[14][others]": {required: "Please enter comments"},
													
													"info[15][others]": {required: "Please enter comments"},
													"info[16][others]": {required: "Please enter comments"},
													"info[17][others]": {required: "Please enter comments"},
													"info[18][others]": {required: "Please enter comments"},
													"info[19][others]": {required: "Please enter comments"},
													"info[20][others]": {required: "Please enter comments"},
													"info[21][others]": {required: "Please enter comments"},
													"info[22][others]": {required: "Please enter comments"},
													"info[23][others]": {required: "Please enter comments"},
													"info[24][others]": {required: "Please enter comments"},
													"info[25][others]": {required: "Please enter comments"},
												
												
													
												
												  }			
									});				
												
		/*	$("#assetsfrm").validate(
									{	
										rules:	{
													"info[1][bankname]": {required: true},
													"info[2][bankname]": {required: true},
													"info[3][bankname]": {required: true},
													"info[4][bankname]": {required: true},
													"info[5][bankname]": {required: true},
											
												},
										messages: {
													
													"info[1][bankname]": {required: ""},
													"info[2][bankname]": {required: ""},
													"info[3][bankname]": {required: ""},
													"info[4][bankname]": {required: ""},
													
													"info[5][bankname]": {required: ""},
												
												  }	,
												 submitHandler: function() { alert("Submitted!"); $.ajax(
	{
		type: "post",
		url: 'http://54.226.15.89/afterlife/Users/ajaxbankaccount/',
		data: $('#assetsfrm').serialize(),
		success:function(msg)
		{
			$('#editbankaccount').hide();
			
			//alert(msg);
			$('#viewbankaccount').html(msg);
			$('#viewbankaccount').show();
			//return false;
			
			//var delid=msg.split('_');
			
			//$("tr#infomember_"+delid[0]).hide();
			//$("tr#infoview_"+delid[0]).hide();
			//$('#delcheck').val(delid[1]);
			//informationcounter=delid[1];
		//	alert("Record Deleted successfully");
			//$('#ajax').html(msg);
		}
	});	} 
												  		
									});	*/
	 							
	 
	   $("#profilefrm").validate(
									{	
										rules:	{
												
													"data[securitycode]": {number:true,minlength: 9,maxlength: 9},
													"data[firstname]": {required: true},
													"data[lastname]": {required: true},
													"data[address1]": {required: true},
													"data[city]": {required: true},
													"data[state]": {required: true},
													//"data[User][zipcode]": {required: true},
													"data[zipcode]": {required: true,number:true,minlength: 5,maxlength: 5}
															

												
												},
										messages: {
													
												
													"data[securitycode]": {number:"Please provide a valid Social Security",minlength: "Please provide a valid Social Security",maxlength:"Please provide a valid Social Security"},
													"data[firstname]": {required: "Please enter your First Name"},
													"data[lastname]": {required: "Please enter your Last Name"},
													"data[address1]": {required: "Please enter your Address"},
													"data[city]": {required: "Please enter your City"},
													"data[state]": {required: "Please select your State"},
													//"data[User][zipcode]": {required: ""},
													"data[zipcode]": {required: "Please enter your Zip Code",number:"Please provide a valid Zip Code",minlength: "Please provide a valid Zip Code",maxlength:"Please provide a valid Zip Code"}
													
														
												  }		,
												  
												  
												   submitHandler: function() {  $.ajax(
	{
		type: "post",
		url: _ROOT+'Users/ajaxuserinfo/',
		data: $('#profilefrm').serialize(),
		success:function(msg)
		{
		//alert('aaasdasdasdasd');
			//alert(msg);return false;
			$('#userinfo').hide();
			$('#editbtn1').show();
			
			//alert(msg);
		
			//return false;
			//tooltip
				$('#viewuserinfo').html(msg);
			$('#viewuserinfo').show();
			
			
			
			
			$('a[rel=tooltip3]').mouseover(function(e) {

		
		//Grab the title attribute's value and assign it to a variable
		//var tip = $(this).attr('title');	
		var tip=$('#test3').html();
		
		//Remove the title attribute's to avoid the native tooltip from the browser
		$(this).attr('title','');
		
		//Append the tooltip template and its value
		$(this).append('<div id="tooltip"><div class="tipHeader"></div><div class="tipBody">' + tip + '</div><div class="tipFooter"></div></div>');		
				
		//Show the tooltip with faceIn effect
		$('#tooltip').fadeIn('500');
		$('#tooltip').fadeTo('10',0.9);
		
	}).mousemove(function(e) {
	
		//Keep changing the X and Y axis for the tooltip, thus, the tooltip move along with the mouse
		$('#tooltip').css('top', e.pageY + 10 );
		$('#tooltip').css('left', e.pageX + 10 );
		 //var leftdata = $('#tooltip').css( 'left' );
		  var leftdata = parseInt($('#tooltip').css('left'));
		  var newdata=leftdata-50;
		  var newd=newdata+"px";
		  $('#tooltip').css({ 'left': newd});

	
	}).mouseout(function() {
	
		//Put back the title attribute's value
		$(this).attr('title',$('.tipBody').html());
	
		//Remove the appended tooltip template
		$(this).children('div#tooltip').remove();
		
	});
	
	//tooltip2
	
	//tooltip2
	$('a[rel=tooltip4]').mouseover(function(e) {
		
		//Grab the title attribute's value and assign it to a variable
		//var tip = $(this).attr('title');	
		var tip=$('#test4').html();
		
		//Remove the title attribute's to avoid the native tooltip from the browser
		$(this).attr('title','');
		
		//Append the tooltip template and its value
		$(this).append('<div id="tooltip"><div class="tipHeader"></div><div class="tipBody">' + tip + '</div><div class="tipFooter"></div></div>');		
				
		//Show the tooltip with faceIn effect
		$('#tooltip').fadeIn('500');
		$('#tooltip').fadeTo('10',0.9);
		
	}).mousemove(function(e) {
	
		//Keep changing the X and Y axis for the tooltip, thus, the tooltip move along with the mouse
		$('#tooltip').css('top', e.pageY + 10 );
		$('#tooltip').css('left', e.pageX + 20 );
		
	}).mouseout(function() {
	
		//Put back the title attribute's value
		$(this).attr('title',$('.tipBody').html());
	
		//Remove the appended tooltip template
		$(this).children('div#tooltip').remove();
		
	});
	//tooltip2 ends//

			
			
			
			
			
			
			
			//tooltip ends//
			//var delid=msg.split('_');
			
			//$("tr#infomember_"+delid[0]).hide();
			//$("tr#infoview_"+delid[0]).hide();
			//$('#delcheck').val(delid[1]);
			//informationcounter=delid[1];
		//	alert("Record Deleted successfully");
			//$('#ajax').html(msg);
		}
	});	} 	
									});	
									
						  $("#profilefrm2").validate(
									{	
								 /* groups: {
                                                                                                      
																										    phoneGroup2: "data[ce11phone1] data[cellphone2] data[cellphone3]",
                                                                                                    },*/
									
										rules:	{
												
												
													"data[primaryemail]": {required: true, PRIMARYEMAIL: true},
													"data[secondaryemail]": {SECONDARYEMAIL: true},
													"data[homephone1]": {required: true,number:true,minlength: 3,maxlength: 3},
													"data[homephone2]": {required: true,number:true,minlength: 3,maxlength: 3},
													"data[homephone3]": {required: true,number:true,minlength: 4,maxlength: 4},
													/*"data[cellphone1]": {number:true,minlength: 3,maxlength: 3},
													"data[cellphone2]": {number:true,minlength: 3,maxlength: 3},
													"data[cellphone3]": {number:true,minlength: 4,maxlength: 4}*/
													 "data[cellphone1]": {
                required: {
                    depends: function (element) {
                        return $("#cellphone2").is(":filled");
						return $("#cellphone3").is(":filled");
                    }
                },
				number:true
				,minlength: 3
				,maxlength: 3
            },
			   "data[cellphone2]": {
                required: {
                    depends: function (element) {
                        return $("#cellphone1").is(":filled");
						return $("#cellphone3").is(":filled");
                    }
                },				
				number:true
				,minlength: 3
				,maxlength: 3
            },
			
			   "data[cellphone3]": {
                required: {
                    depends: function (element) {
                        return $("#cellphone1").is(":filled");
						return $("#cellphone2").is(":filled");
                    }
                },
				number:true
				,minlength: 4
				,maxlength: 4
            }
			

												
												},
										messages: {
													
												
												
													"data[primaryemail]": {required: "Please provide your Email",PRIMARYEMAIL:"Please provide a valid Primary Email"},
                                                     "data[secondaryemail]": {SECONDARYEMAIL: "Please provide a valid Secondary Email"},
													"data[homephone1]": {required: "Please provide Home phone",number:"Please provide a valid Home phone",minlength: "Please provide a valid Home phone",maxlength:"Please provide a valid Home phone"},
													"data[homephone2]": {required: "Please provide Home phone",number:"Please provide a valid Home phone",minlength: "Please provide a valid Home phone",maxlength:"Please provide a valid Home phone"},
													"data[homephone3]": {required: "Please provide Home phone",number:"Please provide a valid Home phone",minlength: "Please provide a valid Home phone",maxlength:"Please provide a valid Home phone"},
													
													//"data[cellphone1]": {number:"Please provide a valid Cell phone",minlength: "Please provide a valid Cell phone",maxlength:"Please provide a valid Cellphone"},
												//	"data[cellphone2]": {number:"Please provide a valid Cell phone",minlength: "Please provide a valid Cell phone",maxlength:"Please provide a valid Cellphone"},
													//"data[cellphone3]": {number:"Please provide a valid Cell phone",minlength: "Please provide a valid Cell phone",maxlength:"Please provide a valid Cellphone"}
														"data[cellphone1]": { required:"Please provide a valid cell phone",number:"Please provide a valid cell phone",minlength: "Please provide a valid cell phone",maxlength: "Please provide a valid cell phone"},
													"data[cellphone2]": { required:"Please provide a valid cell phone",number:"Please provide a valid cell phone",minlength: "Please provide a valid cell phone",maxlength: "Please provide a valid cell phone"},
													"data[cellphone3]": { required:"Please provide a valid cell phone",number:"Please provide a valid cell phone",minlength: "Please provide a valid cell phone",maxlength: "Please provide a valid cell phone"},
														
												  }	,
                                                                                                  
                                                                                groups: {
                                                                                                         phoneGroup: "data[homephone1] data[homephone2] data[homephone3]",
                                                                                                         phoneGroup1: "data[cellphone1] data[cellphone2] data[cellphone3]"
                                                                                                    },
												  
												  
												   submitHandler: function() {  $.ajax(
	{
		type: "post",
		url: _ROOT+'Users/ajaxcontactprofile/',
		data: $('#profilefrm2').serialize(),
		success:function(msg)
		{
			
			$('#contactinfo').hide();
			$('#editbtn2').show();
			
			//alert(msg);
			$('#viewcontactinfo').html(msg);
			$('#viewcontactinfo').show();
			//return false;
			
			//var delid=msg.split('_');
			
			//$("tr#infomember_"+delid[0]).hide();
			//$("tr#infoview_"+delid[0]).hide();
			//$('#delcheck').val(delid[1]);
			//informationcounter=delid[1];
		//	alert("Record Deleted successfully");
			//$('#ajax').html(msg);
		}
	});	} 
												  
												  		
									});	
									
						 $("#uploadsfrm").validate(
									{	
										rules:	{
												
												
													"data[User][comments]": {required: true},
													"data[User][filename]": {required: true}
												
												
												},
										messages: {
													
												
												
													"data[User][comments]": {required: "Please enter comments."},
													"data[User][filename]": {required: "<div style='position: absolute; font-size:11px; font-family: Roboto,sans-serif; top:-2px; width:250px;left:40px;'>Please select a file to upload.</div>"}
												
													
														
												  }	,
												  
												
											/* submitHandler: function() {
													   
													   $('#smalldata').hide();
													   $('#invalidfile').hide();
													   
													 
													     $('#loading_image').show(); // show animation
   
													 // $('#test').html("Loading....");
													 $('#uploadsfrm').submit();
													  
													   
												   }*/
									});
							
									
									
							 $("#claimfrm4").validate(
									{	
										rules:	{
												
												"data[User][notarized]": {required:true},
												
												"data[User][contactno]": {required:true,maxlength: 15},
												
													"data[User][filename]": {required: true},
													
												
												},
										messages: {
													
												"data[User][notarized]": {required:"<div id='myhide1' style='position: absolute; font-size:12px; top:7px; width:250px;left:210px'>Please enter Notarized By</div>"},
												
												
												"data[User][contactno]": {required:"<div id='myhide2' style='position: absolute; font-size:12px; top:7px; width:250px;left:210px'>Please enter phone number</div>",maxlength:"<div id='myhide' style='position: absolute; font-size:12px; top:7px; width:250px;left:210px'>Please provide a valid Phone Number </div>"},
												
													"data[User][filename]": {required: "<div id='myhide' style='position: absolute; font-size:12px; top:0px; width:250px;left:120px'>Please select a file to upload.</div>"},
												
													
														
												  }	,
												  
												  
												 /*  submitHandler: function() {
													
													     $('#loading_image2').show(); // show animation
													   $('#claimfrm4').submit();
													  
													   
												   }*/
									});	
									
										
									
								 $("#forgetpwd").validate(
									{	
										rules:	{
												
												
													"data[User][username]": {required: true},
												
												
												},
										messages: {
													
												
												
													"data[User][username]": {required: "Please enter your email address"},
												
													
														
												  }			
									});								
	  $("#contactfrm").validate(
									{	
										rules:	{
												
													"data[name]": {required: true},
												
													"data[comment]": {required: true},
													"data[primaryemail]": {required: true, PRIMARYEMAIL: true},
													"data[phone]": {required: true},
																				
												},
										messages: {
												
													"data[name]": {required: "Please enter your Name"},
													
													"data[comment]": {required: "Please add a Comment"},
													"data[primaryemail]": {required: "Please enter your Email",PRIMARYEMAIL: "Please enter a valid Email"},
													"data[phone]": {required: "Please enter your Phone"},
														
												  },
                                                                                                  
                                                                              
									});									

	  $("#claimfrm").validate(
									{	
										rules:	{
												
													"data[User][firstname]": {required: true},
													"data[User][lastname]": {required: true},
													
													"data[User][email]": {required: true, EMAIL: true},
													"data[User][pincode]": {required: true,minlength: 4,maxlength: 4},
												
													
												},
										messages: {
												
													"data[User][firstname]": {required: "Please enter your First Name"},
													"data[User][lastname]": {required: "Please enter your Last Name"},
													"data[User][email]": {required: "Please enter your Email"},
														"data[User][pincode]": {required: "Please enter your 4 digit PIN Code" ,minlength: "Please provide a valid 4 digit PIN Code",maxlength:"Please provide a valid 4 digit PIN Code"},
													
														
												  }			
									});
									
		 /* $("#checkpin").validate(
									{	
										rules:	{
												
													"data[User][answer]": {required: true},
													"data[User][email]": {required: true, EMAIL: true},
													
												
													
												},
										messages: {
												
													"data[User][answer]": {required: "Please enter your Answer"},
													"data[User][email]": {required: "Please enter your Email"},
													
													
														
												  }			
									});	*/

 $("#checkpin").validate(
									{	
										rules:	{
												
													"data[User][answer_1]": {required: true},
													"data[User][answer_2]": {required: true},
													
												
													
												},
										messages: {
												
													"data[User][answer_1]": {required: "Please enter your Answer"},
													"data[User][answer_2]": {required: "Please enter your Answer"},
													
													
														
												  }			
									});															
																
	 
	   $("#loginfrm").validate(
									{	
										rules:	{
													
													"data[User][username]": {required: true, USERNAME: true},  
													"data[User][password]": {required: true},
													
													
												},
										messages: {
													"data[User][username]": {required: "Please enter your Email Address"},												
													"data[User][password]": {required: "Please enter your Password"},
													
												  },

								submitHandler: function() { 
								
								if(a==0)
								{
								$.ajax(
	{
		type: "post",
		url: _ROOT+'Users/ajaxlogininfo/',
		data: $('#loginfrm').serialize(),
		success:function(msg)
		{
			
			alert(msg);
			if(msg==1){
		//	$('#loginfrm').submit();
		alert("Invalid username/password");
			return false;
			}
			else{
			
			$('#loginfrm').submit();
			}
			//var delid=msg.split('_');
			
			//$("tr#infomember_"+delid[0]).hide();
			//$("tr#infoview_"+delid[0]).hide();
			//$('#delcheck').val(delid[1]);
			//informationcounter=delid[1];
		//	alert("Record Deleted successfully");
			//$('#ajax').html(msg);
		}
	});
}
	}

												  
									});	
			 $("#loginpopupfrm").validate(
									{	
										rules:	{
													
													"data[User][username]": {required: true, USERNAME: true},  
													"data[User][password]": {required: true},
													
													
												},
										messages: {
													"data[User][username]": {required: "Please enter your Email Address"},												
													"data[User][password]": {required: "Please enter your Password"},
													
												  }			
									});							
	   
		
	 $("#forgetpwd").validate(
									{	
										rules:	{
													
													"data[User][primaryemail]": {required: true, PRIMARYEMAIL: true}  
												
													
												},
										messages: {
													"data[User][primaryemail]": {required: "Email is required."}												
												
												  }			
									});	
									
									
									
		$("#referfrm").validate(
									{	
										rules:	{
													"data[User][name]": {required: true},
													"data[User][email]": {required: true,EMAIL: true},
													"data[User][friendname]": {required: true},
													"data[User][friendemail]": {required: true,FRIENDEMAIL: true},
													"data[User][message]": {required: true},
											
												},
										messages: {
													
													"data[User][name]": {required: "Please enter your Name"},
													"data[User][email]": {required: "Please enter your E-mail Address"},
													"data[User][friendname]": {required: "Please enter your Friend's Name"},
													"data[User][friendemail]": {required: "Please enter your Friend's E-mail Address"},
													"data[User][message]": {required: "Please enter a message"},
													
												
												
												  }			
									});				
																			
	$("#paypal_form").validate(
									{	
									
									 	ignore: [],
									 	highlight:false,
										rules:	{
												
													"kshitizflag": {required: true},
												
													},
										messages: {
												
													"kshitizflag": {required: "Please select Subscription type"},
												
												  }			
									});
    
   /* $("#pincodefrm").validate(
									{	
										rules:	{
												
													"data[User][pincode]": {required: true,number:true,minlength: 4,maxlength: 4},
													"data[User][confirmpincode]": {required: true,number:true,minlength: 4,maxlength: 4,equalTo: "#pincode"},
													"data[User][answer1]": {required: true},
													"data[User][answer2]": {required: true},
													"data[User][datepicker]": {required: true},
													},
										messages: {
												
													"data[User][pincode]": {required: "Please enter 4 digit PIN",number:"Please provide a valid pincode",minlength: "Please provide a valid 4 digit PIN",maxlength:"Please provide a valid 4 digit PIN"},
													"data[User][confirmpincode]": {required: "Please confirm 4 digit PIN",number:"Please provide a valid 4 digit PIN",minlength: "Please provide a valid 4 digit PIN",maxlength:"Please provide a valid 4 digit PIN",equalTo: "This does not match the 4 digit PIN entered above."},
													"data[User][answer1]": {required: "Please enter your Answer"},
													"data[User][answer2]": {required: "Please enter your Answer"},
                          "data[User][datepicker]": {required: "Please select Date of Birth"},
												  }		
									});	*/
									  $("#searchpin").validate(
									{	
										rules:	{
												
														"data[User][email]": {required: true, EMAIL: true},
													
												
													
												},
										messages: {
												
													"data[User][email]": {required: "Please enter your Email"},
													
													
														
												  }			
									});		

$("#pincodefrm").validate(
									{	
										rules:	{
												
													"data[User][pincode]": {required: true,number:true,minlength: 4,maxlength: 4},
													"data[User][confirmpincode]": {required: true,number:true,minlength: 4,maxlength: 4,equalTo: "#pincode"},
													"data[User][answer1]": {required: true},
													"data[User][answer2]": {required: true},
													"data[User][answer3]": {required: true},
													"data[User][answer4]": {required: true},
													"data[User][question1]": {required: true},
													"data[User][question2]": {required: true},
													"data[User][question3]": {required: true},
													"data[User][question4]": {required: true},
													"data[User][datepicker]": {required: true},
													},
										messages: {
												
													"data[User][pincode]": {required: "Please enter 4 digit PIN",number:"Please provide a valid pincode",minlength: "Please provide a valid 4 digit PIN",maxlength:"Please provide a valid 4 digit PIN"},
													"data[User][confirmpincode]": {required: "Please confirm 4 digit PIN",number:"Please provide a valid 4 digit PIN",minlength: "Please provide a valid 4 digit PIN",maxlength:"Please provide a valid 4 digit PIN",equalTo: "This does not match the 4 digit PIN entered above."},
													"data[User][answer1]": {required: "Please enter your Answer"},
													"data[User][answer2]": {required: "Please enter your Answer"},
													"data[User][answer3]": {required: "Please enter your Answer"},
													"data[User][answer4]": {required: "Please enter your Answer"},
													"data[User][question1]": {required: "Please select your Question"},
													"data[User][question2]": {required: "Please select your Question"},
													"data[User][question3]": {required: "Please select your Question"},
													"data[User][question4]": {required: "Please select your Question"},
                         
                          "data[User][datepicker]": {required: "Please select Date of Birth"},
												  }		
									});													

                    $("#card").validate(
									{	
										rules:	{
												
													"payby": {required: true},
													"shipping": {required: true},
                                                                                                        "data[User][packageid]": {required: true},
													"data[User][customer_credit_card_type]": {required: true},
													"data[User][customer_credit_card_number]": {required: true,creditcard: true},
													"data[User][cc_expiration_month]": {required: true},
													"data[User][cc_expiration_year]": {required: true},
													"data[User][cc_cvv2_number]": {required: true,number: true,minlength: 3,maxlength: 4},
													"data[User][customer_address1]": {required: true},
													"data[User][customer_city]": {required: true},
													"data[User][customer_state]": {required: true},
													"data[User][customer_zip]": {required: true,number:true,minlength: 5,maxlength: 5},
													
        },
										messages: {
												
													"payby": {required: "Please select Payment type"},
													"shipping": {required: "Please select Mailing address"},
													
                                                                                                        "data[User][packageid]": {required: "Please select Subscription type"},
													"data[User][customer_credit_card_type]": {required: "Select Credit card type"},
													"data[User][customer_credit_card_number]": {required: "Enter Credit card number"},
													"data[User][cc_expiration_month]": {required: "Select Expiry month"},
                                                                                                        "data[User][cc_expiration_year]": {required: "Select Expiry year"},
                                                                                                        "data[User][cc_cvv2_number]": {required: "Enter Card verification number",number: "Enter Card verification number",minlength: "Enter a valid Card verification number",maxlength: "Enter a valid Card verification number"},
												  }	,
												  "data[User][customer_address1]": {required: "Please enter Address"},	
												   "data[User][customer_city]": {required: "Please enter City"},	
												   "data[User][customer_state]": {required: "Please select State"},		
												  "data[User][customer_zip]": {required: "Please enter Zip Code",number:"Please provide a valid Zip code",minlength: "Please provide a valid Zip code",maxlength:"Please provide a valid Zip code"},
									});									

 

});


