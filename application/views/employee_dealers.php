<!DOCTYPE html>
<html>
<head>
    <title>Dealers List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand">Employee Dashboard</span>
        <a href="<?= base_url('auth/logout') ?>" class="btn btn-light btn-sm">Logout</a>
    </div>
</nav>
<div class="container mt-4">
    <h3>Dealers List</h3>
    <div class="row mb-3">
        <div class="col-md-4">
            <input type="text" class="form-control" id="zipSearch" placeholder="Search by Zip Code">
        </div>
        <div class="col-md-4">
            <button class="btn btn-primary" onclick="searchDealers()">Search</button>
            <button class="btn btn-secondary" onclick="resetSearch()">Reset</button>
        </div>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>City</th>
                <th>State</th>
                <th>Zip Code</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="dealersTable"></tbody>
    </table>
    <nav>
        <ul class="pagination" id="pagination"></ul>
    </nav>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function loadDealers(page = 1, zip = '') {
    $.get('<?= base_url('employee/get_dealers') ?>', {page: page, zip_code: zip}, function(res) {
        const data = JSON.parse(res);
        if (data.success) {
            let html = '';
            data.dealers.forEach(d => {
                html += `<tr>
                    <td>${d.first_name} ${d.last_name}</td>
                    <td>${d.email}</td>
                    <td>${d.city || '-'}</td>
                    <td>${d.state || '-'}</td>
                    <td>${d.zip_code || '-'}</td>
                    <td><a href="<?= base_url('dealer/edit/') ?>${d.id}" class="btn btn-sm btn-primary">Edit</a></td>
                </tr>`;
            });
            $('#dealersTable').html(html || '<tr><td colspan="6" class="text-center">No dealers found</td></tr>');
            
            let pag = '';
            for (let i = 1; i <= data.totalPages; i++) {
                pag += `<li class="page-item ${i == data.page ? 'active' : ''}">
                    <a class="page-link" href="#" onclick="loadDealers(${i}, $('#zipSearch').val()); return false;">${i}</a>
                </li>`;
            }
            $('#pagination').html(pag);
        }
    });
}

function searchDealers() {
    loadDealers(1, $('#zipSearch').val());
}

function resetSearch() {
    $('#zipSearch').val('');
    loadDealers(1);
}

$(document).ready(function() {
    loadDealers();
});
</script>
</body>
</html>
