<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Library Management System</h1>
        <div class="row mb-3">
            <div class="col-md-6">
                <form class="form-inline" method="GET">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search">
                    <select class="form-control mr-sm-2" name="filter">
                        <option value="title">Judul</option>
                        <option value="author">Penulis</option>
                    </select>
                    <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Penerbit</th>
                    <th>Tahun Terbit</th>
                    <th>Status</th>
                    <th>Batas Peminjaman</th>
                    <th>Denda Keterlambatan</th>
                    <th>ISBN</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Define Book class
                // Constructor: Inheritance, Encapsulation
                // Getter methods: Encapsulation
                // Method to borrow and return the book: Encapsulation, Polymorphism
                class Book {
                    protected $title;
                    protected $author;
                    protected $publisher;
                    protected $year;
                    protected $status;
                    protected $dueDate;
                    protected $lateFine;

                    // Constructor to initialize attributes
                    public function __construct($title, $author, $publisher, $year, $status, $dueDate, $lateFine) {
                        $this->title = $title;
                        $this->author = $author;
                        $this->publisher = $publisher;
                        $this->year = $year;
                        $this->status = $status;
                        $this->dueDate = $dueDate;
                        $this->lateFine = $lateFine;
                    }

                    // Getter methods
                    public function getTitle() {
                        return $this->title;
                    }

                    public function getAuthor() {
                        return $this->author;
                    }

                    public function getPublisher() {
                        return $this->publisher;
                    }

                    public function getYear() {
                        return $this->year;
                    }

                    public function getStatus() {
                        return $this->status;
                    }

                    public function getDueDate() {
                        return $this->dueDate;
                    }

                    public function getLateFine() {
                        return $this->lateFine;
                    }

                    // Method to borrow the book
                    public function borrowBook() {
                        $this->status = 'Borrowed';
                    }

                    // Method to return the book
                    public function returnBook() {
                        $this->status = 'Available';
                    }
                }

                // Subclass BookReference
                // Inheritance
                class BookReference extends Book {
                    protected $isbn;

                    // Constructor overriding
                    public function __construct($title, $author, $publisher, $year, $status, $dueDate, $lateFine, $isbn) {
                        parent::__construct($title, $author, $publisher, $year, $status, $dueDate, $lateFine);
                        $this->isbn = $isbn;
                    }

                    public function getISBN() {
                        return $this->isbn;
                    }
                }

                // Array of books
                $books = [
                    // Static data initialization
                    new BookReference("Introduction to PHP", "John Doe", "Publisher A", 2020, "Available", "2024-05-15", "$1 per day", "978-3-16-148410-0"),
                    new BookReference("Advanced PHP Programming", "Jane Smith", "Publisher B", 2019, "Borrowed", "2024-04-30", "$2 per day", "978-3-16-148410-1"),
                    new BookReference("Web Development with JavaScript", "Alice Johnson", "Publisher C", 2021, "Available", "2024-05-20", "$1.5 per day", "978-3-16-148410-2"),
                    new BookReference("Data Science Essentials", "Michael Brown", "Publisher D", 2020, "Available", "2024-06-10", "$2 per day", "978-3-16-148410-3"),
                    new BookReference("Python Programming for Beginners", "David Lee", "Publisher E", 2019, "Borrowed", "2024-05-05", "$2.5 per day", "978-3-16-148410-4"),
                    new BookReference("Machine Learning Fundamentals", "Emily Wang", "Publisher F", 2021, "Available", "2024-05-25", "$1.5 per day", "978-3-16-148410-5"),
                    new BookReference("Introduction to Database Management", "Robert Johnson", "Publisher G", 2020, "Available", "2024-06-05", "$1.8 per day", "978-3-16-148410-6"),
                ];

                // Function to filter books based on search query and filter type
                function filterBooks($books, $search, $filter) {
                    $filteredBooks = [];
                    foreach ($books as $book) {
                        if ($filter === 'title' && strpos(strtolower($book->getTitle()), strtolower($search)) !== false) {
                            $filteredBooks[] = $book;
                        } elseif ($filter === 'author' && strpos(strtolower($book->getAuthor()), strtolower($search)) !== false) {
                            $filteredBooks[] = $book;
                        }
                    }
                    return $filteredBooks;
                }

                // Check if search query is present
                $search = isset($_GET['search']) ? $_GET['search'] : '';
                $filter = isset($_GET['filter']) ? $_GET['filter'] : 'title';

                if (!empty($search)) {
                    $books = filterBooks($books, $search, $filter);
                }

                // Handle actions when buttons are clicked
                if (isset($_POST['action'])) {
                    $action = $_POST['action'];
                    $index = $_POST['index'];

                    if ($action === 'borrow') {
                        $books[$index]->borrowBook();
                    } elseif ($action === 'return') {
                        $books[$index]->returnBook();
                    } elseif ($action === 'delete') {
                        unset($books[$index]);
                    }
                }

                // Display filtered books
                foreach ($books as $index => $book) {
                    echo '<tr>';
                    echo '<td>' . $book->getTitle() . '</td>';
                    echo '<td>' . $book->getAuthor() . '</td>';
                    echo '<td>' . $book->getPublisher() . '</td>';
                    echo '<td>' . $book->getYear() . '</td>';
                    echo '<td>' . $book->getStatus() . '</td>';
                    echo '<td>' . $book->getDueDate() . '</td>';
                    echo '<td>' . $book->getLateFine() . '</td>';
                    // Adding ISBN column
                    if ($book instanceof BookReference) {
                        echo '<td>' . $book->getISBN() . '</td>';
                    } else {
                        echo '<td>N/A</td>';
                    }
                    echo '<td>';
                    if ($book->getStatus() === 'Available') {
                        echo '<form method="POST"><input type="hidden" name="action" value="borrow"><input type="hidden" name="index" value="' . $index . '"><button class="btn btn-success">Pinjam</button></form>';
                    } elseif ($book->getStatus() === 'Borrowed') {
                        echo '<form method="POST"><input type="hidden" name="action" value="return"><input type="hidden" name="index" value="' . $index . '"><button class="btn btn-primary">Kembalikan</button></form>';
                    }
                    echo '<form method="POST"><input type="hidden" name="action" value="delete"><input type="hidden" name="index" value="' . $index . '"><button class="btn btn-danger">Hapus</button></form>';
                    echo '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
