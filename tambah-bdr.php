<?php 
session_name("EGPPBUNKER_SESSION");
session_start();

if (!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}


    include "koneksi.php";
    $id_user = $_SESSION["id_user"];
    $nama = $_SESSION["nama"];
    $level = $_SESSION['is_admin'];

    $id_do = mysqli_real_escape_string($koneksi, $_GET['id_do']);

    $customer = query("SELECT * FROM customer");
    $delivery = query("SELECT * FROM delivery_order WHERE id_do=$id_do")[0];

    // Pastikan $delivery['product'] adalah array atau string yang sesuai
    $selectedProduct = isset($delivery['product']) ? $delivery['product'] : '';

    // Pastikan $delivery['armada'] adalah string atau array yang sesuai
    $selectedArmada = isset($delivery['armada']) ? $delivery['armada'] : '';

    // Asumsikan $delivery['loading_port'] dan $delivery['discharging_port'] adalah string atau array
    $selectedLoadingPort = isset($delivery['loading_port']) ? $delivery['loading_port'] : '';
    $selectedDischargingPort = isset($delivery['discharging_port']) ? $delivery['discharging_port'] : '';

    // Generate nomor bdr otomatis
    $generated_bdr_number = generateBdrNumber();

    // cek apakah tombol submit sudah ditekan atau belum
    if (isset($_POST['editDelivery']) ) {
	
        // cek apakah data berhasil update atau tidak
        if(editDelivery($_POST) > 0 ) {
            echo '<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css"></script>';
            echo '<link rel="stylesheet" href="./sweetalert2.min.css"></script>';
            echo '<script src="./sweetalert2.min.js"></script>';
            echo "<script>
            setTimeout(function () { 
                swal.fire({
                    
                    title               : 'Success',
                    text                : 'Delivery order successfully updated!',
                    icon                : 'success',
                    timer               : 2000,
                    showConfirmButton   : false
                });  
            },10);   setTimeout(function () {
                window.location.href = 'manage-delivery-order.php'; //will redirect to your blog page (an ex: blog.html)
            }, 2000); //will call the function after 2 secs
            </script>"; 
            exit;

        } else{
            echo '<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css"></script>';
            echo '<link rel="stylesheet" href="./sweetalert2.min.css"></script>';
            echo '<script src="./sweetalert2.min.js"></script>';
            echo "<script>
            setTimeout(function () { 
                swal.fire({
                    
                    title               : 'Failed',
                    text                : 'Failed to update delivery order!',
                    icon                : 'error',
                    timer               : 2000,
                    showConfirmButton   : false
                });  
            },10);   setTimeout(function () {
                window.location.href = 'manage-delivery-order.php'; //will redirect to your blog page (an ex: blog.html)
            }, 2000); //will call the function after 2 secs
            </script>";
            exit;

        }
    
    }

?>

<!DOCTYPE html>
<html lang="en">

<?php
    include "layouts/head-css.php";
?>

<style>
    span#x{
        color: red;
    }
</style>

<body>

<?php
    include "layouts/header.php";
?>

<?php
    include "layouts/sidebar.php";
