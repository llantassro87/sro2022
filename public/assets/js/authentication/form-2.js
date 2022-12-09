var togglePassword = document.getElementById("toggle-password");
var togglePasswordConfirm = document.getElementById("toggle-password-confirm");
var formContent = document.getElementsByClassName('form-content')[0]; 
var getFormContentHeight = formContent.clientHeight;

var formImage = document.getElementsByClassName('form-image')[0];
if (formImage) {
	var setFormImageHeight = formImage.style.height = getFormContentHeight + 'px';
}
if (togglePassword || togglePasswordConfirm) {
	togglePassword.addEventListener('click', function() {
	  var x = document.getElementById("password");
	  var y = document.getElementById("password_confirm");
	  if (x.type === "password" || y.type === "password") {
		x.type = "text";
		y.type = "text";
	  } else {
	    x.type = "password";
		y.type = "password";
	  }
	});

	togglePasswordConfirm.addEventListener('click', function() {
		var x = document.getElementById("password");
		var y = document.getElementById("password_confirm");
		if (x.type === "password" || y.type === "password") {
		  x.type = "text";
		  y.type = "text";
		} else {
		  x.type = "password";
		  y.type = "password";
		}
	  });
}
