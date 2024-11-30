<?php
require_once 'config.php';

// Read log file contents
$log_file = 'Leave_Application.log'; // Path to your log file

// Check if the log file exists
if (file_exists($log_file)) {
    // Attempt to read the log file
    $log_contents = file_get_contents($log_file);
    if ($log_contents === false) {
        // Error reading the log file
        echo "Error reading the log file.";
    } else {
        // Log file contents successfully retrieved
        // Display the log contents
        $log_entries = explode("\n\n", $log_contents);
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Log Viewer</title>
            <style>
                /* General styles */
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 0;
                    background-color: #f4f4f4;
                }
                .container {
                    max-width: 800px;
                    margin: 20px auto;
                    padding: 20px;
                    background-color: #fff;
                    border-radius: 5px;
                    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                }
                h1 {
                    text-align: center;
                    color: #333;
                }
                .log-entry {
                    margin-bottom: 20px;
                    padding: 10px;
                    border: 1px solid #ddd;
                    border-radius: 5px;
                    background-color: #f9f9f9;
                    position: relative;
                }
                .delete-button {
                    position: absolute;
                    top: 10px;
                    right: 10px;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>Log Viewer</h1>
                <?php foreach ($log_entries as $index => $entry): ?>
                    <?php if (!empty($entry)): ?>
                        <div class="log-entry">
                            <pre><?php echo $entry; ?></pre>
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="delete-form">
                                <input type="hidden" name="delete_entry" value="<?php echo $index; ?>">
                                <button type="submit" class="delete-button">Delete</button>
                            </form>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </body>
        </html>
        <?php
    }
} else {
    // Log file not found
    echo "Log file not found.";
}

// Check if a delete request is submitted
if (isset($_POST['delete_entry'])) {
    $entry_to_delete = $_POST['delete_entry'];
    $log_contents = file_get_contents($log_file);
    $log_entries = explode("\n\n", $log_contents);
    if (isset($log_entries[$entry_to_delete])) {
        unset($log_entries[$entry_to_delete]);
        file_put_contents($log_file, implode("\n\n", $log_entries));
        echo "<script>alert('Entry deleted successfully.');</script>";
        // Refresh the page after deletion
        header("Refresh:0");
    } else {
        echo "<script>alert('Error deleting the entry.');</script>";
    }
}
?>
