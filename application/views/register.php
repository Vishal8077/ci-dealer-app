<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><h4>Registration</h4></div>
                <div class="card-body">
                    <form id="registerForm">
                        <div class="mb-3">
                            <label>First Name</label>
                            <input type="text" class="form-control" name="first_name" id="first_name">
                            <span class="text-danger" id="err_first_name"></span>
                        </div>
                        <div class="mb-3">
                            <label>Last Name</label>
                            <input type="text" class="form-control" name="last_name" id="last_name">
                            <span class="text-danger" id="err_last_name"></span>
                        </div>
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
                        <div class="mb-3">
                            <label>User Type</label>
                            <select class="form-control" name="user_type" id="user_type">
                                <option value="">Select</option>
                                <option value="employee">Employee</option>
                                <option value="dealer">Dealer</option>
                            </select>
                            <span class="text-danger" id="err_user_type"></span>
                        </div>
                        <button type="submit" class="btn btn-primary">Register</button>
                        <a href="<?= base_url('auth/login') ?>" class="btn btn-link">Login</a>
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

$('#email').blur(function() {
    const email = $(this).val();
    if (email && validateEmail(email)) {
        $.post('<?= base_url('auth/check_email') ?>', {email: email}, function(res) {
            const data = JSON.parse(res);
            $('#err_email').text(data.exists ? 'Email already exists!' : '');
        });
    }
});

$('#registerForm').submit(function(e) {
    e.preventDefault();
    $('.text-danger').text('');
    
    const firstName = $('#first_name').val().trim();
    const lastName = $('#last_name').val().trim();
    const email = $('#email').val().trim();
    const password = $('#password').val();
    const userType = $('#user_type').val();
    
    let valid = true;
    
    if (!firstName || firstName.length < 2) {
        $('#err_first_name').text('First name required (min 2 chars)');
        valid = false;
    }
    if (!lastName || lastName.length < 2) {
        $('#err_last_name').text('Last name required (min 2 chars)');
        valid = false;
    }
    if (!email || !validateEmail(email)) {
        $('#err_email').text('Valid email required');
        valid = false;
    }
    if (!password || password.length < 6) {
        $('#err_password').text('Password required (min 6 chars)');
        valid = false;
    }
    if (!userType) {
        $('#err_user_type').text('User type required');
        valid = false;
    }
    
    if (!valid) return;
    
    $.post('<?= base_url('auth/do_register') ?>', $(this).serialize(), function(res) {
        const data = JSON.parse(res);
        if (data.success) {
            alert(data.message);
            window.location.href = '<?= base_url('auth/login') ?>';
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
