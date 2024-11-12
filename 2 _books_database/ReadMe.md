# PostgreSQL Books Database Setup

This document provides instructions for setting up a PostgreSQL 14 database for storing authors, books, and reviews, along with the seed data that can populate the database.

## Step 1: Create Tables

Run the following SQL commands to create the necessary tables for authors, books, and reviews.

For table creation and data insertion I used TablePlus: https://tableplus.com which can be installed either on Mac OS or Windows.

### 1.1 Authors Table
```sql
CREATE TABLE authors (
    author_id SERIAL PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL
);
```

### 1.2 Books Table
```sql
CREATE TABLE books (
    book_id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    publication_year INT NOT NULL,
    isbn VARCHAR(13) UNIQUE NOT NULL,
    author_id INT REFERENCES authors(author_id)
);
```

### 1.3 Reviews Table
```sql
CREATE TABLE reviews (
    review_id SERIAL PRIMARY KEY,
    rating INT CHECK (rating >= 1 AND rating <= 10),
    content TEXT NOT NULL,
    book_id INT REFERENCES books(book_id)
);

```

## Step 2: Seed Data
Once the tables are created, you can seed the database with the following data. Run the following SQL commands to insert sample authors, books, and reviews into the database.

### 2.1 Seed Authors Table
```sql
-- Insert sample authors
INSERT INTO authors (first_name, last_name)
VALUES
    ('George', 'Orwell'),
    ('J.K.', 'Rowling'),
    ('Harper', 'Lee'),
    ('J.R.R.', 'Tolkien'),
    ('Jane', 'Austen');
```    
### 2.2 Seed Books Table
```sql
-- Insert sample books
INSERT INTO books (title, publication_year, isbn, author_id)
VALUES
    ('1984', 1949, '978-0451524935', 1),
    ('Harry Potter and the Sorcerer\'s Stone', 1997, '978-0439708180', 2),
    ('To Kill a Mockingbird', 1960, '978-0061120084', 3),
    ('The Hobbit', 1937, '978-0547928227', 4),
    ('Pride and Prejudice', 1813, '978-1503290563', 5);
```
### 2.3 Seed Reviews Table
```sql
-- Insert sample reviews
INSERT INTO reviews (rating, content, book_id)
VALUES
    (9, 'A chilling look at totalitarianism and surveillance.', 1),
    (10, 'An enchanting start to an unforgettable series.', 2),
    (8, 'A deep and moving exploration of race and justice.', 3),
    (9, 'A fantastic fantasy adventure full of magic and mystery.', 4),
    (10, 'A timeless romance with sharp social commentary.', 5);
```

### Step 3: SQL Query to Return Authors Names Along with the Number of Books They've Written
Run the following SQL query to retrieve the authors' first and last names, along with the count of books they have written. This query uses a LEFT JOIN to include authors even if they haven't written any books.

```sql
SELECT 
    a.first_name, 
    a.last_name, 
    COUNT(b.book_id) AS number_of_books
FROM 
    authors a
LEFT JOIN 
    books b ON a.author_id = b.author_id
GROUP BY 
    a.author_id
ORDER BY 
    number_of_books DESC;
```
This should return something like this:
```text
first_name | last_name  | number_of_books
--------------------------------------------
George     | Orwell     | 1
J.K.       | Rowling    | 1
Harper     | Lee        | 1
J.R.R.     | Tolkien    | 1
Jane       | Austen     | 1
```

## Step 4: SQL Query to Create a View with the Top 5 Authors Based on the Average Rating of Their Books
Run the following SQL query to create a view called top_authors that displays the top 5 authors based on the average rating of their books. The result is ordered by the average rating in descending order, and the LIMIT 5 restricts the output to the top 5 authors.

```sql
CREATE VIEW top_authors AS
SELECT 
    a.first_name, 
    a.last_name, 
    AVG(r.rating) AS average_rating
FROM 
    authors a
JOIN 
    books b ON a.author_id = b.author_id
JOIN 
    reviews r ON b.book_id = r.book_id
GROUP BY 
    a.author_id
ORDER BY 
    average_rating DESC
LIMIT 5;
```

The query will generate the results as a view that will appear on the left sidebar of the TablePlus UI.

```text
first_name | last_name  | average_rating
-----------------------------------------
J.K.       | Rowling    | 10
Jane       | Austen     | 10
George     | Orwell     | 9
J.R.R.     | Tolkien    | 9
Harper     | Lee        | 8
```
