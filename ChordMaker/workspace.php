<?php
    session_start();

    // Connect to the database server
    $connection = new mysqli("127.0.0.1", "root", "Sm10230420?", "chordmaker");
    if ($connection->connect_error) {
        die("Connectino failed: " . $connection->connect_error);
    }

    if (isset($_POST['title']) && isset($_POST['xml']) && isset($_POST['writers']) && isset($_POST['album'])) {
        // Update infos about the document to the database
        $connection->query("UPDATE " . $_SESSION['username'] . 
                                " SET Title=\"" . $_POST['title'] . "\", XML=\"" . $_POST['xml'] . "\", Songwriters=\"" . $_POST['writers'] . 
                                "\", Album=\"" . $_POST['album'] . "\", LastModified=CAST('" . date("Y-m-d H-i-s") . "' AS DATETIME) 
                                WHERE Title=\"" . $_SESSION['title'] . "\" AND Songwriters=\"" . $_SESSION['writers'] . 
                                "\" AND Album=\"" . $_SESSION['album'] . "\" AND LastModified=\"" . $_SESSION['date'] . "\"") or die($connection->error);
        $_SESSION["title"] = $_POST['title'];
        $_SESSION["writers"] = $_POST['writers'];
        $_SESSION["album"] = $_POST['album'];
        $_SESSION["date"] = date("Y-m-d H-i-s");
    }

    $connection->close();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Workspace</title>
        <link rel="stylesheet" href="workspace.css">
        <link rel="stylesheet" href="workspace_popups.css">
        <link rel="stylesheet" href="workspace_pages.css">
        <link rel="stylesheet" href="workspace_edit.css">
        <link rel="stylesheet" href="workspace_music.css">
        <script src="workspace.js"></script>
        <script src="workspace_popups.js"></script>
        <script src="workspace_pages.js"></script>
        <script src="workspace_edit.js"></script>
        <script src="workspace_music.js"></script>
    </head>
    <body onload="initialize()">

        <div id="popup-file-page-setup" class="popup" style="width: 30%; height: 30%;">
            <p><b>Page setup</b></p>          
            <div style="float: left; width: 60%;">      
                <div id="popup-file-page-setup-orientation">
                    <label class="popup-file-page-setup-label" for="orientation">Orientation</label>
                    <select id="popup-file-page-setup-orientation-input" name="orientation">
                        <option value="Portrait">Portrait</option>
                        <option value="Landscape">Landscape</option>
                    </select>
                </div>
                <div id="popup-file-page-setup-paper-size">
                    <label class="popup-file-page-setup-label" for="paper-size">Paper size</label>
                    <select id="popup-file-page-setup-paper-size-input" name="paper-size">
                        <option value="Letter 8.5 x 11">Letter 8.5 x 11</option>
                    </select>
                </div>
                <div id="popup-file-page-setup-page-color">
                    <label class="popup-file-page-setup-label" for="color">Page color</label>
                    <input id="popup-file-page-setup-page-color-input" class="color-input" type="color" name="color" value="#ffffff">
                </div>
            </div>
            <div id="popup-file-page-setup-margins">
                <p style="margin-top: 0px; margin-bottom: 5px; font-weight: bold;">Margins (inches)</p>
                <label class="popup-file-page-setup-margins-label" for="margin-top">Top</label>
                <input id="popup-file-page-setup-margins-top-input" class="margins-input" type="text" name="margin-top" value="100"><br>
                <label class="popup-file-page-setup-margins-label" for="margin-top">Bottom</label>
                <input id="popup-file-page-setup-margins-bottom-input" class="margins-input" type="text" name="margin-bottom" value="100"><br>
                <label class="popup-file-page-setup-margins-label" for="margin-top">Left</label>
                <input id="popup-file-page-setup-margins-left-input" class="margins-input" type="text" name="margin-left" value="100"><br>
                <label class="popup-file-page-setup-margins-label" for="margin-top">Right</label>
                <input id="popup-file-page-setup-margins-right-input" class="margins-input" type="text" name="margin-right" value="100"><br>
            </div>
            <div id="popup-file-page-setup-buttons">
                <button id="popup-file-page-setup-buttons-default" onclick="popupFilePageSetupDefault()">Change to default</button>
                <button id="popup-file-page-setup-buttons-save" onclick="popupFilePageSetupSave()">Save</button>
                <button id="popup-file-page-setup-buttons-cancel" onclick="popupFilePageSetupCancel()">Cancel</button>
            </div>
        </div>

        <div id="info-container">
            <form id="info-section" action="" method="POST">
