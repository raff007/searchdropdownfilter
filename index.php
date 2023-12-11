<?php
// Include your database connection file
include 'db_connection.php';

    // Modify the query to fetch category IDs and names
    $stmt = $db->query("SELECT DISTINCT a.id_category, c.category_name
                         FROM asset a
                         JOIN category c ON a.id_category = c.id_category");

    // Check if categories are fetched successfully
    if ($stmt) {
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // Handle the error or set $categories to an empty array
        $categories = array();
    }

?>

<!-- Modify the dropdown options to use category names -->
<form action="search.php" method="post">
    <label for="category">Select Category:</label>
    <select name="category" id="category">
        <?php
        // Generate dropdown options dynamically using category names
        foreach ($categories as $category) {
            echo "<option value=\"{$category['id_category']}\">{$category['category_name']}</option>";
        }
        ?>
    </select>
    <input type="text" placeholder="Enter Keywords" name="search_keywords">
    <button type="submit">Search</button>
</form>