?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Bunker Delivery Receipt</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Bunker Delivery Receipt</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->


    <section class="section">
        <div class="row">
            <div class="col-lg-8">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">DO Number : <?= $delivery['do_number']?></h5>
        
                    <!-- Horizontal Form -->
                    <form action="" method="post">

                        <input type="hidden" name="id_do" value="<?= $id_do?>">
                        <div class="mb-2">
                            <label for="bdr_no" class="form-label">BDR No <span id="x">*</span></label>
                            <input type="text" class="form-control" name="bdr_no" id="bdr_no" value="<?php echo htmlspecialchars($generated_bdr_number); ?>" readonly>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="mb-2">
                                    <label for="discharging_port" class="form-label">Delivered at <span id="x">*</span></label>
                                    <select name="discharging_port" id="discharging_port" class="form-select" disabled>
                                        <!-- Opsi-opsi dari JSON akan ditambahkan di sini -->
                                    </select>
                                </div>
                            </div>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const loadingPortSelect = document.getElementById('loading_port');
                                    const dischargingPortSelect = document.getElementById('discharging_port');
                            
                                    const selectedLoadingPort = '<?= $selectedLoadingPort ?>'; // PHP variable for selected loading port
                                    const selectedDischargingPort = '<?= $selectedDischargingPort ?>'; // PHP variable for selected discharging port
                            
                                    // Fetch options from the JSON file and populate select dropdowns
                                    fetch('ports.json')
                                        .then(response => response.json())
                                        .then(data => {
                                            data.forEach(port => {
                                                const optionLoading = document.createElement('option');
                                                optionLoading.value = port;
                                                optionLoading.textContent = port;
                            
                                                // Mark as selected if it matches the current value
                                                if (port === selectedLoadingPort) {
                                                    optionLoading.selected = true;
                                                }
                                                loadingPortSelect.appendChild(optionLoading);
                            
                                                const optionDischarging = document.createElement('option');
                                                optionDischarging.value = port;
                                                optionDischarging.textContent = port;
                            
                                                // Mark as selected if it matches the current value
                                                if (port === selectedDischargingPort) {
                                                    optionDischarging.selected = true;
                                                }
                                                dischargingPortSelect.appendChild(optionDischarging);
                                            });
                                        })
                                        .catch(error => console.error('Error fetching port data:', error));
                            
                                    // Add new port to the select dropdowns and update the JSON file
                                    document.getElementById('add_port').addEventListener('click', function() {
                                        const newPort = document.getElementById('new_port').value.trim();
                            
                                        if (newPort) {
                                            // Add new option to the select dropdowns
                                            const optionLoading = document.createElement('option');
                                            optionLoading.value = newPort;
                                            optionLoading.textContent = newPort;
                                            loadingPortSelect.appendChild(optionLoading);
                                            loadingPortSelect.value = newPort; // Select the newly added option
                            
                                            const optionDischarging = document.createElement('option');
                                            optionDischarging.value = newPort;
                                            optionDischarging.textContent = newPort;
                                            dischargingPortSelect.appendChild(optionDischarging);
                                            dischargingPortSelect.value = newPort; // Select the newly added option
                            
                                            // Send the new option to the server to update the JSON file
                                            fetch('update_port.php', {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/json'
                                                },
                                                body: JSON.stringify({ port: newPort })
                                            })
                                            .then(response => response.text())
                                            .then(data => {
                                                console.log(data);
                                                alert('New port added successfully!');
                                            })
                                            .catch(error => console.error('Error updating JSON file:', error));
                                        } else {
                                            alert('Please enter a valid port.');
                                        }
                                    });
                                });
                            </script>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="mb-2">
                                    <label for="do_date" class="form-label">Date </label>
                                    <input type="date" class="form-control" name="do_date" id="do_date" value="<?= $delivery['do_date']?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="mb-2">
                                    <label for="discharging_port" class="form-label">Delivered by <span id="x">*</span></label>
                                    <input type="text" class="form-control" name="vessel_name" id="vessel_name" value="">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="mb-2">
                                    <label for="vessel_cust" class="form-label">Vessel's Name <span id="x">*</span></label>
                                    <select name="vessel_cust" id="vessel_cust" class="form-select" required>
                                        <!-- Opsi-opsi dari JSON akan ditambahkan di sini -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="mb-2">
                                    <label for="new_vessel" class="form-label">Add New Vessel</label>
                                    <div class="d-flex">
                                        <input type="text" id="new_vessel" class="form-control" placeholder="Enter new vessel">
                                        <button id="add_vessel" class="btn btn-primary btn-sm ms-2">Add</button>
                                    </div>
                                </div>
                            </div>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    // Load existing vessels from JSON file
                                    loadVessels();
                                    
                                    document.getElementById('add_vessel').addEventListener('click', function() {
                                        const newVesselInput = document.getElementById('new_vessel');
                                        const newVesselName = newVesselInput.value.trim();
                                
                                        if (newVesselName === '') {
                                            alert('Please enter a vessel name.');
                                            return;
                                        }
                                
                                        const formData = new FormData();
                                        formData.append('vessel_name', newVesselName);
                                
                                        fetch('update_vessel.php', {
                                            method: 'POST',
                                            body: formData
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.status === 'success') {
                                                // Update the dropdown with the new vessel
                                                updateVesselDropdown(newVesselName);
                                                newVesselInput.value = ''; // Clear the input field
                                
                                                // Show success alert
                                                alert(data.message); // Use the message from the server response
                                            } else {
                                                alert(data.message); // Show error message from server response
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Error:', error);
                                            alert('An error occurred while adding the vessel.');
                                        });
                                    });
                                });
                                
                                function loadVessels() {
                                    fetch('vessel.json')
                                        .then(response => response.json())
                                        .then(vessels => {
                                            const vesselSelect = document.getElementById('vessel_cust');
                                            vesselSelect.innerHTML = ''; // Clear existing options
                                            
                                            vessels.forEach(vessel => {
                                                // Create new option
                                                const option = document.createElement('option');
                                                option.value = vessel;
                                                option.text = vessel;
                                                
                                                // Add new option to the dropdown
                                                vesselSelect.add(option);
                                            });
                                        })
                                        .catch(error => {
                                            console.error('Error loading vessels:', error);
                                            alert('An error occurred while loading vessels.');
                                        });
                                }
                                
                                function updateVesselDropdown(newVesselName) {
                                    const vesselSelect = document.getElementById('vessel_cust');
                                    
                                    // Create new option
                                    const newOption = document.createElement('option');
                                    newOption.value = newVesselName;
                                    newOption.text = newVesselName;
                                
                                    // Add new option to the dropdown
                                    vesselSelect.add(newOption);
                                }
                            </script>  
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="mb-2">
                                    <label for="product" class="form-label">Product <span id="x">*</span></label>
                                    <select name="product" id="product" class="form-select" required disabled>
                                        <!-- Opsi-opsi dari JSON akan ditambahkan di sini -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="mb-2">
                                    <label for="next_port" class="form-label">Next Port </label>
                                    <input type="text" class="form-control" name="next_port" id="next_port">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="mb-2">
                                    <label for="commence_pump" class="form-label">Commence Pump </label>
                                    <input type="text" class="form-control" name="commence_pump" id="commence_pump" value="<?= $delivery['commence_pump']?>">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="mb-2">
                                    <label for="finished_pump" class="form-label">E.T.D </label>
                                    <input type="text" class="form-control" name="finished_pump" id="finished_pump" value="<?= $delivery['finished_pump']?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="mb-2">
                                    <label for="finished_pump" class="form-label">Finished Pump </label>
                                    <input type="text" class="form-control" name="finished_pump" id="finished_pump" value="<?= $delivery['finished_pump']?>">
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <hr>
                            <p>PRODUCT SUPPLIED</p>
                            <hr>
                        </div>

                        <div class="mb-2">
                            <label for="customer_id" class="form-label">Customer <span id="x">*</span></label>
                            <select name="customer_id" id="customer_id" class="form-select" required>
                                <option value="">Select Customer</option>
                                <?php foreach($customer as $row) : ?>
                                    <option value="<?= $row['id_customer']?>" <?= ($row['id_customer'] == $delivery['customer_id']) ? 'selected' : '' ?>><?= $row['customer_name']?></option>
                                <?php endforeach;?>
                            </select>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Delivery Address </label>
                            <textarea id="delivery_address" class="form-control" disabled></textarea>
                        </div>

                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                        <script>
                        $(document).ready(function() {
                            var customer_id = $('#customer_id').val();

                            // Pastikan customer_id dipilih saat halaman dimuat
                            if (customer_id) {
                                $.ajax({
                                    url: 'get_delivery_address.php', // File PHP untuk mengambil data address
                                    type: 'POST',
                                    data: { customer_id: customer_id },
                                    success: function(response) {
                                        // Menampilkan address di dalam textarea
                                        $('#delivery_address').val(response);
                                    },
                                    error: function(xhr, status, error) {
                                        console.error(error);
                                    }
                                });
                            }

                            // Menangani perubahan pilihan customer
                            $('#customer_id').change(function() {
                                var customer_id = $(this).val();

                                // Pastikan customer_id dipilih
                                if (customer_id) {
                                    $.ajax({
                                        url: 'get_delivery_address.php', // File PHP untuk mengambil data address
                                        type: 'POST',
                                        data: { customer_id: customer_id },
                                        success: function(response) {
                                            // Menampilkan address di dalam textarea
                                            $('#delivery_address').val(response);
                                        },
                                        error: function(xhr, status, error) {
                                            console.error(error);
                                        }
                                    });
                                } else {
                                    // Jika tidak ada customer yang dipilih, kosongkan textarea
                                    $('#delivery_address').val('');
                                }
                            });
                        });
                        </script>


                        <div class="text-center">
                            <hr>
                            <p>DELIVERY INFORMATION</p>
                            <hr>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="mb-2">
                                    <label for="product" class="form-label">Product <span id="x">*</span></label>
                                    <select name="product" id="product" class="form-select" required>
                                        <!-- Opsi-opsi dari JSON akan ditambahkan di sini -->
                                    </select>
                                </div>
                            
                                <div class="mb-2">
                                    <label for="new_product" class="form-label">Add New Product</label>
                                    <input type="text" id="new_product" class="form-control" placeholder="Enter new product">
                                    <button id="add_product" class="btn btn-primary btn-sm mt-2">Add</button>
                                </div>
                            </div>
                            
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const productSelect = document.getElementById('product');
                                    const selectedProduct = '<?= $selectedProduct ?>'; // PHP variable for selected product
                            
                                    // Fetch options from JSON file and populate select dropdown
                                    fetch('product.json')
                                        .then(response => response.json())
                                        .then(data => {
                                            data.forEach(product => {
                                                const option = document.createElement('option');
                                                option.value = product;
                                                option.textContent = product;
                            
                                                if (product === selectedProduct) {
                                                    option.selected = true; // Mark the current product as selected
                                                }
                                                productSelect.appendChild(option);
                                            });
                                        })
                                        .catch(error => console.error('Error fetching product data:', error));
                            
                                    // Add new option to the select dropdown and update the JSON file
                                    document.getElementById('add_product').addEventListener('click', function() {
                                        const newProduct = document.getElementById('new_product').value.trim();
                            
                                        if (newProduct) {
                                            // Add new option to the select dropdown
                                            const option = document.createElement('option');
                                            option.value = newProduct;
                                            option.textContent = newProduct;
                                            productSelect.appendChild(option);
                            
                                            // Select the newly added option
                                            productSelect.value = newProduct;
                            
                                            // Send the new option to the server to update the JSON file
                                            fetch('update_product.php', {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/json'
                                                },
                                                body: JSON.stringify({ product: newProduct })
                                            })
                                            .then(response => response.text())
                                            .then(data => {
                                                console.log(data);
                                                alert('New product added successfully!');
                                            })
                                            .catch(error => console.error('Error updating JSON file:', error));
                                        } else {
                                            alert('Please enter a valid product.');
                                        }
                                    });
                                });
                            </script>
                            
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="mb-2">
                                    <label for="armada" class="form-label">Vessel / Fuel Truck <span id="x">*</span></label>
                                    <select name="armada" id="armada" class="form-select" required>
                                        <!-- Opsi-opsi dari JSON akan ditambahkan di sini -->
                                    </select>
                                </div>
                            
                                <div class="mb-2">
                                    <label for="new_armada" class="form-label">Add New Vessel / Fuel Truck</label>
                                    <input type="text" id="new_armada" class="form-control" placeholder="Enter new option">
                                    <button id="add_armada" class="btn btn-primary btn-sm mt-2">Add</button>
                                </div>
                            </div>
                            
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const armadaSelect = document.getElementById('armada');
                                    const selectedArmada = '<?= $selectedArmada ?>'; // PHP variable for selected armada
                            
                                    // Fetch options from JSON file and populate select dropdown
                                    fetch('armada.json')
                                        .then(response => response.json())
                                        .then(data => {
                                            data.forEach(armada => {
                                                const option = document.createElement('option');
                                                option.value = armada;
                                                option.textContent = armada;
                            
                                                if (armada === selectedArmada) {
                                                    option.selected = true; // Mark the current armada as selected
                                                }
                                                armadaSelect.appendChild(option);
                                            });
                                        })
                                        .catch(error => console.error('Error fetching armada data:', error));
                            
                                    // Add new option to the select dropdown and update the JSON file
                                    document.getElementById('add_armada').addEventListener('click', function() {
                                        const newArmada = document.getElementById('new_armada').value.trim();
                            
                                        if (newArmada) {
                                            // Add new option to the select dropdown
                                            const option = document.createElement('option');
                                            option.value = newArmada;
                                            option.textContent = newArmada;
                                            armadaSelect.appendChild(option);
                            
                                            // Select the newly added option
                                            armadaSelect.value = newArmada;
                            
                                            // Send the new option to the server to update the JSON file
                                            fetch('update_armada.php', {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/json'
                                                },
                                                body: JSON.stringify({ armada: newArmada })
                                            })
                                            .then(response => response.text())
                                            .then(data => {
                                                console.log(data);
                                                alert('New option added successfully!');
                                            })
                                            .catch(error => console.error('Error updating JSON file:', error));
                                        } else {
                                            alert('Please enter a valid option.');
                                        }
                                    });
                                });
                            </script>
                            

                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="mb-2">
                                    <label for="quantity" class="form-label">Quantity <span id="x">*</span></label>
                                    <div class="input-group mb-2">
                                        <input type="text" name="quantity" id="quantity" class="form-control" aria-label="Quantity" value="<?= number_format($delivery['quantity'], 0, '', '.') ?>" aria-describedby="basic-addon2">
                                        <span class="input-group-text" id="basic-addon2">Liter</span>
                                    </div>
                                </div>
                            </div>
                            <script>
                                $(document).ready(function() {
                                    // Format value on page load
                                    let quantityField = $('#quantity');
                                    let initialValue = quantityField.val().replace(/\D/g, ''); // Remove non-digit characters
                        
                                    // Store raw value for form submission
                                    quantityField.data('raw-value', initialValue);
                        
                                    $('#quantity').on('input', function() {
                                        // Get the input value and remove any non-digit characters
                                        let rawValue = $(this).val().replace(/\D/g, '');
                                        
                                        // Save the raw value for database purposes
                                        $(this).data('raw-value', rawValue);
                                        
                                        // Format the value with thousands separator for display
                                        if (rawValue) {
                                            let formattedValue = Number(rawValue).toLocaleString('id-ID'); // Change 'id-ID' to your locale if needed
                                            $(this).val(formattedValue);
                                        } else {
                                            $(this).val('');
                                        }
                                    });
                        
                                    // Ensure the raw value is used for form submission
                                    $('form').on('submit', function() {
                                        let rawValue = quantityField.data('raw-value');
                                        quantityField.val(rawValue); // Set the raw value before form submission
                                    });
                                });
                            </script>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="mb-2">
                                    <label for="driver" class="form-label">Master / Driver </label>
                                    <input type="text" class="form-control" name="driver" id="driver" value="<?= $delivery['driver']?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="mb-2">
                                    <label for="departure_time" class="form-label">Departure Time </label>
                                    <input type="text" class="form-control" name="departure_time" id="departure_time" value="<?= $delivery['departure_time']?>">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="mb-2">
                                    <label for="arrival_time" class="form-label">Arrival Time </label>
                                    <input type="text" class="form-control" name="arrival_time" id="arrival_time" value="<?= $delivery['arrival_time']?>">
                                </div>
                            </div>
                        </div>

                        
                        
                        

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="mb-2">
                                    <label for="commence_pump" class="form-label">Commence Pump </label>
                                    <input type="text" class="form-control" name="commence_pump" id="commence_pump" value="<?= $delivery['commence_pump']?>">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="mb-2">
                                    <label for="finished_pump" class="form-label">Finished Pump </label>
                                    <input type="text" class="form-control" name="finished_pump" id="finished_pump" value="<?= $delivery['finished_pump']?>">
                                </div>
                            </div>
                        </div>

                        <div class="mb-2">
                            <label for="seal_number1" class="form-label">Seal Number 1 </label>
                            <input type="text" class="form-control" name="seal_number1" id="seal_number1" value="<?= $delivery['seal_number1']?>">
                        </div>
                        <div class="mb-2">
                            <label for="seal_number2" class="form-label">Seal Number 2 </label>
                            <input type="text" class="form-control" name="seal_number2" id="seal_number2" value="<?= $delivery['seal_number2']?>">
                        </div>

                        <div class="text-left">
                        <button type="submit" class="btn btn-primary btn-sm" name="editDelivery"><i class="fa fa-file-invoice fa-sm"></i> Update</button>
                        <a href="manage-delivery-order.php" class="btn btn-danger btn-sm"><i class="fa fa-times fa-sm"></i> Cancel</a>
                        </div>
                    </form><!-- End Horizontal Form -->
        
                    </div>
                </div>

            </div>
        </div>
    </section>

   

  </main><!-- End #main -->

<?php
    include "layouts/footer.php";
?>

<?php
    include "layouts/script-js.php";
?>
  

</body>

</html>