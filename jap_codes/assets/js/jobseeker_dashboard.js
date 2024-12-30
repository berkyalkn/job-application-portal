document.addEventListener('DOMContentLoaded', () => {
    fetch('../../pages/jobseeker_dashboard/jobseeker_dashboard.php')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error(data.error);
                window.location.href = "../../pages/login/login.html";
            } else {
                document.getElementById('welcome-message').textContent = `Welcome to your Job Seeker Dashboard, ${data.username}`;
            }
        })
        .catch(error => console.error('Error:', error));
});


document.getElementById('logout-btn').addEventListener('click', () => {
            window.location.href = "../../pages/login/login.html";
        })

