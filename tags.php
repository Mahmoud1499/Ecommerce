<?php
session_start();
include 'init.php';
?>

<div class="container">
    <h1 class="text-center"> <?= $_GET['name']  ?> </h1>
    <div class="row">
        <?php
        if (isset($_GET['name'])) {
            $tag = $_GET['name'];

            $tagItems = getAllFrom("*", "items", "where tags like '%$tag%'", "AND Approve = 1", "Item_ID");
            foreach ($tagItems as $item) {
                echo "<div class='col-sm-6 col-md-4'>";
                echo "<div class='img-thumbnail item-box'>";
                echo "<span class='price-tag'> " . $item['Price'] . "</span>";
                echo "<img class='rounded img-fluid' src='https://th.bing.com/th/id/OIP.2RR4RuG1NyW5PsfzQN_sKgHaE8?pid=ImgDet&rs=1' alt='' />";
                echo "<div class='caption'>";
                echo '<h3 class="" > <a href="item.php?itemid=' . $item['Item_ID'] . ' "> ' . $item['Name'] . " </a> </h3>";
                echo "<p class=''>   " . $item['Description'] . "   </p>";
                echo "<div class='date'>" . $item['Add_Date'] . "</div>";

                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo 'You Must Enter Tag Name';
        }
        ?>
    </div>
</div>

<?php include $tpl . 'footer.php'; ?>