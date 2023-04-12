
        function PasswordChange() {
    const password = document.getElementById("password").value;
    const passwordStrengthLabel = document.getElementById(
      "msg"
    );
  
  
      let strength = 0;
      if (password.length >= 8) {
        strength += 1;
      }
      if (password.match(/[a-z]/)) {
        strength += 1;
      }
      if (password.match(/[A-Z]/)) {
        strength += 1;
      }
      if (password.match(/[0-9]/)) {
        strength += 1;
      }
      if (password.match(/[!@#$%^&*()_+\-=[\]{};':"\\|,.<>/?]/)) {
        strength += 1;
      }
  
      if (password.length === 0) {
        passwordStrengthLabel.innerHTML = "";
      } else if (strength === 1) {
        passwordStrengthLabel.innerHTML = "Weak";
        passwordStrengthLabel.style.color = "red";
      } else if (strength === 2 || strength === 3) {
        passwordStrengthLabel.innerHTML = "Medium";
        passwordStrengthLabel.style.color = "Yellow";
      } else if (strength >= 4) {
        passwordStrengthLabel.innerHTML = "Strong";
        passwordStrengthLabel.style.color = "green";
      }
    }

