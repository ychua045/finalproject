function chkName() {
	// Username should be 1 to 20 characters long, containing a-z A-Z 0-9 -_
	var content = document.getElementById("memName").value.trim();
	var error = document.getElementById("nameError");
	var pattern = /^[a-zA-Z0-9_-]{1,20}$/;
	
	if (!pattern.test(content)) {
		error.textContent = "Invalid email format.";
	} else {
		error.textContent = ""; // Clear the error message
	}
	return error.textContent;
}


function chkEmail() {
	// Email format: 
	var content = document.getElementById("memEmail").value.trim();
	var error = document.getElementById("emailError");
	var pattern = /^[a-zA-Z0-9.-]+@[\w]+(\.[a-zA-Z0-9]+){0,2}\.[a-zA-Z]{1,3}$/;
	
	if (!pattern.test(content)) {
		error.textContent = "Invalid email format.";
	} else {
		error.textContent = ""; // Clear the error message
	}
	return error.textContent;
}


function chkPassword() {
    // Password format: 8 to 20 characters which contain at least one lowercase letter, one uppercase letter, one numeric digit, and one special character.
	var content = document.getElementById("memPassword").value;
	var error = document.getElementById("passwordError");
	var pattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,20}$/; 
	
	if (document.getElementById("confirmPassword") !== null) {
		document.getElementById("confirmPassword").value = "";
	}
	
	if (!pattern.test(content)) {
		error.textContent = "Invalid password format.";
	} else {
		error.textContent = ""; // Clear the error message
	}
	return error.textContent;
}

function chkConfirmPassword() {
	// check if two passwords are the same. 
	var content1 = document.getElementById("memPassword").value;
	var content2 = document.getElementById("confirmPassword").value;
	var error = document.getElementById("confirmpasswordError");
	if (content1 !== content2) {
		error.textContent = "Passwords don't match.";
	} else {
		error.textContent = ""; // Clear the error message
	}
	return error.textContent;
}

function chkHp() {
	// 8 digits. 
	var content = document.getElementById("memHp").value.trim();
	var error = document.getElementById("hpError");
	var pattern = /^[0-9]{8}$/; 
	
	if (!pattern.test(content)) {
		error.textContent = "Invalid phone number format.";
	} else {
		error.textContent = ""; // Clear the error message		
	}
	return error.textContent;
}
function chkCard() {
	// 16 digits. 
	var content = document.getElementById("memCard").value.trim();
	var error = document.getElementById("cardError");
	var pattern = /^[0-9]{16}$/; 
	
	if (!pattern.test(content)) {
		error.textContent = "Invalid card number format.";
	} else {
		error.textContent = ""; // Clear the error message
	}
	return error.textContent;
}

function loginSubmit(){
	var emailInput = document.getElementById("memEmail");
	var passwordInput = document.getElementById("memPassword");
	var emailError = document.getElementById("emailError");
	var passwordError = document.getElementById("passwordError");
	
	if (emailError.textContent.length) {
		alert("Please check your Email format.");
		emailInput.focus();
		emailInput.select();
	}
	else if (passwordError.textContent.length) {
		alert("Please check your password format.");
		passwordInput.focus();
		passwordInput.select(); 
	}
	else {
		document.getElementById("LoginForm").submit();
	}
}

function registerSubmit(){
	var nameInput = document.getElementById("memName");
	var nameError = document.getElementById("nameError");
	var emailInput = document.getElementById("memEmail");
	var emailError = document.getElementById("emailError");
	var hpInput = document.getElementById("memHp");
	var hpError = document.getElementById("hpError");
	var cardInput = document.getElementById("memCard");
	var cardError = document.getElementById("cardError");
	var passwordInput = document.getElementById("memPassword");
	var passwordError = document.getElementById("passwordError");
	var confirmInput = document.getElementById("confirmPassword");
	var confirmError = document.getElementById("confirmpasswordError");
	
	if (nameError.textContent.length) {
		alert("Please check your username format.");
		nameInput.focus();
		nameInput.select();
	}
	else if (emailError.textContent.length) {
		alert("Please check your Email format.");
		emailInput.focus();
		emailInput.select();
	}
	else if (hpError.textContent.length) {
		alert("Please check your phone number.");
		hpInput.focus();
		hpInput.select();
	}
	else if (cardError.textContent.length) {
		alert("Please check your card number.");
		cardInput.focus();
		cardInput.select();
	}
	else if (passwordError.textContent.length) {
		alert("Please check your password format.");
		passwordInput.focus();
		passwordInput.select(); 
	}
	else if (confirmError.textContent.length) {
		alert("Please make sure the passwords match.");
		confirmInput.focus();
		confirmInput.select(); 
	}
	else {
		document.getElementById("RegisterForm").submit();
	}
}


