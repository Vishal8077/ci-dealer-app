<!DOCTYPE html>
<html>
<head>
    <title>Complete Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><h4>Complete Your Profile</h4></div>
                <div class="card-body">
                    <form id="profileForm">
                        <div class="mb-3">
                            <label>City</label>
                            <input type="text" class="form-control" name="city" id="city">
                            <span class="text-danger" id="err_city"></span>
                        </div>
                        <div class="mb-3">
                            <label>State</label>
                            <input type="text" class="form-control" name="state" id="state">
                            <span class="text-danger" id="err_state"></span>
                        </div>
                        <div class="mb-3">
                            <label>Zip Code</label>
                            <input type="text" class="form-control" name="zip_code" id="zip_code">
                            <span class="text-danger" id="err_zip_code"></span>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$('#profileForm').submit(function(e) {
    e.preventDefault();
    $('.text-danger').text('');
    
    const city = $('#city').val().trim();
    const state = $('#state').val().trim();
    const zipCode = $('#zip_code').val().trim();
    
    let valid = true;
    
    if (!city) {
        $('#err_city').text('City required');
        valid = false;
    }
    if (!state) {
        $('#err_state').text('State required');
        valid = false;
    }
    if (!zipCode || !/^\d{5,10}$/.test(zipCode)) {
        $('#err_zip_code').text('Valid zip code required (5-10 digits)');
        valid = false;
    }
    
    if (!valid) return;
    
    $.post('<?= base_url('dealer/update_profile') ?>', $(this).serialize(), function(res) {
        const data = JSON.parse(res);
        if (data.success) {
            alert(data.message);
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
