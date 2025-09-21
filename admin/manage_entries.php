<?php
require_once 'auth_check.php';
require_once '../db.php';
include 'admin_header.php';
?>

<div class="container-fluid">
    <div class="d-sm-flex justify-content-between align-items-center mb-4">
        <h3 class="text-dark mb-0">Manage Entries</h3>
        <a href="add_entry.php" class="btn btn-success btn-sm">Add New Entry</a>
    </div>
    <div class="card shadow">
        <div class="card-header py-3">
            <p class="text-primary m-0 font-weight-bold">All Entries</p>
        </div>
        <div class="card-body">
            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                <table class="table my-0" id="dataTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Year</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Pagination logic
                        $limit = 10; // Entries per page
                        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $offset = ($page - 1) * $limit;

                        // Get total number of entries
                        $total_result = $conn->query("SELECT COUNT(id) AS total FROM entries");
                        $total_entries = $total_result->fetch_assoc()['total'];
                        $total_pages = ceil($total_entries / $limit);

                        // Fetch entries for the current page
                        $sql = "SELECT e.id, e.title, c.name AS category_name, e.year
                                FROM entries e
                                LEFT JOIN categories c ON e.category_id = c.id
                                ORDER BY e.id DESC
                                LIMIT $limit OFFSET $offset";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['title']); ?></td>
                            <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['year']); ?></td>
                            <td>
                                <a href="edit_entry.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="delete_entry.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this entry? This will also delete all associated seasons, episodes, and servers.');">Delete</a>
                            </td>
                        </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='5'>No entries found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-md-6 align-self-center">
                    <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Showing <?php echo $offset + 1; ?> to <?php echo min($offset + $limit, $total_entries); ?> of <?php echo $total_entries; ?></p>
                </div>
                <div class="col-md-6">
                    <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                        <?php
                        function generate_pagination_html($page, $total_pages) {
                            $html = '<ul class="pagination">';

                            // Previous button
                            $prev_class = ($page <= 1) ? 'disabled' : '';
                            $html .= '<li class="page-item ' . $prev_class . '"><a class="page-link" href="?page=' . ($page - 1) . '">Previous</a></li>';

                            // Page numbers logic
                            $window = 2; // Number of links to show around the current page
                            if ($total_pages <= (2 * $window + 5)) {
                                // Show all pages if total is small
                                for ($i = 1; $i <= $total_pages; $i++) {
                                    $active_class = ($i == $page) ? 'active' : '';
                                    $html .= '<li class="page-item ' . $active_class . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                                }
                            } else {
                                // Show first page
                                $html .= '<li class="page-item ' . ($page == 1 ? 'active' : '') . '"><a class="page-link" href="?page=1">1</a></li>';

                                // Ellipsis after first page
                                if ($page > $window + 2) {
                                    $html .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                }

                                // Window of pages
                                $start = max(2, $page - $window);
                                $end = min($total_pages - 1, $page + $window);
                                for ($i = $start; $i <= $end; $i++) {
                                    $active_class = ($i == $page) ? 'active' : '';
                                    $html .= '<li class="page-item ' . $active_class . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                                }

                                // Ellipsis before last page
                                if ($page < $total_pages - $window - 1) {
                                    $html .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                }

                                // Show last page
                                $html .= '<li class="page-item ' . ($page == $total_pages ? 'active' : '') . '"><a class="page-link" href="?page=' . $total_pages . '">' . $total_pages . '</a></li>';
                            }

                            // Next button
                            $next_class = ($page >= $total_pages) ? 'disabled' : '';
                            $html .= '<li class="page-item ' . $next_class . '"><a class="page-link" href="?page=' . ($page + 1) . '">Next</a></li>';

                            $html .= '</ul>';
                            return $html;
                        }

                        if ($total_pages > 1) {
                            echo generate_pagination_html($page, $total_pages);
                        }
                        ?>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$conn->close();
include 'admin_footer.php';
?>
