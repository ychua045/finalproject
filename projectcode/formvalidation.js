function chkName() {
	// Username should be 1 to 20 characters long, containing a-z A-Z 0-9 -_
	var content = document.getElementById("memName").value;
	var error = document.getElementById("nameError");
	var pattern = /^[a-zA-Z0-9_-]{1,20}$/;
	
	if (!pattern.test(content)) {
		error.textContent = "1 to 20 characters long, containing only alphabets, numbers, '-' and '_'";
	} else {
		error.textContent = ""; // Clear the error message
	}
	return error.textContent;
}


function chkEmail() {
	// A string containing only alphabets, numbers, '.' and '-', followed by '@localhost'
	var content = document.getElementById("memEmail").value.trim();
	var error = document.getElementById("emailError");
	//var pattern = /^[a-zA-Z0-9.-]+@[\w]+(\.[a-zA-Z0-9]+){0,2}\.[a-zA-Z]{1,3}$/;
	var pattern = /^[a-zA-Z0-9.-]+@localhost$/;
	if (!pattern.test(content)) {
		error.textContent = "A string containing only alphabets, numbers, '.' and '-', then followed by '@localhost'";
	} else {
		error.textContent = ""; // Clear the error message
	}
	return error.textContent;
}


function chkPassword(ch) {
    // Password format: 8 to 20 characters which contain at least one lowercase letter, one uppercase letter, one numeric digit, and one special character.
	var content = document.getElementById("memPassword").value;
	var error = document.getElementById("passwordError");
	var pattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,20}$/; 
	
	if (ch == 1) {
		document.getElementById("confirmPassword").value = "";
	}
	
	if (!pattern.test(content)) {
		error.textContent = "8 to 20 characters long, at least one lowercase letter, one uppercase letter, one digit, and one special character";
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
		error.textContent = "Doesn't match with the password above";
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
		error.textContent = "Exactly 8 digits";
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
		error.textContent = "Exactly 16 digits";
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
	
	chkPassword(0);
	chkEmail();
	
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
	chkName();
	chkHp();
	chkEmail();
	chkCard();
	chkPassword(0);
	chkConfirmPassword();
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

function chkContactName() {
	// Username should be 1 to 20 characters long, containing a-z A-Z 0-9 -_
	var content = document.getElementById("contactName").value;
	var error = document.getElementById("nameError");
	var pattern = /^[a-zA-Z0-9_-]{1,20}$/;
	
	if (!pattern.test(content)) {
		error.textContent = "1 to 20 characters long, containing only alphabets, numbers, '-' and '_'";
	} else {
		error.textContent = ""; // Clear the error message
	}
	return error.textContent;
}

function chkContactEmail() {
	// A string containing only alphabets, numbers, '.' and '-', followed by '@localhost'
	var content = document.getElementById("contactEmail").value.trim();
	var error = document.getElementById("emailError");
	//var pattern = /^[a-zA-Z0-9.-]+@[\w]+(\.[a-zA-Z0-9]+){0,2}\.[a-zA-Z]{1,3}$/;
	var pattern = /^[a-zA-Z0-9.-]+@localhost$/;
	if (!pattern.test(content)) {
		error.textContent = "A string containing only alphabets, numbers, '.' and '-', then followed by '@localhost'";
	} else {
		error.textContent = ""; // Clear the error message
	}
	return error.textContent;
}

function chkContactHp() {
	// 8 digits. 
	var content = document.getElementById("contactPhone").value.trim();
	var error = document.getElementById("hpError");
	var pattern = /^[0-9]{8}$/; 
	
	if (!pattern.test(content)) {
		error.textContent = "Exactly 8 digits";
	} else {
		error.textContent = ""; // Clear the error message		
	}
	return error.textContent;
}

function chkContactComment() {
	// Not empty. 
	var content = document.getElementById("contactComment").value.trim();
	var error = document.getElementById("commentError");
	if (content.length == 0) {
		error.textContent = "Comment should not be empty. ";
	} else {
		error.textContent = ""; // Clear the error message		
	}
	return error.textContent;
}


function commentSubmit(){
	var nameInput = document.getElementById("contactName");
	var nameError = document.getElementById("nameError");
	var emailInput = document.getElementById("contactEmail");
	var emailError = document.getElementById("emailError");
	var hpInput = document.getElementById("contactPhone");
	var hpError = document.getElementById("hpError");
	var commentInput = document.getElementById("contactComment");
	var commentError = document.getElementById("commentError");
	chkContactName();
	chkContactEmail();
	chkContactHp();
	chkContactComment();
	if (nameError.textContent.length) {
		alert("Please check your username format.");
		nameInput.focus();
		nameInput.select();
	}
	else if (hpError.textContent.length) {
		alert("Please check your phone number.");
		hpInput.focus();
		hpInput.select();
	}
	else if (emailError.textContent.length) {
		alert("Please check your Email format.");
		emailInput.focus();
		emailInput.select();
	}
	else if (commentError.textContent.length) {
		alert("Please check your comment.");
		commentInput.focus();
		commentInput.select();
	}
	else {
		document.getElementById("commentForm").submit();
	}
}