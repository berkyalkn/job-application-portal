document.getElementById('register-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const username = document.getElementById('username').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    const role = document.getElementById('role').value;

    const errorContainer = document.getElementById('error-message');
    const successContainer = document.getElementById('success-message');


    errorContainer.style.display = 'none';
    successContainer.style.display = 'none';

    if (username === '' || email === '' || password === '' || confirmPassword === '') {
        errorContainer.textContent = 'Please fill in all fields.';
        errorContainer.style.display = 'block';
        return;
    }

    if (password !== confirmPassword) {
        errorContainer.textContent = 'Passwords do not match!';
        errorContainer.style.display = 'block';
        return;
    }

    const formData = new FormData();
    formData.append('username', username);
    formData.append('email', email);
    formData.append('password', password);
    formData.append('role', role);

    fetch('../../pages/register/register.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            errorContainer.textContent = data.error;
            errorContainer.style.display = 'block';
        } else if (data.success) {
            successContainer.textContent = data.success;
            successContainer.style.display = 'block';
            setTimeout(() => {
                window.location.href = '../../pages/login/login.html';
            }, 2000);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
