<?php 

$host = "localhost";
$user = "root";
$pass = "78789898";
$db = "egppbunker"; //nama database
//melakukan koneksi ke database
$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
	echo "Gagal konek: " . die(mysqli_error($koneksi));
}

function query($query){
	global $koneksi;
	$result = mysqli_query($koneksi, $query);
	$rows = [];
	while ($row = mysqli_fetch_assoc($result) ) {
		$rows[] = $row;
	}

	return $rows;
}


function changePassword($data) {
	global $koneksi;
	$id_user = $data["id_user"];
	$nama = htmlspecialchars($data["nama"]);
	$username = htmlspecialchars($data["username"]);
	$password = mysqli_real_escape_string($koneksi, $data["password"]);
	$is_admin = 0;

	$password2 = password_hash($password, PASSWORD_DEFAULT);

	$query = "UPDATE user SET
				nama = '$nama',
				username = '$username',
				password = '$password2',
				is_admin = '$is_admin'
			  WHERE id_user = $id_user
			";
	mysqli_query($koneksi, $query);

	return mysqli_affected_rows($koneksi);
}


function tambahLogin($data){
	global $koneksi;

	$nama	= mysqli_real_escape_string($koneksi, $data["nama"]);	
	$username = strtolower(stripcslashes($data["username"]));
	$password = mysqli_real_escape_string($koneksi, $data["password"]);
    $password2 = mysqli_real_escape_string($koneksi, $data["password2"]);
	$is_admin	= 0;	

	// cek username sudah ada atau belum
	$result = mysqli_query($koneksi, "SELECT username FROM user WHERE username= '$username'");
	if (mysqli_fetch_assoc($result)) {
		echo '<link rel="stylesheet" href="./sweetalert2.min.css"></script>';
		echo '<script src="./sweetalert2.min.js"></script>';
		echo "<script>
		setTimeout(function () { 
			swal.fire({
				
				title               : 'Registration Failed',
				text                :  'The selected username is already registered',
				//footer              :  '',
				icon                : 'error',
				timer               : 2000,
				showConfirmButton   : true
			});  
		},10);   setTimeout(function () {
			window.location.href = 'manage-user.php'; //will redirect to your blog page (an ex: blog.html)
		}, 2000); //will call the function after 2 secs
		</script>";

		return false;
	}

	// cek konfirmasi password
	if ($password !== $password2) {
		echo '<link rel="stylesheet" href="./sweetalert2.min.css"></script>';
		echo '<script src="./sweetalert2.min.js"></script>';
		echo "<script>
		setTimeout(function () { 
			swal.fire({
				
				title               : 'Registration Failed',
				text                :  'Password Confirmation Does Not Match!',
				//footer              :  '',
				icon                : 'error',
				timer               : 2000,
				showConfirmButton   : true
			});  
		},10);   setTimeout(function () {
			window.location.href = 'manage-user.php'; //will redirect to your blog page (an ex: blog.html)
		}, 2000); //will call the function after 2 secs
		</script>";

		return false;
	}

	// enkripsi password
	$password = password_hash($password, PASSWORD_DEFAULT);


	// tambahkan user baru ke database
	mysqli_query($koneksi, "INSERT INTO user VALUES('', '$nama', '$username', '$password', '$is_admin')");

	return mysqli_affected_rows($koneksi);
}

function ubahLogin($data) {
	global $koneksi;
	$id_user = $data["id_user"];
	$nama = htmlspecialchars($data['nama']);
	$username = htmlspecialchars($data["username"]);
	$password = mysqli_real_escape_string($koneksi, $data["password"]);

	$password2 = password_hash($password, PASSWORD_DEFAULT);
	$is_admin	= 0;	

	$query = "UPDATE user SET
				nama = '$nama',
				username = '$username',
				password = '$password2',
				is_admin = '$is_admin'
			  WHERE id_user = $id_user
			";
	mysqli_query($koneksi, $query);

	return mysqli_affected_rows($koneksi);
}


function hapusLogin($id_user) {
	global $koneksi;
	mysqli_query($koneksi, "DELETE FROM user WHERE id_user=$id_user");

	return mysqli_affected_rows($koneksi);

}

function registrasi($data){
	global $koneksi;

    $nama = stripcslashes($data["nama"]);
	$email = strtolower(stripcslashes($data["email"]));
	$password = mysqli_real_escape_string($koneksi, $data["password"]);
    $password2 = mysqli_real_escape_string($koneksi, $data["password2"]);
	

	// cek email sudah ada atau belum
	$result = mysqli_query($koneksi, "SELECT email FROM users WHERE email= '$email'");
	if (mysqli_fetch_assoc($result)) {
		echo '<link rel="stylesheet" href="./sweetalert2.min.css"></script>';
		echo '<script src="./sweetalert2.min.js"></script>';
		echo "<script>
		setTimeout(function () { 
			swal.fire({
				
				title               : 'Registration Failed',
				text                :  'The selected email is already registered',
				//footer              :  '',
				icon                : 'error',
				timer               : 2000,
				showConfirmButton   : true
			});  
		},10);   setTimeout(function () {
			window.location.href = 'index.php'; //will redirect to your blog page (an ex: blog.html)
		}, 2000); //will call the function after 2 secs
		</script>";
		return false;
	}

	// cek konfirmasi password
	if ($password !== $password2) {
		echo "
			<script>
				alert('konfirmasi password tidak sesuai!');
			</script>
		";
		return false;
	}

	// enkripsi password
	$password = password_hash($password, PASSWORD_DEFAULT);


	// tambahkan user baru ke database
	mysqli_query($koneksi, "INSERT INTO users VALUES('','$nama', '$email', '$password', '')");

	return mysqli_affected_rows($koneksi);
}

function removeUser($id_user) {
	global $koneksi;
	mysqli_query($koneksi, "DELETE FROM users WHERE id_user=$id_user");

	return mysqli_affected_rows($koneksi);

}

function resetPassword($data) {
	global $koneksi;
	$id_user = htmlspecialchars($data["id_user"]);
	$password = htmlspecialchars($data["password"]);
	$password2 = htmlspecialchars($data["password2"]);

    // cek konfirmasi password
	if ($password !== $password2) {
		return false;
	}

    // enkripsi password
	$password = password_hash($password, PASSWORD_DEFAULT);

	$query = "UPDATE users SET
				id_user = '$id_user',
				password = '$password'
			  WHERE id_user = $id_user
			";
	mysqli_query($koneksi, $query);

	return mysqli_affected_rows($koneksi);
}

function makeAdmin($id_user) {
    global $koneksi;
    $id_user = mysqli_real_escape_string($koneksi, $id_user); // Menghindari SQL Injection
    
    $query = "UPDATE users SET
                is_admin = '1'
              WHERE id_user = '$id_user'
            ";
    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}
function removeAdmin($id_user) {
    global $koneksi;
    $id_user = mysqli_real_escape_string($koneksi, $id_user); // Menghindari SQL Injection

    $query = "UPDATE users SET
                is_admin = '0'
              WHERE id_user = '$id_user'
            ";
    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

function generateDoNumber() {
    global $koneksi;

    // Ambil nomor urut terakhir
    $query = "SELECT do_number FROM delivery_order ORDER BY id_do DESC LIMIT 1";
    $result = mysqli_query($koneksi, $query);
    $last_do_number = mysqli_fetch_assoc($result)['do_number'];

    // Ekstrak nomor urut terakhir dan tambahkan 1
    $last_number = $last_do_number ? (int)explode('/', $last_do_number)[0] : 0;
    $new_number = str_pad($last_number + 1, 3, '0', STR_PAD_LEFT);

    // Dapatkan bulan dalam format Romawi
    $month = date('n'); // Bulan dalam format numerik
    $month_romawi = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
    $current_month_romawi = $month_romawi[$month - 1];

    // Dapatkan tahun saat ini
    $year = date('Y');

    // Format nomor DO
    return "{$new_number}/DO-GPP/{$current_month_romawi}/{$year}";
}


function tambahDelivery($data) {
    global $koneksi;
    $po_number = htmlspecialchars($data["po_number"]);
    $do_number = htmlspecialchars($data["do_number"]);
    $do_date = !empty($data["do_date"]) ? htmlspecialchars($data["do_date"]) : NULL; // Set to NULL if empty
    $customer_id = htmlspecialchars($data["customer_id"]);
    $product = htmlspecialchars($data["product"]);
    $armada = htmlspecialchars($data["armada"]);
    $quantity = htmlspecialchars($data["quantity"]);
    $driver = htmlspecialchars($data["driver"]);
    $departure_time = htmlspecialchars($data["departure_time"]);
    $arrival_time = htmlspecialchars($data["arrival_time"]);
    $loading_port = htmlspecialchars($data["loading_port"]);
    $discharging_port = htmlspecialchars($data["discharging_port"]);
    $commence_pump = htmlspecialchars($data["commence_pump"]);
    $finished_pump = htmlspecialchars($data["finished_pump"]);
    $seal_number1 = htmlspecialchars($data["seal_number1"]);
    $seal_number2 = htmlspecialchars($data["seal_number2"]);

    $query = "INSERT INTO delivery_order (
        po_number, do_number, do_date, customer_id, product, armada, quantity, driver, 
        departure_time, arrival_time, loading_port, discharging_port, commence_pump, 
        finished_pump, seal_number1, seal_number2
    ) VALUES (
        '$po_number', '$do_number', " . ($do_date === NULL ? "NULL" : "'$do_date'") . ", 
        '$customer_id', '$product', '$armada', '$quantity', '$driver', 
        '$departure_time', '$arrival_time', '$loading_port', '$discharging_port', 
        '$commence_pump', '$finished_pump', '$seal_number1', '$seal_number2'
    )";
    
    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}


