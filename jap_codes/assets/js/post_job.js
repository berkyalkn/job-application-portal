document.querySelector('form').addEventListener('submit', function(e) {
    let title = document.querySelector('#title').value;
    if (title.trim() === '') {
        alert('Job title is required!');
        e.preventDefault();
    }
});

document.getElementById('logout-btn').addEventListener('click', () => {
    window.location.href = "../../pages/login/login.html";
});



