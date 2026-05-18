

<html>
<head>
    <title>Specialization Management</title>
    <link rel="stylesheet" href="styles/style.css">

    <script src="../Controller/JS/loadSpecializations.js"></script>
    <script src="../Controller/JS/addSpecialization.js"></script>
    <script src="../Controller/JS/updateSpecialization.js"></script>
    <script src="../Controller/JS/deleteSpecialization.js"></script>
</head>

<body onload="loadSpecializations()">

    <h2>Specialization Management</h2>
    <a href="doctor.php">Doctor Management</a> 
    <a href="../Controller/logout.php">Logout</a></p>

    <hr>

    <h3>Add New Specialization</h3>

    <table>
        <tr>
            <td>Specialization Name</td>
            <td><input type="text" id="spec_name" placeholder="e.g. Cardiology"></td>
            <td><button type="button" onclick="addSpecialization()">Add</button></td>
        </tr>
    </table>

    <p id="spec_response"></p>


    <div id="editSpecSection" style="display: none;">
        <h3>Edit Specialization</h3>
        <input type="hidden" id="spec_edit_id">
        <table>
            <tr>
                <td>New Name</td>
                <td><input type="text" id="spec_edit_name"></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <button type="button" onclick="updateSpecialization()">Save</button>
                    <button type="button" onclick="cancelEditSpec()">Cancel</button>
                </td>
            </tr>
        </table>
    </div>

    <hr>

    <h3>All Specializations</h3>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="specializationTableBody">
        </tbody>
    </table>

</body>
</html>
