<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
$x = $_SESSION['id'];
?>

<!DOCTYPE html>
<html>

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="style.css">
    <title>Twitter</title>
</head>

<body>

    <?php

    include("./like.php");

    $posts = mysqli_query($con, "SELECT * FROM tweets");
    while ($row = mysqli_fetch_array($posts)) { ?>

        
        <div class="post">
            <td><?php echo $row['tweet']; ?></td>

            <div style="padding: 2px; margin-top: 5px;">
                <?php
                // determine if user has already liked this post
                $results = mysqli_query($con, "SELECT * FROM likes WHERE users_id=1 AND tweets_id=" . $row['id'] . "");

                if (mysqli_num_rows($results) == 1){
                    echo '<button class="unlike" data-id="' . $row['id'] .'  ">Unlike</button>';
                    // echo '<button class="like" data-id="' . $row['id'] .'  ">like</button>';
                } else {
                    echo '<button class="like" data-id="' . $row['id'] .'  ">like</button>';
                    // echo '<button class="unlike" data-id="' . $row['id'] .'  ">Unlike</button>';
                }
                
                
                
                
                ?>

                <span class="likes_count"><?php echo $row['likes']; ?> likes</span>
            </div>
        </div>         
    <?php } ?>

    <!-- Add Jquery to page -->
    <script src="jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // when the user clicks on like
            $('.like').on('click', function() {
                var postid = $(this).data('id');
                $post = $(this);

                $.ajax({
                    url: 'like.php',
                    type: 'post',
                    data: {
                        'liked': 1,
                        'postid': postid
                    },
                    success: function(response) {
                        $post.parent().find('span.likes_count').text(response + " likes");
                        $post.addClass('hide');
                        $post.siblings().removeClass('hide');
                    }
                });
            });

            // when the user clicks on unlike
            $('.unlike').on('click', function() {
                var postid = $(this).data('id');
                $post = $(this);

                $.ajax({
                    url: 'like.php',
                    type: 'post',
                    data: {
                        'unliked': 1,
                        'postid': postid
                    },
                    success: function(response) {
                        $post.parent().find('span.likes_count').text(response + " likes");
                        $post.addClass('hide');
                        $post.siblings().removeClass('hide');
                    }
                });
            });
        });
    </script>
















    <label for="">Tweet here:</label>

    <textarea id="tweet" name="tweet" rows="4" cols="50" placeholder="Tweet here...">
    </textarea>
    <input type="hidden" value="<?php echo $x; ?>" id="id" />

    <button type="button" onclick="addTweet()">Click Me!</button>

    <script>
        // Add new tweet
        function addTweet() {
            var tweet = document.getElementById("tweet").value
            var id = document.getElementById("id").value
            console.log(tweet)

            const formData = new FormData();
            formData.append('tweet', tweet);
            formData.append('user_id', id);


            // Fire off the request to /form.php
            request = $.ajax({
                url: "http://localhost/twitter/add_tweet.php",
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

        // Add like
        function addLike(tweet) {

            var id = document.getElementById("id").value
            console.log('test', tweet, id)

            const formData = new FormData();
            formData.append('tweet', tweet);
            formData.append('user_id', id);


            // Fire off the request to /form.php
            request = $.ajax({
                url: "http://localhost/twitter/add_like.php",
                type: "post",
                cache: false,
                processData: false,
                contentType: false,
                data: formData
            });

            // Callback handler that will be called on success
            request.done(function(response, textStatus, jqXHR) {
                // Log a message to the console
                // location.reload();
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

        function deleteU(id) {
            const formData = new FormData();
            formData.append('id', id);


            // Fire off the request to /form.php
            request = $.ajax({
                url: "http://localhost/twitter/delete_tweet.php",
                type: "post",
                cache: false,
                processData: false,
                contentType: false,
                data: formData
            });

            // Callback handler that will be called on success
            request.done(function(response, textStatus, jqXHR) {
                // Reload page after succes
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

    <?php

    include("./connection.php");

    $sqlQuery = "SELECT id, tweet, likes
                FROM tweets;";

    try {
        $stmt = $conn->prepare($sqlQuery);
        $stmt->execute();
    } catch (PDOException $e) {
        $error = $e->getMessage();
        echo $error;
    }

    echo "
                    <table id='tweets'>
                        <tr>
                        <th>ID</th>
                        <th>Tweets</th>
                        <th>Delete</th>
                        <th>Like</th>
                        <th>Likes_count</th>
                        <th>Dislike</th>
                        </tr>
                        ";


    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . htmlentities($row['tweet']) . "</td>";
        echo '<td><button class="btn" id="button" onclick="deleteU(' . htmlentities($row['id']) . ')">Delete</button></td>';
        echo '<td><button class="btn" id="buttonLike" onclick="addLike(' . htmlentities($row['id']) . ')">Like</button></td>';
        echo '<td><span class="likes_count"> ' . $row['likes'] . '</span></td>';
        echo '<td><button class="btn" id="button" onclick="myFunction()">Dislike</button></td>';

        echo "<tr>";
    }
    echo "</table>";



    ?>

    <script>
        const btn = document.getElementById('buttonLike');

        btn.addEventListener('click', () => {

            // 👇️ hide button
            btn.style.display = 'none';
        });
    </script>





</body>

</html>