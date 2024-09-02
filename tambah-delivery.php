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

    $customer = query("SELECT * FROM customer");

    // Generate nomor DO otomatis
    $generated_do_number = generateDoNumber();

    // cek apakah tombol reset sudah ditekan atau belum
    if (isset($_POST['deliveryOrder']) ) {
	
        // cek apakah data berhasil ditambahkan atau tidak
        if(tambahDelivery($_POST) > 0 ) {
            echo '<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css"></script>';
            echo '<link rel="stylesheet" href="./sweetalert2.min.css"></script>';
            echo '<script src="./sweetalert2.min.js"></script>';
            echo "<script>
            setTimeout(function () { 
                swal.fire({
                    
                    title               : 'Success',
                    text                : 'Delivery order successfully added!',
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
                    text                : 'Failed to add delivery order!',
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
      <h1>New Delivery Order</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">New Delivery Order</li>
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

                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="mb-2">
                                <label for="po_number" class="form-label">Purchase Order No <span id="x">*</span></label>
                                <input type="text" class="form-control" name="po_number" id="po_number" required>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="mb-2">
                                <label for="do_number" class="form-label">Delivery Order No <span id="x">*</span></label>
                                <input type="text" class="form-control" name="do_number" id="do_number" value="<?php echo htmlspecialchars($generated_do_number); ?>" readonly>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="mb-2">
                                <label for="do_date" class="form-label">Delivery Order Date </label>
                                <input type="date" class="form-control" name="do_date" id="do_date" >
                            </div>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label for="customer_id" class="form-label">Customer <span id="x">*</span></label>
                        <select name="customer_id" id="customer_id" class="form-select" required>
                            <option value="">Select Customer</option>
                            <?php foreach($customer as $row) : ?>
                                <option value="<?= $row['id_customer']?>"><?= $row['customer_name']?></option>
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


                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const productSelect = document.getElementById('product');
                            const newProductInput = document.getElementById('new_product');
                            const addProductBtn = document.getElementById('add_product');
                            const removeProductButtonsContainer = document.getElementById('remove-buttons-container');

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

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const armadaSelect = document.getElementById('armada');
                            const removeArmadaButtonsContainer = document.getElementById('remove-armada-buttons-container');

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
                                    })
                                    .catch(error => console.error('Error fetching armada data:', error));
                            }

                            function addArmadaOption(selectElement, armada) {
                                const option = document.createElement('option');
                                option.value = armada;
                                option.textContent = armada;
                                selectElement.appendChild(option);
                            }

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

                            document.getElementById('add_armada').addEventListener('click', function() {
                                const newArmada = document.getElementById('new_armada').value.trim();

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
                                        document.getElementById('new_armada').value = ''; // Clear the input
                                        fetchArmadaOptions(); // Refresh options to ensure they are updated
                                    })
                                    .catch(error => console.error('Error updating JSON file:', error));
                                } else {
                                    alert('Please enter a valid option.');
                                }
                            });

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


                    
                    <div class="row mt-2">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="mb-2">
                                <label for="quantity" class="form-label">Quantity <span id="x">*</span></label>
                                <div class="input-group mb-2">
                                    <input type="text" name="quantity" id="quantity" class="form-control" aria-label="Quantity" aria-describedby="basic-addon2">
                                    <span class="input-group-text" id="basic-addon2">Liter</span>
                                </div>
                            </div>
                        </div>
                        <script>
                            $(document).ready(function() {
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

                                // Use the raw value for form submission or other purposes
                                $('form').on('submit', function() {
                                    let quantityField = $('#quantity');
                                    let rawValue = quantityField.data('raw-value');
                                    quantityField.val(rawValue); // Ensure raw value is submitted
                                });
                            });
                        </script>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="mb-2">
                                <label for="driver" class="form-label">Master / Driver </label>
                                <input type="text" class="form-control" name="driver" id="driver">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="mb-2">
                                <label for="departure_time" class="form-label">Departure Time </label>
                                <input type="text" class="form-control" name="departure_time" id="departure_time">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="mb-2">
                                <label for="arrival_time" class="form-label">Arrival Time </label>
                                <input type="text" class="form-control" name="arrival_time" id="arrival_time">
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
                                <input type="text" class="form-control" name="commence_pump" id="commence_pump">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="mb-2">
                                <label for="finished_pump" class="form-label">Finished Pump </label>
                                <input type="text" class="form-control" name="finished_pump" id="finished_pump">
                            </div>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label for="seal_number1" class="form-label">Seal Number 1 </label>
                        <input type="text" class="form-control" name="seal_number1" id="seal_number1">
                    </div>
                    <div class="mb-2">
                        <label for="seal_number2" class="form-label">Seal Number 2 </label>
                        <input type="text" class="form-control" name="seal_number2" id="seal_number2">
                    </div>

                    <div class="text-left">
                      <button type="submit" class="btn btn-primary btn-sm" name="deliveryOrder"><i class="fa fa-file-invoice fa-sm"></i> Create</button>
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