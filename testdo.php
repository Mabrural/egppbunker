<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate DO Number</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 600px;
            margin-top: 50px;
        }
        .result {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Generate DO Number</h1>
        <form method="post" action="">
            <div class="form-group">
                <label for="date">Select Date:</label>
                <input type="date" id="date" name="date" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Generate DO Number</button>
        </form>

        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <div class="result">
            <?php
            // Include your database connection
            include 'koneksi.php'; // Pastikan file ini berisi variabel $koneksi

            // Function to generate DO Number
            function generateDoNumber2($date) {
                global $koneksi;

                // Format date
                $selected_date = new DateTime($date);
                $month = $selected_date->format('n');
                $year = $selected_date->format('Y');

                // Ambil nomor urut terakhir
                $query = "SELECT do_number FROM delivery_order ORDER BY id_do DESC LIMIT 1";
                $result = mysqli_query($koneksi, $query);
                $last_do_number = mysqli_fetch_assoc($result)['do_number'];

                // Ekstrak nomor urut terakhir dan tambahkan 1
                $last_number = $last_do_number ? (int)explode('/', $last_do_number)[0] : 0;
                $new_number = str_pad($last_number + 1, 3, '0', STR_PAD_LEFT);

                // Dapatkan bulan dalam format Romawi
                $month_romawi = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
                $current_month_romawi = $month_romawi[$month - 1];

                // Format nomor DO
                return "{$new_number}/DO-GPP/{$current_month_romawi}/{$year}";
            }

            // Get date from POST
            $selected_date = $_POST['date'];
            echo "<h3>Generated DO Number:</h3>";
            echo "<p>" . generateDoNumber2($selected_date) . "</p>";
            ?>
        </div>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