<?php
    echo "
                <input id=\"title\" type=\"text\" name=\"title\" class=\"submit-on-enter\" placeholder=\"Title of Music\" value=\"" . $_SESSION['title'] . "\" onkeydown=\"resizeInput(this)\">
                <input id=\"writers\" type=\"text\" name=\"writers\" class=\"submit-on-enter\" placeholder=\"Songwriters\" value=\"" . $_SESSION['writers'] . "\" onkeydown=\"resizeInput(this)\">
                <input id=\"album\" type=\"text\" name=\"album\" class=\"submit-on-enter\" placeholder=\"Album\" value=\"" . $_SESSION['album'] . "\" onkeydown=\"resizeInput(this)\">
                <input id=\"date\" type=\"hidden\" name=\"date\" value=\"" . $_SESSION['date'] . "\" readonly>
                <input id=\"xml\" type=\"hidden\" name=\"xml\" value=\"\">
                <button id=\"submit-button\" type=\"submit\" name=\"submit\"></button>\n";
?>
            </form>
            <div>
                <div class="ui-title" style="width: 15ch;">
                    <button id="file" class="title" onfocus="visualizeActions(this)">File</button>
                    <div id="file-actions" class="ui-actions">
                        <button class="actions" onmouseover="visualizeAdditionalActions(this)">Share</button>
                        <button class="actions" onmouseover="visualizeAdditionalActions(this)">New</button>
                        <button class="actions" onmouseover="visualizeAdditionalActions(this)">Open</button>
                        <button class="actions" onmouseover="visualizeAdditionalActions(this)">Make a copy</button>
                        <button class="actions" onmouseover="visualizeAdditionalActions(this)">Download</button>
                        <button class="actions" onmouseover="visualizeAdditionalActions(this)">Version history</button>
                        <button class="actions" onmouseover="visualizeAdditionalActions(this)">Rename</button>
                        <button class="actions" onmouseover="visualizeAdditionalActions(this)">Move to trash</button>
                        <button class="actions" onmouseover="visualizeAdditionalActions(this)">Document details</button>
                        <button id="file-page-setup" class="actions" onmouseover="visualizeAdditionalActions(this)" onclick="showPopup(this)">Page setup</button>
                        <button class="actions" onmouseover="visualizeAdditionalActions(this)">Print</button>
                    </div>
                </div>
                <div class="ui-title" style="width: 13ch;">
                    <button id="view" class="title" onfocus="visualizeActions(this)">View</button>
                    <div id="view-actions" class="ui-actions">
                        <button class="actions" onmouseover="visualizeAdditionalActions(this)">Fullscreen</button>
                    </div>
                </div>
                <div class="ui-title" style="width: 17ch;">
                    <button id="insert" class="title" onfocus="visualizeActions(this)">Insert</button>
                    <div id="insert-actions" class="ui-actions">
                        <button class="actions" onmouseover="visualizeAdditionalActions(this)">Horizontal line</button>
                        <button id="insert-headers-and-footers" class="actions" onmouseover="visualizeAdditionalActions(this)">Headers & footers<b class="arrow">&gt;</b></button>
                        <div id="div-insert-headers-and-footers" class="actions-of-action" style="width: 7ch;">
                            <button class="actions" onmouseover="visualizeAdditionalActions(this)">Header</button>
                            <button class="actions" onmouseover="visualizeAdditionalActions(this)">Footer</button>
                        </div>
                        <button class="actions" onmouseover="visualizeAdditionalActions(this)">Page numbers</button>
                    </div>
                </div>
                <div class="ui-title" style="width: 17ch;">
                    <button id="format" class="title" onfocus="visualizeActions(this)">Format</button>
                    <div id="format-actions" class="ui-actions">
                        <button class="actions" onmouseover="visualizeAdditionalActions(this)">Text</button>
                        <button class="actions" onmouseover="visualizeAdditionalActions(this)">Paragraph Styles</button>
                        <button class="actions" onmouseover="visualizeAdditionalActions(this)">Align & indent</button>
                        <button class="actions" onmouseover="visualizeAdditionalActions(this)">Line spacing</button>
                        <button class="actions" onmouseover="visualizeAdditionalActions(this)">Columns</button>
                        <button class="actions" onmouseover="visualizeAdditionalActions(this)">Headers & footers</button>
                        <button class="actions" onmouseover="visualizeAdditionalActions(this)">Page numbers</button>
                        <button class="actions" onmouseover="visualizeAdditionalActions(this)">Clear Formatting</button>
                    </div>
                </div>
                <div class="ui-title" style="width: 5ch;">
                    <button id="help" class="title" onfocus="visualizeActions(this)">Help</button>
                    <div id="help-actions" class="ui-actions">
                    </div>
                </div>
            </div>
        </div>
        <div style="position: absolute; width: 100%;">
            <div id="music-table">
            </div>
            <div id="workspace">
                <div id="page-1" class="page">
                    <div class="page-header" tabindex="1" onfocus="recordSelectedElement(this)">
