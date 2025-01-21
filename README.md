# ShowPick

**ShowPick** is a web-based platform designed to help users discover and explore films and series tailored to their interests. The system allows users to create accounts, log in,
and search for content by genre, name, or age classification. Users can view detailed information about films and series, including storylines, directors, release dates, genres,
and reviews. Additionally, users can leave reviews, mark favorites, and personalize their
experience for seamless content discovery.

## Features

- **Login Form**: 
  - Input fields for username and password.
  
- **Account Creation**: 
  - Fields for username, email, password, and password confirmation.
  
- **Design**:
  - Styled with a clean and modern design.
  - Search movies by title.
  - Filter results by age classification and genre.

- **Interactive Elements**:
  - Toggling between login and create account views.

- **Random films and series**:
  - 10 random films and series appear in the home page.

- **Logout Button **

- **Detail Page**:
  - Info about the films or series
  - Trailer
  - Button to add the films or series to the favorites
  - Comment field
  - Rating 

- **favorites Page**:
  - Display all your favorites films or series
   
## Technologies Used

- **HTML**: Structure and layout of the application.
- **CSS**: Custom styling for the forms and background.
- **JavaScript**: Dynamic toggling.
-  **PHP**: Link the database to website
-  **XAMPP**: To use apache to create local server and to use Mycql to create database 

## Usage

1.Login/Registration:
- Enter your credentials on the login page to log in.
- If you don’t have an account, click the "Register" link to create one.
  
2.Search Movies:
- Use the search bar to find movies by title.
-Apply filters for age classification and genre to refine results.

3.Interactive Buttons:
- Buttons and links provide smooth transitions between pages.


## How to Use


ShowPick Website Setup Guide
Introduction
 provides a step-by-step guide to set up the ShowPick website on your local machine using XAMPP.

Prerequisites

Download all file from github

Download and install XAMPP on your computer from this link https://www.apachefriends.org/download.html

Setup Instructions

1.Start Apache and MySQL:
- After successfully installing XAMPP, open the XAMPP Control Panel.
- Start the Apache and MySQL services by clicking the "Start" buttons for each.

2.Navigate to the `htdocs` folder:
- In the XAMPP Control Panel, click the Explorer button.
- Open the `htdocs` folder located within the XAMPP installation directory.


3.Manage project files:
- Delete all files currently in the `htdocs` folder.
- Copy and paste the project files downloaded from GitHub into the `htdocs` folder.


4.Create a new database:
- Go back to the XAMPP Control Panel and click Admin next to the MySQL service.
- This will open phpMyAdmin in your browser.
- Click New in the left sidebar to create a new database.
- you must Name the database as this "ShowPick" 


5.Import the SQL file:
- After creating the database, click on the database name (ShowPick) in the left sidebar.
- Go to the Import tab at the top.
- Click Choose File and select the SQL file associated with the project.
- Click the Go button to import the SQL file.
- Note: Ensure the required tables, such as user and movie, are created.


6.Run the website:
- Go back to the XAMPP Control Panel and click Admin next to the Apache service.
- This will open the website's home page in your browser (if the setup is correct).


7.Enjoy the website:
- Now you can explore and enjoy the website. Test its features to ensure everything is working properly. 


Troubleshooting
- Ports in Use: If Apache or MySQL fails to start, ensure no other applications (e.g., Skype) are using ports 80 or 443. Adjust the ports in the XAMPP settings if needed.
Database Connection Issues: Verify the database name and credentials in your website's configuration files.

- With this guide, you should be able to set up and run the ShowPick website successfully. If you encounter any issues, feel free to reach out!


## Future Improvements

- admin interface
- admin can add , edit and remove movies / series
- Admin can delete comments


