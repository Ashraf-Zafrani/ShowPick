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
Download and install XAMPP on your computer.
Setup Instructions

1.Install XAMPP
Download XAMPP from the official website.
Follow the installation instructions specific to your operating system.

2.Move Project Files
Navigate to the installation directory of XAMPP (e.g., C:\xampp on Windows).
Place the website files in the htdocs directory.

3.Start XAMPP Services
Open the XAMPP control panel.
Start the Apache and MySQL modules.

4.Access MySQL Admin Panel
In the XAMPP control panel, click the Admin button next to MySQL.
This opens the phpMyAdmin interface in your browser.

5.Create a Database
In phpMyAdmin:
Click New in the left sidebar.
Name the database ShowPick.
Click Create.

6.Create Tables
Open the SQL tab in phpMyAdmin.
Run the following SQL commands to create the required tables.
Users Table:
sql
Copy code
```
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

Movies Table:
sql
Copy code
```
CREATE TABLE movies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    genre VARCHAR(50) NOT NULL,
    age_class VARCHAR(20) NOT NULL,
    image_url VARCHAR(255)
);
```

7.Insert Movie Data
Use the SQL tab in phpMyAdmin to run the following command and populate the movies table:
sql
Copy code
```
INSERT INTO movies (title, genre, age_class, image_url)
VALUES
-- Action
('The Dark Knight', 'action', 'adult', 'Posters/dark-knight.jpg'),
('Avengers: Endgame', 'action', 'adult', 'Posters/avengers-endgame.jpg'),
('Mad Max: Fury Road', 'action', 'adult', 'Posters/mad-max.jpg'),
('John Wick', 'action', 'adult', 'Posters/john-wick.jpg'),
('Spider-Man: Into the Spider-Verse', 'action', 'kids', 'Posters/spider-verse.jpg'),

-- Comedy
('Finding Nemo', 'comedy', 'kids', 'Posters/finding-nemo.jpg'),
('Shrek', 'comedy', 'kids', 'Posters/shrek.jpg'),
('The Hangover', 'comedy', 'adult', 'Posters/hangover.jpg'),
('Superbad', 'comedy', 'adult', 'Posters/superbad.jpg'),
('Toy Story', 'comedy', 'kids', 'Posters/toy-story.jpg'),

-- Horror
('The Conjuring', 'horror', 'adult', 'Posters/conjuring.jpg'),
('A Quiet Place', 'horror', 'adult', 'Posters/a-quiet-place.jpg'),
('It', 'horror', 'adult', 'Posters/it.jpg'),
('Coraline', 'horror', 'kids', 'Posters/coraline.jpg'),
('The Ring', 'horror', 'adult', 'Posters/ring.jpg'),

-- Drama
('Breaking Bad', 'Drama', 'adult', 'Posters/breaking-bad.jpg'),
('The Crown', 'Drama', 'adult', 'Posters/the-crown.jpg'),
('Forrest Gump', 'Drama', 'adult', 'Posters/forrest-gump.jpg'),
('The Pursuit of Happyness', 'Drama', 'adult', 'Posters/pursuit-of-happyness.jpg'),
('Coco', 'Drama', 'kids', 'Posters/coco.jpg'),

-- Romance
('The Notebook', 'romance', 'adult', 'Posters/the-notebook.jpg'),
('Titanic', 'romance', 'adult', 'Posters/titanic.jpg'),
('Pride and Prejudice', 'romance', 'adult', 'Posters/pride-and-prejudice.jpg'),
('Beauty and the Beast', 'romance', 'kids', 'Posters/beauty-and-beast.jpg'),
('The Fault in Our Stars', 'romance', 'adult', 'Posters/fault-in-our-stars.jpg');
```
8.Launch the Website
Go back to the XAMPP control panel.
Click the Admin button next to Apache.
This will open the local server in your default browser.
Navigate to the folder where your files are stored .

Troubleshooting
- Ports in Use: If Apache or MySQL fails to start, ensure no other applications (e.g., Skype) are using ports 80 or 443. Adjust the ports in the XAMPP settings if needed.
Database Connection Issues: Verify the database name and credentials in your website's configuration files.

- With this guide, you should be able to set up and run the ShowPick website successfully. If you encounter any issues, feel free to reach out!


## Future Improvements

- Make user Leave a Reviews
- Add favorite section
- Show details about film or series


