
<?php
    require_once 'process.php';

    $informations = $connect->query("SELECT * FROM informations ORDER BY id DESC") or die($connect->error);

//    $information = $informations->fetch_assoc();
//
//    echo '<pre>';
//    print_r($information);
//    die();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.6">
    <title>Simple Crud</title>

    <!-- Bootstrap core CSS -->
    <link href="https://getbootstrap.com/docs/4.4/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .container {
            max-width: 960px;
        }
    </style>
</head>
<body class="bg-light">
<div class="container">
    <div class="text-center mt-3">
        <h2>Table</h2>
    </div>

    <div class="row">

        <?php if (isset($_SESSION['message'])) :?>
        <div class="alert alert-<?= $_SESSION['type']; ?>">
            <?php
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            ?>
        </div>
        <?php endif; ?>

        <table class="table table-bordered text-center">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Location</th>
                <th scope="col">Image</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php $row = 1; ?>
            <?php while ($information = $informations->fetch_assoc()) : ?>
            <tr>
                <th scope="row"><?php echo $row++; ?></th>
                <td><?php echo $information['name']; ?></td>
                <td><?php echo $information['location']; ?></td>
                <td>
                    <img src="<?php echo $information['image']; ?>" alt="" style="height: 80px; width: 80px;">
                </td>
                <td>
                    <a href="index.php?edit=<?php echo $information['id']; ?>" class="btn btn-primary">Edit</a>
                    <a href="process.php?delete=<?php echo $information['id']; ?>" class="btn btn-danger">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <hr class="my-5">
    <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6">
            <h4 class="mb-3">Information</h4>
            <form action="process.php" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name">First name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>" placeholder="Enter your name" required>
                        <div class="invalid-feedback">
                            Valid name is required.
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="location">Location</label>
                        <input type="text" class="form-control" id="location" name="location" value="<?php echo $location; ?>" placeholder="Your location" required>
                        <div class="invalid-feedback">
                            Valid location is required.
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="image">Image</label>
                        <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
<!--                        <div class="invalid-feedback">-->
<!--                            Valid location is required.-->
<!--                        </div>-->
                    </div>
                </div>
                <hr class="mb-4">
                <a href="index.php" class="btn btn-dark">Back</a>
                <?php if ($update == true): ?>
                    <button class="btn btn-info float-right" type="submit" name="update">Update</button>
                <?php else: ?>
                    <button class="btn btn-primary float-right" type="submit" name="save">Save</button>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://getbootstrap.com/docs/4.4/dist/js/bootstrap.bundle.min.js"></script>
<script>

    (function() {
        'use strict'
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation')
            // Loop over them and prevent submission
            Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        }, false)
    }())

</script>
</body>
</html>
