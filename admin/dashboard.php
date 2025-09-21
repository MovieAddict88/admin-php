<?php
require_once 'auth_check.php';
require_once '../db.php';
include 'admin_header.php';

// Fetch counts for dashboard
$entries_count = $conn->query("SELECT COUNT(id) as count FROM entries")->fetch_assoc()['count'];
$categories_count = $conn->query("SELECT COUNT(id) as count FROM categories")->fetch_assoc()['count'];

?>

<div class="container-fluid">
    <div class="d-sm-flex justify-content-between align-items-center mb-4">
        <h3 class="text-dark mb-0">Dashboard</h3>
    </div>
    <div class="row">
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card shadow border-left-primary py-2">
                <div class="card-body">
                    <div class="row align-items-center no-gutters">
                        <div class="col mr-2">
                            <div class="text-uppercase text-primary font-weight-bold text-xs mb-1"><span>Entries</span></div>
                            <div class="text-dark font-weight-bold h5 mb-0"><span><?php echo $entries_count; ?></span></div>
                        </div>
                        <div class="col-auto"><i class="fas fa-film fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card shadow border-left-success py-2">
                <div class="card-body">
                    <div class="row align-items-center no-gutters">
                        <div class="col mr-2">
                            <div class="text-uppercase text-success font-weight-bold text-xs mb-1"><span>Categories</span></div>
                            <div class="text-dark font-weight-bold h5 mb-0"><span><?php echo $categories_count; ?></span></div>
                        </div>
                        <div class="col-auto"><i class="fas fa-tags fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="text-primary font-weight-bold m-0">Welcome to the Admin Panel</h6>
                </div>
                <div class="card-body">
                    <p class="m-0">This is the central hub for managing your CineCraze website. From here, you can add, edit, and delete entries and categories. Use the sidebar to navigate through the different management pages.</p>
                    <p class="m-0 mt-3">For more advanced tasks, such as bulk importing from TMDB, use the corresponding links in the sidebar.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$conn->close();
include 'admin_footer.php';
?>