function editDelivery($data) {
    global $koneksi;
    $id_do = $data["id_do"];
    $po_number = htmlspecialchars($data["po_number"]);
    $do_number = htmlspecialchars($data["do_number"]);
    $do_date = !empty($data["do_date"]) ? htmlspecialchars($data["do_date"]) : NULL; // Set to NULL if empty
    $customer_id = htmlspecialchars($data["customer_id"]);
    $product = htmlspecialchars($data["product"]);
    $armada = htmlspecialchars($data["armada"]);
    $quantity = htmlspecialchars($data["quantity"]);
    $driver = htmlspecialchars($data["driver"]);
    $departure_time = htmlspecialchars($data["departure_time"]);
    $arrival_time = htmlspecialchars($data["arrival_time"]);
    $loading_port = htmlspecialchars($data["loading_port"]);
    $discharging_port = htmlspecialchars($data["discharging_port"]);
    $commence_pump = htmlspecialchars($data["commence_pump"]);
    $finished_pump = htmlspecialchars($data["finished_pump"]);
    $seal_number1 = htmlspecialchars($data["seal_number1"]);
    $seal_number2 = htmlspecialchars($data["seal_number2"]);

    // Update data delivery_order di database
    $query = "UPDATE delivery_order SET
                po_number = '$po_number',
                do_number = '$do_number',
                do_date = " . ($do_date === NULL ? "NULL" : "'$do_date'") . ",
                customer_id = '$customer_id',
                product = '$product',
                armada = '$armada',
                quantity = '$quantity',
                driver = '$driver',
                departure_time = '$departure_time',
                arrival_time = '$arrival_time',
                loading_port = '$loading_port',
                discharging_port = '$discharging_port',
                commence_pump = '$commence_pump',
                finished_pump = '$finished_pump',
                seal_number1 = '$seal_number1',
                seal_number2 = '$seal_number2'
              WHERE id_do = $id_do";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}



function removeDelivery($id_do) {
	global $koneksi;
	mysqli_query($koneksi, "DELETE FROM delivery_order WHERE id_do=$id_do");

	return mysqli_affected_rows($koneksi);

}

function tambahCustomer($data) {
	global $koneksi;
	$customer_name = htmlspecialchars($data["customer_name"]);
	$address = htmlspecialchars($data["address"]);

	$query = "INSERT INTO customer VALUES
			('', '$customer_name', '$address')";
	mysqli_query($koneksi, $query);

	return mysqli_affected_rows($koneksi);
}

function editCustomer($data) {
	global $koneksi;
	$id_customer = mysqli_real_escape_string($koneksi, $data['id_customer']);
	$customer_name = htmlspecialchars($data["customer_name"]);
	$address = htmlspecialchars($data["address"]);

	$query = "UPDATE customer SET
				customer_name = '$customer_name',
				address = '$address'
			  WHERE id_customer = $id_customer
			";
	mysqli_query($koneksi, $query);

	return mysqli_affected_rows($koneksi);
}

function removeCustomer($id_customer) {
	global $koneksi;
	try{
		mysqli_query($koneksi, "DELETE FROM customer WHERE id_customer=$id_customer");
	}catch(Exception $e){
		return false;
	}

	return mysqli_affected_rows($koneksi);

}

function generateBdrNumber() {
    global $koneksi;

    // Ambil nomor urut terakhir
    $query = "SELECT bdr_no FROM bdr ORDER BY id_bdr DESC LIMIT 1";
    $result = mysqli_query($koneksi, $query);

    if (!$result) {
        die('Query Error: ' . mysqli_error($koneksi)); // Tangani kesalahan query
    }

    $last_bdr_no_assoc = mysqli_fetch_assoc($result);

    if ($last_bdr_no_assoc) {
        $last_bdr_no = $last_bdr_no_assoc['bdr_no'];
    } else {
        $last_bdr_no = null; // Atau string kosong jika lebih sesuai
    }

    // Ekstrak nomor urut terakhir dan tambahkan 1
    $last_no = $last_bdr_no ? (int)explode('/', $last_bdr_no)[0] : 0;
    $new_no = str_pad($last_no + 1, 3, '0', STR_PAD_LEFT);

    // Dapatkan bulan dalam format Romawi
    $month = date('n'); // Bulan dalam format numerik
    $month_romawi = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
    $current_month_romawi = $month_romawi[$month - 1];

    // Dapatkan tahun saat ini
    $year = date('Y');

    // Format nomor BDR
    return "{$new_no}/BDR-GPP/{$current_month_romawi}/{$year}";
}

function tambahBdr($data) {
	global $koneksi;
	$do_id = mysqli_real_escape_string($koneksi, $data['do_id']);
	$bdr_no = mysqli_real_escape_string($koneksi, $data['bdr_no']);
	$delivered_by = mysqli_real_escape_string($koneksi, $data['delivered_by']);
	$vessel_cust = mysqli_real_escape_string($koneksi, $data['vessel_cust']);
	$next_port = mysqli_real_escape_string($koneksi, $data['next_port']);
	$visc = mysqli_real_escape_string($koneksi, $data['visc']);
	$density = mysqli_real_escape_string($koneksi, $data['density']);
	$flashpoint = mysqli_real_escape_string($koneksi, $data['flashpoint']);
	$sulphur = mysqli_real_escape_string($koneksi, $data['sulphur']);
	$water_content = mysqli_real_escape_string($koneksi, $data['water_content']);
	$net_metric_ton = mysqli_real_escape_string($koneksi, $data['net_metric_ton']);
	$vcf = mysqli_real_escape_string($koneksi, $data['vcf']);
	$wcf = mysqli_real_escape_string($koneksi, $data['wcf']);
	$temp = mysqli_real_escape_string($koneksi, $data['temp']);
	$table_52 = mysqli_real_escape_string($koneksi, $data['table_52']);
	$table_1 = mysqli_real_escape_string($koneksi, $data['table_1']);

	$query = "INSERT INTO bdr VALUES
			('', '$do_id', '$bdr_no', '$delivered_by', '$vessel_cust', '$next_port', '$visc', '$density', '$flashpoint', '$sulphur', '$water_content', '$net_metric_ton', '$vcf', '$wcf', '$temp', '$table_52', '$table_1')";
	mysqli_query($koneksi, $query);

	return mysqli_affected_rows($koneksi);
}

function tambahCompany($data) {
	global $koneksi;
	$company_name = htmlspecialchars($data["company_name"]);

	$query = "INSERT INTO company VALUES
			('', '$company_name')";
	mysqli_query($koneksi, $query);

	return mysqli_affected_rows($koneksi);
}

function editCompany($data) {
	global $koneksi;
	$id_company = mysqli_real_escape_string($koneksi, $data['id_company']);
	$company_name = htmlspecialchars($data["company_name"]);

	$query = "UPDATE company SET
				id_company = '$id_company',
				company_name = '$company_name'
			  WHERE id_company = $id_company
			";
	mysqli_query($koneksi, $query);

	return mysqli_affected_rows($koneksi);
}

function removeCompany($id_company) {
	global $koneksi;
	try{
		mysqli_query($koneksi, "DELETE FROM company WHERE id_company=$id_company");
	}catch(Exception $e){
		return false;
	}

	return mysqli_affected_rows($koneksi);

}

function uploadPhoto(){

	$namaFile = $_FILES['photo']['name'];
	$ukuranFile = $_FILES['photo']['size'];
	$error = $_FILES['photo']['error'];
	$tmpName = $_FILES['photo']['tmp_name'];

	// cek apakah tidak ada file yang diupload
	if ($error === 4) {
		echo '<link rel="stylesheet" href="css/app.css"></script>';
		echo '<link rel="stylesheet" href="./sweetalert2.min.css"></script>';
		echo '<script src="./sweetalert2.min.js"></script>';
		echo "<script>
		setTimeout(function () { 
			swal.fire({
				
				title               : 'Failed',
				text                : 'Please select a file first!',
				icon                : 'error',
				timer               : 2000,
				showConfirmButton   : false
			});  
		},10);   setTimeout(function () {
			// window.location.href = 'manage-employees.php'; //will redirect to your blog page (an ex: blog.html)
		}, 2000); //will call the function after 2 secs
		</script>";
		return false;
	}

	// cek apakah yang diupload adalah png, jpg, jpeg
	$ekstensiFileValid = ['png', 'jpg', 'jpeg'];
	$ekstensiFile = explode('.', $namaFile);
	$ekstensiFile = strtolower(end($ekstensiFile));
	if (!in_array($ekstensiFile, $ekstensiFileValid) ){
		echo '<link rel="stylesheet" href="css/app.css"></script>';
		echo '<link rel="stylesheet" href="./sweetalert2.min.css"></script>';
		echo '<script src="./sweetalert2.min.js"></script>';
		echo "<script>
		setTimeout(function () { 
			swal.fire({
				
				title               : 'Failed',
				text                : 'Invalid file extension or the uploaded file is not an image!',
				icon                : 'error',
				timer               : 2000,
				showConfirmButton   : false
			});  
		},10);   setTimeout(function () {
			// window.location.href = 'manage-employees.php'; //will redirect to your blog page (an ex: blog.html)
		}, 2000); //will call the function after 2 secs
		</script>";
		return false;
	}

	// cek jika ukurannya terlalu besar
	if ($ukuranFile > 1000000){
		echo '<link rel="stylesheet" href="css/app.css"></script>';
		echo '<link rel="stylesheet" href="./sweetalert2.min.css"></script>';
		echo '<script src="./sweetalert2.min.js"></script>';
		echo "<script>
		setTimeout(function () { 
			swal.fire({
				
				title               : 'Failed',
				text                : 'The file size is too large!',
				icon                : 'error',
				timer               : 2000,
				showConfirmButton   : false
			});  
		},10);   setTimeout(function () {
			// window.location.href = 'manage-employees.php'; //will redirect to your blog page (an ex: blog.html)
		}, 2000); //will call the function after 2 secs
		</script>";
		return false;
	}

	// lolos pengecekan, photo siap diupload
	// generate nama photo baru
	$namaFileBaru = uniqid();
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiFile;

	move_uploaded_file($tmpName, 'files/photo/'. $namaFileBaru);
	return $namaFileBaru;
}

function uploadAttach(){

	$namaFile = $_FILES['attach']['name'];
	$ukuranFile = $_FILES['attach']['size'];
	$error = $_FILES['attach']['error'];
	$tmpName = $_FILES['attach']['tmp_name'];

	// cek apakah tidak ada file yang diupload
	if ($error === 4) {
		echo '<link rel="stylesheet" href="css/app.css"></script>';
		echo '<link rel="stylesheet" href="./sweetalert2.min.css"></script>';
		echo '<script src="./sweetalert2.min.js"></script>';
		echo "<script>
		setTimeout(function () { 
			swal.fire({
				
				title               : 'Failed',
				text                : 'Please select a file first!',
				icon                : 'error',
				timer               : 2000,
				showConfirmButton   : false
			});  
		},10);   setTimeout(function () {
			// window.location.href = 'manage-employees.php'; //will redirect to your blog page (an ex: blog.html)
		}, 2000); //will call the function after 2 secs
		</script>";
		return false;
	}

	// cek apakah yang diupload adalah pdf
	$ekstensiFileValid = ['pdf'];
	$ekstensiFile = explode('.', $namaFile);
	$ekstensiFile = strtolower(end($ekstensiFile));
	if (!in_array($ekstensiFile, $ekstensiFileValid) ){
		echo '<link rel="stylesheet" href="css/app.css"></script>';
		echo '<link rel="stylesheet" href="./sweetalert2.min.css"></script>';
		echo '<script src="./sweetalert2.min.js"></script>';
		echo "<script>
		setTimeout(function () { 
			swal.fire({
				
				title               : 'Failed',
				text                : 'The uploaded file is not a PDF!',
				icon                : 'error',
				timer               : 2000,
				showConfirmButton   : false
			});  
		},10);   setTimeout(function () {
			// window.location.href = 'manage-employees.php'; //will redirect to your blog page (an ex: blog.html)
		}, 2000); //will call the function after 2 secs
		</script>";
		return false;
	}

	// cek jika ukurannya terlalu besar
	if ($ukuranFile > 3000000){
		echo '<link rel="stylesheet" href="css/app.css"></script>';
		echo '<link rel="stylesheet" href="./sweetalert2.min.css"></script>';
		echo '<script src="./sweetalert2.min.js"></script>';
		echo "<script>
		setTimeout(function () { 
			swal.fire({
				
				title               : 'Failed',
				text                : 'The file size is too large!',
				icon                : 'error',
				timer               : 2000,
				showConfirmButton   : false
			});  
		},10);   setTimeout(function () {
			// window.location.href = 'manage-employees.php'; //will redirect to your blog page (an ex: blog.html)
		}, 2000); //will call the function after 2 secs
		</script>";
		return false;
	}

	// lolos pengecekan, attach siap diupload
	// generate nama attach baru
	$namaFileBaru = uniqid();
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiFile;

	move_uploaded_file($tmpName, 'files/attach/'. $namaFileBaru);
	return $namaFileBaru;
}

function tambahEmployee($data) {
	global $koneksi;
	date_default_timezone_set('Asia/Jakarta');
	$company_id = htmlspecialchars($data["company_id"]);
	$emp_no = htmlspecialchars($data["emp_no"]);
	$emp_name = htmlspecialchars($data["emp_name"]);
	$email = htmlspecialchars($data["email"]);
	$phone = htmlspecialchars($data["phone"]);
	$address = htmlspecialchars($data["address"]);
	$hire_date = htmlspecialchars($data["hire_date"]);
	$title_id = htmlspecialchars($data["title_id"]);
	$salary = htmlspecialchars($data["salary"]);
	$status = 'active';
	$created_at = date('Y-m-d H:i:s');

	// Upload photo and attachment
    $photo = uploadPhoto();
    $attach = uploadAttach();

    if (!$photo || !$attach) {
        // If either upload fails, do not proceed
        if ($photo) { // If photo was uploaded, delete it
            unlink('files/photo/' . $photo); // 
        }
        if ($attach) { // If attachment was uploaded, delete it
            unlink('files/attach/' . $attach); // 
        }
        return false;
    }

	$query = "INSERT INTO employees VALUES
			('', '$company_id', '$emp_no', '$emp_name', '$email', '$phone', '$address', '$hire_date', '$title_id', '$salary', '$photo', '$attach', '$status', '$created_at')";
	mysqli_query($koneksi, $query);

	return mysqli_affected_rows($koneksi);
}

function editEmployee($data) {
    global $koneksi;
	date_default_timezone_set('Asia/Jakarta');
    $id_emp = $data["id_emp"];
    $company_id = htmlspecialchars($data["company_id"]);
    $emp_no = htmlspecialchars($data["emp_no"]);
    $emp_name = htmlspecialchars($data["emp_name"]);
    $email = htmlspecialchars($data["email"]);
    $phone = htmlspecialchars($data["phone"]);
    $address = htmlspecialchars($data["address"]);
    $hire_date = htmlspecialchars($data["hire_date"]);
    $title_id = htmlspecialchars($data["title_id"]);
    $salary = htmlspecialchars($data["salary"]);

    $updated_at = date('Y-m-d H:i:s');

    // Inisialisasi variabel untuk file lama
    $photoLama = isset($data["photo_lama"]) ? mysqli_real_escape_string($koneksi, $data["photo_lama"]) : '';
    $attachLama = isset($data["attach_lama"]) ? mysqli_real_escape_string($koneksi, $data["attach_lama"]) : '';

    // cek apakah user pilih file baru untuk photo dan attachment
    $photo = '';
    $attach = '';

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] !== 4) {
        // Upload photo baru
        $photo = uploadPhoto();

        if (!$photo) {
            return false;
        }

        // Hapus photo lama jika ada
        if (!empty($photoLama)) {
            $photo_path = 'files/photo/' . $photoLama;
            if (file_exists($photo_path)) {
                unlink($photo_path);
            }
        }
    } else {
        // Jika tidak ada photo baru, gunakan photo lama
        $photo = $photoLama;
    }

    if (isset($_FILES['attach']) && $_FILES['attach']['error'] !== 4) {
        // Upload attachment baru
        $attach = uploadAttach();

        if (!$attach) {
            return false;
        }

        // Hapus attachment lama jika ada
        if (!empty($attachLama)) {
            $attach_path = 'files/attach/' . $attachLama;
            if (file_exists($attach_path)) {
                unlink($attach_path);
            }
        }
    } else {
        // Jika tidak ada attachment baru, gunakan attachment lama
        $attach = $attachLama;
    }

    // Update data karyawan di database
    $query = "UPDATE employees SET
                company_id = '$company_id',
                emp_no = '$emp_no',
                emp_name = '$emp_name',
                email = '$email',
                phone = '$phone',
                address = '$address',
                hire_date = '$hire_date',
                title_id = '$title_id',
                salary = '$salary',
                photo = '$photo',
                attach = '$attach',
                created_at = '$updated_at'
              WHERE id_emp = $id_emp";
              
    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

