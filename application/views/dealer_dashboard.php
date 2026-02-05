<!DOCTYPE html>
<html>
<head>
    <title>Dealer Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand">Dealer Dashboard</span>
        <a href="<?= base_url('auth/logout') ?>" class="btn btn-light btn-sm">Logout</a>
    </div>
</nav>
<div class="container mt-5">
    <div class="alert alert-success">
        <h4>Welcome, Dealer!</h4>
        <p>You are successfully logged in.</p>
    </div>
</div>
</body>
</html>
