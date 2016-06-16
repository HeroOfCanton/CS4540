
I have 5 tests:

1- BasicAdvisorLoginTest
  This test checks to make sure that basic login is possible, by logging in with an advisor login, and then asserting that they are dropped onto the advisor homepage, via URL, which isn't accessible unless you are logged in as an advisor.

2- NoAuthTest
  This test just checks to make sure that someone can't access the DGS Homepage by asserting they are dropped onto the unauth page via URL.

3- NewUserTest **THIS TEST CAN ONLY BE RUN ONCE**
  This test asserts that a new user is added to the database by asserting the success message appears on the page. This test can only be run once, as continued attempts will result in a different message being shown (regarding duplicate entry errors in MySQL). If you'd like to run it more than once, you'll need to login into my Grad_Prog_V5 DB and delete the user from the Users Table

4- AddUserFormVerifyTest **THIS TEST CAN ONLY BE RUN ONCE**
  This test asserts that a new user is added to the database by asserting the success message appears on the page. Then the user is logged in, and a new Progress form is created for them. Then we go back to the student's list of forms and assert that the information entered is correct, and that the user's information is correct. This test can only be run once, else duplicate user errors on the new user page will cause test to fail. If you'd like to run it more than once, you'll need to login into my Grad_Prog_V5 DB and delete the user from the Users Table, and their Progress forms from the Progress Table.
  
5- AddStudentCheckAdvisor 
  This test relies upon test #4 having being run. It logs in as an advisor and asserts that the user from test #4 has been added to the list of students that are under this advisor. 
  
I feel this represents Good work, as it visits multiple pages, and checks to make sure that entered data matches what is retreived from the database in the forms.
