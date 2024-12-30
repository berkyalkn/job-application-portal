document.getElementById('reset-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const email = document.getElementById('email').value;
    const errorMessage = document.getElementById('error-message');
    errorMessage.style.display = 'none';

    const formData = new FormData();
    formData.append('email', email);

    fetch('../../pages/reset_password/reset_password.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            errorMessage.textContent = data.error;
            errorMessage.style.display = 'block';
        } else if (data.success) {
            window.location.href = '../../pages/login/login.html'; 
        }
    })
    .catch(error => console.error('Error:', error));
});
