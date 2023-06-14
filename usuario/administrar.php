<?php include "../templates/header.php"; ?>
<?php
if(!isset($_SESSION['user_id'])){
    header('Location: index.php');
    exit;
} else {
    // Show users the page! 
}

?>

<?php include "../templates/footer.php"; ?>