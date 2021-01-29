<?php
    session_start();

    // Connect to the database server
    $connection = new mysqli("127.0.0.1", "root", "Sm10230420?", "chordmaker");
    if ($connection->connect_error) {
        die("Connectino failed: " . $connection->connect_error);
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Chord Drive</title>
        <link rel="stylesheet" href="chorddrive.css">
        <script src="chorddrive.js"></script>
    </head>
    <body onload="resizeTable()" onresize="resizeTable()">
        <table id="menu">
            <tr>
                <th>
                    <form action="createmusic.php" method="POST">
                        <button type="submit">+ New Music</button>
                    </form>
                </th>
            </tr>
            <tr>
                <th>Chord Drive</th>
            </tr>
            <tr>
                <th>Shared Musics</th>
            </tr>
            <tr>
                <th>Trash</th>
            </tr>
        </table>
        <form id="form" action="workspace.php" method="POST">
            <input type="hidden" name="title">
            <input type="hidden" name="writers">
            <input type="hidden" name="album">
            <input type="hidden" name="date">
            <table id="list">
                <tr>
                    <th>Name</th>
                    <th>Songwriters</th>
                    <th>Album</th>
                    <th>Last Modified</th>  
                    <th></th>  
                </tr>
<?php
    // Selects all musics from the specific user database
    $result = $connection->query("SELECT * FROM " . $_SESSION['username']) or die($connection->error);
    if ($result->num_rows > 0)
    {    
        while ($row = $result->fetch_assoc())
        {
            $title = $row["Title"];
            $xml = $row["XML"];
            $writers = $row["Songwriters"];
            $album = $row["Album"];
            $date = $row["LastModified"];
            echo "
                <tr class=\"music\">
                    <td class=\"name\">$title</td>
                    <td class=\"songwriters\">$writers</td>
                    <td class=\"album\">$album</td>
                    <td class=\"date\">$date</td>
                    <td style=\"display: none;\">$xml</td>
                    <td class=\"deleteButton\">
                        <button type=\"submit\" onclick=\"openMusic(this)\">open</button>
                        <button type=\"submit\" onclick=\"deleteMusic(this)\">delete</button>
                    </td>
                </tr>\n";
        }
        echo "
            </table>
        </form>\n";
    }

    $connection->close();
?>
    </body>
</html>