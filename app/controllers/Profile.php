<?php

class Profile extends Controller
{
    // public function index()
	// {
	// 	if (!Auth::logged_in()) {
	// 		message('Please login to view your account');
	// 		redirect('login');
	// 	}

	// 	$id = Auth::getCustomerID();
	// 	$data['title'] = "manage-account";

	// 	if($id != ''){
	// 		$url = ROOT . "/fetch/customers/" . $id;
	// 		$response = file_get_contents($url);
	// 		$customer = json_decode($response, true);

	// 		$data = $customer;
	// 		$this->view('customers/manage-account', $data);
	// 	}
    // }

    public function index()
    {
        if (!Auth::logged_in()) {
			message('Please login to view your account');
			redirect('login');
		}

		$id = Auth::getCustomerID();
		$data['title'] = "profile";

		if($id != ''){
			$url = ROOT . "/fetch/customers/" . $id;
			$response = file_get_contents($url);
			$customer = json_decode($response, true);

			$data = $customer;
			$this->view('customers/profile', $data);
		}
    }

	public function editProfile()
	{
		if (!Auth::logged_in()) {
			message('Please login!!');
			redirect('login');
		}

		$id = Auth::getCustomerID();
		$data['title'] = "edit-profile";
		// $customer = []; 

		if ($id != '') {
			$url = ROOT . "/fetch/customers/" . $id;
			$response = file_get_contents($url);
			$customer = json_decode($response, true);

			$data = $customer;
			$this->view('customers/edit-profile', $data);
		}
    }

	public function updateProfile()
	{
		if (!Auth::logged_in()) {
			message('Please login to update your profile');
			redirect('login');
		}

		$id = Auth::getCustomerID();

		$customerModel = new Customer();

		// Validate form data
		$updatedData = [
			'first_name' => $_POST['first_name'],
			'last_name' => $_POST['last_name'],
			'telephone' => $_POST['telephone'],
		];
	
		if (!$customerModel->validate($updatedData)) {
			// Validation failed, redirect back to the edit profile page with errors
			message('Failed to update. Please try again!');
			redirect('profile/editProfile');
		}
		else{
			// Perform the database update
			$success = $customerModel->updateCustomerProfile($id, $updatedData);

			if ($success) {
				message('Updated successfully!');
				redirect('profile');
			} 
			else {
				message('Failed to update. Please try again!');
				redirect('customers/editProfile');
			}
		}	
	}

	// public function password()
	// {
	// 	if (!Auth::logged_in()) {
	// 		message('Please login!!');
	// 		redirect('login');
	// 	}

	// 	$id = Auth::getCustomerID();
	// 	$data['title'] = "change-password";
	// 	// $customer = []; 

	// 	if ($id != '') {
	// 		$url = ROOT . "/fetch/customers/" . $id;
	// 		$response = file_get_contents($url);
	// 		$customer = json_decode($response, true);

	// 		$data = $customer;
	// 		$this->view('customers/change-password', $data);
	// 	}
    // }

	// public function editPW()
	// {
	// 	if (!Auth::logged_in()) {
	// 		message('Please login to update your profile');
	// 		redirect('login');
	// 	}

	// 	$id = Auth::getID();
	// 	$userModel = new User();

	// 	// Get the current user's information
	// 	// $currentUser = $userModel->getUserByID($id);
	// 	$url = ROOT . "/fetch/customers/" . $id;
	// 		$response = file_get_contents($url);
	// 		$customer = json_decode($response, true);

	// 		$data = $customer;

	// 	// Check if the entered current password matches the stored hashed password
	// 	if (!password_verify($_POST['current_password'], $data->password)) {
	// 		message('Current password is incorrect. Please try again.');
	// 		show('2');
	// 		// redirect('profile/password');
	// 	}

	// 	// Validate form data
	// 	$updatedData = [
	// 		'password' => $_POST['new_password'],
	// 	];

	// 	if (!$userModel->validate($updatedData)) {
	// 		// Validation failed, redirect back to the edit profile page with errors
	// 		message('Validation failed. Please check your inputs.');
	// 		show('3');
	// 		// redirect('profile/password');
	// 	} else {
	// 		// Hash the new password
	// 		$hashedPassword = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

	// 		// Perform the database update
	// 		$success = $userModel->updatePW($id, $hashedPassword);

	// 		if ($success) {
	// 			message('Password updated successfully');
	// 			show('4');
	// 			// redirect('profile/myProfile');
	// 		} else {
	// 			message('Failed to update password. Please try again.');
	// 			show('5');
	// 			// redirect('profile/password');
	// 		}
	// 	}
	// }

    // public function addressbook($id = '')
	// {
	// 	if (!Auth::logged_in()) {
	// 		message('Please login!!');
	// 		redirect('login');
	// 	}

	// 	// $id = Auth::getCustomerID();

	// 	$data['title'] = "addressbook";
	// 	$customer = []; 

	// 	if ($id != '') {
	// 		$url = ROOT . "/fetch/customers/" . $id;
	// 		$response = file_get_contents($url);
	// 		$customer = json_decode($response, true);

