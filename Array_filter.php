
<?php

function Arraybased_Filter($input) {
    // SQL Syntax keywords and characters
    $sqlSyntax = array("SELECT", "INSERT", "UPDATE", "DELETE", "DROP", "OR", "CREATE", "ALTER", ";", "--", "<", ">", "'");
    
    // Check for SQL Syntax key/char
    foreach ($sqlSyntax as $keyword) {
        if (stripos($input, $keyword) !== false) {
            return true; 
        }
    }
    return false; 
}

   

?>






