function initialize() {
    // Initialize the minimum width of the input depending on the length of placeholder for each inputs
    var inputs = document.getElementsByTagName("input");
    for (var index = 0; index < inputs.length; ++index) {
        var text = document.createElement("span");
        document.body.appendChild(text);

        text.style.font = inputs[index].style.font;
        text.style.fontSize = inputs[index].style.fontSize + "px";
        text.style.height = 'auto';
        text.style.width = 'auto';
        text.style.position = 'absolute';
        text.style.whiteSpace = 'no-wrap';
        text.innerHTML = inputs[index].placeholder;

        width = Math.ceil(text.clientWidth);
        var formattedWidth = width + "px";

        inputs[index].style.minWidth = formattedWidth;
        document.body.removeChild(text);

        // Set the width of input as minimum width if there is no default value
        if (inputs[index].value == "") {
            inputs[index].style.width = inputs[index].style.minWidth;
        }
        else {
            resizeInput(inputs[index]);
        }

        // Saves entry info to the database when the user releases an enter on the keyboard
        if (inputs[index].className == "submit-on-enter") {
            inputs[index].addEventListener("keydown", function(event) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                    // Update Xml
                    updateXml();
                }
            });
        }
    }

    // Initialize the height of workspace and editing table
    var height = document.body.offsetHeight - document.getElementById("info-container").offsetHeight;
    var formattedHeight = height + "px";
    document.getElementById("music-table").style.height = formattedHeight;
    document.getElementById("workspace").style.height = formattedHeight;
    document.getElementById("editing-table").style.height = formattedHeight;

    // Initialize the page formats 
    readXml();
    initializePages();
}

function resizeInput(input) {
    // Change the width of the input whenever the value of input is changed (key down)
    var text = document.createElement("span");
    document.body.appendChild(text);

    text.style.font = input.style.font;
    text.style.fontSize = input.style.font + "px";
    text.style.height = 'auto';
    text.style.width = 'auto';
    text.style.position = 'absolute';
    text.style.whiteSpace = 'no-wrap';
    text.innerHTML = input.value;

    width = Math.ceil(text.clientWidth);
    var formattedWidth = width + "px";

    input.style.width = formattedWidth;
    document.body.removeChild(text);
}

function visualizeActions(button) {
    // Make actions visible to that specific title
    var actions = document.getElementById(button.id + "-actions");
    actions.style.display = "inline";
    
    // Hide other actions from other title
    var actionTitles = document.getElementsByClassName("title");
    for (var index = 0; index < actionTitles.length; ++index) {
        if (actionTitles[index].tagName == "BUTTON" && actionTitles[index].id != button.id) {
            actionTitles[index].parentNode.getElementsByTagName("div")[0].style.display = "none";
        }
    }
}
function hideActions(button) {
    // Make actions invisible to that specific title
    var index = button.id.indexOf("-");
    if (index == -1) {
        console.log("No \"-\" found in id (hideActions()): " + button.id);
    }
    else {
        var id = button.id.substr(0, index + 1) + "actions";
        document.getElementById(id).style.display = "none";
    }
}

function visualizeAdditionalActions(button) {
    var currentActions = button.parentNode.childNodes;

    // Make the specific addtional actions to be visible while the mouse is hovering the button
    var div = document.getElementById("div-" + button.id);
    if (div != null) {
        div.style.display = "inline";
        
        // Move it to the right relative to its position
        div.style.left = button.offsetWidth + "px";
        
        var count = 0;
        for (var index = 0; index < currentActions.length; ++index) {
            if (currentActions[index].tagName == "BUTTON") {
                if (currentActions[index].id != button.id) {
                    count++;
                }
                else {
                    break;
                }
            }
        }
        div.style.top = count * button.offsetHeight + "px";
    }

    // Make the rest of the other additional actions to be invisible if there is one
    for (var index = 0; index < currentActions.length; ++index) {
        if (currentActions[index].tagName == "DIV" && currentActions[index].id != ("div-" + button.id)) {
            currentActions[index].style.display = "none";
        }
    }
}