<?php
    echo "
    <p class=\"page-header-title\" tabindex=\"2\" onfocus=\"loadInfos(this)\">" . $_SESSION['title'] . "</p>
    <div class=\"page-header-writers\" tabindex=\"2\" onfocus=\"loadInfos(this)\">
        <label class=\"page-header-labels\" for=\"writers\">Words & Music by </label>
        <input class=\"page-header-values\" name=\"writers\" value=\"" . $_SESSION['writers'] . "\" disabled=\"disabled\">
    </div>
    <div class=\"page-header-infos\" tabindex=\"2\" onfocus=\"loadInfos(this)\">
        <label class=\"page-header-labels\" for=\"key\">Key of </label>
        <input class=\"page-header-values\" name=\"key\" maxlength=\"1\" value=\"C\" disabled=\"disabled\">
        <label class=\"page-header-labels\" for=\"bpm\">| </label>
        <input class=\"page-header-values\" name=\"bpm\" maxlength=\"3\" value=\"100\" disabled=\"disabled\">
        <div style=\"display: inline;\">
            <label class=\"page-header-labels\" for=\"timesignature-numerator\">| </label>
            <input class=\"page-header-values\" name=\"timesignature-numerator\" maxlength=\"2\" value=\"16\" disabled=\"disabled\">
            <label class=\"page-header-labels\" for=\"timesignature-denominator\"> / </label>
            <input class=\"page-header-values\" name=\"timesignature-denominator\" maxlength=\"2\" value=\"16\" disabled=\"disabled\">
        </div>
        <label class=\"page-header-labels\" for=\"version\">| Version: </label>
        <input class=\"page-header-values\" name=\"version\" maxlength=\"40\" value=\"" . $_SESSION['album'] . "\" disabled=\"disabled\">
    </div>\n";
?>
                    </div>
                    <div id="page-content-1" class="page-content" tabindex="1" onfocus="recordSelectedElement(this)">
                    </div>
                    <div class="page-footer" tabindex="1" onfocus="recordSelectedElement(this)">
                    </div>
                </div>
            </div>   
            <div id="editing-table"> 
                <div id="zoom">
                    <button id="zoom-out-button" class="zoom-button" onclick="zoom(-1)">-</button>
                    <div id="zoom-value">75</div>
                    <button id="zoom-in-button" class="zoom-button" onclick="zoom(1)">+</button>
                </div><br><br>
                <div>
                    <label for="font-family" class="editing-table-labels">Font-family</label>
                    <select id="editing-table-font-family" class="editing-table-inputs" name="font-family">
                        <option value="Arial">Arial</option>
                        <option value="Verdana">Verdana</option>
                        <option value="Helvetica">Helvetica</option>
                        <option value="Tahoma">Tahoma</option>
                        <option value="Trebuchet MS">Trebuchet MS</option>
                        <option value="Times New Roman">Times New Roman</option>
                        <option value="Georgia">Georgia</option>
                        <option value="Garamond">Garamond</option>
                        <option value="Courier New">Courier New</option>
                        <option value="Brush Script MT">Brush Script MT</option>
                    </select>
                </div><br><br>
                <div>
                    <label for="font-size" class="editing-table-labels">Font-size</label>
                    <input id="editing-table-font-size" class="editing-table-inputs" name="font-size" value="11">
                </div><br><br>
                <div>
                    <label for="text-bold" class="editing-table-labels">Text-style</label>
                    <button id="editing-table-text-underline" class="editing-table-inputs" name="text-underline"><b><u>U</u></b></button>
                    <button id="editing-table-text-italic" class="editing-table-inputs" name="text-italic"><b><i>I</i></b></button>
                    <button id="editing-table-text-bold" class="editing-table-inputs" name="text-bold"><b>B</b></button>
                </div><br><br>
                <div>
                    <label for="text-color" class="editing-table-labels">Text color</label>
                    <input id="editing-table-text-color" class="editing-table-inputs" type="color" name="text-color">
                </div><br><br>
                <div>
                    <label for="background-color" class="editing-table-labels">Background color</label>
                    <input id="editing-table-background-color" class="editing-table-inputs" type="color" name="background-color">
                </div><br><br>
                <div>
                    <label for="text-alignment" class="editing-table-labels">Text alignment</label>
                    <select id="editing-table-text-alignments" class="editing-table-inputs" name="text-alignment">
                        <option value="Left">Left</option>
                        <option value="Center">Center</option>
                        <option value="Right">Right</option>
                        <option value="Justify">Justify</option>
                    </select>
                </div><br><hr>
                <div>
                    <button id="editing-table-add-page" class="editing-table-add" name="add-page" onclick="addPage()">Add Page</button>
                    <button id="editing-table-delete-page" class="editing-table-delete" name="delete-page">Delete Page</button>
                    <button id="editing-table-add-lyric" class="editing-table-add" name="add-lyric" onclick="addLyric()" disabled>Add Lyric</button>
                    <button id="editing-table-delete-lyric" class="editing-table-delete" name="delete-lyric">Delete Lyric</button>
                </div>
            </div>
        </div>
    </body>
</html>