	// 		$data = $customer;
	// 		$this->view('customers/addressbook', $data);
	// 	}
	// }

    public function editAddress()
	{
		if (!Auth::logged_in()) {
			message('Please login!!');
			redirect('login');
		}

		$id = Auth::getCustomerID();

		$data['title'] = "edit-addressbook";
		// $customer = []; 

		if ($id != '') {
			$url = ROOT . "/fetch/customers/" . $id;
			$response = file_get_contents($url);
			$customer = json_decode($response, true);

			$data = $customer;
			$this->view('customers/edit-addressbook', $data);
		}
	}

    // public function addAddress($id = '')
	// {
	// 	if (!Auth::logged_in()) {
	// 		message('Please login!!');
	// 		redirect('login');
	// 	}
		
	// 	// $id = Auth::getCustomerID();

	// 	$data['title'] = "add-address";
	// 	$data['errors'] = [];
	// 	$customer = []; 
	// 	$address = new Address;

	// 	if ($id != '') {
	// 		$url = ROOT . "/fetch/customers/" . $id;
	// 		$response = file_get_contents($url);
	// 		$customer = json_decode($response, true);

	// 		$data = $customer;
	// 		$this->view('customers/add-address', $data);
	// 	}

	// 	if ($_SERVER['REQUEST_METHOD'] == "POST") {

	// 		$_POST['role'] = "customer";


	// 		$result1 = $address->validate($_POST);
	// 		$result2 = $customer->validate($_POST);

	// 		// show($_POST);

	// 		if ($result1 && $result2) {
	// 			$db = new Database;

	// 			// $user_arr['role'] = "customer";

	// 			$address_arr['address_line_1'] = $_POST['address_line_1'];
	// 			$address_arr['address_line_2'] = $_POST['address_line_2'];
	// 			$address_arr['city'] = $_POST['city'];
	// 			$address_arr['zip_code'] = $_POST['zip_code'];
	// 			$address_query = "INSERT INTO address (address_line_1, address_line_2, city, zip_code) VALUES (:address_line_1, :address_line_2, :city, :zip_code)";
	// 			$db->query($address_query, $address_arr);

	// 			// Get the last inserted address_id
	// 			// $last_address_id = $db->query("SELECT address_id FROM address WHERE address_line_1 = $_POST[address_line_1] AND address_line_2 = $_POST[address_line_2] AND city = $_POST[city] AND zip_code = $_POST[zip_code]")
	// 			$last_address_id = $db->query("SELECT address_id FROM address WHERE address_id = (SELECT MAX(address_id) FROM address)");

	// 			// $customer_arr['user_id'] = $last_user_id;
	// 			$customer_arr['first_name'] = $_POST['first_name'];
	// 			$customer_arr['last_name'] = $_POST['last_name'];
	// 			$customer_arr['telephone'] = $_POST['telephone'];
	// 			// $customer_arr['address_id'] = $last_address_id;

	// 			show($customer_arr);
	// 		}
	// 	}

	// 	$data['errors'] = array_merge($data['errors'], $address->errors);
	// 	$data['errors'] = array_merge($data['errors'], $customer->errors);
	// }

	public function updateAddress()
	{
		if (!Auth::logged_in()) {
			message('Please login!!');
			redirect('login');
		}

		$id = Auth::getCustomerID();
		$customerModel = new Customer();
		$addressModel = new Address();

		$url = ROOT . "/fetch/customers/" . $id;
		$response = file_get_contents($url);
		$customer = json_decode($response, true);

		// Get the address ID associated with the customer ID
		$addressId = $customer['address_id'];

		// Validate form data
		$updatedCustomerData = [
			'first_name' => $_POST['first_name'],
			'last_name' => $_POST['last_name'],
			'telephone' => $_POST['telephone'],
		];

		$updatedAddressData = [
			'address_line_1' => $_POST['address_line_1'],
			'address_line_2' => $_POST['address_line_2'],
			'city' => $_POST['city'],
			'province' => $_POST['province'],
			'zip_code' => $_POST['zip_code'],
		];

		// show($updatedAddressData);

		$result1 = $customerModel-> validate($updatedCustomerData);
		$result2 = $addressModel -> validate($updatedAddressData);

		// show($result1);
		// show('***');
		// show($result2);

		// if (!$result1 && $result2){
		// 		// Validation failed, redirect back to the edit profile page with errors
		// 		message('Validation failed. Please check your inputs!');
		// 		redirect('profile/editAddress');
		// }

		if($result1 && $result2){
			// Perform the database update
			$customerSuccess = $customerModel->updateCustomerProfile($id, $updatedCustomerData);
			$addressSuccess = $addressModel->updateCustomerAddress($addressId, $updatedAddressData);

			if ($customerSuccess && $addressSuccess) {
				message('Updated successfully!');
				redirect('profile');
			} else {
				message('Failed to update. Please try again!');
				redirect('profile/editAddress');
			}
		}
		else{
			// Validation failed, redirect back to the edit profile page with errors
			message('Failed to update. Please try again!');
			redirect('profile/editAddress');
		}	
	}
}