function readXml() {
    // Read infos from xml contents
    var xmlText = localStorage.getItem("xml");
    var parser = new DOMParser();
    var xmlDoc = parser.parseFromString(xmlText, "text/xml");

    // Read from settings $ Initialize page settings
    var pageSetups = xmlDoc.getElementsByTagName("pagesetup")[0];
    // orientation
    document.getElementById("popup-file-page-setup-orientation-input").selectedIndex = pageSetups.getElementsByTagName("orientation")[0].firstChild.nodeValue;
    // paper size
    document.getElementById("popup-file-page-setup-paper-size-input").selectedIndex = pageSetups.getElementsByTagName("papersize")[0].firstChild.nodeValue;
    // page color
    document.getElementById("popup-file-page-setup-page-color-input").value = pageSetups.getElementsByTagName("pagecolor")[0].firstChild.nodeValue;
    // margins
    var margins = pageSetups.getElementsByTagName("margins")[0];
    document.getElementById("popup-file-page-setup-margins-top-input").value = margins.getElementsByTagName("top")[0].firstChild.nodeValue;
    document.getElementById("popup-file-page-setup-margins-bottom-input").value = margins.getElementsByTagName("bottom")[0].firstChild.nodeValue;
    document.getElementById("popup-file-page-setup-margins-left-input").value = margins.getElementsByTagName("left")[0].firstChild.nodeValue;
    document.getElementById("popup-file-page-setup-margins-right-input").value = margins.getElementsByTagName("right")[0].firstChild.nodeValue;

    // Initialize info section
    var pages = document.getElementsByClassName("page");
    for (var index = 0; index < pages.length; ++index) {
        var infos = pages[index].getElementsByClassName("page-header-values");
        infos[1].value = xmlDoc.getElementsByTagName("key")[0].firstChild.nodeValue;
        infos[2].value = xmlDoc.getElementsByTagName("bpm")[0].firstChild.nodeValue;
        infos[3].value = xmlDoc.getElementsByTagName("numerator")[0].firstChild.nodeValue;
        infos[4].value = xmlDoc.getElementsByTagName("denominator")[0].firstChild.nodeValue;
    }

    // Initizlize font/text attributes
    var header = xmlDoc.getElementsByTagName("header")[0];
    for (var index = 0; index < 3; ++index) {
        var headerTargets;
        var node;
        if (index == 0) {
            headerTargets = document.getElementsByClassName("page-header-title");
            node = header.getElementsByTagName("title")[0];
        }
        else if (index == 1) {
            headerTargets = document.getElementsByClassName("page-header-writers");
            node = header.getElementsByTagName("authors")[0];
        }
        else if (index == 2) {
            headerTargets = document.getElementsByClassName("page-header-infos");
            node = header.getElementsByTagName("musicinfo")[0];
        }

        for (var count = 0; count < headerTargets.length; ++count) {
            // font family
            headerTargets[count].style.fontFamily = node.getAttribute('fontfamily');
            // font size
            headerTargets[count].style.fontSize = node.getAttribute('fontsize') + "px";
            // textStyle
            var textStyle = node.getAttribute('textstyle');
            if (textStyle.charAt(0) == '1') {
                headerTargets[count].style.fontWeight = "bold";
            }
            if (textStyle.charAt(1) == '1') {
                headerTargets[count].style.fontStyle = "italic";
            }
            if (textStyle.charAt(2) == '1') {
                headerTargets[count].style.textDecoration = "underline";
            }
            // text color
            headerTargets[count].style.color = node.getAttribute('textcolor');
            // background color
            headerTargets[count].style.backgroundColor = node.getAttribute('backgroundcolor');
            // textalignment
            var textAlignment = node.getAttribute('textalignment');
            headerTargets[count].style.textAlignment = textAlignment;
        }
    }
}

function updateXml() {
    var modifiedXml = localStorage.getItem("xml");
    for (var index = 0; index < modifiedXml.length; ++index) {
        if (modifiedXml.charAt(index) == '"') {
            modifiedXml = modifiedXml.substring(0, index) + "\\" + modifiedXml.substring(index);
            index++;
        }
    }
    document.getElementById("xml").value = modifiedXml;
    document.getElementById("submit-button").click();
}

function recordSelectedElement(element) {
    // Save class name if the element does not have an id
    if (element.id == "") {
        localStorage.setItem("selectedElement", element.className);
    }
    else {
        localStorage.setItem("selectedElement", element.id);
    }

    // Disable add-lyric button depending on the selected element (non page-content element)
    var addLyricButton = document.getElementById("editing-table-add-lyric");
    addLyricButton.disabled = (localStorage.getItem("selectedElement").indexOf("page-content") == -1);

    console.log(localStorage.getItem("selectedElement"));
}