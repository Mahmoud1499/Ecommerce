<?php
session_start();
$pageTitle = 'Profile';
include "init.php";
// echo $sessionsUser;

if (isset($_SESSION['user'])) {
    $getUser = $con->prepare('SELECT * FROM users WHERE UserName = ?');
    $getUser->execute(array($sessionsUser));
    $info = $getUser->fetch();
    // var_dump($info);

?>
    <div class="information block">
        <div class="container">
            <div class="card  border-primary ">
                <div class="card-header bg-primary text-white">My Information</div>
                <div class="card-body">
                    User Name: <?= $info['UserName']; ?> </br>
                    Full Name: <?= $info['FullName']; ?> </br>
                    Email: <?= $info['Email']; ?> </br>
                    Registerd Date: <?= $info['UserName']; ?> </br>
                    Favorite Categories: <?= $info['UserName']; ?> </br>

                </div>
            </div>
        </div>
    </div>

    <div class="my-ads block">
        <div class="container ">
            <div class="card border-primary  ">
                <div class="card-header bg-primary text-white">My Ads</div>
                <div class="card-body">
                    Test: <?php echo
                            $_SESSION['user'];

                            foreach (getItems('Member_ID', $info['UserID']) as $item) {
                                echo "<div class='col-sm-6 col-md-4'>";
                                echo "<div class='img-thumbnail item-box'>";
                                echo "<span class='price-tag'> " . $item['Price'] . "</span>";
                                echo "<img class='rounded img-fluid' src='https://th.bing.com/th/id/OIP.2RR4RuG1NyW5PsfzQN_sKgHaE8?pid=ImgDet&rs=1' alt='' />";
                                echo "<div class='caption'>";
                                echo "<h3 class=''>" . $item['Name'] . " </h3>";
                                echo "<p class=''> " . $item['Description'] . " </p>";
                                echo "</div>";
                                echo "</div>";
                                echo "</div>";
                            };
                            ?>
                </div>
            </div>
        </div>
    </div>

    <div class="my-comments block">
        <div class="container">
            <div class="card  border-primary  ">
                <div class="card-header bg-primary text-white">Latest comments</div>
                <div class="card-body">
                    Comments: <?php
                                echo $_SESSION['user'];

                                $stmt = $con->prepare("SELECT comments.* , items.Name AS Item_Name 
                                FROM comments
                                INNER JOIN items on items.Item_ID = comments.item_id
                                                        WHERE user_id =? 
                    ");
                                $stmt->execute(array($info['UserID']));
                                $comments = $stmt->fetchAll();

                                if (!empty($comments)) {
                                    foreach ($comments as $comment) {
                                        echo "<p class=''> " . $comment['comment'] . " </p>";
                                    }
                                } else {
                                    echo "There is no comments to show ";
                                }
                                ?>
                </div>
            </div>
        </div>
    </div>






<?php
} else {
    header('location:login.php ');
    exit();
}

include $tpl . "footer.php";
