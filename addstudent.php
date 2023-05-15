<!DOCTYPE html>
<html>
    <head>
        <title>Add student</title>
        <link rel="stylesheet" type="text/css" href="CSS/add.css">
        <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
        <link rel="stylesheet"href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    </head>
    <body>
    <?php include "header.php"; ?>
        <div class="page-container">
            <div>
                <p class="add_student">Add Student</p>
                <input type="file" name="img" class="img" accept=".png,.jpg">
            </div>
            <hr>
            <form action="">
                <div class="section1">
                    <h2>Psychologue</h2>
                    <label>Name:</label>
                    <div class="name_parent">
                        <input  class="name1" type="text" placeholder="First Name" required>
                        <input  class="name2" type="text" placeholder="Last Name" required>
                    </div>
                    <label>Date of Birth:</label>
                    <div class="va-header">
                        <input class="text" type="date" >
                    </div>
                    <label>Place of Birth:</label>
                    <div class="va-header">
                        <input class="text" type="text" >
                    </div>
                    <label>Numero inscription:</label>
                    <div class="va-header">
                        <input class="text" type="text" max="10">
                    </div>
                    <label>Adress:</label>
                    <div class="va-header">
                        <input class="text" type="text" >
                    </div>
                    <div class="va-header">
                        <button type="submit">Add</button>
                    </div>
                </div>
                <div class="section2">
                    <h2 id="parenth2">Parent Info</h2>
                    <label>Parent Name:</label>
                    <div class="name_parent">
                        <input class="name1" type="text" placeholder="First Name" required>
                        <input class="name2" type="text" placeholder="Last Name" required>
                    </div>
                    <label>Job father:</label>
                    <div class="va-header">
                        <input class="text" type="text" >
                    </div>
                    <label>Job mother:</label>
                    <div class="va-header">
                        <input class="text" type="text" >
                    </div>
                    <label>Adress:</label>
                    <div class="va-header">
                        <input class="text" type="text" >
                    </div>
                    

                </div>
            </form>
        </div>

        
        <script type="text/javascript" src="Scripts/index.js"></script>
    </body>
</html>