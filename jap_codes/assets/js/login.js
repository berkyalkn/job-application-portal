document.getElementById('login-form').addEventListener('submit', function(event) {
    event.preventDefault(); 

    
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const role = document.getElementById('role').value;

    const formData = new FormData();
    formData.append('username', username);
    formData.append('password', password);
    formData.append('role', role);
    

    fetch('../../pages/login/login.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        
        const errorContainer = document.getElementById('error-message');
        const linksContainer = document.querySelector('.links'); 

        if (data.error) {
            errorContainer.textContent = data.error;
            errorContainer.style.display = 'block';
            linksContainer.style.marginTop = '10px'; 
        } else if (data.success) {
            if (data.role === 'admin') {
                window.location.href = '../../pages/admin_dashboard/admin_dashboard.php';
            } else if (data.role === 'employer') {
                window.location.href = '../../pages/employer_dashboard/employer_dashboard.html';
            } else if (data.role === 'job_seeker') {
                window.location.href = '../../pages/jobseeker_dashboard/jobseeker_dashboard.html';
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
