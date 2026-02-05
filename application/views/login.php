<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header"><h4>Login</h4></div>
                <div class="card-body">
                    <form id="loginForm">
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" id="email">
                            <span class="text-danger" id="err_email"></span>
                        </div>
                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" id="password">
                            <span class="text-danger" id="err_password"></span>
                        </div>
                        <button type="submit" class="btn btn-primary">Login</button>
                        <a href="<?= base_url('auth/register') ?>" class="btn btn-link">Register</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function validateEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

$('#loginForm').submit(function(e) {
    e.preventDefault();
    $('.text-danger').text('');
    
    const email = $('#email').val().trim();
    const password = $('#password').val();
    
    let valid = true;
    
    if (!email || !validateEmail(email)) {
        $('#err_email').text('Valid email required');
        valid = false;
    }
    if (!password) {
        $('#err_password').text('Password required');
        valid = false;
    }
    
    if (!valid) return;
    
    $.post('<?= base_url('auth/do_login') ?>', $(this).serialize(), function(res) {
        const data = JSON.parse(res);
        if (data.success) {
            window.location.href = data.redirect;
        } else {
            if (data.errors) {
                $.each(data.errors, function(key, val) {
                    $('#err_' + key).text(val);
                });
            } else {
                alert(data.message);
            }
        }
    });
});
</script>
</body>
</html>
