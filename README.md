# Bincom ICT Software Developer Assessment

A PHP and MySQL web application developed as part of the Bincom ICT Software Developer Assessment. The application processes election results from polling units and provides result aggregation at the Local Government Area (LGA) level.

## Features

### Question 1 - Individual Polling Unit Results
- View election results for a selected polling unit.
- User-friendly chained dropdowns (LGA → Ward → Polling Unit).
- Displays results for all political parties in the selected polling unit.

### Question 2 - LGA Result Summary
- Select any Local Government Area.
- Automatically calculates and displays the total votes for each political party by summing all polling unit results within the selected LGA.
- Results are generated dynamically without using the `announced_lga_results` table as required.

### Question 3 - Add New Polling Unit Results
- Add a new polling unit.
- Record election scores for all political parties.

---

## Technologies Used

- PHP (Procedural)
- MySQL
- JavaScript
- Bootstrap 5
- HTML5

---

## Database

Import the provided database before running the application.

Database file:

```
bincom_test.sql
```

---

## Installation

1. Clone the repository

```bash
git clone https://github.com/Aidenshalom/bincom.git
```

2. Import `bincom_test.sql` into MySQL.

3. Configure your database connection.

```php
$con = mysqli_connect(
    "localhost",
    "username",
    "password",
    "bincom_test"
);
```

4. Start Apache and MySQL.

5. Open

```
http://localhost/bincom
```

---

## Project Structure

```
bincom/
│
├── config/
├── pages/
├── index.php
└── README.md
```

## Author

**Muhammed Ogunbajo**

## Live Demo

http://bincomtest.atwebpages.com

---

## Notes

This project was completed as part of the Bincom ICT Software Developer assessment and demonstrates:

- Database design understanding
- SQL joins and aggregation
- AJAX-based chained dropdowns
- CRUD operations
- Transaction handling
- User-friendly interface# bincom
