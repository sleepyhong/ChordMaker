<?php
    session_start();

    // Connect to the database server
    $connection = new mysqli("127.0.0.1", "root", "Sm10230420?", "chordmaker");
    if ($connection->connect_error) {
        die("Connectino failed: " . $connection->connect_error);
    }

    // Add a row of new music in the database of the user
    $sql = "INSERT INTO " . $_SESSION['username'] . " (Title, XML, Songwriters, Album, LastModified, Owner) VALUES (
        'New Music', 
        '
<song>
    <setting>
        <pagesetup>
            <orientation>0</orientation>
            <papersize>0</papersize>
            <pagecolor>#ffffff</pagecolor>
            <margins>
                <top>1</top>
                <bottom>1</bottom>
                <left>1</left>
                <right>1</right>
            </margins>
        </pagesetup>
    </setting>
    <header>
        <title fontfamily=\"Arial\" fontsize=\"18\" textstyle=\"000\" textcolor=\"#000000\" backgroundcolor=\"#ffffff\" textalignMent=\"Left\"></title>
        <authors fontfamily=\"Arial\" fontsize=\"12\" textstyle=\"000\" textcolor=\"#000000\" backgroundcolor=\"#ffffff\" textalignMent=\"Left\"></authors>
        <musicinfo fontfamily=\"Arial\" fontsize=\"12\" textstyle=\"000\" textcolor=\"#000000\" backgroundcolor=\"#ffffff\" textalignMent=\"Left\">
            <key>C</key>
            <bpm>60</bpm>
            <timesignature>
                <numerator>4</numerator>
                <denominator>4</denominator>
            </timesignature>
        </musicinfo>
    </header>
    <page number=\"1\">
    </page>
    <footer>
    </footer>
</song>', 
        '', 
        '',
        CAST('" . date("Y-m-d H-i-s") . "' AS DATETIME), 
        '" . $_SESSION['username'] .  "')" or die($connection->error);
    if ($connection->query($sql) == TRUE) {
        header("Location: chorddrive.php");
    }
    else {
        echo "Error: " . $sql . "<br>" . $connection->error;
    }
    $connection->close();    
?>