
const passwordForm = document.getElementById('passwordForm');
const passwordError = document.getElementById('passwordError');

// Function to validate the password
function validatePassword(event) {
    event.preventDefault(); 

    const passwordInput = passwordForm.querySelector('input[name="newpass"]');
    const password = passwordInput.value;
    const cnfrmpasswordInput = passwordForm.querySelector('input[name="confirm_password"]');
    const cnfrmpassword = cnfrmpasswordInput.value;


    const constraintsRegex = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*]).{8,}$/;

    if (!constraintsRegex.test(password)) {
        passwordError.textContent = 'Password must meet the following requirements:';
        if (password.length < 8) {
            passwordError.textContent += ' At least 8 characters long,';
        }
        if (!/(?=.*[A-Z])/.test(password)) {
            passwordError.textContent += ' At least one capital letter,';
        }
        if (!/\d/.test(password)) {
            passwordError.textContent += ' At least one number,';
        }
        if (!/[!@#$%^&*]/.test(password)) {
            passwordError.textContent += ' At least one special character';
        }
        return false; 
    } else {
        if (password !== cnfrmpassword) {
            passwordError.textContent = 'Passwords don\'t match';
            return false; 
        } else {
            passwordError.textContent = '';
            passwordForm.submit(); 
            return true;
        }
    }
}

passwordForm.addEventListener('submit', validatePassword);