function uploadSeparationLetter(){

	$namaFile = $_FILES['separation_letter']['name'];
	$ukuranFile = $_FILES['separation_letter']['size'];
	$error = $_FILES['separation_letter']['error'];
	$tmpName = $_FILES['separation_letter']['tmp_name'];

	// cek apakah tidak ada file yang diupload
	if ($error === 4) {
		echo '<link rel="stylesheet" href="css/app.css"></script>';
		echo '<link rel="stylesheet" href="./sweetalert2.min.css"></script>';
		echo '<script src="./sweetalert2.min.js"></script>';
		echo "<script>
		setTimeout(function () { 
			swal.fire({
				
				title               : 'Failed',
				text                : 'Please select a file first!',
				icon                : 'error',
				timer               : 2000,
				showConfirmButton   : false
			});  
		},10);   setTimeout(function () {
			// window.location.href = 'manage-employees.php'; //will redirect to your blog page (an ex: blog.html)
		}, 2000); //will call the function after 2 secs
		</script>";
		return false;
	}

	// cek apakah yang diupload adalah pdf
	$ekstensiFileValid = ['pdf'];
	$ekstensiFile = explode('.', $namaFile);
	$ekstensiFile = strtolower(end($ekstensiFile));
	if (!in_array($ekstensiFile, $ekstensiFileValid) ){
		echo '<link rel="stylesheet" href="css/app.css"></script>';
		echo '<link rel="stylesheet" href="./sweetalert2.min.css"></script>';
		echo '<script src="./sweetalert2.min.js"></script>';
		echo "<script>
		setTimeout(function () { 
			swal.fire({
				
				title               : 'Failed',
				text                : 'The uploaded file is not a PDF!',
				icon                : 'error',
				timer               : 2000,
				showConfirmButton   : false
			});  
		},10);   setTimeout(function () {
			// window.location.href = 'manage-employees.php'; //will redirect to your blog page (an ex: blog.html)
		}, 2000); //will call the function after 2 secs
		</script>";
		return false;
	}

	// cek jika ukurannya terlalu besar
	if ($ukuranFile > 3000000){
		echo '<link rel="stylesheet" href="css/app.css"></script>';
		echo '<link rel="stylesheet" href="./sweetalert2.min.css"></script>';
		echo '<script src="./sweetalert2.min.js"></script>';
		echo "<script>
		setTimeout(function () { 
			swal.fire({
				
				title               : 'Failed',
				text                : 'The file size is too large!',
				icon                : 'error',
				timer               : 2000,
				showConfirmButton   : false
			});  
		},10);   setTimeout(function () {
			// window.location.href = 'manage-employees.php'; //will redirect to your blog page (an ex: blog.html)
		}, 2000); //will call the function after 2 secs
		</script>";
		return false;
	}

	// lolos pengecekan, separation letter siap diupload
	// generate nama separation letter baru
	$namaFileBaru = uniqid();
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiFile;

	move_uploaded_file($tmpName, 'files/separation-letter/'. $namaFileBaru);
	return $namaFileBaru;
}

