window.addEventListener('DOMContentLoaded', (event) => {
  const facultyIdInput = document.querySelector('input[name="fid"]');
  const emailInput = document.querySelector('input[name="fmail"]');
  const passwordInput = document.querySelector('input[name="fpass"]');
  const errorFacultyId = document.querySelector('#error-faculty-id');
  const errorEmail = document.querySelector('#error-email');
  const errorPassword = document.querySelector('#error-password');

  const form = document.querySelector('#signupform');

  facultyIdInput.addEventListener('input', validateFacultyId);
  emailInput.addEventListener('input', validateEmail);
  passwordInput.addEventListener('input', validatePassword);

  form.addEventListener('submit', (event) => {
    event.preventDefault(); // Prevent the form from submitting by default

    // Check if all conditions are satisfied
    if (validateFacultyId() && validateEmail() && validatePassword()) {
      form.submit(); // Submit the form
    }
  });

  function validateFacultyId() {
    const facultyId = facultyIdInput.value;
    if (facultyId.length !== 6) {
      errorFacultyId.textContent = 'Faculty ID should be 6 digits.';
      return false;
    } else {
      errorFacultyId.textContent = '';
      return true;
    }
  }

  function validateEmail() {
    const email = emailInput.value;
    const emailRegex = /^[^\s@]+@gmail\.com$/i;
    if (!emailRegex.test(email)) {
      errorEmail.textContent = 'Email should be a valid Gmail address.';
      return false;
    } else {
      errorEmail.textContent = '';
      return true;
    }
  }

  function validatePassword() {
    const password = passwordInput.value;
    let errorMessages = [];
  
    if (password.length < 8) {
      errorMessages.push('Password should have length >= 8');
    }
  
    if (!/[A-Z]/.test(password)) {
      errorMessages.push('Password should contain one [A-Z]');
    }
  
    if (!/\d/.test(password)) {
      errorMessages.push('Password should contain one digit');
    }
  
    if (!/[@$!%*#?&]/.test(password)) {
      errorMessages.push('Password should have one[!@#$&%]');
    }
  
    if (errorMessages.length > 0) {
      errorPassword.textContent = errorMessages[0];
      return false;
    } else {
      errorPassword.textContent = '';
      return true;
    }
  }
});
