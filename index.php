<?php 
include("config.php");

$name = "";
$age = "";
$msg = "";
if (isset($_POST["submit"])) {
    $name = $_POST["name"];
    $age = $_POST["age"];
    $recaptchaResponse = $_POST["g-recaptcha-response"];
    $userIp = $_SERVER["REMOTE_ADDR"];

    $request = "https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$recaptchaResponse}&remoteip={$userIp}";
    $content = file_get_contents($request);
    $json = json_decode($content);
    if ($json->success == "true") {
        $msg = "Hi {$name}, You are {$age} years old!";
    } else {
        $msg = "You have failed to pass recaptcha. What does this means? ROBOT!";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css">
    <!-- Google Recaptcha -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <title>Implement Google Recaptcha</title>
</head>
<body class="bg-light py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-5 mx-auto">
                <div class="card border shadow-sm bg-white p-3">
                    <div class="card-body">
                        <h3 class="card-title mb-3">Google Recaptcha</h3>
                        <p><?php echo $msg; ?></p>
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label for="name" class="form-label">Enter your name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="e.g. John Doe" value="<?php echo $name; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="age" class="form-label">Enter your age</label>
                                <input type="number" class="form-control" id="age" name="age" placeholder="e.g. 20" value="<?php echo $age; ?>" required>
                            </div>
                            <div class="g-recaptcha mb-3" data-sitekey="<?php echo $siteKey; ?>"></div>
                            <button class="btn btn-primary" name="submit" type="submit">Submit Form</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>    

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>