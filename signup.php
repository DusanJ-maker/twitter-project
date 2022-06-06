<!DOCTYPE html>
<html>

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Twitter</title>
</head>


<body>

    <form action="action_page.php" style="border:1px solid #ccc">
        <div class="container">
            <h1>Sign Up</h1>
            <p>Create an account.</p>

            <label for="username"><b>Username</b></label><br>
            <input type="text" id="username" placeholder="Enter Username" name="username" required><br>

            <label for="email"><b>Email</b></label><br>
            <input type="text" id="email" placeholder="Enter Email" name="email" required><br>

            <label for="psw"><b>Password</b></label><br>
            <input type="password" id="psw" placeholder="Enter Password" name="psw" required><br>

            <label for="psw-repeat"><b>Repeat Password</b></label><br>
            <input type="password" id="psw-repeat" placeholder="Repeat Password" name="psw-repeat" required><br><br>

            <div class="">
                <button type="button" class="signupbtn" onclick="addUser()">Sign Up</button>
            </div>
        </div>

        <h3> Already have <a href="login.php">an account</a>? </h3>
    </form>

    <script>
        function addUser() {
            var username = document.getElementById("username").value
            var email = document.getElementById("email").value
            var password = document.getElementById("psw").value
            var passwordr = document.getElementById("psw-repeat").value
            console.log(username, email, password, passwordr)

            const formData = new FormData();
            formData.append('username', username);
            formData.append('email', email);
            formData.append('psw', password);
            formData.append('psw-repeat', passwordr);





            // Fire off the request to /form.php
            request = $.ajax({
                url: "http://localhost/twitter/add_user.php",
                type: "post",
                cache: false,
                processData: false,
                contentType: false,
                data: formData
            });

            // Callback handler that will be called on success
            request.done(function(response, textStatus, jqXHR) {
                // Log a message to the console
                location.reload();
            });

            // Callback handler that will be called on failure
            request.fail(function(jqXHR, textStatus, errorThrown) {
                // Log the error to the console
                console.error(
                    "The following error occurred: " +
                    textStatus, errorThrown
                );
            });

        }
    </script>

</body>

</html>