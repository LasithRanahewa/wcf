<?php $page = 'staff' ?>
<?php include "inc/header.view.php"; ?>

<?php
if (isset($_SESSION['errors']) && isset($_SESSION['form_data']) && isset($_SESSION['form_id'])) {
    $errors = $_SESSION['errors'];
    $form_data = $_SESSION['form_data'];
    $form_id = $_SESSION['form_id'];
    // unset the session variables so they don't persist on page refresh
    unset($_SESSION['errors']);
    unset($_SESSION['form_data']);
    unset($_SESSION['form_id']);
    // display the errors and repopulate the form with the data
    // show($form_data);
}
?>

<div class="table-section">
    <?php if (message()) : ?>
        <div class="mzg-box">
            <div class="messege"><?= message('', true) ?></div>
        </div>
    <?php endif; ?>


    <h2 class="table-section__title">Staff Members</h2>

    <div class="table-section__add">
        <a href="#" class="table-section__add-link" onclick="openPopup('add-item-popup')">Add New Staff Member</a>
    </div>

    <div class="table-section__search">
        <input type="text" id="searchStaff" placeholder="Search Staff Members..." class="table-section__search-input">
    </div>


    <div id="scrollable_sec">
        <table class="table-section__table" id="staff_table">
            <thead>
                <tr>
                    <th>Staff ID</th>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Email</th>
                    <th>Mobile Number</th>
                    <th>Address</th>
                    <!-- <th>Created At</th> -->
                    <!-- <th>Updated At</th> -->

                    <th>Actions</th>
                </tr>
            </thead>

            <tbody id="table-section__tbody">
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        function updateTable() {
                            fetch('<?php echo ROOT ?>/fetch/staff')
                                .then(response => response.json())
                                .then(data => {
                                    // console.log(data);
                                    let tableBody = document.getElementById('table-section__tbody');
                                    let table = document.getElementById('staff_table');
                                    // Clear existing table rows
                                    while (table.rows.length > 1) {
                                        table.deleteRow(1);
                                    }
                                    
                                    data.sort((a, b) => b.staff_id - a.staff_id);

                                    data.forEach(item => {
                                        let row = table.insertRow();
                                        let staff_id = "STF-" + String(item.staff_id).padStart(3, '0');
                                        item.first_name = item.first_name.charAt(0).toUpperCase() + item.first_name.slice(1);
                                        item.last_name = item.last_name.charAt(0).toUpperCase() + item.last_name.slice(1);
                                        let name = item.first_name + " " + item.last_name;
                                        // switch (item.role) {
                                        //     case 'osr':
                                        //         item.role = 'Online Sales Representative';
                                        //         break;
                                        //     case 'gm':
                                        //         item.role = 'General Manager';
                                        //         break;
                                        //     case 'pm':
                                        //         item.role = 'Production Manager';
                                        //         break;
                                        //     case 'sk':
                                        //         item.role = 'Stock Keeper';
                                        //         break;
                                        //     default:
                                        //         item.role = 'Staff';
                                        //         break;
                                        // }
                                        let role = item.role.toUpperCase();
                                        let email = item.email;
                                        let mobile_number = item.mobile_number;
                                        let address = item.address_line_1 + ",<br> " + item.address_line_2 + ",<br> " + item.city + ".<br> " + item.province + ' Province.<br>' + item.zip_code;
                                        // let updated_at = item.updated_at;

                                        row.insertCell().innerHTML = staff_id;
                                        row.insertCell().innerHTML = name;
                                        row.insertCell().innerHTML = role;
                                        row.insertCell().innerHTML = email;
                                        row.insertCell().innerHTML = mobile_number;
                                        row.insertCell().innerHTML = address;
                                        // row.insertCell(6).innerHTML = created_at;
                                        // row.insertCell().innerHTML = updated_at;
                                        row.insertCell().innerHTML = `<a class="table-section__button" onclick="openUpdatePopup(${item.staff_id})">Update</a><a class="table-section__button table-section__button-del" onclick="openDeletePopup(${item.staff_id})">Delete</a>`;
                                    })
                                })



                        }
                        updateTable();
                        
                        document.getElementById('searchStaff').addEventListener('input', function() {
                            let searchValue = this.value.toLowerCase();
                            let rows = document.getElementById('staff_table').rows;
                            for (let i = 1; i < rows.length; i++) {
                                let name = rows[i].cells[1].innerText.toLowerCase();
                                let id = rows[i].cells[0].innerText.toLowerCase();
                                let role = rows[i].cells[2].innerText.toLowerCase();
                                let email = rows[i].cells[3].innerText.toLowerCase();
                                let mobile_number = rows[i].cells[4].innerText.toLowerCase();
                                let address = rows[i].cells[5].innerText.toLowerCase();

                                if (name.includes(searchValue) || id.includes(searchValue) || role.includes(searchValue) || email.includes(searchValue) || mobile_number.includes(searchValue) || address.includes(searchValue)) {
                                    rows[i].style.display = '';
                                } else {
                                    rows[i].style.display = 'none';
                                }
                            }
                        });

                        let headers = document.querySelectorAll('th');

                        headers.forEach(header => {
                            header.addEventListener('click', function() {
                                let table = document.getElementById('staff_table');
                                let rows = table.rows;
                                let headerIndex = this.cellIndex;
                                let switching = true;
                                let shouldSwitch = false;
                                let dir = 'asc';
                                let switchcount = 0;
                                let x, y;
                                let i;
                                let currentRow, nextRow;

                                while (switching) {
                                    switching = false;
                                    for (i = 1; i < (rows.length - 1); i++) {
                                        shouldSwitch = false;
                                        currentRow = rows[i].getElementsByTagName('td')[headerIndex];
                                        nextRow = rows[i + 1].getElementsByTagName('td')[headerIndex];
                                        if (dir === 'asc') {
                                            if (currentRow.innerHTML.toLowerCase() > nextRow.innerHTML.toLowerCase()) {
                                                shouldSwitch = true;
                                                break;
                                            }
                                        } else if (dir === 'desc') {
                                            if (currentRow.innerHTML.toLowerCase() < nextRow.innerHTML.toLowerCase()) {
                                                shouldSwitch = true;
                                                break;
                                            }
                                        }
                                    }
                                    if (shouldSwitch) {
                                        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                                        switching = true;
                                        switchcount++;
                                    } else {
                                        if (switchcount === 0 && dir === 'asc') {
                                            dir = 'desc';
                                            switching = true;
                                        }
                                    }
                                }
                            });
                        });
                    });
                </script>
            </tbody>
        </table>
    </div>

    <div class="popup-form" id="add-item-popup">
        <div class="popup-form__content">
            <form action="<?php echo ROOT ?>/add/staff" method="POST" class="form">
                <h2 class="popup-form-title">Add New Staff Member</h2>

                <?php if (!empty($errors['first_name'])) : ?>
                    <p class="validate-mzg"><?= $errors['first_name'] ?></p>
                <?php endif; ?>
                <div class="form-group">
                    <label for="first_name" class="form-label label-popup">First Name</label>
                    <input value="<?php echo $form_data['first_name'] ?>" type="text" id="first_name" name="first_name" class="form-input input-popup">
                </div>

                <?php if (!empty($errors['last_name'])) : ?>
                    <p class="validate-mzg"><?= $errors['last_name'] ?></p>
                <?php endif; ?>
                <div class="form-group">
                    <label for="last_name" class="form-label label-popup">Last Name</label>
                    <input value="<?php echo $form_data['last_name'] ?>" type="text" id="last_name" name="last_name" class="form-input input-popup">
                </div>

                <!-- email -->
                <?php if (!empty($errors['email'])) : ?>
                    <p class="validate-mzg"><?= $errors['email'] ?></p>
                <?php endif; ?>
                <div class="form-group">
                    <label for="email" class="form-label label-popup">Email</label>
                    <input value="<?php echo $form_data['email'] ?>" type="text" id="email" name="email" class="form-input input-popup">
                </div>

                <!-- password -->
                <?php if (!empty($errors['password'])) : ?>
                    <p class="validate-mzg"><?= $errors['password'] ?></p>
                <?php endif; ?>
                <div class="form-group">
                    <label for="password" class="form-label label-popup">Password</label>
                    <input value="<?php echo $form_data['password'] ?>" type="password" id="password" name="password" class="form-input input-popup">
                </div>

                <?php if (!empty($errors['role'])) : ?>
                    <p class="validate-mzg"><?= $errors['role'] ?></p>
                <?php endif; ?>
                <div class="form-group">
                    <label for="role" class="form-label label-popup">Role</label>
                    <select id="role" name="role" class="form-select input-popup">

                        <?php if (empty($form_data['role'])) : ?>
                            <option value="" selected disabled>Select Role</option>
                        <?php else : ?>
                            <option value="" disabled>Select Role</option>
                        <?php endif; ?>
                        <?php if ($form_data['role'] === 'osr') : ?>
                            <option value="osr" selected>Online Sales Representative</option>
                        <?php else : ?>
                            <option value="osr">Online Sales Representative</option>
                        <?php endif; ?>
                        <?php if ($form_data['role'] === 'gm') : ?>
                            <option value="gm" selected>General Manager</option>
                        <?php else : ?>
                            <option value="gm">General Manager</option>
                        <?php endif; ?>
                        <?php if ($form_data['role'] === 'pm') : ?>
                            <option value="pm" selected>Production Manager</option>
                        <?php else : ?>
                            <option value="pm">Production Manager</option>
                        <?php endif; ?>
                        <?php if ($form_data['role'] === 'sk') : ?>
                            <option value="sk" selected>Stock Keeper</option>
                        <?php else : ?>
                            <option value="sk">Stock Keeper</option>
                        <?php endif; ?>

                    </select>
                </div>


                <?php if (!empty($errors['mobile_number'])) : ?>
                    <p class="validate-mzg"><?= $errors['mobile_number'] ?></p>
                <?php endif; ?>
                <div class="form-group">
                    <label for="mobile_number" class="form-label label-popup">Mobile Number</label>
                    <input value="<?php echo $form_data['mobile_number'] ?>" type="text" id="mobile_number" name="mobile_number" class="form-input input-popup">
                </div>

                <?php if (!empty($errors['address_line_1'])) : ?>
                    <p class="validate-mzg"><?= $errors['address_line_1'] ?></p>
                <?php endif; ?>
                <div class="form-group">
                    <label for="address_line_1" class="form-label label-popup">Address Line 1</label>
                    <input value="<?php echo $form_data['address_line_1'] ?>" type="text" id="address_line_1" name="address_line_1" class="form-input input-popup">
                </div>

                <?php if (!empty($errors['address_line_2'])) : ?>
                    <p class="validate-mzg"><?= $errors['address_line_2'] ?></p>
                <?php endif; ?>
                <div class="form-group">
                    <label for="address_line_2" class="form-label label-popup">Address Line 2</label>
                    <input value="<?php echo $form_data['address_line_2'] ?>" type="text" id="address_line_2" name="address_line_2" class="form-input input-popup">
                </div>

                <?php if (!empty($errors['city'])) : ?>
                    <p class="validate-mzg"><?= $errors['city'] ?></p>
                <?php endif; ?>
                <div class="form-group">
                    <label for="city" class="form-label label-popup">City</label>
                    <input value="<?php echo $form_data['city'] ?>" type="text" id="city" name="city" class="form-input input-popup">
                </div>

                <?php if (!empty($errors['province'])) : ?>
                    <p class="validate-mzg"><?= $errors['province'] ?></p>
                <?php endif; ?>
                <div class="form-group">
                    <label for="province" class="form-label label-popup">Province</label>
                    <!-- 'Central','Eastern','North Central','Northern','North Western','Sabaragamuwa','Southern','Uva','Western' -->
                    <select id="province" name="province" class="form-select input-popup">
                        <?php if (empty($form_data['province'])) : ?>
                            <option value="" selected disabled>Select Province</option>
                        <?php else : ?>
                            <option value="" disabled>Select Province</option>
                        <?php endif; ?>
                        <?php if ($form_data['province'] === 'Central') : ?>
                            <option value="Central" selected>Central</option>
                        <?php else : ?>
                            <option value="Central">Central</option>
                        <?php endif; ?>
                        <?php if ($form_data['province'] === 'Eastern') : ?>
                            <option value="Eastern" selected>Eastern</option>
                        <?php else : ?>
                            <option value="Eastern">Eastern</option>
                        <?php endif; ?>
                        <?php if ($form_data['province'] === 'North Central') : ?>
                            <option value="North Central" selected>North Central</option>
                        <?php else : ?>
                            <option value="North Central">North Central</option>
                        <?php endif; ?>
                        <?php if ($form_data['province'] === 'Northern') : ?>
                            <option value="Northern" selected>Northern</option>
                        <?php else : ?>
                            <option value="Northern">Northern</option>
                        <?php endif; ?>
                        <?php if ($form_data['province'] === 'North Western') : ?>
                            <option value="North Western" selected>North Western</option>
                        <?php else : ?>
                            <option value="North Western">North Western</option>
                        <?php endif; ?>
                        <?php if ($form_data['province'] === 'Sabaragamuwa') : ?>
                            <option value="Sabaragamuwa" selected>Sabaragamuwa</option>
                        <?php else : ?>
                            <option value="Sabaragamuwa">Sabaragamuwa</option>
                        <?php endif; ?>
                        <?php if ($form_data['province'] === 'Southern') : ?>
                            <option value="Southern" selected>Southern</option>
                        <?php else : ?>
                            <option value="Southern">Southern</option>
                        <?php endif; ?>
                        <?php if ($form_data['province'] === 'Uva') : ?>
                            <option value="Uva" selected>Uva</option>
                        <?php else : ?>
                            <option value="Uva">Uva</option>
                        <?php endif; ?>
                        <?php if ($form_data['province'] === 'Western') : ?>
                            <option value="Western" selected>Western</option>
                        <?php else : ?>
                            <option value="Western">Western</option>
                        <?php endif; ?>
                    </select>

                </div>

                <?php if (!empty($errors['zip_code'])) : ?>
                    <p class="validate-mzg"><?= $errors['zip_code'] ?></p>
                <?php endif; ?>
                <div class="form-group">
                    <label for="zip_code" class="form-label label-popup">Zip Code</label>
                    <input value="<?php echo $form_data['zip_code'] ?>" type="text" id="zip_code" name="zip_code" class="form-input input-popup">
                </div>

                <div class="form-group form-btns">
                    <button type="submit" class="form-btn submit-btn">Add New Worker</button>
                    <button type="button" class="form-btn cancel-btn" onclick="closePopup()">Cancel</button>
                </div>
            </form>

        </div>
    </div>
    <script>
        // Function to open popup form
        function openPopup(popupId) {
            const popup = document.getElementById(popupId);
            popup.classList.add('popup-form--open');
        }

        // Function to close popup form
        function closePopup() {
            const popups = document.querySelectorAll('.popup-form');
            // confirmText = document.querySelector('.confirmation-text');
            // confirmText.innerHTML = "Are you sure you want to delete ";
            popups.forEach(popup => {
                popup.classList.remove('popup-form--open');
            });

            // Clear validation messages
            const validationMessages = document.querySelectorAll('.validate-mzg');
            validationMessages.forEach(message => {
                message.innerHTML = '';
            });



        }
    </script>



    <!-- Update item popup form -->
    <div class="popup-form" id="update-item-popup">
        <div class="popup-form__content">
            <form action="<?php echo ROOT ?>/update/staff" method="POST" class="form">
                <h2 class="popup-form-title" id="update_title">Update Staff Member</h2>

                <?php if (!empty($errors['first_name'])) : ?>
                    <p class="validate-mzg"><?= $errors['first_name'] ?></p>
                <?php endif; ?>
                <div class="form-group">
                    <label for="first_name" class="form-label label-popup">First Name</label>
                    <input value="<?php echo $form_data['first_name'] ?>" type="text" id="first_name_update" name="first_name" class="form-input input-popup">
                </div>

                <?php if (!empty($errors['last_name'])) : ?>
                    <p class="validate-mzg"><?= $errors['last_name'] ?></p>
                <?php endif; ?>
                <div class="form-group">
                    <label for="last_name" class="form-label label-popup">Last Name</label>
                    <input value="<?php echo $form_data['last_name'] ?>" type="text" id="last_name_update" name="last_name" class="form-input input-popup">
                </div>

                <!-- email -->
                <?php if (!empty($errors['email'])) : ?>
                    <p class="validate-mzg"><?= $errors['email'] ?></p>
                <?php endif; ?>
                <div class="form-group">
                    <label for="email" class="form-label label-popup">Email</label>
                    <input disabled value="<?php echo $form_data['email'] ?>" type="text" id="email_update" name="email" class="form-input input-popup disabled-input" disabled>
                </div>

                <!-- password -->


                <!-- role -->
                <?php if (!empty($errors['role'])) : ?>
                    <p class="validate-mzg"><?= $errors['role'] ?></p>
                <?php endif; ?>
                <div class="form-group">
                    <label for="role" class="form-label label-popup">Role</label>
                    <select id="role_update" name="role" class="form-select input-popup disabled-input">
                        <?php if (empty($form_data['role'])) : ?>
                            <option value="" selected disabled>Select Role</option>
                        <?php else : ?>
                            <option value="" disabled>Select Role</option>
                        <?php endif; ?>
                        <?php if ($form_data['role'] === 'osr') : ?>
                            <option value="osr" disabled selected>Online Sales Representative</option>
                        <?php else : ?>
                            <option value="osr" disabled>Online Sales Representative</option>
                        <?php endif; ?>
                        <?php if ($form_data['role'] === 'gm') : ?>
                            <option value="gm" disabled selected>General Manager</option>
                        <?php else : ?>
                            <option value="gm" disabled>General Manager</option>
                        <?php endif; ?>
                        <?php if ($form_data['role'] === 'pm') : ?>
                            <option value="pm" disabled selected>Production Manager</option>
                        <?php else : ?>
                            <option value="pm" disabled>Production Manager</option>
                        <?php endif; ?>
                        <?php if ($form_data['role'] === 'sk') : ?>
                            <option value="sk" disabled selected>Stock Keeper</option>
                        <?php else : ?>
                            <option value="sk" disabled>Stock Keeper</option>
                        <?php endif; ?>

                    </select>
                </div>


                <?php if (!empty($errors['mobile_number'])) : ?>
                    <p class="validate-mzg"><?= $errors['mobile_number'] ?></p>
                <?php endif; ?>
                <div class="form-group">
                    <label for="mobile_number" class="form-label label-popup">Mobile Number</label>
                    <input value="<?php echo $form_data['mobile_number'] ?>" type="text" id="mobile_number_update" name="mobile_number" class="form-input input-popup">
                </div>

                <?php if (!empty($errors['address_line_1'])) : ?>
                    <p class="validate-mzg"><?= $errors['address_line_1'] ?></p>
                <?php endif; ?>
                <div class="form-group">
                    <label for="address_line_1" class="form-label label-popup">Address Line 1</label>
                    <input value="<?php echo $form_data['address_line_1'] ?>" type="text" id="address_line_1_update" name="address_line_1" class="form-input input-popup">
                </div>

                <?php if (!empty($errors['address_line_2'])) : ?>
                    <p class="validate-mzg"><?= $errors['address_line_2'] ?></p>
                <?php endif; ?>
                <div class="form-group">
                    <label for="address_line_2" class="form-label label-popup">Address Line 2</label>
                    <input value="<?php echo $form_data['address_line_2'] ?>" type="text" id="address_line_2_update" name="address_line_2" class="form-input input-popup">
                </div>

                <?php if (!empty($errors['city'])) : ?>
                    <p class="validate-mzg"><?= $errors['city'] ?></p>
                <?php endif; ?>
                <div class="form-group">
                    <label for="city" class="form-label label-popup">City</label>
                    <input value="<?php echo $form_data['city'] ?>" type="text" id="city_update" name="city" class="form-input input-popup">
                </div>

                <?php if (!empty($errors['province'])) : ?>
                    <p class="validate-mzg"><?= $errors['province'] ?></p>
                <?php endif; ?>
                <div class="form-group">
                    <label for="province" class="form-label label-popup">Province</label>
                    <select id="province_update" name="province" class="form-select input-popup">
                        <?php if (empty($form_data['province'])) : ?>
                            <option value="" selected disabled>Select Province</option>
                        <?php else : ?>
                            <option value="" disabled>Select Province</option>
                        <?php endif; ?>
                        <?php if ($form_data['province'] === 'Central') : ?>
                            <option value="Central" selected>Central</option>
                        <?php else : ?>
                            <option value="Central">Central</option>
                        <?php endif; ?>
                        <?php if ($form_data['province'] === 'Eastern') : ?>
                            <option value="Eastern" selected>Eastern</option>
                        <?php else : ?>
                            <option value="Eastern">Eastern</option>
                        <?php endif; ?>
                        <?php if ($form_data['province'] === 'North Central') : ?>
                            <option value="North Central" selected>North Central</option>
                        <?php else : ?>
                            <option value="North Central">North Central</option>
                        <?php endif; ?>
                        <?php if ($form_data['province'] === 'Northern') : ?>
                            <option value="Northern" selected>Northern</option>
                        <?php else : ?>
                            <option value="Northern">Northern</option>
                        <?php endif; ?>
                        <?php if ($form_data['province'] === 'North Western') : ?>
                            <option value="North Western" selected>North Western</option>
                        <?php else : ?>
                            <option value="North Western">North Western</option>
                        <?php endif; ?>
                        <?php if ($form_data['province'] === 'Sabaragamuwa') : ?>
                            <option value="Sabaragamuwa" selected>Sabaragamuwa</option>
                        <?php else : ?>
                            <option value="Sabaragamuwa">Sabaragamuwa</option>
                        <?php endif; ?>
                        <?php if ($form_data['province'] === 'Southern') : ?>
                            <option value="Southern" selected>Southern</option>
                        <?php else : ?>
                            <option value="Southern">Southern</option>
                        <?php endif; ?>
                        <?php if ($form_data['province'] === 'Uva') : ?>
                            <option value="Uva" selected>Uva</option>
                        <?php else : ?>
                            <option value="Uva">Uva</option>
                        <?php endif; ?>
                        <?php if ($form_data['province'] === 'Western') : ?>
                            <option value="Western" selected>Western</option>
                        <?php else : ?>
                            <option value="Western">Western</option>
                        <?php endif; ?>
                    </select>
                </div>

                <?php if (!empty($errors['zip_code'])) : ?>
                    <p class="validate-mzg"><?= $errors['zip_code'] ?></p>
                <?php endif; ?>
                <div class="form-group">
                    <label for="zip_code" class="form-label label-popup">Zip Code</label>
                    <input value="<?php echo $form_data['zip_code'] ?>" type="text" id="zip_code_update" name="zip_code" class="form-input input-popup">
                </div>


                <div class="form-group form-btns">
                    <button type="submit" class="form-btn submit-btn">Update Staff Member</button>
                    <button type="button" class="form-btn cancel-btn" onclick="closePopup()">Cancel</button>
                </div>
            </form>

        </div>
    </div>

    <script>
        openUpdatePopup = (id) => {
            sessionStorage.setItem('staff_id', id);
            const popupTitle = document.getElementById('update_title');
            popupTitle.innerHTML = "Update Staff Member (ID: STF-" + String(id).padStart(3, '0') + ")";

            const popup = document.getElementById('update-item-popup');
            // fetch data from database as json
            fetch('<?php echo ROOT ?>/fetch/staff/' + id)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    // populate form with data
                    document.getElementById('first_name_update').value = data.first_name;
                    document.getElementById('last_name_update').value = data.last_name;
                    document.getElementById('email_update').value = data.email;
                    // document.getElementById('password_update').value = data.password;
                    document.getElementById('role_update').value = data.role;
                    document.getElementById('mobile_number_update').value = data.mobile_number;
                    document.getElementById('address_line_1_update').value = data.address_line_1;
                    document.getElementById('address_line_2_update').value = data.address_line_2;
                    document.getElementById('city_update').value = data.city;
                    document.getElementById('zip_code_update').value = data.zip_code;
                    document.getElementById('province_update').value = data.province;

                })
                .catch(error => console.error(error));
            popup.classList.add('popup-form--open');

            popup.querySelector('form').action = "<?php echo ROOT ?>/update/staff/" + id;
        }
    </script>

    <script>
        <?php if (!empty($errors)) : ?>
            if ('<?php echo $form_id; ?>' === 'form1') {
                openPopup('add-item-popup');
            } else if ('<?php echo $form_id; ?>' === 'form2') {
                // code to open your second popup goes here
                staff_id = sessionStorage.getItem('staff_id');
                openUpdatePopup(staff_id);
            }
        <?php endif; ?>
    </script>

    <div class="popup-form" id="delete-item-popup">
        <div class="popup-form__content">
            <form action="" method="POST" class="form">
                <!-- <h2 class="popup-form-title">Delete Item</h2> -->
                <!-- <p>Are you sure you want to delete this item?</p> -->
                <p class="confirmation-text">Are you sure you want to delete </p>

                <div class="form-group frm-btns">
                    <button type="submit" class="form-btn submit-btn">Yes</button>
                    <button type="button" class="form-btn cancel-btn" onclick="closePopup()">No</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        openDeletePopup = (id) => {
            const popup = document.getElementById('delete-item-popup');
            const confirmationText = document.querySelector('.confirmation-text');
            x = "STF-" + String(id).padStart(3, '0');
            confirmationText.innerHTML += "Staff ID: " + x + "?";
            popup.classList.add('popup-form--open');
            popup.querySelector('form').action = "<?php echo ROOT ?>/delete/staff/" + id;
        }
    </script>








    <?php include "inc/footer.view.php"; ?>