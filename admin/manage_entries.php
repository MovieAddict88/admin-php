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
                        <ul class="pagination">
                            <li class="page-item <?php if($page <= 1){ echo 'disabled'; } ?>">
                                <a class="page-link" href="<?php if($page <= 1){ echo '#'; } else { echo "?page=".($page - 1); } ?>" aria-label="Previous"><span aria-hidden="true">«</span></a>
                            </li>
                            <?php for($i = 1; $i <= $total_pages; $i++ ): ?>
                            <li class="page-item <?php if($page == $i) {echo 'active'; } ?>">
                                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                            <?php endfor; ?>
                            <li class="page-item <?php if($page >= $total_pages) { echo 'disabled'; } ?>">
                                <a class="page-link" href="<?php if($page >= $total_pages){ echo '#'; } else {echo "?page=".($page + 1); } ?>" aria-label="Next"><span aria-hidden="true">»</span></a>
                            </li>
                        </ul>
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