function uploadExperienceLetter(){

	$namaFile = $_FILES['experience_letter']['name'];
	$ukuranFile = $_FILES['experience_letter']['size'];
	$error = $_FILES['experience_letter']['error'];
	$tmpName = $_FILES['experience_letter']['tmp_name'];

	// cek apakah tidak ada file yang diupload
	if ($error === 4) {
		echo '<link rel="stylesheet" href="css/app.css"></script>';
		echo '<link rel="stylesheet" href="./sweetalert2.min.css"></script>';
		echo '<script src="./sweetalert2.min.js"></script>';
		echo "<script>
		setTimeout(function () { 
			swal.fire({
				
				title               : 'Failed',
				text                : 'Please select a file first!',
				icon                : 'error',
				timer               : 2000,
				showConfirmButton   : false
			});  
		},10);   setTimeout(function () {
			// window.location.href = 'manage-employees.php'; //will redirect to your blog page (an ex: blog.html)
		}, 2000); //will call the function after 2 secs
		</script>";
		return false;
	}

	// cek apakah yang diupload adalah pdf
	$ekstensiFileValid = ['pdf'];
	$ekstensiFile = explode('.', $namaFile);
	$ekstensiFile = strtolower(end($ekstensiFile));
	if (!in_array($ekstensiFile, $ekstensiFileValid) ){
		echo '<link rel="stylesheet" href="css/app.css"></script>';
		echo '<link rel="stylesheet" href="./sweetalert2.min.css"></script>';
		echo '<script src="./sweetalert2.min.js"></script>';
		echo "<script>
		setTimeout(function () { 
			swal.fire({
				
				title               : 'Failed',
				text                : 'The uploaded file is not a PDF!',
				icon                : 'error',
				timer               : 2000,
				showConfirmButton   : false
			});  
		},10);   setTimeout(function () {
			// window.location.href = 'manage-employees.php'; //will redirect to your blog page (an ex: blog.html)
		}, 2000); //will call the function after 2 secs
		</script>";
		return false;
	}

	// cek jika ukurannya terlalu besar
	if ($ukuranFile > 3000000){
		echo '<link rel="stylesheet" href="css/app.css"></script>';
		echo '<link rel="stylesheet" href="./sweetalert2.min.css"></script>';
		echo '<script src="./sweetalert2.min.js"></script>';
		echo "<script>
		setTimeout(function () { 
			swal.fire({
				
				title               : 'Failed',
				text                : 'The file size is too large!',
				icon                : 'error',
				timer               : 2000,
				showConfirmButton   : false
			});  
		},10);   setTimeout(function () {
			// window.location.href = 'manage-employees.php'; //will redirect to your blog page (an ex: blog.html)
		}, 2000); //will call the function after 2 secs
		</script>";
		return false;
	}

	// lolos pengecekan, experience letter siap diupload
	// generate nama experience letter baru
	$namaFileBaru = uniqid();
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiFile;

	move_uploaded_file($tmpName, 'files/experience-letter/'. $namaFileBaru);
	return $namaFileBaru;
}

function tambahSeparationEmployees($data){
	global $koneksi;
	date_default_timezone_set('Asia/Jakarta');
	$emp_id = mysqli_real_escape_string($koneksi, $data["emp_id"]);
	$separation_type = mysqli_real_escape_string($koneksi, $data["separation_type"]);
	$separation_date = mysqli_real_escape_string($koneksi, $data["separation_date"]);
	$created_at = date('Y-m-d H:i:s');
	
	// Upload separation-letter and experience-letter
    $separation_letter = uploadSeparationLetter();
    $experience_letter = uploadExperienceLetter();
	
    if (!$separation_letter || !$experience_letter) {
        // If either upload fails, do not proceed
        if ($separation_letter) { // If separation-letter was uploaded, delete it
            unlink('files/separation-letter/' . $separation_letter); // 
        }
        if ($experience_letter) { // If experience-letter was uploaded, delete it
            unlink('files/experience-letter/' . $experience_letter); // 
        }
        return false;
    }

	$query = "INSERT INTO separated_employees VALUES
			('', '$emp_id', '$separation_type', '$separation_date', '$separation_letter', '$experience_letter', '$created_at')";
	mysqli_query($koneksi, $query);

	return mysqli_affected_rows($koneksi);
}

