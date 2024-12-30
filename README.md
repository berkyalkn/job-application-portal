# Job Application Portal - Project

## Project Overview
This project is a web-based Job Application Portal that connects job seekers with employers. It allows users to apply for jobs, create job listings, and manage their profiles. The portal is designed to be simple, user-friendly, and efficient.

## Features
### Common Features for All Users
- **User Registration and Login**: Users can register by providing basic information such as name, email, and password. They can then log in to access relevant features based on their roles (Job Seeker, Employer, or Admin).
- **Password Reset**: Users can reset their password if they forget it by receiving a password reset link through email.

### Job Seeker Features
- **Search Jobs**: Job seekers can search for jobs using various filters such as job title, job type, location, etc.
- **Job Seeker Dashboard**: Job seekers can view applied jobs, search for jobs, and manage their profile.
- **View Applications**: Job seekers can view the jobs they have applied for.
- **Profile Management**: Job seekers can manage and update their profile information.

### Employer Features
- **Employer Dashboard**: Employers can manage posted jobs, view applicants, and update their profile.
- **Posting a Job**: Employers can post new job listings with details such as title, description, salary, location, etc.
- **Manage Jobs**: Employers can view, edit, or delete their posted job listings.
- **View Applicants**: Employers can view job applications submitted for their job listings.
- **Profile Management**: Employers can manage and update their profile information.

### Admin Features
- **Admin Dashboard**: Admins can manage job seekers and employers and view system statistics.
- **Manage Job Seekers**: Admins can view and edit job seekers' information.
- **Manage Employers**: Admins can view and edit employers' information.

## Technologies Used
- **Frontend**: HTML, CSS, JavaScript, jQuery
- **Backend**: PHP
- **Database**: MySQL
- **Server**: MAMP or XAMPP

## Database Structure
The project uses the following database tables:
- **users**: Stores user details (user_id, username, password, email, role, first_name, last_name, gender, date_of_birth, phone_number, country, city).
- **applications**: Stores job applications (application_id, job_id, username, application_date).
- **jobs**: Stores job listings (job_id, title, employer_name, location, job_type, description, salary_range, application_deadline, posted_date, industry, benefits).

## System Requirements
- XAMPP or MAMP installed
- PHP version 7.0 or higher
- MySQL database setup

## Setup Instructions

### Installation
1. Install XAMPP or MAMP and start the Apache and MySQL services.
2. Create a new database named `group1`.
3. Import the `group1.sql` file into the database via PhpMyAdmin.
4. Place the project files in the `htdocs` directory (for XAMPP) or the appropriate folder for MAMP.
5. Update the `config.php` file with the correct database connection details.

### Usage
Once the setup is complete, you can access the portal by opening `localhost` in your web browser. The following features will be available:
- User Registration and Login
- Search and Apply for Jobs (Job Seekers)
- Create and Manage Job Listings (Employers)
- Admin Dashboard for Managing Users

## License
This project is open-source and available under the MIT License.

## Author
**Berkay Alkan**
