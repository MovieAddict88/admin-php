<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="sidebar-header">
                <h3>Admin Panel</h3>
            </div>
            <ul class="list-unstyled components">
                <p>CineCraze</p>
                <li class="active">
                    <a href="dashboard.php">Dashboard</a>
                </li>
                <li>
                    <a href="manage_entries.php">Manage Entries</a>
                </li>
                <li>
                    <a href="manage_categories.php">Manage Categories</a>
                </li>
                <li>
                    <a href="bulk_import_tmdb.php">Bulk Import</a>
                </li>
            </ul>
            <ul class="list-unstyled CTAs">
                <li><a href="logout.php" class="logout btn-danger">Logout</a></li>
            </ul>
        </nav>
        <!-- Page Content -->
        <div class="content">
            <div class="overlay"></div>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </nav>