function editSeparationEmployees($data) {
    global $koneksi;
	date_default_timezone_set('Asia/Jakarta');
    $id_separation = $data["id_separation"];
    $emp_id = $data["emp_id"];
    $separation_type = htmlspecialchars($data["separation_type"]);
    $separation_date = htmlspecialchars($data["separation_date"]);
    $updated_at = date('Y-m-d H:i:s');

    // Inisialisasi variabel untuk file lama
    $separationLetterLama = isset($data["separation_letter_lama"]) ? mysqli_real_escape_string($koneksi, $data["separation_letter_lama"]) : '';
    $experienceLetterLama = isset($data["experience_letter_lama"]) ? mysqli_real_escape_string($koneksi, $data["experience_letter_lama"]) : '';

    // cek apakah user pilih file baru untuk separation_letter dan experience_letter
    $separationLetter = '';
	$experienceLetter = '';

    if (isset($_FILES['separation_letter']) && $_FILES['separation_letter']['error'] !== 4) {
        // Upload separation_letter baru
        $separationLetter = uploadSeparationLetter();

        if (!$separationLetter) {
            return false;
        }

        // Hapus separation-letter lama jika ada
        if (!empty($separationLetterLama)) {
            $separationLetterPath = 'files/separation-letter/' . $separationLetterLama;
            if (file_exists($separationLetterPath)) {
                unlink($separationLetterPath);
            }
        }
    } else {
        // Jika tidak ada separation-letter baru, gunakan separation-letter lama
        $separationLetter = $separationLetterLama;
    }

    if (isset($_FILES['experience_letter']) && $_FILES['experience_letter']['error'] !== 4) {
        // Upload experience_letter baru
        $experienceLetter = uploadExperienceLetter();

        if (!$experienceLetter) {
            return false;
        }

        // Hapus experience_letter lama jika ada
        if (!empty($experienceLetterLama)) {
            $experienceLetterPath = 'files/experience-letter/' . $experienceLetterLama;
            if (file_exists($experienceLetterPath)) {
                unlink($experienceLetterPath);
            }
        }
    } else {
        // Jika tidak ada experience_letter baru, gunakan experience_letter lama
        $experienceLetter = $experienceLetterLama;
    }

    // Update data separated_employees di database
    $query = "UPDATE separated_employees SET
                emp_id = '$emp_id',
                separation_type = '$separation_type',
                separation_date = '$separation_date',
                separation_letter = '$separationLetter',
                experience_letter = '$experienceLetter',
                created_at = '$updated_at'
              WHERE id_separation = $id_separation";
              
    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

function uploadDiploma(){

	$namaFile = $_FILES['diploma_scan']['name'];
	$ukuranFile = $_FILES['diploma_scan']['size'];
	$error = $_FILES['diploma_scan']['error'];
	$tmpName = $_FILES['diploma_scan']['tmp_name'];

	// cek apakah tidak ada file yang diupload
	if ($error === 4) {
		echo '<link rel="stylesheet" href="css/app.css"></script>';
		echo '<link rel="stylesheet" href="./sweetalert2.min.css"></script>';
		echo '<script src="./sweetalert2.min.js"></script>';
		echo "<script>
		setTimeout(function () { 
			swal.fire({
				
				title               : 'Failed',
				text                : 'Please select a file first!',
				icon                : 'error',
				timer               : 2000,
				showConfirmButton   : false
			});  
		},10);   setTimeout(function () {
			// window.location.href = 'manage-diplomas.php'; //will redirect to your blog page (an ex: blog.html)
		}, 2000); //will call the function after 2 secs
		</script>";
		return false;
	}

	// cek apakah yang diupload adalah pdf
	$ekstensiFileValid = ['pdf'];
	$ekstensiFile = explode('.', $namaFile);
	$ekstensiFile = strtolower(end($ekstensiFile));
	if (!in_array($ekstensiFile, $ekstensiFileValid) ){
		echo '<link rel="stylesheet" href="css/app.css"></script>';
		echo '<link rel="stylesheet" href="./sweetalert2.min.css"></script>';
		echo '<script src="./sweetalert2.min.js"></script>';
		echo "<script>
		setTimeout(function () { 
			swal.fire({
				
				title               : 'Failed',
				text                : 'The uploaded file is not a PDF!',
				icon                : 'error',
				timer               : 2000,
				showConfirmButton   : false
			});  
		},10);   setTimeout(function () {
			// window.location.href = 'manage-diplomas.php'; //will redirect to your blog page (an ex: blog.html)
		}, 2000); //will call the function after 2 secs
		</script>";
		return false;
	}

	// cek jika ukurannya terlalu besar
	if ($ukuranFile > 3000000){
		echo '<link rel="stylesheet" href="css/app.css"></script>';
		echo '<link rel="stylesheet" href="./sweetalert2.min.css"></script>';
		echo '<script src="./sweetalert2.min.js"></script>';
		echo "<script>
		setTimeout(function () { 
			swal.fire({
				
				title               : 'Failed',
				text                : 'The file size is too large!',
				icon                : 'error',
				timer               : 2000,
				showConfirmButton   : false
			});  
		},10);   setTimeout(function () {
			// window.location.href = 'manage-diplomas.php'; //will redirect to your blog page (an ex: blog.html)
		}, 2000); //will call the function after 2 secs
		</script>";
		return false;
	}

	// lolos pengecekan, diploma siap diupload
	// generate nama diploma baru
	$namaFileBaru = uniqid();
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiFile;

	move_uploaded_file($tmpName, 'files/diploma/'. $namaFileBaru);
	return $namaFileBaru;
}

function uploadDeliveryProof(){

	$namaFile = $_FILES['delivery_proof']['name'];
	$ukuranFile = $_FILES['delivery_proof']['size'];
	$error = $_FILES['delivery_proof']['error'];
	$tmpName = $_FILES['delivery_proof']['tmp_name'];

	// cek apakah tidak ada file yang diupload
	if ($error === 4) {
		echo '<link rel="stylesheet" href="css/app.css"></script>';
		echo '<link rel="stylesheet" href="./sweetalert2.min.css"></script>';
		echo '<script src="./sweetalert2.min.js"></script>';
		echo "<script>
		setTimeout(function () { 
			swal.fire({
				
				title               : 'Failed',
				text                : 'Please select a file first!',
				icon                : 'error',
				timer               : 2000,
				showConfirmButton   : false
			});  
		},10);   setTimeout(function () {
			// window.location.href = 'manage-diplomas.php'; //will redirect to your blog page (an ex: blog.html)
		}, 2000); //will call the function after 2 secs
		</script>";
		return false;
	}

	// cek apakah yang diupload adalah pdf
	$ekstensiFileValid = ['pdf'];
	$ekstensiFile = explode('.', $namaFile);
	$ekstensiFile = strtolower(end($ekstensiFile));
	if (!in_array($ekstensiFile, $ekstensiFileValid) ){
		echo '<link rel="stylesheet" href="css/app.css"></script>';
		echo '<link rel="stylesheet" href="./sweetalert2.min.css"></script>';
		echo '<script src="./sweetalert2.min.js"></script>';
		echo "<script>
		setTimeout(function () { 
			swal.fire({
				
				title               : 'Failed',
				text                : 'The uploaded file is not a PDF!',
				icon                : 'error',
				timer               : 2000,
				showConfirmButton   : false
			});  
		},10);   setTimeout(function () {
			// window.location.href = 'manage-diplomas.php'; //will redirect to your blog page (an ex: blog.html)
		}, 2000); //will call the function after 2 secs
		</script>";
		return false;
	}

	// cek jika ukurannya terlalu besar
	if ($ukuranFile > 3000000){
		echo '<link rel="stylesheet" href="css/app.css"></script>';
		echo '<link rel="stylesheet" href="./sweetalert2.min.css"></script>';
		echo '<script src="./sweetalert2.min.js"></script>';
		echo "<script>
		setTimeout(function () { 
			swal.fire({
				
				title               : 'Failed',
				text                : 'The file size is too large!',
				icon                : 'error',
				timer               : 2000,
				showConfirmButton   : false
			});  
		},10);   setTimeout(function () {
			// window.location.href = 'manage-diplomas.php'; //will redirect to your blog page (an ex: blog.html)
		}, 2000); //will call the function after 2 secs
		</script>";
		return false;
	}

	// lolos pengecekan, delivery-proof siap diupload
	// generate nama delivery-proof baru
	$namaFileBaru = uniqid();
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiFile;

	move_uploaded_file($tmpName, 'files/delivery-proof/'. $namaFileBaru);
	return $namaFileBaru;
}

function uploadReturnProof(){

	$namaFile = $_FILES['return_proof']['name'];
	$ukuranFile = $_FILES['return_proof']['size'];
	$error = $_FILES['return_proof']['error'];
	$tmpName = $_FILES['return_proof']['tmp_name'];

	// cek apakah tidak ada file yang diupload
	if ($error === 4) {
		echo '<link rel="stylesheet" href="css/app.css"></script>';
		echo '<link rel="stylesheet" href="./sweetalert2.min.css"></script>';
		echo '<script src="./sweetalert2.min.js"></script>';
		echo "<script>
		setTimeout(function () { 
			swal.fire({
				
				title               : 'Failed',
				text                : 'Please select a file first!',
				icon                : 'error',
				timer               : 2000,
				showConfirmButton   : false
			});  
		},10);   setTimeout(function () {
			// window.location.href = 'manage-diplomas.php'; //will redirect to your blog page (an ex: blog.html)
		}, 2000); //will call the function after 2 secs
		</script>";
		return false;
	}

	// cek apakah yang diupload adalah pdf
	$ekstensiFileValid = ['pdf'];
	$ekstensiFile = explode('.', $namaFile);
	$ekstensiFile = strtolower(end($ekstensiFile));
	if (!in_array($ekstensiFile, $ekstensiFileValid) ){
		echo '<link rel="stylesheet" href="css/app.css"></script>';
		echo '<link rel="stylesheet" href="./sweetalert2.min.css"></script>';
		echo '<script src="./sweetalert2.min.js"></script>';
		echo "<script>
		setTimeout(function () { 
			swal.fire({
				
				title               : 'Failed',
				text                : 'The uploaded file is not a PDF!',
				icon                : 'error',
				timer               : 2000,
				showConfirmButton   : false
			});  
		},10);   setTimeout(function () {
			// window.location.href = 'manage-diplomas.php'; //will redirect to your blog page (an ex: blog.html)
		}, 2000); //will call the function after 2 secs
		</script>";
		return false;
	}

	// cek jika ukurannya terlalu besar
	if ($ukuranFile > 3000000){
		echo '<link rel="stylesheet" href="css/app.css"></script>';
		echo '<link rel="stylesheet" href="./sweetalert2.min.css"></script>';
		echo '<script src="./sweetalert2.min.js"></script>';
		echo "<script>
		setTimeout(function () { 
			swal.fire({
				
				title               : 'Failed',
				text                : 'The file size is too large!',
				icon                : 'error',
				timer               : 2000,
				showConfirmButton   : false
			});  
		},10);   setTimeout(function () {
			// window.location.href = 'manage-diplomas.php'; //will redirect to your blog page (an ex: blog.html)
		}, 2000); //will call the function after 2 secs
		</script>";
		return false;
	}

	// lolos pengecekan, return-proof siap diupload
	// generate nama return-proof baru
	$namaFileBaru = uniqid();
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiFile;

	move_uploaded_file($tmpName, 'files/return-proof/'. $namaFileBaru);
	return $namaFileBaru;
}

function tambahDiploma($data) {
	global $koneksi;
	date_default_timezone_set('Asia/Jakarta');
	$emp_id = htmlspecialchars($data["emp_id"]);
	$diploma_number = htmlspecialchars($data["diploma_number"]);
	$issue_date = htmlspecialchars($data["issue_date"]);
	$status_diploma = 'Being Held';
	$created_at = date('Y-m-d H:i:s');

	// Upload diploma scan
	$diploma_scan = uploadDiploma();
    $delivery_proof = uploadDeliveryProof();

    if (!$diploma_scan || !$delivery_proof) {
        // If either upload fails, do not proceed
        if ($diploma_scan) { // If photo was uploaded, delete it
            unlink('files/diploma/' . $diploma_scan); // 
        }
        if ($delivery_proof) { // If delivery_proof was uploaded, delete it
            unlink('files/delivery-proof/' . $delivery_proof); // 
        }
        return false;
    }

	$query = "INSERT INTO diplomas VALUES
			('', '$emp_id', '$diploma_number', '$issue_date', NULL, '$status_diploma', '$diploma_scan', '$delivery_proof', NULL, '$created_at')";
	mysqli_query($koneksi, $query);

	return mysqli_affected_rows($koneksi);
}

function editDiploma($data) {
    global $koneksi;
	date_default_timezone_set('Asia/Jakarta');
    $id_diploma = $data["id_diploma"];
    $emp_id = htmlspecialchars($data["emp_id"]);
    $diploma_number = htmlspecialchars($data["diploma_number"]);
    $issue_date = htmlspecialchars($data["issue_date"]);
    $updated_at = date('Y-m-d H:i:s');

	// Inisialisasi variabel untuk file lama
    $diploma_scanLama = isset($data["diploma_scan_lama"]) ? mysqli_real_escape_string($koneksi, $data["diploma_scan_lama"]) : '';
    $delivery_proofLama = isset($data["delivery_proof_lama"]) ? mysqli_real_escape_string($koneksi, $data["delivery_proof_lama"]) : '';

    // Cek apakah user memilih file baru untuk diploma scan
    $diploma_scan = '';
    $delivery_proof = '';

    if (isset($_FILES['diploma_scan']) && $_FILES['diploma_scan']['error'] !== 4) {
        // Upload diploma scan baru
        $diploma_scan = uploadDiploma();

        if (!$diploma_scan) {
            return false;
        }

        // Hapus diploma scan lama jika ada
        if (!empty($diploma_scanLama)) {
            $diploma_scan_path = 'files/diploma/' . $diploma_scanLama;
            if (file_exists($diploma_scan_path)) {
                unlink($diploma_scan_path);
            }
        }
    } else {
        // Jika tidak ada diploma scan baru, gunakan diploma scan lama
        $diploma_scan = $diploma_scanLama;
    }

    if (isset($_FILES['delivery_proof']) && $_FILES['delivery_proof']['error'] !== 4) {
        // Upload delivery-proof baru
        $delivery_proof = uploadDeliveryProof();

        if (!$delivery_proof) {
            return false;
        }

        // Hapus delivery-proof lama jika ada
        if (!empty($delivery_proofLama)) {
            $delivery_proof_path = 'files/delivery-proof/' . $delivery_proofLama;
            if (file_exists($delivery_proof_path)) {
                unlink($delivery_proof_path);
            }
        }
    } else {
        // Jika tidak ada delivery-proof baru, gunakan delivery-proof lama
        $delivery_proof = $delivery_proofLama;
    }

    // Update data diploma di database
    $query = "UPDATE diplomas SET
                emp_id = '$emp_id',
                diploma_number = '$diploma_number',
                issue_date = '$issue_date',
                return_date = NULL, 
                diploma_scan = '$diploma_scan',
                delivery_proof = '$delivery_proof',
                created_at = '$updated_at'
              WHERE id_diploma = $id_diploma";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

function returnDiploma($data){
    global $koneksi;
	date_default_timezone_set('Asia/Jakarta');
    $id_diploma = mysqli_real_escape_string($koneksi, $data["id_diploma"]);
    $return_date = mysqli_real_escape_string($koneksi, $data["return_date"]);
    $status_diploma = 'Returned';
    $updated_at = date('Y-m-d H:i:s');

	// Upload return_proof
    $return_proof = uploadReturnProof();

    // Update data diploma di database
    $query = "UPDATE diplomas SET
                return_date = '$return_date', 
                status_diploma = '$status_diploma',
                return_proof = '$return_proof',
                created_at = '$updated_at'
              WHERE id_diploma = $id_diploma";

    mysqli_query($koneksi, $query);

    if(mysqli_affected_rows($koneksi) < 0) {
        echo "Error: " . mysqli_error($koneksi);
    }

    return mysqli_affected_rows($koneksi);
}

function calculateDaysWorked($hire_date) {
    $hireDate = new DateTime($hire_date);
    $currentDate = new DateTime();
    $interval = $hireDate->diff($currentDate);

    $years = $interval->y;
    $months = $interval->m;
    $days = $interval->d;

    // Format output
    $output = '';
    if ($years > 0) {
        $output .= "$years year";
        if ($years > 1) {
            $output .= "s"; // plural if more than 1 year
        }
        $output .= " ";
    }
    if ($months > 0) {
        $output .= "$months month";
        if ($months > 1) {
            $output .= "s"; // plural if more than 1 month
        }
        $output .= " ";
    }
    if ($days > 0) {
        $output .= "$days day";
        if ($days > 1) {
            $output .= "s"; // plural if more than 1 day
        }
    }

    return $output;
}


function editLeave($data) {
    global $koneksi;
    $id_leave = $data["id_leave"];
    $emp_id = htmlspecialchars($data["emp_id"]);
    $sick_leave = htmlspecialchars($data["sick_leave"]);
    $annual_leave = htmlspecialchars($data["annual_leave"]);
    $unpaid_leave = htmlspecialchars($data["unpaid_leave"]);

    // Update data leave di database
    $query = "UPDATE leaves SET
                emp_id = '$emp_id',
                sick_leave = '$sick_leave',
                annual_leave = '$annual_leave',
                unpaid_leave = '$unpaid_leave'
              WHERE id_leave = $id_leave";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

function uploadAttachment(){

	$namaFile = $_FILES['attachment']['name'];
	$ukuranFile = $_FILES['attachment']['size'];
	$error = $_FILES['attachment']['error'];
	$tmpName = $_FILES['attachment']['tmp_name'];

	// cek apakah tidak ada file yang diupload
	if ($error === 4) {
		echo '<link rel="stylesheet" href="css/app.css"></script>';
		echo '<link rel="stylesheet" href="./sweetalert2.min.css"></script>';
		echo '<script src="./sweetalert2.min.js"></script>';
		echo "<script>
		setTimeout(function () { 
			swal.fire({
				
				title               : 'Failed',
				text                : 'Please select a file first!',
				icon                : 'error',
				timer               : 2000,
				showConfirmButton   : false
			});  
		},10);   setTimeout(function () {
			// window.location.href = 'manage-leaves.php'; //will redirect to your blog page (an ex: blog.html)
		}, 2000); //will call the function after 2 secs
		</script>";
		return false;
	}

	// cek apakah yang diupload adalah pdf, png, jpg, jpeg
	$ekstensiFileValid = ['pdf', 'png', 'jpg', 'jpeg'];
	$ekstensiFile = explode('.', $namaFile);
	$ekstensiFile = strtolower(end($ekstensiFile));
	if (!in_array($ekstensiFile, $ekstensiFileValid) ){
		echo '<link rel="stylesheet" href="css/app.css"></script>';
		echo '<link rel="stylesheet" href="./sweetalert2.min.css"></script>';
		echo '<script src="./sweetalert2.min.js"></script>';
		echo "<script>
		setTimeout(function () { 
			swal.fire({
				
				title               : 'Failed',
				text                : 'The uploaded file extension is not allowed!',
				icon                : 'error',
				timer               : 2000,
				showConfirmButton   : false
			});  
		},10);   setTimeout(function () {
			// window.location.href = 'manage-leaves.php'; //will redirect to your blog page (an ex: blog.html)
		}, 2000); //will call the function after 2 secs
		</script>";
		return false;
	}

	// cek jika ukurannya terlalu besar
	if ($ukuranFile > 3000000){
		echo '<link rel="stylesheet" href="css/app.css"></script>';
		echo '<link rel="stylesheet" href="./sweetalert2.min.css"></script>';
		echo '<script src="./sweetalert2.min.js"></script>';
		echo "<script>
		setTimeout(function () { 
			swal.fire({
				
				title               : 'Failed',
				text                : 'The file size is too large!',
				icon                : 'error',
				timer               : 2000,
				showConfirmButton   : false
			});  
		},10);   setTimeout(function () {
			// window.location.href = 'manage-leaves.php'; //will redirect to your blog page (an ex: blog.html)
		}, 2000); //will call the function after 2 secs
		</script>";
		return false;
	}

	// lolos pengecekan, diploma siap diupload
	// generate nama diploma baru
	$namaFileBaru = uniqid();
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiFile;

	move_uploaded_file($tmpName, 'files/leave/'. $namaFileBaru);
	return $namaFileBaru;
}

function leaveRequest($data) {
	global $koneksi;
	date_default_timezone_set('Asia/Jakarta');
	$emp_id = htmlspecialchars($data["emp_id"]);
	$leave_type = htmlspecialchars($data["leave_type"]);
	$start_date = htmlspecialchars($data["start_date"]);
	$end_date = htmlspecialchars($data["end_date"]);
	$reason = htmlspecialchars($data["reason"]);
	$created_at = date('Y-m-d H:i:s');

	// Upload attachment
    $attachment = uploadAttachment();

    if (!$attachment) {
        // If either upload fails, do not proceed
        if ($attachment) { // If attachment was uploaded, delete it
            unlink('files/leave/' . $attachment); // 
        }
        return false;
    }

	$query = "INSERT INTO leave_requests VALUES
			('', '$emp_id', '$leave_type', '$start_date', '$end_date', '$reason', '$attachment', '$created_at')";
	mysqli_query($koneksi, $query);

	return mysqli_affected_rows($koneksi);
}

function removeLeaveRequest($id_request) {
	global $koneksi;

	// Mengambil nama file lampiran dari database
    $query = mysqli_query($koneksi, "SELECT attachment FROM leave_requests WHERE id_request = $id_request");
    $row = mysqli_fetch_assoc($query);
    $namaFileLampiran = $row['attachment'];

    // Jika ada lampiran, hapus file lampiran dari direktori
    if (!empty($namaFileLampiran)) {
        $pathLampiran = 'files/leave/' . $namaFileLampiran;
        if (file_exists($pathLampiran)) {
            unlink($pathLampiran);
        }
    }

	mysqli_query($koneksi, "DELETE FROM leave_requests WHERE id_request=$id_request");

	return mysqli_affected_rows($koneksi);

}

function uploadWarning(){

	$namaFile = $_FILES['warning_letter_file']['name'];
	$ukuranFile = $_FILES['warning_letter_file']['size'];
	$error = $_FILES['warning_letter_file']['error'];
	$tmpName = $_FILES['warning_letter_file']['tmp_name'];

	// cek apakah tidak ada file yang diupload
	if ($error === 4) {
		echo '<link rel="stylesheet" href="css/app.css"></script>';
		echo '<link rel="stylesheet" href="./sweetalert2.min.css"></script>';
		echo '<script src="./sweetalert2.min.js"></script>';
		echo "<script>
		setTimeout(function () { 
			swal.fire({
				
				title               : 'Failed',
				text                : 'Please select a file first!',
				icon                : 'error',
				timer               : 2000,
				showConfirmButton   : false
			});  
		},10);   setTimeout(function () {
			// window.location.href = 'manage-leaves.php'; //will redirect to your blog page (an ex: blog.html)
		}, 2000); //will call the function after 2 secs
		</script>";
		return false;
	}

	// cek apakah yang diupload adalah pdf
	$ekstensiFileValid = ['pdf'];
	$ekstensiFile = explode('.', $namaFile);
	$ekstensiFile = strtolower(end($ekstensiFile));
	if (!in_array($ekstensiFile, $ekstensiFileValid) ){
		echo '<link rel="stylesheet" href="css/app.css"></script>';
		echo '<link rel="stylesheet" href="./sweetalert2.min.css"></script>';
		echo '<script src="./sweetalert2.min.js"></script>';
		echo "<script>
		setTimeout(function () { 
			swal.fire({
				
				title               : 'Failed',
				text                : 'The uploaded file extension is not allowed!',
				icon                : 'error',
				timer               : 2000,
				showConfirmButton   : false
			});  
		},10);   setTimeout(function () {
			// window.location.href = 'manage-leaves.php'; //will redirect to your blog page (an ex: blog.html)
		}, 2000); //will call the function after 2 secs
		</script>";
		return false;
	}

	// cek jika ukurannya terlalu besar
	if ($ukuranFile > 3000000){
		echo '<link rel="stylesheet" href="css/app.css"></script>';
		echo '<link rel="stylesheet" href="./sweetalert2.min.css"></script>';
		echo '<script src="./sweetalert2.min.js"></script>';
		echo "<script>
		setTimeout(function () { 
			swal.fire({
				
				title               : 'Failed',
				text                : 'The file size is too large!',
				icon                : 'error',
				timer               : 2000,
				showConfirmButton   : false
			});  
		},10);   setTimeout(function () {
			// window.location.href = 'manage-leaves.php'; //will redirect to your blog page (an ex: blog.html)
		}, 2000); //will call the function after 2 secs
		</script>";
		return false;
	}

	// lolos pengecekan, diploma siap diupload
	// generate nama diploma baru
	$namaFileBaru = uniqid();
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiFile;

	move_uploaded_file($tmpName, 'files/warnings/'. $namaFileBaru);
	return $namaFileBaru;
}

function tambahWarning($data) {
	global $koneksi;
	date_default_timezone_set('Asia/Jakarta');
	$emp_id = htmlspecialchars($data["emp_id"]);
	$warning_type = htmlspecialchars($data["warning_type"]);
	$issued_date = htmlspecialchars($data["issued_date"]);
	$reason = htmlspecialchars($data["reason"]);
	$created_at = date('Y-m-d H:i:s');

	// Upload warning_letter_file
    $warning_letter_file = uploadWarning();

    if (!$warning_letter_file) {
        // If either upload fails, do not proceed
        if ($warning_letter_file) { // If attachment was uploaded, delete it
            unlink('files/warnings/' . $warning_letter_file); // 
        }
        return false;
    }

	$query = "INSERT INTO warnings VALUES
			('', '$emp_id', '$warning_type', '$issued_date', '$reason', '$warning_letter_file','$created_at')";
	mysqli_query($koneksi, $query);

	return mysqli_affected_rows($koneksi);
}

function editWarning($data) {
	global $koneksi;
	date_default_timezone_set('Asia/Jakarta');
	$id_warning = $data["id_warning"];
	$emp_id = htmlspecialchars($data["emp_id"]);
	$warning_type = htmlspecialchars($data["warning_type"]);
	$issued_date = htmlspecialchars($data["issued_date"]);
	$reason = htmlspecialchars($data["reason"]);
	$updated_at = date('Y-m-d H:i:s');


	// Inisialisasi variabel untuk file lama
	$fileLama = isset($data["warning_letter_file_lama"]) ? mysqli_real_escape_string($koneksi, $data["warning_letter_file_lama"]) : '';

	// cek apakah user pilih pdf baru atau tidak
	$file = '';

	if (isset($_FILES['warning_letter_file']) && $_FILES['warning_letter_file']['error'] !== 4) {
		// Upload file baru
		$file = uploadWarning();

        if (!$file) {
            return false;
        }

		// Hapus file lama jika ada
		if (!empty($fileLama)) {
			$file_path = 'files/warnings/' . $fileLama;
			if (file_exists($file_path)) {
				unlink($file_path);
			}
		}
    } else {
        // Jika tidak ada file baru, gunakan file lama
        $file = $fileLama;
    }

    

	$query = "UPDATE warnings SET
				id_warning = '$id_warning',
				emp_id = '$emp_id',
				warning_type = '$warning_type',
				issued_date = '$issued_date',
				reason = '$reason',
				warning_letter_file = '$file',
				created_at = '$updated_at'
			  WHERE id_warning = $id_warning
			";
	mysqli_query($koneksi, $query);

	return mysqli_affected_rows($koneksi);
}

function removeWarning($id_warning) {
	global $koneksi;

	// Mengambil nama file lampiran dari database
    $query = mysqli_query($koneksi, "SELECT warning_letter_file FROM warnings WHERE id_warning = $id_warning");
    $row = mysqli_fetch_assoc($query);
    $namaFileLampiran = $row['warning_letter_file'];

    // Jika ada lampiran, hapus file lampiran dari direktori
    if (!empty($namaFileLampiran)) {
        $pathLampiran = 'files/warnings/' . $namaFileLampiran;
        if (file_exists($pathLampiran)) {
            unlink($pathLampiran);
        }
    }

	mysqli_query($koneksi, "DELETE FROM warnings WHERE id_warning=$id_warning");

	return mysqli_affected_rows($koneksi);

}

function tambahKpi($data) {
	global $koneksi;
	$emp_id = htmlspecialchars($data["emp_id"]);
	$period = htmlspecialchars($data["period"]);
	$year = htmlspecialchars($data["year"]);
	$productivity = htmlspecialchars($data["productivity"]);
	$quality_of_work = htmlspecialchars($data["quality_of_work"]);
	$attendance_rate = htmlspecialchars($data["attendance_rate"]);
	$competency_development = htmlspecialchars($data["competency_development"]);
	$target_achievement = htmlspecialchars($data["target_achievement"]);
	$team_contribution = htmlspecialchars($data["team_contribution"]);
	$statisfaction = htmlspecialchars($data["statisfaction"]);
	$comments = htmlspecialchars($data["comments"]);

	$query = "INSERT INTO kpi VALUES
			('', '$emp_id', '$period', '$year', '$productivity', '$quality_of_work','$attendance_rate', '$competency_development', '$target_achievement', '$team_contribution', '$statisfaction', '$comments')";
	mysqli_query($koneksi, $query);

	return mysqli_affected_rows($koneksi);
}

function editKpi($data) {
	global $koneksi;
	$id_kpi = mysqli_real_escape_string($koneksi, $data['id_kpi']);
	$period = htmlspecialchars($data["period"]);
	$year = htmlspecialchars($data["year"]);
	$productivity = htmlspecialchars($data["productivity"]);
	$quality_of_work = htmlspecialchars($data["quality_of_work"]);
	$attendance_rate = htmlspecialchars($data["attendance_rate"]);
	$competency_development = htmlspecialchars($data["competency_development"]);
	$target_achievement = htmlspecialchars($data["target_achievement"]);
	$team_contribution = htmlspecialchars($data["team_contribution"]);
	$statisfaction = htmlspecialchars($data["statisfaction"]);
	$comments = htmlspecialchars($data["comments"]);

	$query = "UPDATE kpi SET
				id_kpi = '$id_kpi',
				period = '$period',
				year = '$year',
				productivity = '$productivity',
				quality_of_work = '$quality_of_work',
				attendance_rate = '$attendance_rate',
				competency_development = '$competency_development',
				target_achievement = '$target_achievement',
				team_contribution = '$team_contribution',
				statisfaction = '$statisfaction',
				comments = '$comments'
			  WHERE id_kpi = $id_kpi
			";
	mysqli_query($koneksi, $query);

	return mysqli_affected_rows($koneksi);
}

function removeKpi($id_kpi) {
	global $koneksi;
	mysqli_query($koneksi, "DELETE FROM kpi WHERE id_kpi=$id_kpi");

	return mysqli_affected_rows($koneksi);

}

function uploadPayslip(){

	$namaFile = $_FILES['slip_file']['name'];
	$ukuranFile = $_FILES['slip_file']['size'];
	$error = $_FILES['slip_file']['error'];
	$tmpName = $_FILES['slip_file']['tmp_name'];

	// cek apakah tidak ada file yang diupload
	if ($error === 4) {
		echo '<link rel="stylesheet" href="css/app.css"></script>';
		echo '<link rel="stylesheet" href="./sweetalert2.min.css"></script>';
		echo '<script src="./sweetalert2.min.js"></script>';
		echo "<script>
		setTimeout(function () { 
			swal.fire({
				
				title               : 'Failed',
				text                : 'Please select a file first!',
				icon                : 'error',
				timer               : 2000,
				showConfirmButton   : false
			});  
		},10);   setTimeout(function () {
			// window.location.href = 'manage-payslip.php'; //will redirect to your blog page (an ex: blog.html)
		}, 2000); //will call the function after 2 secs
		</script>";
		return false;
	}

	// cek apakah yang diupload adalah pdf, xlsx
	$ekstensiFileValid = ['pdf', 'xlsx'];
	$ekstensiFile = explode('.', $namaFile);
	$ekstensiFile = strtolower(end($ekstensiFile));
	if (!in_array($ekstensiFile, $ekstensiFileValid) ){
		echo '<link rel="stylesheet" href="css/app.css"></script>';
		echo '<link rel="stylesheet" href="./sweetalert2.min.css"></script>';
		echo '<script src="./sweetalert2.min.js"></script>';
		echo "<script>
		setTimeout(function () { 
			swal.fire({
				
				title               : 'Failed',
				text                : 'The uploaded file extension is not allowed!',
				icon                : 'error',
				timer               : 2000,
				showConfirmButton   : false
			});  
		},10);   setTimeout(function () {
			// window.location.href = 'manage-payslip.php'; //will redirect to your blog page (an ex: blog.html)
		}, 2000); //will call the function after 2 secs
		</script>";
		return false;
	}

	// cek jika ukurannya terlalu besar
	if ($ukuranFile > 3000000){
		echo '<link rel="stylesheet" href="css/app.css"></script>';
		echo '<link rel="stylesheet" href="./sweetalert2.min.css"></script>';
		echo '<script src="./sweetalert2.min.js"></script>';
		echo "<script>
		setTimeout(function () { 
			swal.fire({
				
				title               : 'Failed',
				text                : 'The file size is too large!',
				icon                : 'error',
				timer               : 2000,
				showConfirmButton   : false
			});  
		},10);   setTimeout(function () {
			// window.location.href = 'manage-payslip.php'; //will redirect to your blog page (an ex: blog.html)
		}, 2000); //will call the function after 2 secs
		</script>";
		return false;
	}

	// lolos pengecekan, diploma siap diupload
	// generate nama diploma baru
	$namaFileBaru = uniqid();
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiFile;

	move_uploaded_file($tmpName, 'files/payslip/'. $namaFileBaru);
	return $namaFileBaru;
}

function tambahPayslip($data) {
	global $koneksi;
	$emp_id = htmlspecialchars($data["emp_id"]);
	$period = htmlspecialchars($data["period"]);
	$year = htmlspecialchars($data["year"]);
	$pay_date = htmlspecialchars($data["pay_date"]);

	// Upload payslip_file
    $payslip_file = uploadPayslip();

    if (!$payslip_file) {
        // If either upload fails, do not proceed
        if ($payslip_file) { // If attachment was uploaded, delete it
            unlink('files/payslip/' . $payslip_file); // 
        }
        return false;
    }

	$query = "INSERT INTO salary_slip VALUES
			('', '$emp_id', '$period', '$year', '$pay_date', '$payslip_file')";
	mysqli_query($koneksi, $query);

	return mysqli_affected_rows($koneksi);
}

function editPayslip($data) {
	global $koneksi;
	$id_salary = $data["id_salary"];
	$emp_id = htmlspecialchars($data["emp_id"]);
	$period = htmlspecialchars($data["period"]);
	$year = htmlspecialchars($data["year"]);
	$pay_date = htmlspecialchars($data["pay_date"]);


	// Inisialisasi variabel untuk file lama
	$fileLama = isset($data["slip_file_lama"]) ? mysqli_real_escape_string($koneksi, $data["slip_file_lama"]) : '';

	// cek apakah user pilih pdf baru atau tidak
	$file = '';

	if (isset($_FILES['slip_file']) && $_FILES['slip_file']['error'] !== 4) {
		// Upload file baru
		$file = uploadPayslip();

        if (!$file) {
            return false;
        }

		// Hapus file lama jika ada
		if (!empty($fileLama)) {
			$file_path = 'files/payslip/' . $fileLama;
			if (file_exists($file_path)) {
				unlink($file_path);
			}
		}
    } else {
        // Jika tidak ada file baru, gunakan file lama
        $file = $fileLama;
    }

    

	$query = "UPDATE salary_slip SET
				emp_id = '$emp_id',
				period = '$period',
				year = '$year',
				pay_date = '$pay_date',
				slip_file = '$file'
			  WHERE id_salary = $id_salary
			";
	mysqli_query($koneksi, $query);

	return mysqli_affected_rows($koneksi);
}

function removePayslip($id_salary) {
	global $koneksi;

	// Mengambil nama file lampiran dari database
    $query = mysqli_query($koneksi, "SELECT slip_file FROM salary_slip WHERE id_salary = $id_salary");
    $row = mysqli_fetch_assoc($query);
    $namaFileLampiran = $row['slip_file'];

    // Jika ada lampiran, hapus file lampiran dari direktori
    if (!empty($namaFileLampiran)) {
        $pathLampiran = 'files/payslip/' . $namaFileLampiran;
        if (file_exists($pathLampiran)) {
            unlink($pathLampiran);
        }
    }

	mysqli_query($koneksi, "DELETE FROM salary_slip WHERE id_salary=$id_salary");

	return mysqli_affected_rows($koneksi);

}

function tambahRecord($data) {
	global $koneksi;
	$id_project = htmlspecialchars($data["id_project"]);
	$tipe = htmlspecialchars($data["tipe"]);
	$tgl_catatan = htmlspecialchars($data["tgl_catatan"]);
	$nominal = htmlspecialchars($data["nominal"]);
	$deskripsi = htmlspecialchars($data["deskripsi"]);
    $id_user = htmlspecialchars($data['id_user']);
	
	$file_nota =  uploadNota();
	if (!$file_nota) {
		return false;
	}

	$query = "INSERT INTO catatan_keuangan VALUES
			('', '$id_project', '$tipe', '$tgl_catatan', '$nominal', '$deskripsi', '$file_nota', '$id_user')";
	mysqli_query($koneksi, $query);

	return mysqli_affected_rows($koneksi);
}

function editRecord($data) {
	global $koneksi;
	$id_catatan = $data["id_catatan"];
	$id_project = htmlspecialchars($data["id_project"]);
	$tipe = htmlspecialchars($data["tipe"]);
	$tgl_catatan = htmlspecialchars($data["tgl_catatan"]);
	$nominal = htmlspecialchars($data["nominal"]);
	$deskripsi = htmlspecialchars($data["deskripsi"]);
    $id_user = htmlspecialchars($data['id_user']);


	// Inisialisasi variabel untuk file lama
	$fileLama = isset($data["nota_lama"]) ? mysqli_real_escape_string($koneksi, $data["nota_lama"]) : '';

	// cek apakah user pilih pdf baru atau tidak
	$file = '';

	if (isset($_FILES['nota']) && $_FILES['nota']['error'] !== 4) {
		// Upload file baru
		$file = uploadNota();

        if (!$file) {
            return false;
        }

		// Hapus file lama jika ada
		if (!empty($fileLama)) {
			$file_path = 'files/nota/' . $fileLama;
			if (file_exists($file_path)) {
				unlink($file_path);
			}
		}
    } else {
        // Jika tidak ada file baru, gunakan file lama
        $file = $fileLama;
    }

    

	$query = "UPDATE catatan_keuangan SET
				id_project = '$id_project',
				tipe = '$tipe',
				tgl_catatan = '$tgl_catatan',
				nominal = '$nominal',
				deskripsi = '$deskripsi',
				nota = '$file',
				id_user = '$id_user'
			  WHERE id_catatan = $id_catatan
			";
	mysqli_query($koneksi, $query);

	return mysqli_affected_rows($koneksi);
}

function removeRecord($id_catatan) {
	global $koneksi;

	// Mengambil nama file lampiran dari database
    $query = mysqli_query($koneksi, "SELECT nota FROM catatan_keuangan WHERE id_catatan = $id_catatan");
    $row = mysqli_fetch_assoc($query);
    $namaFileLampiran = $row['nota'];

    // Jika ada lampiran, hapus file lampiran dari direktori
    if (!empty($namaFileLampiran)) {
        $pathLampiran = 'files/nota/' . $namaFileLampiran;
        if (file_exists($pathLampiran)) {
            unlink($pathLampiran);
        }
    }

	mysqli_query($koneksi, "DELETE FROM catatan_keuangan WHERE id_catatan=$id_catatan");

	return mysqli_affected_rows($koneksi);

}

function uploadNota(){

	$namaFile = $_FILES['nota']['name'];
	$ukuranFile = $_FILES['nota']['size'];
	$error = $_FILES['nota']['error'];
	$tmpName = $_FILES['nota']['tmp_name'];

	// cek apakah tidak ada file yang diupload
	if ($error === 4) {
		echo "
			<script>
				alert('pilih file terlebih dahulu!');
			</script>
		";
		return false;
	}

	// cek apakah yang diupload adalah pdf
	$ekstensiFileValid = ['pdf'];
	$ekstensiFile = explode('.', $namaFile);
	$ekstensiFile = strtolower(end($ekstensiFile));
	if (!in_array($ekstensiFile, $ekstensiFileValid) ){
		echo "
			<script>
				alert('yang anda upload bukan Pdf!');
			</script>
		";
		return false;
	}

	// cek jika ukurannya terlalu besar
	if ($ukuranFile > 1000000){
		echo "
			<script>
				alert('ukuran pdf terlalu besar!');
			</script>
		";
		return false;
	}

	// lolos pengecekan, pdf siap diupload
	// generate nama pdf baru
	$namaFileBaru = uniqid();
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiFile;

	move_uploaded_file($tmpName, 'files/nota/'. $namaFileBaru);
	return $namaFileBaru;
}

 function changeProfile($data) {
	global $koneksi;
	$id_user = htmlspecialchars($data["id_user"]);
	$nama = htmlspecialchars($data["nama"]);
	$email = htmlspecialchars($data["email"]);

	$query = "UPDATE users SET
				id_user = '$id_user',
				nama = '$nama',
				email = '$email'
			  WHERE id_user = $id_user
			";
	mysqli_query($koneksi, $query);

	return mysqli_affected_rows($koneksi);
}

 ?>