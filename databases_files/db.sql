CREATE TABLE
  Users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('Teacher', 'Student', 'Assistant') NOT NULL,
    experience TEXT,
    specialization VARCHAR(255),
    availability TEXT
  );


CREATE TABLE
  Students_Profile (
    student_id INT,
    classroom VARCHAR(100),
    subjects TEXT,
    PRIMARY KEY (student_id),
    FOREIGN KEY (student_id) REFERENCES Users(user_id) ON DELETE CASCADE
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
    teacher_id INT,
    course_id INT,
    length INT,
    session_theme VARCHAR(255),
    FOREIGN KEY (teacher_id) REFERENCES Users(user_id) ON DELETE
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
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES Users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (recipient_id) REFERENCES Users(user_id) ON DELETE CASCADE
  );