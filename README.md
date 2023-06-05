# Cateen Billing system

this new branches another change again again

## Project Idea
1. Canteen can login
2. Finance can login
3. Employee added by finance
4. Employee list with canteen
5. Entress requires date of entry and employee
6. Cateen can view user expenses with filter(date range, paid and unpiad)
7. Finance can also view expenses with filter(date range, paid and unpaid)
8. Finance can pay fee for employee
9. Report of how much is due and how much is paid

## Table structure
1. User
    -role(canteen{default} , admin, finance) {required}

2. Employee
    -employee_company_id(int) {required}
    -fname(string) {required}
    -lname(string) {required}
    -number(int) {requried}
    -email(string) {required}

3. Dish
    -name(string) {required}
    -price(int) {requried}

4. Expenses
    -employee_id{required}
     -employee_company_id{required}
    -dish_id{required}
    -dish_name{required}
    -quantity{required}
    -total{required}
    -user_id{required} filled by laravel
    -created_at(timestamp),{required}
    -status(unpaid{default} , paid) {required}  
    -status_changed_by_id  {nullable}
    -status_changed_by_name {nullable}

4. Expenses
    -employee_id{required}
    -dish{required}
    -quantity{required}
    -total{required}
    -user_id{required} filled by laravel
    -created_at(timestamp),{required}
    -status(unpaid{default} , paid) {required}  
    -status_changed_by_id  {nullable}

5. Employee_expenses
    -employee_id{required}
    -employee_name{required}
    -empoyee_company_id{required}
    -paid filled by laravel
    -pending filled by laravel
    -total filled by laravel

    



    