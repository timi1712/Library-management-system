<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>404 Error Page</title>
  <meta content="Error Page" name="description">
  <meta content="404 Error" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/errors/error-favicon.png" rel="icon">
  <link href="assets/img/errors/error-favicon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" 
		integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- custom css -->
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/style.css">

</head>

<body>
	<div class="d-flex align-items-center justify-content-center vh-100 section-notfound">
		<div class="text-center">
			<p class="fs-3">
				<img src="<?= ROOT ?>/assets/images/404.png" class="img-fluid" alt="image">
			</p>
			<h1 class="display-1 fw-bold">404</h1>
			<p class="fs-3"> <span class="text-danger">Oops!</span> Page not found</p>
			<p class="lead">
				The page you are looking for doesn’t exist.
			</p>
			<a href="<?= ROOT ?>" class="btn btn-success">Go To Home Page</a>
		</div>
	</div>
</body>

</html>