# This script is for populating the database with fake data for testing and development purposes only.


from faker import Faker
from datetime import datetime, timedelta
import random

fake = Faker()

professor_titles = ['Associate Professor', 'Assistant Professor', 'Engineering Professor', 'Comp Sci. Professor', 'English Professor', 'Ethics Professor']

# Generate random professors
professors = []
students = []
enrollment_records = []

for _ in range(10):
    # Generate SSN with exactly 9 digits
    ssn = fake.unique.random_number()
    while len(str(ssn)) != 9:
        ssn = fake.unique.random_number()

    name = fake.name()
    address_street = fake.street_address()
    address_city = fake.city()
    address_state = fake.state()
    address_zip_code = fake.zipcode()
    telephone_area_code = fake.random_int(min=100, max=999)
    telephone_number = fake.random_number(7)
    sex = fake.random_element(elements=('M', 'F'))
    title = random.choice(professor_titles)
    salary = round(random.uniform(50000, 150000), 2)
    college_degrees = fake.random_element(elements=('Ph.D.', 'Masters', 'Bachelors'))

    # Print the SQL insert statement for professors
    print(f"INSERT INTO Professors VALUES ('{ssn}', '{name}', '{address_street}', '{address_city}', "
          f"'{address_state}', '{address_zip_code}', '{telephone_area_code}', '{telephone_number}', "
          f"'{sex}', '{title}', {salary}, '{college_degrees}');")

    professors.append({'SSN': ssn})


# Generate random departments with existing chairpersons
department_names = ['Biology', 'Computer Science', 'Engineering', 'Ethics', 'Mathematics', 'Chemistry', 'Physics']

for i in range(1, 10):
    department_number = i
    name = random.choice(department_names)
    telephone = fake.random_number(10)
    office_location = fake.street_address()

    # Ensure chairperson exists in Professors table
    chairperson_ssn = random.choice([professor['SSN'] for professor in professors])

    print(f"INSERT INTO Departments VALUES ({department_number}, '{name}', '{telephone}', '{office_location}', '{chairperson_ssn}');")


# List of real course titles
course_titles = [
    'Introduction to Programming',
    'Calculus 1',
    'Calculus 2',
    'Mechanics',
    'Operating Systems',
    'Organic Chemistry',
    'Digital Circuits',
    'Object Oriented Programming',
]

for i in range(1, 10):  # Generating data for 8 courses
    course_number = i
    title = random.choice(course_titles)
    textbook_number = random.randint(1, 1000)
    textbook = f"Textbook {textbook_number}"
    units = random.randint(1, 4)
    department_offering = random.randint(1, 7)

    print(f"INSERT INTO Courses VALUES ({course_number}, '{title}', '{textbook}', {units}, {department_offering});")



total_courses = 8

# Generate random prerequisites
for i in range(1, 10):
    course_number = i
    prerequisite_course_number = random.randint(1, total_courses)

    print(f"INSERT INTO Prerequisites VALUES ({course_number}, {prerequisite_course_number});")


total_courses = 8

# Generate random sections
room_names = [f"Room {i}{chr(65 + i % 26)}" for i in range(1, 101)]  # Generate room names

meeting_days_options = [['M', 'W'], ['T', 'Th']]

# Define start times and calculate end times
start_times = ['08:00', '09:15', '10:30', '12:00', '13:15', '14:30', '15:00', '16:15']
end_times = [(datetime.strptime(start, '%H:%M') + timedelta(minutes=75)).strftime('%H:%M') for start in start_times]

for i in range(1, 20):
    section_number = i
    course_number = random.randint(1, total_courses)  # Ensure it falls within the range of valid CourseNumber values
    professor_ssn = random.choice([professor['SSN'] for professor in professors])
    classroom = random.choice(room_names)
    seats = random.randint(20, 50)

    # Choose either M/W or T/Th
    selected_days = random.choice(meeting_days_options)

    # Select a random start time
    start_time = random.choice(start_times)
    
    # Calculate end time based on start time
    end_time = end_times[start_times.index(start_time)]

    meeting_days = ''.join(selected_days)  # Define meeting_days here

    print(f"INSERT INTO Sections VALUES ({section_number}, {course_number}, '{professor_ssn}', '{classroom}', {seats}, '{meeting_days}', '{start_time}', '{end_time}');")



# Generate random students
num_students = 200
campus_wide_ids = set()

for _ in range(num_students):
    while True:
        campus_wide_id = fake.unique.random_number(digits=9)
        if campus_wide_id not in campus_wide_ids:
            campus_wide_ids.add(campus_wide_id)
            break

for i, student_id in enumerate(campus_wide_ids, start=1):
    first_name = fake.first_name()
    last_name = fake.last_name()
    address = fake.street_address()
    telephone_area_code = fake.random_int(min=100, max=999)
    telephone_number = fake.random_number(7)
    major = random.randint(1, 7) 
    minor = random.randint(1, 7) 

    print(f"INSERT INTO Students VALUES ('{student_id}', '{first_name}', '{last_name}', '{address}', "
          f"'{telephone_area_code}', '{telephone_number:07}', {major}, {minor});")

    students.append({'CampusWideID': student_id})


# Generate random enrollment records
for i, student_id in enumerate(campus_wide_ids, start=1):
    course_section_number = random.randint(1, 10)  # Assuming 10 course sections
    grade = random.choice(['A', 'A-', 'A+', 'B', 'B-', 'B+', 'C', 'C-', 'C+', 'D', 'F'])

    # Check if the enrollment record already exists for the student and course section
    existing_record = next((record for record in enrollment_records if record['StudentID'] == student_id and record['CourseSectionNumber'] == course_section_number), None)

    if existing_record:
        # Update the grade for the existing record
        existing_record['Grade'] = grade
        print(f"UPDATE EnrollmentRecords SET Grade = '{grade}' WHERE StudentID = '{student_id}' AND CourseSectionNumber = {course_section_number};")
    else:
        print(f"INSERT INTO EnrollmentRecords VALUES ('{student_id}', {course_section_number}, '{grade}');")
        enrollment_records.append({'StudentID': student_id, 'CourseSectionNumber': course_section_number, 'Grade': grade})