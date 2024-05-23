CREATE TABLE teachers (
    teacher_id INT PRIMARY KEY,
    user_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    user_password VARCHAR(255) NOT NULL,
	user_role varchar(1)
);

CREATE TABLE courses (
    course_id varchar(255) PRIMARY KEY,
    course_name VARCHAR(100) NOT NULL,
    teacher_id INT,
    FOREIGN KEY (teacher_id) REFERENCES teachers(teacher_id)
);

CREATE TABLE students (
    student_id INT PRIMARY KEY,
    user_name VARCHAR(100) NOT NULL,
    course_id varchar(255),
    email varchar(100) not null unique,
	user_password VARCHAR(255) NOT NULL,
    user_role varchar(1),
    FOREIGN KEY (course_id) REFERENCES courses(course_id)
);