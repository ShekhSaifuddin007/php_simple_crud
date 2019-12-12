<?php

    session_start();

    $connect = new mysqli('localhost', 'root', '', 'basic_crud') or die(mysqli_errno($connect));

    $id = '';
    $update = false;
    $name = '';
    $location = '';

    if (isset($_POST['save'])) {
        $image =  $_FILES['image'];
        $name = $_POST['name'];
        $location = $_POST['location'];

        if (is_uploaded_file($_FILES['image']['tmp_name'])) {
            $ext = explode('.', $image['name']);
            $imageTmpName = $image['tmp_name'];
            $imageName = $_REQUEST['name'].'_'.time().'.'.strtolower(end($ext));
            $imageDir = 'image/';
            move_uploaded_file($imageTmpName, $imageDir.$imageName);
            $imageUrl = $imageDir.$imageName;
            $connect->query("INSERT INTO informations(name, location, image) VALUES ('$name', '$location', '$imageUrl')") or die($connect->error);
        } else {
            $connect->query("INSERT INTO informations(name, location) VALUES ('$name', '$location')") or die($connect->error);
        }

        $_SESSION['message']= 'Record has been saved successfully..';
        $_SESSION['type']= 'success';

        header('Location:index.php');
    }

    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $image =  $_FILES['image'];
        $name = $_POST['name'];
        $location = $_POST['location'];
        $result = $connect->query("SELECT * FROM informations WHERE id = $id") or die($connect->error);
        $selectImg = $result->fetch_assoc();

        if (is_uploaded_file($_FILES['image']['tmp_name'])) {
            if (file_exists($selectImg['image'])) {
                unlink($selectImg['image']);
            }
            $ext = explode('.', $image['name']);
            $imageTmpName = $image['tmp_name'];
            $imageName = $_REQUEST['name'].'_'.time().'.'.strtolower(end($ext));
            $imageDir = 'image/';
            move_uploaded_file($imageTmpName, $imageDir.$imageName);
            $imageUrl = $imageDir.$imageName;

            $connect->query("UPDATE informations SET name = '$name', location = '$location', image = '$imageUrl' WHERE id = '$id'") or die($connect->error);
        } else {
            $connect->query("UPDATE informations SET name = '$name', location = '$location' WHERE id = '$id'") or die($connect->error);
        }

        $_SESSION['message']= 'Record has been updated successfully..';
        $_SESSION['type']= 'info';

        header('Location:index.php');
    }

    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];

        $result = $connect->query("SELECT * FROM informations WHERE id = $id") or die($connect->error);
        $selectImg = $result->fetch_assoc();

        if (file_exists($selectImg['image'])) {
            unlink($selectImg['image']);
        }

        $connect->query("DELETE FROM informations WHERE id = $id") or die($connect->error);

        $_SESSION['message']= 'Record has been deleted successfully..';
        $_SESSION['type']= 'danger';

        header('Location:index.php');
    }

    if (isset($_GET['edit'])) {
        $id = $_GET['edit'];
        $update = true;
        $result = $connect->query("SELECT * FROM informations WHERE id = $id") or die($connect->error);

        if ($result) {
            $info = $result->fetch_assoc();

            $name = $info['name'];
            $location = $info['location'];
        }
    }
