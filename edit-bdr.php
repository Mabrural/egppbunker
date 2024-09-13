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

    $id_bdr = mysqli_real_escape_string($koneksi, $_GET['id_bdr']);

    $customer = query("SELECT * FROM customer");
    $bdr = query("SELECT * FROM bdr JOIN delivery_order ON delivery_order.id_do=bdr.do_id WHERE id_bdr=$id_bdr")[0];

    $selectedProduct = $bdr['product'];

    // Ambil nilai vessel_cust dari array $bdr
    $selectedVessel = isset($bdr['vessel_cust']) ? $bdr['vessel_cust'] : '';

    $selectedDischargingPort = $bdr['discharging_port'];

    // cek apakah tombol submit sudah ditekan atau belum
    if (isset($_POST['editBdr']) ) {
	
        // cek apakah data berhasil update atau tidak
        if(editBdr($_POST) > 0 ) {
            echo '<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css"></script>';
            echo '<link rel="stylesheet" href="./sweetalert2.min.css"></script>';
            echo '<script src="./sweetalert2.min.js"></script>';
            echo "<script>
            setTimeout(function () { 
                swal.fire({
                    
                    title               : 'Success',
                    text                : 'BDR successfully updated!',
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
                    text                : 'Failed to update BDR!',
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
      <h1>Edit Bunker Delivery Receipt</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Edit Bunker Delivery Receipt</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->


    <section class="section">
        <div class="row">
            <div class="col-lg-8">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">DO Number : <?= $bdr['do_number']?></h5>
        
                    <!-- Horizontal Form -->
                    <form action="" method="post">

                        <input type="hidden" name="id_bdr" value="<?= $id_bdr?>">
                        <input type="hidden" name="do_id" value="<?= $bdr['do_id']?>">
                        <div class="mb-2">
                            <label for="bdr_no" class="form-label">BDR No <span id="x">*</span></label>
                            <input type="text" class="form-control" name="bdr_no" id="bdr_no" value="<?= $bdr['bdr_no'] ?>" >
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="mb-2">
                                    <label for="discharging_port" class="form-label">Delivered at <span id="x">*</span></label>
                                    <input type="text" value="<?= $selectedDischargingPort?>" class="form-control" disabled>
                                </div>
                            </div>
                            
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="mb-2">
                                    <label for="do_date" class="form-label">Date </label>
                                    <input type="date" class="form-control" id="do_date" value="<?= $bdr['do_date']?>" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="mb-2">
                                    <label for="delivered_by" class="form-label">Delivered by </label>
                                    <input type="text" class="form-control" name="delivered_by" id="delivered_by" value="<?= $bdr['delivered_by']?>">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="mb-2">
                                    <label for="vessel_cust" class="form-label">Vessel's Name</label>
                                    <select name="vessel_cust" id="vessel_cust" class="form-select">
                                        <option value="" selected>Select a vessel</option>
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

                            <div id="remove-vessel-buttons-container" class="remove-buttons-container">
                                <!-- Tombol remove untuk vessel akan muncul di sini -->
                            </div>

                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const vesselSelect = document.getElementById('vessel_cust');
                                    const newVesselInput = document.getElementById('new_vessel');
                                    const addVesselBtn = document.getElementById('add_vessel');
                                    const removeVesselButtonsContainer = document.getElementById('remove-vessel-buttons-container');

                                    // Retrieve the selected vessel from PHP
                                    const selectedVessel = '<?php echo isset($selectedVessel) ? htmlspecialchars($selectedVessel, ENT_QUOTES) : ''; ?>'; // Escape the PHP variable for safety

                                    // Function to fetch vessels and populate the select dropdown
                                    function fetchVessels() {
                                        const timestamp = new Date().getTime(); // Unique timestamp to avoid cache
                                        fetch(`vessel.json?t=${timestamp}`)
                                            .then(response => response.json())
                                            .then(data => {
                                                vesselSelect.innerHTML = '<option value="" selected>Select a vessel</option>';
                                                removeVesselButtonsContainer.innerHTML = '';

                                                data.forEach(vessel => {
                                                    addVesselOption(vesselSelect, vessel);
                                                    addRemoveVesselButton(vessel);
                                                });

                                                // Set the selected vessel in the dropdown if it matches the selectedVessel value from PHP
                                                setSelectedVessel();
                                            })
                                            .catch(error => console.error('Error fetching vessel data:', error));
                                    }

                                    // Function to add an option to the select element
                                    function addVesselOption(selectElement, vessel) {
                                        const option = document.createElement('option');
                                        option.value = vessel;
                                        option.textContent = vessel;
                                        selectElement.appendChild(option);
                                    }

                                    // Function to add a remove button for each vessel
                                    function addRemoveVesselButton(vessel) {
                                        const button = document.createElement('button');
                                        button.className = 'remove-button';
                                        button.textContent = `Remove ${vessel}`;
                                        button.onclick = function() {
                                            if (confirm(`Are you sure you want to remove ${vessel}?`)) {
                                                removeVessel(vessel);
                                            }
                                        };
                                        removeVesselButtonsContainer.appendChild(button);
                                    }

                                    // Add new vessel to the select dropdown and update the JSON file
                                    addVesselBtn.addEventListener('click', function() {
                                        const newVessel = newVesselInput.value.trim();

                                        if (newVessel) {
                                            addVesselOption(vesselSelect, newVessel);
                                            addRemoveVesselButton(newVessel);

                                            fetch('update_vessel.php', {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/json'
                                                },
                                                body: JSON.stringify({ action: 'add', vessel: newVessel })
                                            })
                                            .then(response => response.text())
                                            .then(data => {
                                                console.log(data);
                                                alert('New vessel added successfully!');
                                                newVesselInput.value = ''; // Clear the input
                                                fetchVessels(); // Refresh vessels to ensure they are updated
                                            })
                                            .catch(error => console.error('Error updating JSON file:', error));
                                        } else {
                                            alert('Please enter a valid vessel.');
                                        }
                                    });

                                    // Function to remove a vessel
                                    function removeVessel(vessel) {
                                        fetch('update_vessel.php', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json'
                                            },
                                            body: JSON.stringify({ action: 'remove', vessel: vessel })
                                        })
                                        .then(response => response.text())
                                        .then(data => {
                                            console.log(data);
                                            alert('Vessel removed successfully!');
                                            fetchVessels(); // Reload the vessels
                                        })
                                        .catch(error => console.error('Error updating JSON file:', error));
                                    }

                                    // Function to set the selected vessel
                                    function setSelectedVessel() {
                                        if (selectedVessel) {
                                            const options = vesselSelect.options;
                                            for (let i = 0; i < options.length; i++) {
                                                if (options[i].value === selectedVessel) {
                                                    options[i].selected = true;
                                                    break;
                                                }
                                            }
                                        }
                                    }

                                    // Load the vessels when the page is loaded
                                    fetchVessels();
                                });
                            </script>
                            
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="mb-2">
                                    <label for="product" class="form-label">Product <span id="x">*</span></label>
                                    <select id="product" class="form-select" required disabled>
                                        <!-- Opsi-opsi dari JSON akan ditambahkan di sini -->
                                    </select>
                                </div>
                            </div>
                            
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const productSelect = document.getElementById('product');
                                
                                    // Ambil data PHP untuk product yang sudah dipilih
                                    const selectedProduct = '<?= $selectedProduct ?>'; // PHP variable for selected product
                                
                                    // Fetch options from the JSON file and populate select dropdown
                                    fetch('product.json') // Assuming you have a JSON file named 'products.json'
                                        .then(response => response.json())
                                        .then(data => {
                                            data.forEach(product => {
                                                const optionProduct = document.createElement('option');
                                                optionProduct.value = product;
                                                optionProduct.textContent = product;
                                
                                                // Mark as selected if it matches the current value from the database
                                                if (product === selectedProduct) {
                                                    optionProduct.selected = true;
                                                }
                                                productSelect.appendChild(optionProduct);
                                            });
                                        })
                                        .catch(error => console.error('Error fetching product data:', error));
                                });
                            </script>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="mb-2">
                                    <label for="next_port" class="form-label">Next Port </label>
                                    <input type="text" class="form-control" name="next_port" value="<?= $bdr['next_port']?>" id="next_port">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="mb-2">
                                    <label for="commence_pump" class="form-label">Commence Pump </label>
                                    <input type="text" class="form-control" id="commence_pump" value="<?= $bdr['commence_pump']?>" disabled>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="mb-2">
                                    <label for="etd" class="form-label">E.T.D </label>
                                    <input type="text" class="form-control" id="etd" value="<?= $bdr['departure_time']?>" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="mb-2">
                                    <label for="finished_pump" class="form-label">Finished Pump </label>
                                    <input type="text" class="form-control" id="finished_pump" value="<?= $bdr['finished_pump']?>" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <hr>
                            <p>PRODUCT SUPPLIED</p>
                            <hr>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <b>Fuel Characteristic</b>/<i>Karakteristik bahan bakar</i>
                                <div class="mb-2">
                                    <label for="visc" class="form-label">Visc. cSt @40&deg;C <br/><i>(ASTM D445/ISO 3104)</i> <span id="x">*</span></label>
                                    <input type="text" name="visc" id="visc" value="<?= $bdr['visc']?>" class="form-control">
                                </div>
                            
                                <div class="mb-2">
                                    <label for="density" class="form-label">Density @ 15&deg;C <br/><i>(ASTM D1298-D4052)</i> <span id="x">*</span></label>
                                    <input type="text" id="density" name="density" class="form-control" value="<?= $bdr['density']?>" required>
                                </div>

                                <div class="mb-2">
                                    <label for="flashpoint" class="form-label">Flashpoint &deg;C <br/><i>(ASTM D93)</i> <span id="x">*</span></label>
                                    <input type="text" id="flashpoint" name="flashpoint" class="form-control" value="<?= $bdr['flashpoint']?>" required>
                                </div>

                                <div class="mb-2">
                                    <label for="sulphur" class="form-label">Sulphur wt% <br/><i>(ASTM D2622/D4294/D5453)</i> <span id="x">*</span></label>
                                    <input type="text" id="sulphur" name="sulphur" class="form-control" value="<?= $bdr['sulphur']?>" required>
                                </div>

                                <div class="mb-2">
                                    <label for="water_content" class="form-label">Water Content % Vol. <br/><i>(ASTM D6304/ISO 3733:1999)</i> <span id="x">*</span></label>
                                    <input type="text" id="water_content" name="water_content" class="form-control" value="<?= $bdr['water_content']?>" required>
                                </div>
                            </div>
                            
                            <?php
                                $quantity = $bdr['quantity']; // Asumsikan $bdr['quantity'] sudah didefinisikan
                                $wcf = 0.8479; // Nilai default dari W.C.F
                            ?>

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <b>Quantity</b>/<i>Jumlah</i>

                                <div class="mb-2">
                                    <label for="quantity" class="form-label">Gross Vol. Litres <span id="x">*</span></label>
                                    <input type="text" class="form-control" value="<?= number_format($quantity, 0, ',', '.') ?>" disabled>
                                </div>                                

                                <div class="mb-2">
                                    <label for="cubic_meter" class="form-label">Cubic Meter (KL)</label>
                                    <input type="text" id="cubic_meter" class="form-control" value="<?= number_format($quantity / 1000, 0, ',', '.') ?>" disabled>
                                </div>

                                <div class="mb-2">
                                    <label for="net_metric_ton" class="form-label">Net Metric Tons</label>
                                    <input type="text" id="net_metric_ton" name="net_metric_ton" class="form-control" value="<?= number_format(($quantity * $wcf / 1000), 3, '.', '.') ?>" readonly>
                                </div>

                                <script>
                                    function updateNetMetricTon() {
                                        // Ambil nilai W.C.F dari input
                                        let wcf = parseFloat(document.getElementById('wcf').value) || 0;

                                        // Ambil nilai quantity dari PHP
                                        let quantity = <?= $quantity ?>;

                                        // Hitung Net Metric Tons
                                        let netMetricTon = (quantity * wcf / 1000).toFixed(3);

                                        // Format angka menjadi ribuan dengan titik (misal: 1.000,00)
                                        netMetricTon = netMetricTon.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");

                                        // Update input Net Metric Tons
                                        document.getElementById('net_metric_ton').value = netMetricTon;
                                    }

                                    function updateWcf(value) {
                                        // Update nilai W.C.F secara real-time
                                        document.getElementById('wcf').value = value;
                                        
                                        // Panggil fungsi untuk memperbarui Net Metric Tons
                                        updateNetMetricTon();
                                    }
                                </script>

                                <div class="mb-2">
                                    <label for="vcf" class="form-label">V.C.F (ASTM tab. 54)</label>
                                    <input type="text" id="vcf" name="vcf" class="form-control" value="<?= $bdr['vcf']?>">
                                </div>

                                <div class="mb-2">
                                    <label for="wcf" class="form-label">W.C.F (ASTM tab. 56)</label>
                                    <input type="text" id="wcf" name="wcf" class="form-control" value="<?= $bdr['wcf'] ?>" oninput="updateWcf(this.value)">
                                </div>

                                <div class="mb-2">
                                    <label for="temp" class="form-label">Temperature &deg;C</label>
                                    <input type="text" id="temp" name="temp" class="form-control" value="<?= $bdr['temp'] ?>">
                                </div>

                                <div class="mb-2">
                                    <label for="table_52" class="form-label">Table 52 &deg;C</label>
                                    <input type="text" id="table_52" name="table_52" class="form-control" value="<?= $bdr['table_52'] ?>">
                                </div>

                                <div class="mb-2">
                                    <label for="table_1" class="form-label">Table 1 (MT/LT)</label>
                                    <input type="text" id="table_1" name="table_1" class="form-control" value="<?= $bdr['table_1'] ?>">
                                </div>
                            </div>
                        </div>


                        <div class="text-left">
                        <button type="submit" class="btn btn-primary btn-sm" name="editBdr"><i class="fa fa-file-invoice fa-sm"></i> Update</button>
                        <a href="view-bdr.php?id_bdr=<?= $id_bdr?>" class="btn btn-danger btn-sm"><i class="fa fa-times fa-sm"></i> Cancel</a>
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