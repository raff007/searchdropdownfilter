<?php
// Include your database connection file
include 'db_connection.php';

// Initialize variables to hold the category and search term
$selectedCategory = "";
$searchKeywords = ""; // Use the correct variable name

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the selected category and search term from the form
    $selectedCategory = $_POST['category'];
    $searchKeywords = $_POST['search_keywords']; // Use the correct name
}

    // Prepare the SQL query with placeholders for category and multi-keyword search
    $sql = "SELECT a.*, d.nama_departement
            FROM asset a
            LEFT JOIN tbldepartments d ON a.id_departement = d.id_departement
            WHERE a.id_category = :id_category";

    // Check if a search term is provided
    if (!empty($searchKeywords)) {
        $sql .= " AND (a.nama_asset LIKE :searchTerm OR a.used_by LIKE :searchTerm OR d.nama_departement LIKE :searchTerm)";
    }

    // Prepare the SQL query
    $stmt = $db->prepare($sql);

    // Bind the category parameter
    $stmt->bindParam(':id_category', $selectedCategory);

    // Bind the search term parameter if applicable
    if (!empty($searchKeywords)) {
        $searchPattern = "%{$searchKeywords}%";
        $stmt->bindValue(":searchTerm", $searchPattern, PDO::PARAM_STR);
    }

    // Execute the query
    $stmt->execute();

    // Fetch the results
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Display the results
    $totalAssetsByDepartment = array(); // Initialize an array to store total assets per department

    foreach ($results as $result) {
        // Output the data as needed
        echo "Asset Name: " . $result['nama_asset'] . "<br>";
        echo "Kode asset: " . $result['code_asset'] . "<br>";
        echo "Department: " . $result['nama_departement'] . "<br>"; // Display department name
        // Add more fields as needed
        echo "<hr>";

        // Increment the total assets for the department
        $departmentName = $result['nama_departement'];
        if (!isset($totalAssetsByDepartment[$departmentName])) {
            $totalAssetsByDepartment[$departmentName] = 1;
        } else {
            $totalAssetsByDepartment[$departmentName]++;
        }
    }

    // Display the total number of assets for each department
    foreach ($totalAssetsByDepartment as $department => $totalAssets) {
        echo "$department: " . $totalAssets . "<br>";
    }

    // Display the total number of assets for all departments
    $overallTotalAssets = count($results);
    echo "Overall Total Assets: " . $overallTotalAssets;


?>
