<?php
$ciphering = "AES-128-CTR";
$options = 0;
$encryption_iv = 'ITMarvel@ABCD018';
$encryption_key = "ITnv@2024"; 

function decrypt_data($data) {
    global $ciphering, $encryption_key, $options, $encryption_iv;
    return openssl_decrypt($data, $ciphering, $encryption_key, $options, $encryption_iv);
}

function verify_and_decrypt_data() {
    // Read the encrypted data
    $file_contents = file_get_contents('encrypted_data.txt');
    $entries = explode("\n\n", trim($file_contents));

    foreach ($entries as $entry) {
        $lines = explode("\n", $entry);

        if (count($lines) < 4) {
            continue;
        }

        $sequence_number_line = explode(". ", $lines[0]);
        $date_time_line = explode(": ", $lines[0]);
        $encrypted_email_line = explode(": ", $lines[1]);
        $encrypted_password_line = explode(": ", $lines[2]);
        $original_hash_line = explode(": ", $lines[3]);

        if (count($sequence_number_line) < 2 || count($date_time_line) < 2 || count($encrypted_email_line) < 2 || count($encrypted_password_line) < 2 || count($original_hash_line) < 2) {
            // If any line does not split correctly, skip this entry
            continue;
        }

        $sequence_number = $sequence_number_line[0];
        $date_time = $date_time_line[1];
        $encrypted_email = $encrypted_email_line[1];
        $encrypted_password = $encrypted_password_line[1];
        $original_hash = $original_hash_line[1];

        // Decrypt the data
        $decrypted_email = decrypt_data($encrypted_email);
        $decrypted_password = decrypt_data($encrypted_password);

        // Generate hash of the decrypted data
        $decrypted_hash = hash('sha256', $decrypted_email . $decrypted_password);

        // Verify data integrity
        $integrity_status = $original_hash === $decrypted_hash ? 'Integrity Verified' : 'Data Corrupted';

        // Save decrypted data along with sequence number, date, and time
        $file = fopen('decrypted_data.txt', 'a');
        fwrite($file, "$sequence_number. Date and Time: $date_time\n$sequence_number. Email: $decrypted_email\n$sequence_number. Password: $decrypted_password\n$sequence_number. Integrity Status: $integrity_status\n\n");
        fclose($file);
    }
}

verify_and_decrypt_data();
?>






