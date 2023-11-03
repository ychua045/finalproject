function chkName() {
	// Username should be 1 to 20 characters long, containing a-z A-Z 0-9 
}


function chkEmail() {
	// Email format: 
	var emailInput = document.getElementById("memEmail");
	var emailError = document.getElementById("emailError");
	var email = emailInput.value.trim();
	var emailPattern = /^[a-zA-Z0-9.-]+@[\w]+(\.[a-zA-Z0-9]+){0,2}\.[a-zA-Z]{1,3}$/;

	if (!emailPattern.test(email)) {
		emailError.textContent = "Invalid email format";
		return false;
	} else {
		emailError.textContent = ""; // Clear the error message
		return true;
	}
}


function chkPassword() {
    // Password format: 8 to 20 characters which contain at least one lowercase letter, one uppercase letter, one numeric digit, and one special character.
	var passwordInput = document.getElementById("memPassword");
	var passwordError = document.getElementById("passwordError");
	var passwords = passwordInput.value.trim();
	var passwordPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,20}$/;

	if (!passwordPattern.test(passwords)) {
		passwordError.textContent = "Invalid password format";
		return false;
	} else {
		passwordError.textContent = ""; // Clear the error message
		return true;
	}    
}

function chkHp() {
	
}
function chkCard() {
	
}

function loginSubmit(){
	if (chkEmail() && chkPassword()) {
		document.getElementById("LoginForm").submit();
	}
}


