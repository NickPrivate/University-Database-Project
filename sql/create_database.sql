-- SQL Database used for this project

-- Professors Table
CREATE TABLE Professors (
    SSN VARCHAR(9) PRIMARY KEY,
    Name VARCHAR(100),
    Address_Street VARCHAR(100),
    Address_City VARCHAR(50),
    Address_State VARCHAR(50),
    Address_ZipCode VARCHAR(20),
    Telephone_AreaCode VARCHAR(10),
    Telephone_Number VARCHAR(20),
    Sex CHAR(1),
    Title VARCHAR(50),
    Salary DECIMAL(10, 2),
    CollegeDegrees VARCHAR(100)
);

-- Departments Table
CREATE TABLE Departments (
    DepartmentNumber INT PRIMARY KEY,
    Name VARCHAR(50),
    Telephone VARCHAR(20),
    OfficeLocation VARCHAR(100),
    ChairpersonSSN VARCHAR(20),
    FOREIGN KEY (ChairpersonSSN) REFERENCES Professors(SSN)
    
);

-- Courses Table
CREATE TABLE Courses (
    CourseNumber INT PRIMARY KEY,
    Title VARCHAR(100),
    Textbook VARCHAR(100),
    Units INT,
    DepartmentOffering INT,
    FOREIGN KEY (DepartmentOffering) REFERENCES Departments(DepartmentNumber)
    
);

-- Prerequisites Table
CREATE TABLE Prerequisites (
    CourseNumber INT,
    PrerequisiteCourseNumber INT,
    PRIMARY KEY (CourseNumber, PrerequisiteCourseNumber),
    FOREIGN KEY (CourseNumber) REFERENCES Courses(CourseNumber),
    FOREIGN KEY (PrerequisiteCourseNumber) REFERENCES Courses(CourseNumber)
);

-- Sections Table
CREATE TABLE Sections (
    SectionNumber INT PRIMARY KEY,
    CourseNumber INT,
    ProfessorSSN VARCHAR(20),
    Classroom VARCHAR(50),
    Seats INT,
    MeetingDays VARCHAR(10),
    BeginningTime TIME,
    EndingTime TIME,
    FOREIGN KEY (CourseNumber) REFERENCES Courses(CourseNumber),
    FOREIGN KEY (ProfessorSSN) REFERENCES Professors(SSN)
  
);

-- Students Table
CREATE TABLE Students (
    CampusWideID VARCHAR(20) PRIMARY KEY,
    FirstName VARCHAR(50),
    LastName VARCHAR(50),
    Address VARCHAR(100),
    Telephone_AreaCode VARCHAR(10),
    Telephone_Number VARCHAR(20),
    Major INT,
    Minor INT,
    FOREIGN KEY (Major) REFERENCES Departments(DepartmentNumber),
    FOREIGN KEY (Minor) REFERENCES Departments(DepartmentNumber)
    
);

-- Enrollment Records Table
CREATE TABLE EnrollmentRecords (
    StudentID VARCHAR(20),
    CourseSectionNumber INT,
    Grade VARCHAR(5),
    PRIMARY KEY (StudentID),
    FOREIGN KEY (StudentID) REFERENCES Students (CampusWideID)
);