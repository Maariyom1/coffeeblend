
## Task 1

# print('--------------------')
# print(f'\nStudent Result Averager')
#
# # Stores the first name of the student in the first_name var
# first_name = input('\nEnter your first name: ')
#
# # Stores the middle name of the student in the middle_name var
# middle_name = input('Enter your middle name: ')
#
# # Stores the last name of the student in the last_name var
# last_name = input('Enter your last name: ')

# Stores the full name of the student in a student_name var
# student_name = f'{first_name} {middle_name} {last_name}'

student_name = input('Enter your name: ')

# Stores the age of the student in an age var
age = int(input('Enter your age: '))

# Store the subject scores of Mathematics, English and Physics in the score1, score2 and score3 var respectively
print(f'\n{student_name}, please enter the scores for:')
score1 = float(input(f'Mathematics: '))
score2 = float(input(f'English: '))
score3 = float(input(f'Physics: '))

# List of the three scores in the scores var
scores = [
    score1,
    score2,
    score3
]

# Average score is gotten by this formular: total scores / number of list
average_score = round(sum(scores) / len(scores), 2)

# print(f'\nYour name: {student_name}; Age: {age}. Your average score is: {average_score}')

## Task 2
# ----- Task Details -----
# ***** Assign Multiple Values with Operations *****
# • In one line of code, assign the values to three variables a, b, and c where:
#
# 1. var(a) is equal to the sum of the first two scores from the scores list.
# 2. b is equal to the product of the first and last score in the scores list.
# 3. c is equal to the difference between the second score and the first score.

# Sum of the first and second scores, Product of the first and third scores, Difference of the second and first scores
a, b, c = scores[0] + scores[1], scores[0] * scores[2], scores[1] - scores[0]


## Task 3
# ----- Task  Details -----
# ***** Use of Boolean Variables *****
# Create two boolean variables:
#
# 1. passed : Set this to True if the average_score is greater than or equal to 50, otherwise
# False .
# 2. is_adult: Set this to True if age is 18 or above, otherwise False.

# passed set to a str
passed = ""
if average_score >= 50:
    passed = True
else:
    passed = False

# is_adult set to an int
is_adult = int()
if age >= 18:
    is_adult = True
else:
    is_adult = False

# Average Score grade
grade = ""
if average_score >= 90:
    grade = 'A'
elif average_score >= 70:
    grade = 'B'
elif average_score >= 50:
    grade = 'C'
elif average_score >= 30:
    grade = 'D'
elif average_score >= 10:
    grade = 'E'
else:
    grade = 'F'

## Task 4
# ----- Task Details -----
# ***** Nested Conditional Logic and String Formatting *****
# - Using nested conditional logic, display a message that meets the following criteria:
#   1. If the student has passed (passed is True):
#      • Check the age:
#        • If the student is an adult (is_adult is True), print a message congratulating the adult student for passing.
#        • If the student is not an adult (is_adult is False), print a message congratulating the younger student for passing.
#   2. If the student has failed (passed is False):
#      • Check the age:
#        • If the student is an adult, print a message encouraging the adult student to try again.
#        • If the student is not an adult, print a message encouraging the younger student to keep learning.

# - Use advanced string formatting to include student_name, age, and average_score in your message.
if passed:
    if is_adult:
        print("\n----- Adult Student Information -----")
        print(f"Name: {student_name}, Age: {age}, Average Score: {average_score}, Grade: {grade}. Congratulations on passing your tests.")
    else:
        print("\n-----Adult Student Information-----")
        print(f"Name: {student_name}, Age: {age}, Average Score: {average_score}, Grade: {grade}.  Congratulations on passing your tests.")
else:
    if is_adult:
        print("\n----- Young Student Information -----")
        print(f"Name: {student_name}, Age: {age}, Average Score: {average_score}, Grade: {grade}. You are encouraged to try again.")
    else:
        print("\n-----Young Student Information-----")
        print(f"Name: {student_name}, Age: {age}, Average Score: {average_score}, Grade: {grade}. You are encouraged to keep learning.")


## Task 5
# ***** Reassign and Manipulate Variables Using Conditions *****
# - Reassign new values to a, b, and c using the following complex logic:
#
#   1. If the average_score is above 90, multiply a by 2.
#   2. If the average_score is between 70 and 90 (inclusive), increment b by 15.
#   3. If the average_score is below 50 and the student is an adult, subtract 20 from c. Otherwise,
#   if the student is not an adult, add the second score in scores to c.
if average_score > 90:
    a *= 2
elif average_score >= 70 or average_score >= 90:
    b += 15
elif average_score < 50 and is_adult == True:
    c -= 20
elif not is_adult:
    c = b + c

print(f'\n{student_name}, your manipulated score for a is: {a}, for b is: {b} and for c: {c}')
