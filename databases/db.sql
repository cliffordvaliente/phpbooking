/* ________________________________________________________
 
 HOW TO LOGIN VIA TERMINAL IN MACOS MAMP
 
 / Applications / MAMP / Library / bin / mysql - uroot - p
 
 PASSWORD: ROOT 
 
 ___________________________________________________________
 */
CREATE TABLE
  Users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('Student', 'Assistant') NOT NULL,
    experience TEXT,
    specialization VARCHAR(255),
    availability TEXT
  );


CREATE TABLE
  Courses (
    course_id INT AUTO_INCREMENT PRIMARY KEY,
    course_name VARCHAR(255) NOT NULL,
    description TEXT
  );


CREATE TABLE
  Guidance_Sessions (
    session_id INT AUTO_INCREMENT PRIMARY KEY,
    assistant_id INT,
    course_id INT,
    length INT,
    session_theme VARCHAR(255),
    FOREIGN KEY (assistant_id) REFERENCES Users(user_id) ON DELETE
    SET
      NULL,
      FOREIGN KEY (course_id) REFERENCES Courses(course_id) ON DELETE
    SET
      NULL
  );


CREATE TABLE
  Messages (
    message_id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT NOT NULL,
    recipient_id INT NOT NULL,
    message_text TEXT NOT NULL,
    mread BOOLEAN,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES Users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (recipient_id) REFERENCES Users(user_id) ON DELETE CASCADE
  );


CREATE TABLE
  Student_Courses (
    student_id INT,
    course_id INT,
    PRIMARY KEY (student_id, course_id),
    FOREIGN KEY (student_id) REFERENCES Users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES Courses(course_id) ON DELETE CASCADE
  );


CREATE TABLE
  Assistant (
    assistant_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    additional_info TEXT,
    FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE
  );


CREATE TABLE
  Students (
    student_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    additional_info TEXT,
    FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE
  );