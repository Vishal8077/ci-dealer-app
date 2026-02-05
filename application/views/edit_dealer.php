<!DOCTYPE html>
<html>
<head>
    <title>Edit Dealer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand">Edit Dealer</span>
        <a href="<?= base_url('auth/logout') ?>" class="btn btn-light btn-sm">Logout</a>
    </div>
</nav>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><h4>Edit Dealer Information</h4></div>
                <div class="card-body">
                    <form id="editForm">
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
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="javascript:history.back()" class="btn btn-secondary">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
const dealerId = <?= $dealer_id ?>;

$(document).ready(function() {
    $.get('<?= base_url('dealer/get_dealer/') ?>' + dealerId, function(res) {
        const data = JSON.parse(res);
        if (data.success && data.dealer) {
            $('#city').val(data.dealer.city);
            $('#state').val(data.dealer.state);
            $('#zip_code').val(data.dealer.zip_code);
        }
    });
});

$('#editForm').submit(function(e) {
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
    
    $.post('<?= base_url('dealer/update/') ?>' + dealerId, $(this).serialize(), function(res) {
        const data = JSON.parse(res);
        if (data.success) {
            alert(data.message);
            history.back();
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
