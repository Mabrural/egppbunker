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

    .dropdown-container {
    margin-bottom: 1rem;
}

/* .remove-buttons-container {
    display: flex;
    flex-direction: column;
    gap: 5px;
    margin-top: 10px;
} */

.remove-button {
    display: inline-flex;
    align-items: center;
    background-color: transparent;
    border: none;
    color: red;
    cursor: pointer;
    font-size: 12px;
}

.remove-buttons-container {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
}

.remove-button {
    display: flex;
    align-items: center;
    background-color: transparent;
    border: none;
    color: red;
    cursor: pointer;
    font-size: 12px;
    text-align: left;
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
      <h1>Edit Delivery Order</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Edit Delivery Order</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->


    <section class="section">
      <div class="row">
        <div class="col-lg-8">

            <div class="card">
                <div class="card-body">
                  <h5 class="card-title"></h5>
    
                  <!-- Horizontal Form -->
                  <form action="" method="post">

                    <input type="hidden" name="id_do" value="<?= $id_do?>">

                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="mb-2">
                                <label for="po_number" class="form-label">Purchase Order No </label>
                                <input type="text" class="form-control" name="po_number" id="po_number" value="<?= $delivery['po_number']?>">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="mb-2">
                                <label for="do_number" class="form-label">Delivery Order No <span id="x">*</span></label>
                                <input type="text" class="form-control" name="do_number" id="do_number" value="<?= $delivery['do_number']?>" required>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="mb-2">
                                <label for="do_date" class="form-label">Delivery Order Date </label>
                                <input type="date" class="form-control" name="do_date" id="do_date" value="<?= $delivery['do_date']?>">
                            </div>
                        </div>
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

                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="mb-2">
                            <label for="product" class="form-label">Product <span id="x">*</span></label>
                            <select name="product" id="product" class="form-select" required>
                                <!-- Opsi-opsi dari JSON akan ditambahkan di sini -->
                            </select>
                        </div>
                    
                        <div class="mb-2">
                            <label for="new_product" class="form-label">Add New Product</label>
                            <div class="d-flex">
                                <input type="text" id="new_product" class="form-control" placeholder="Enter new product">
                                <button id="add_product" class="btn btn-primary btn-sm ms-2">Add</button>
                            </div>
                        </div>
                    </div>
                    
                    <div id="remove-buttons-container" class="remove-buttons-container">
                        <!-- Tombol remove untuk produk akan muncul di sini -->
                    </div>
                    
                    <!-- Hidden input to store the selected product -->
                    <input type="hidden" id="selected_product" value="<?= htmlspecialchars($delivery['product']) ?>">                    


                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const productSelect = document.getElementById('product');
                            const newProductInput = document.getElementById('new_product');
                            const addProductBtn = document.getElementById('add_product');
                            const removeProductButtonsContainer = document.getElementById('remove-buttons-container');
                            const selectedProduct = document.getElementById('selected_product').value; // Get selected product from hidden input

                            // Function to fetch products and populate select dropdowns
                            function fetchProducts() {
                                const timestamp = new Date().getTime(); // Unique timestamp to avoid cache
                                fetch(`product.json?t=${timestamp}`)
                                    .then(response => response.json())
                                    .then(data => {
                                        productSelect.innerHTML = '';
                                        removeProductButtonsContainer.innerHTML = '';

                                        data.forEach(product => {
                                            addProductOption(productSelect, product);
                                            addRemoveProductButton(product);
                                        });

                                        // Set the selected option
                                        if (selectedProduct) {
                                            productSelect.value = selectedProduct;
                                        }
                                    })
                                    .catch(error => console.error('Error fetching product data:', error));
                            }

                            // Function to add an option to the select element
                            function addProductOption(selectElement, product) {
                                const option = document.createElement('option');
                                option.value = product;
                                option.textContent = product;
                                selectElement.appendChild(option);
                            }

                            // Function to add a remove button for each product
                            function addRemoveProductButton(product) {
                                const button = document.createElement('button');
                                button.className = 'remove-button';
                                button.textContent = `Remove ${product}`;
                                button.onclick = function() {
                                    if (confirm(`Are you sure you want to remove ${product}?`)) {
                                        removeProduct(product);
                                    }
                                };
                                removeProductButtonsContainer.appendChild(button);
                            }

                            // Add new product to the select dropdown and update the JSON file
                            addProductBtn.addEventListener('click', function() {
                                const newProduct = newProductInput.value.trim();

                                if (newProduct) {
                                    addProductOption(productSelect, newProduct);
                                    addRemoveProductButton(newProduct);

                                    fetch('update_product.php', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json'
                                        },
                                        body: JSON.stringify({ action: 'add', product: newProduct })
                                    })
                                    .then(response => response.text())
                                    .then(data => {
                                        console.log(data);
                                        alert('New product added successfully!');
                                        newProductInput.value = ''; // Clear the input
                                        fetchProducts(); // Refresh products to ensure they are updated
                                    })
                                    .catch(error => console.error('Error updating JSON file:', error));
                                } else {
                                    alert('Please enter a valid product.');
                                }
                            });

                            // Function to remove a product
                            function removeProduct(product) {
                                fetch('update_product.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({ action: 'remove', product: product })
                                })
                                .then(response => response.text())
                                .then(data => {
                                    console.log(data);
                                    alert('Product removed successfully!');
                                    fetchProducts(); // Reload the products
                                })
                                .catch(error => console.error('Error updating JSON file:', error));
                            }

                            // Load the products when the page is loaded
                            fetchProducts();
                        });

                    </script>

                    <div class="col-lg-12 col-md-12 col-sm-12 mt-2">
                        <div class="mb-2">
                            <label for="armada" class="form-label">Vessel / Fuel Truck <span id="x">*</span></label>
                            <select name="armada" id="armada" class="form-select" required>
                                <!-- Opsi-opsi dari JSON akan ditambahkan di sini -->
                            </select>
                        </div>

                        <div class="mb-2">
                            <label for="new_armada" class="form-label">Add New Vessel / Fuel Truck</label>
                            <div class="d-flex">
                                <input type="text" id="new_armada" class="form-control" placeholder="Enter new option">
                                <button id="add_armada" class="btn btn-primary btn-sm ms-2">Add</button>
                            </div>
                        </div>

                        <div id="remove-armada-buttons-container" class="remove-buttons-container">
                            <!-- Tombol remove untuk armada akan muncul di sini -->
                        </div>
                    </div>

                    <!-- Hidden input to store the selected armada -->
                    <input type="hidden" id="selected_armada" value="<?= htmlspecialchars($delivery['armada']) ?>">

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const armadaSelect = document.getElementById('armada');
                            const newArmadaInput = document.getElementById('new_armada');
                            const addArmadaBtn = document.getElementById('add_armada');
                            const removeArmadaButtonsContainer = document.getElementById('remove-armada-buttons-container');
                            const selectedArmada = document.getElementById('selected_armada').value; // Get selected armada from hidden input

                            // Function to fetch armada options and populate the select dropdown
                            function fetchArmadaOptions() {
                                fetch('armada.json?v=' + Date.now()) // Cache-busting parameter
                                    .then(response => response.json())
                                    .then(data => {
                                        armadaSelect.innerHTML = '';
                                        removeArmadaButtonsContainer.innerHTML = '';

                                        data.forEach(armada => {
                                            addArmadaOption(armadaSelect, armada);
                                            addRemoveArmadaButton(armada);
                                        });

                                        // Set the selected option
                                        if (selectedArmada) {
                                            armadaSelect.value = selectedArmada;
                                        }
                                    })
                                    .catch(error => console.error('Error fetching armada data:', error));
                            }

                            // Function to add an option to the select element
                            function addArmadaOption(selectElement, armada) {
                                const option = document.createElement('option');
                                option.value = armada;
                                option.textContent = armada;
                                selectElement.appendChild(option);
                            }

                            // Function to add a remove button for each armada
                            function addRemoveArmadaButton(armada) {
                                const button = document.createElement('button');
                                button.className = 'remove-button';
                                button.textContent = `Remove ${armada}`;
                                button.onclick = function() {
                                    if (confirm(`Are you sure you want to remove ${armada}?`)) {
                                        removeArmada(armada);
                                    }
                                };
                                removeArmadaButtonsContainer.appendChild(button);
                            }

                            // Add new armada to the select dropdown and update the JSON file
                            addArmadaBtn.addEventListener('click', function() {
                                const newArmada = newArmadaInput.value.trim();

                                if (newArmada) {
                                    addArmadaOption(armadaSelect, newArmada);
                                    addRemoveArmadaButton(newArmada);

                                    fetch('update_armada.php', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json'
                                        },
                                        body: JSON.stringify({ action: 'add', armada: newArmada })
                                    })
                                    .then(response => response.text())
                                    .then(data => {
                                        console.log(data);
                                        alert('New option added successfully!');
                                        newArmadaInput.value = ''; // Clear the input
                                        fetchArmadaOptions(); // Refresh options to ensure they are updated
                                    })
                                    .catch(error => console.error('Error updating JSON file:', error));
                                } else {
                                    alert('Please enter a valid option.');
                                }
                            });

                            // Function to remove an armada
                            function removeArmada(armada) {
                                fetch('update_armada.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({ action: 'remove', armada: armada })
                                })
                                .then(response => response.text())
                                .then(data => {
                                    console.log(data);
                                    alert('Option removed successfully!');
                                    fetchArmadaOptions(); // Reload the armada options
                                })
                                .catch(error => console.error('Error updating JSON file:', error));
                            }

                            // Load the armada options when the page is loaded
                            fetchArmadaOptions();
                        });

                    </script>


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

                    <div class="row mt-2">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="mb-2">
                                <label for="loading_port" class="form-label">Loading Port <span id="x">*</span></label>
                                <select name="loading_port" id="loading_port" class="form-select" required>
                                    <!-- Opsi-opsi dari JSON akan ditambahkan di sini -->
                                </select>
                            </div>
                        </div>
                    
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="mb-2">
                                <label for="discharging_port" class="form-label">Discharging Port <span id="x">*</span></label>
                                <select name="discharging_port" id="discharging_port" class="form-select" required>
                                    <!-- Opsi-opsi dari JSON akan ditambahkan di sini -->
                                </select>
                            </div>
                        </div>
                    
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="mb-2">
                                <label for="new_port" class="form-label">Add New Port</label>
                                <div class="d-flex">
                                    <input type="text" id="new_port" class="form-control" placeholder="Enter new port">
                                    <button id="add_port" class="btn btn-primary btn-sm ms-2">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div id="remove-port-buttons-container" class="remove-buttons-container">
                        <!-- Tombol remove untuk port akan muncul di sini -->
                    </div>
                    
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const loadingPortSelect = document.getElementById('loading_port');
                            const dischargingPortSelect = document.getElementById('discharging_port');
                            const removePortButtonsContainer = document.getElementById('remove-port-buttons-container');
                    
                            // Assume delivery data is available globally
                            const delivery = {
                                loading_port: "<?php echo $delivery['loading_port']; ?>",
                                discharging_port: "<?php echo $delivery['discharging_port']; ?>"
                            };
                    
                            function fetchPorts() {
                                fetch('ports.json?v=' + Date.now()) // Cache-busting parameter
                                    .then(response => response.json())
                                    .then(data => {
                                        loadingPortSelect.innerHTML = '';
                                        dischargingPortSelect.innerHTML = '';
                                        removePortButtonsContainer.innerHTML = '';
                    
                                        data.forEach(port => {
                                            addPortOption(loadingPortSelect, port);
                                            addPortOption(dischargingPortSelect, port);
                                            addRemovePortButton(port);
                                        });
                    
                                        // Set selected options
                                        if (delivery.loading_port) {
                                            loadingPortSelect.value = delivery.loading_port;
                                        }
                                        if (delivery.discharging_port) {
                                            dischargingPortSelect.value = delivery.discharging_port;
                                        }
                                    })
                                    .catch(error => console.error('Error fetching port data:', error));
                            }
                    
                            function addPortOption(selectElement, port) {
                                const option = document.createElement('option');
                                option.value = port;
                                option.textContent = port;
                                selectElement.appendChild(option);
                            }
                    
                            function addRemovePortButton(port) {
                                const button = document.createElement('button');
                                button.className = 'remove-button';
                                button.textContent = `Remove ${port}`;
                                button.onclick = function() {
                                    if (confirm(`Are you sure you want to remove ${port}?`)) {
                                        removePort(port);
                                    }
                                };
                                removePortButtonsContainer.appendChild(button);
                            }
                    
                            document.getElementById('add_port').addEventListener('click', function() {
                                const newPort = document.getElementById('new_port').value.trim();
                    
                                if (newPort) {
                                    addPortOption(loadingPortSelect, newPort);
                                    addPortOption(dischargingPortSelect, newPort);
                                    addRemovePortButton(newPort);
                    
                                    fetch('update_port.php', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json'
                                        },
                                        body: JSON.stringify({ action: 'add', port: newPort })
                                    })
                                    .then(response => response.text())
                                    .then(data => {
                                        console.log(data);
                                        alert('New port added successfully!');
                                        document.getElementById('new_port').value = ''; // Clear the input
                                        fetchPorts(); // Refresh options to ensure they are updated
                                    })
                                    .catch(error => console.error('Error updating JSON file:', error));
                                } else {
                                    alert('Please enter a valid port.');
                                }
                            });
                    
                            function removePort(port) {
                                fetch('update_port.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({ action: 'remove', port: port })
                                })
                                .then(response => response.text())
                                .then(data => {
                                    console.log(data);
                                    alert('Port removed successfully!');
                                    fetchPorts(); // Reload the port options
                                })
                                .catch(error => console.error('Error updating JSON file:', error));
                            }
                    
                            // Load the port options when the page is loaded
                            fetchPorts();
                        });
                    </script>
                    
                    

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