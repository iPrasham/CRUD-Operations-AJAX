$(document).ready(function() {

	var userObj;
	var userArray;
	var tableData;
	var session = false;

	$("#signUpDiv").hide();
	$("#loginDiv").show();
	$("#homeDiv").hide();


	$("#name").focus(function(){
		$("#nameError").text("");
	});

	$("#phone").focus(function(){
		$("#phoneError").text("");
	});

	$("#email").focus(function(){
		$("#signUpEmailError").text("");
	});

	$("#password").focus(function(){
		$("#signUpPasswordError").text("");
	});

	
	$("#loginEmail").focus(function(){
		$("#loginEmailError").text("");
	});

	$("#loginPassword").focus(function(){
		$("#loginPasswordError").text("");
	});

	
	
	$("#aHome").on("click", function(){
		//console.log(typeof userObj);
		if(session === false){
			//console.log("Hi from jquery");
			$("#signUpDiv").hide();
			$("#loginDiv").show();
			$("#homeDiv").hide();
			alert("Please Login");
			$("#aSignUp").parent().removeClass("active");
			$("#aLogin").parent().addClass("active");

		} 
		else{
			$("#signUpDiv").hide();
			$("#loginDiv").hide();
			$("#homeDiv").show();
			$(this).parent().addClass("active");
			$("#aSignUp").parent().removeClass("active");
			$("#aLogin").parent().removeClass("active");
		}
	
	});

	$("#aSignUp").on("click", function(){
		$("#signUpDiv").show();
		$("#loginDiv").hide();
		$("#homeDiv").hide();
		$(this).parent().addClass("active");
		$("#aHome").parent().removeClass("active");
		$("#aLogin").parent().removeClass("active");

	});


	$("#aLogin").on("click", function(){
		$("#signUpDiv").hide();
		$("#loginDiv").show();
		$("#homeDiv").hide();
		$(this).parent().addClass("active");
		$("#aHome").parent().removeClass("active");
		$("#aSignUp").parent().removeClass("active");

	});

	
	$("#signUpButton").on("click", function() 
	{
		var signUpFlag = 0;
		var name= $("#name").val();
		var email = $("#email").val();
                var password= $("#password").val();
		var phone = $("#phone").val();

		if(!(/^[A-Z]{1}[a-zA-Z\s]{1,50}$/.test(name))){
			$("#nameError").text("Please provide a valid name");
			signUpFlag = 1;
		}

		if(!(/^[6-9]\d{9}$/.test(phone))){
			$("#phoneError").text("Please provide a valid phone number");
			signUpFlag = 1;
		}

		if(!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email))){
			$("#signUpEmailError").text("Please provide a valid email address");
			signUpFlag = 1;
		}

		if(!(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#\$%\^&\*]).{8,22}$/.test(password))){
			$("#signUpPasswordError").text("Please provide the password according to specified criteria");
			signUpFlag = 1;
		}


		if(signUpFlag == 0){
		$.ajax({
                    type: "POST",
                    url: "phpFunctions.php?signup=true",
                   // data: "name=" + name + "&email=" + email + "&password=" + password,
		    // data: data,
		    data: {
			name: name,
			email: email,
			phone: phone,
			password: password
		},
		    success: function(data) {
			    	alert(data);
			    	$("#signUpDiv").hide();
			    	$("#loginDiv").show();
			    	$("#homeDiv").hide();
			        $("#aSignUp").parent().removeClass("active");
				$("#aLogin").parent().addClass("active");

		    	}
		});
	}
	});

		$("#loginButton").on("click", function() 
		{
			var loginEmail = $("#loginEmail").val();
                	var loginPassword= $("#loginPassword").val();
			var loginFlag = 0;
			
			if(!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(loginEmail))){
				$("#loginEmailError").text("Please provide a valid email address");
				loginFlag = 1;
			}

			if(!(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#\$%\^&\*]).{8,22}$/.test(loginPassword))){
				$("#loginPasswordError").text("Please provide the password according to specified criteria");
				loginFlag = 1;
			}

		
			if(loginFlag == 0){

			var user = {
				email: loginEmail,
				password: loginPassword
			};
			console.log(user);
			var jsonUser = JSON.stringify(user);
			console.log(jsonUser);
			console.log(typeof jsonUser);

		$.ajax({
                    type: "POST",
                    url: "phpFunctions.php?login=true",
                    data: { jsonUser: jsonUser },
		    success: function(data) {
			    	if(data){
					alert("Login Successfully");
					console.log(data);
					session = true;
					userArray = JSON.parse(data);
					console.log(userArray);
					//console.log(userObj);
						
					$("#signUpDiv").hide();
			    		$("#loginDiv").hide();
			    		$("#homeDiv").show();
					$("#aHome").parent().addClass("active");
					$("#aLogin").parent().removeClass("active");


				}
				else{
					alert('Invalid username/password');
					console.log(data);
					$("#signUpDiv").hide();
			    		$("#loginDiv").show();
			    		$("#homeDiv").hide();
					$("#loginEmail").val("");
					$("#loginPassword").val("");

					//$("#aSignUp").parent().removeClass("active");
					//$("#aLogin").parent().removeClass("active");

				}
		    	
			}
		
		});
	
	}
	});

	

	$("#showUsersButton").on("click", function(){

		for(userObj = 0; userObj < userArray.length;  userObj++){
			//console.log(userObj);
			var id = userObj + 1;
			tableData = tableData + "<tr>" 
						       + "<td>" + userArray[userObj].id + "</td>"
						       + "<td>" + userArray[userObj].name + "</td>"
						       + "<td>" + userArray[userObj].email + "</td>"
						       + "<td>" + userArray[userObj].phone + "</td>"
						       + "<td><button class='btn btn-primary'>Edit Details</button></td>"
						       + "<td><button class='btn btn-danger'>Delete User</button></td>";
						"</tr>"
			}
		$("#homeTable").html($("#homeTable").html() + tableData);
		$("#showDetails").hide();
		$("#userDetails").show();
	});

	$("#logoutButton").on("click", function(){
					session = false;
					$("#loginDiv").show();
					$("#aHome").parent().removeClass("active");
					$("#aLogin").parent().addClass("active");
			    		$("#homeDiv").hide();
					$("#loginEmail").val("");
					$("#loginPassword").val("");
	
	});


});
