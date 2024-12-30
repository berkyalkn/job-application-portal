document.getElementById('search-btn').addEventListener('click', function() {
    const searchInput = document.getElementById('search-input').value;
    const filterType = document.getElementById('filter-type').value;

    fetch(`../../pages/search/search.php?search=${encodeURIComponent(searchInput)}&type=${encodeURIComponent(filterType)}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();  
        })
        .then(text => {
            try {
                const data = JSON.parse(text);
                const resultsDiv = document.getElementById('results');
                resultsDiv.innerHTML = ''; 
                if (data.length === 0) {
                    resultsDiv.innerHTML = '<p>No jobs found for your search criteria</p>';
                } else {
                    data.forEach(job => {
                        resultsDiv.innerHTML += `
                            <div class="job">
                                <h2>${job.title}</h2>
                                <p>${job.description}</p>
                                <p><strong>Company:</strong> ${job.employer_name}</p>
                                <p><strong>Location:</strong> ${job.location}</p>
                                <p><strong>Type:</strong> ${job.job_type}</p>
                                <p><strong>Salary Range:</strong> ${job.salary_range}</p>
                                <p><strong>Application Deadline:</strong> ${job.application_deadline}</p>
                                <p><strong>Industry:</strong> ${job.industry}</p>
                                <p><strong>Benefits:</strong> ${job.benefits}</p>
                                <button class="apply-btn" data-job-id="${job.job_id}">Apply</button>
                            </div>`;
                    });

                    document.querySelectorAll('.job').forEach(job => {
                        job.style.margin = '20px 0';
                        job.style.padding = '15px';
                        job.style.border = '1px solid #ddd';
                        job.style.borderRadius = '10px';
                        job.style.boxShadow = '0 2px 5px rgba(0, 0, 0, 0.1)';
                    });
                    
                    document.querySelectorAll('.job h2').forEach(h2 => {
                        h2.style.color = '#333';
                        h2.style.marginBottom = '10px';
                    });
                    
                    document.querySelectorAll('.job p').forEach(p => {
                        p.style.color = '#555';
                        p.style.margin = '10px 0';
                    });
                    
                    document.querySelectorAll('.apply-btn').forEach(button => {
                        button.style.display = 'inline-block';
                        button.style.padding = '10px 20px';
                        button.style.backgroundColor = '#4CAF50';
                        button.style.color = 'white';
                        button.style.fontSize = '16px';
                        button.style.fontWeight = 'bold';
                        button.style.border = 'none';
                        button.style.borderRadius = '5px';
                        button.style.cursor = 'pointer';
                        button.style.transition = 'background-color 0.3s ease, transform 0.2s ease';
                    
                        button.addEventListener('mouseover', () => {
                            button.style.backgroundColor = '#45a049';
                            button.style.transform = 'scale(1.05)'; 
                        });
                    
                        button.addEventListener('mouseout', () => {
                            button.style.backgroundColor = '#4CAF50'; 
                            button.style.transform = 'scale(1)'; 
                        });
            
                        button.addEventListener('mousedown', () => {
                            button.style.backgroundColor = '#3e8e41'; 
                            button.style.transform = 'scale(1)'; 
                        });
                    
                        button.addEventListener('mouseup', () => {
                            button.style.backgroundColor = '#45a049'; 
                        });

                        button.addEventListener('click', function() {
                            const jobId = button.getAttribute('data-job-id');
                            const isApplied = button.getAttribute('data-applied') === 'true';
                            
                            if (isApplied) {
                                alert('You have already applied to this job.');
                            } else {
                            
                                fetch('../../pages/search/apply.php')
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            const username = data.username;
                        
                                            fetch('../../pages/search/apply.php', {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/x-www-form-urlencoded'
                                                },
                                                body: `username=${encodeURIComponent(username)}&job_id=${encodeURIComponent(jobId)}`
                                            })
                                            .then(response => response.json())
                                            .then(data => {
                                                if (data.success) {
                                                    alert('Application submitted successfully!');
                                                    button.setAttribute('data-applied', 'true');
                                                    button.disabled = true;
                                                    button.innerText = 'Already Applied';
                                                } else {
                                                    alert('An error occurred while applying.');
                                                }
                                            })
                                            .catch(error => {
                                                console.log(error);
                                            });
                                        } else {
                                            alert('User is not logged in');
                                        }
                                    })
                          .catch(error => {
                              console.log(error);
                          });
                        }
                  });
              });
                }
            } catch (error) {
                document.getElementById('results').innerHTML = `<p>Error parsing JSON: ${error.message}</p>`;
            }
        })
        .catch(error => {
            document.getElementById('results').innerHTML = `<p>Error fetching data: ${error.message}</p>`;
        });
});


document.getElementById('logout-btn').addEventListener('click', () => {
    window.location.href = "../../pages/login/login.html";
})


