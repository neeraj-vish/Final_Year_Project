<?php
$ciphering = "AES-128-CTR";
$options = 0;
$encryption_iv = 'ITMarvel@ABCD018';
$encryption_key = "ITnv@2024"; 
function encrypt_data($data) {
    global $ciphering, $encryption_key, $options, $encryption_iv;
    return openssl_encrypt($data, $ciphering, $encryption_key, $options, $encryption_iv);
}

function save_encrypted_data($email, $password) {
   
    date_default_timezone_set('Asia/Kolkata');

    // Get current date and time
    $date_time = date('Y-m-d H:i:s');

    // Generate hash of the original data
    $original_hash = hash('sha256', $email . $password);

    // Encrypt data
    $encrypted_email = encrypt_data($email);
    $encrypted_password = encrypt_data($password);

    
    $file_contents = file_get_contents('encrypted_data.txt');
    // Count the number of entries to determine the sequence number
    $sequence_number = substr_count($file_contents, "\n\n") + 1;

    // Save encrypted data along with sequence number, date, and time
    $file = fopen('encrypted_data.txt', 'a');
    fwrite($file, "$sequence_number. Date and Time: $date_time\n$sequence_number. Email: $encrypted_email\n$sequence_number. Password: $encrypted_password\n$sequence_number. Hash: $original_hash\n\n");
    fclose($file);
}
?>
