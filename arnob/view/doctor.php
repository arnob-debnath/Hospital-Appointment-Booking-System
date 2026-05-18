

<html>
<head>
    <title>Doctor Management</title>
    <link rel="stylesheet" href="styles/style.css">

    <script src="../Controller/JS/loadDoctors.js"></script>
    <script src="../Controller/JS/addDoctor.js"></script>
    <script src="../Controller/JS/updateDoctor.js"></script>
    <script src="../Controller/JS/deleteDoctor.js"></script>
</head>

<body onload="loadDoctors(); loadSpecializationDropdown('doc_specialization_id', '')">

    <h2>Doctor Management</h2>
    <a href="specialization.php">Specialization Management</a> 
    <a href="../Controller/logout.php">Logout</a></p>

    <hr>

    <h3>Add New Doctor</h3>

    <table>
        <tr>
            <td>Full Name</td>
            <td><input type="text" id="doc_name" placeholder="Dr. Full Name"></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><input type="email" id="doc_email" placeholder="doctor@hospital.com"></td>
        </tr>
        <tr>
            <td>Temporary Password</td>
            <td>
                <input type="password" id="doc_password" placeholder="Min 8 characters">
                <br><small>Doctor must change this on first login</small>
            </td>
        </tr>
        <tr>
            <td>Specialization</td>
            <td>
                <select id="doc_specialization_id">
                    <option value="">Select Specialization</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Consultation Fee (BDT)</td>
            <td><input type="number" id="doc_fee" placeholder="500" min="0"></td>
        </tr>
        <tr>
            <td>Available Days</td>
            <td>
                <label><input type="checkbox" class="day-checkbox" value="Monday"> Monday</label>
                <label><input type="checkbox" class="day-checkbox" value="Tuesday"> Tuesday</label>
                <label><input type="checkbox" class="day-checkbox" value="Wednesday"> Wednesday</label>
                <label><input type="checkbox" class="day-checkbox" value="Thursday"> Thursday</label>
                <label><input type="checkbox" class="day-checkbox" value="Friday"> Friday</label>
            </td>
        </tr>
        <tr>
            <td>Profile Photo</td>
            <td>
                <input type="file" id="doc_photo" accept="image/jpeg, image/png">
                <br><small>JPEG or PNG, max 2 MB</small>
            </td>
        </tr>
        <tr>
            <td>Bio</td>
            <td><textarea id="doc_bio" rows="3" cols="40" placeholder="Brief professional background..."></textarea></td>
        </tr>
        <tr>
            <td></td>
            <td><button type="button" onclick="addDoctor()">Add Doctor</button></td>
        </tr>
    </table>

    <p id="doc_response"></p>



    <div id="editDoctorSection" style="display: none;">
        <h3>Edit Doctor</h3>

        <input type="hidden" id="edit_doctor_id">
        <input type="hidden" id="edit_user_id">

        <table>
            <tr>
                <td>Full Name</td>
                <td><input type="text" id="edit_doc_name"></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><input type="email" id="edit_doc_email"></td>
            </tr>
            <tr>
                <td>New Password</td>
                <td><input type="password" id="edit_doc_password" placeholder="Leave blank to keep current"></td>
            </tr>
            <tr>
                <td>Specialization</td>
                <td>
                    <select id="edit_doc_specialization_id">
                        <option value="">Select Specialization</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Consultation Fee (BDT)</td>
                <td><input type="number" id="edit_doc_fee" min="0"></td>
            </tr>
            <tr>
                <td>Available Days</td>
                <td>
                    <label><input type="checkbox" class="edit-day-checkbox" value="Monday"> Monday</label>
                    <label><input type="checkbox" class="edit-day-checkbox" value="Tuesday"> Tuesday</label>
                    <label><input type="checkbox" class="edit-day-checkbox" value="Wednesday"> Wednesday</label>
                    <label><input type="checkbox" class="edit-day-checkbox" value="Thursday"> Thursday</label>
                    <label><input type="checkbox" class="edit-day-checkbox" value="Friday"> Friday</label>
                </td>
            </tr>
            <tr>
                <td>New Photo</td>
                <td>
                    <input type="file" id="edit_doc_photo" accept="image/jpeg, image/png">
                    <br><small>Leave blank to keep current photo</small>
                </td>
            </tr>
            <tr>
                <td>Bio</td>
                <td><textarea id="edit_doc_bio" rows="3" cols="40"></textarea></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <button type="button" onclick="updateDoctor()">Save Changes</button>
                    <button type="button" onclick="cancelEditDoctor()">Cancel</button>
                </td>
            </tr>
        </table>
    </div>

    <hr>

    <h3>All Doctors</h3>

    <table border="1">
        <thead>
            <tr>
                <th>Photo</th>
                <th>Name / Email</th>
                <th>Specialization</th>
                <th>Fee (BDT)</th>
                <th>Available Days</th>
                <th>Status</th>
                <th>Appointments</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="doctorTableBody">
        </tbody>
    </table>

</body>
</html>
