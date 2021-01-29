function zoom(number) {
    var percentage = document.getElementById("zoom-value");
    percentage.innerHTML = parseInt(percentage.innerHTML, 10) + number;
    if (percentage.innerHTML > 100) {
        percentage.innerHTML = 100;
    }
    if (percentage.innerHTML < 10) {
        percentage.innerHTML = 10;
    }    
    resizePapers();
}

function loadInfos(element) {
    // Record element
    recordSelectedElement(element);

    // Font Family
    var fontFamilies = document.getElementById("editing-table-font-family").options;
    for (var index = 0; index < fontFamilies.length; ++index) {
        if(fontFamilies[index].value == element.style.fontFamily) {
            fontFamilies.selectedIndex = index;
            break;
        }
    }

    // Font Size
    var fontSize = document.getElementById("editing-table-font-size");
    fontSize.value = element.style.fontSize.substring(0, element.style.fontSize.length - 2);

    // Text style
    var bold = document.getElementById("editing-table-text-bold");
    var italic = document.getElementById("editing-table-text-italic");
    var underline = document.getElementById("editing-table-text-underline");

    if (element.style.fontWeight == "bold") {
        bold.style.backgroundColor = "#cccccc";
    }
    else {
        bold.style.backgroundColor = "#ffffff";
    }
    if (element.style.fontStyle == "italic") {
        italic.style.backgroundColor = "#cccccc";
    }
    else {
        italic.style.backgroundColor = "#ffffff";
    }
    if (element.style.textDecoration == "underline") {
        underline.style.backgroundColor = "#cccccc";
    }
    else {
        underline.style.backgroundColor = "#ffffff";
    }

    // Text color
    var textColor = document.getElementById("editing-table-text-color");
    textColor.value = strToHex(element.style.color);

    // Background color
    var backgroundColor = document.getElementById("editing-table-background-color");
    backgroundColor.value = strToHex(element.style.backgroundColor);
    
    // Text alignment
    var textAlignments = document.getElementById("editing-table-text-alignments");
    for (var index = 0; index < textAlignments.length; ++index) {
        if (textAlignments[index].value == element.style.textAlignment) {
            textAlignments.selectedIndex = index;
            break;
        }
    }
}

function strToHex(rgb) {
    var result = "#";
    var firstComma = rgb.indexOf(",");
    var secondComma = rgb.indexOf(",", firstComma + 1);
    var red = parseInt(rgb.substring(4, firstComma));
    var green = parseInt(rgb.substring(firstComma + 2, secondComma));
    var blue = parseInt(rgb.substring(secondComma + 2, rgb.length - 1));
    if (red < 16) {
        result += "0" + red.toString(16);
    }
    else {
        result += red.toString(16);
    }
    if (green < 16) {
        result += "0" + green.toString(16);
    }
    else {
        result += green.toString(16);
    }
    if (blue < 16) {
        result += "0" + blue.toString(16);
    }
    else {
        result += blue.toString(16);
    }    
    return result;
}

function addPage() {

}

function addLyric() {
    // Create a new lyric section
    var newDiv = document.createElement("div");
    // div attributes
    newDiv.className = "page-content-lyric";
    newDiv.tabIndex = "2";
    // div css
    newDiv.style.borderStyle = "solid";
    newDiv.style.borderWidth = "1px";
    newDiv.style.borderColor = "transparent";
    newDiv.style.fontFamily = "Arial";
    newDiv.style.fontSize = "12px";
    newDiv.style.color = "#000000";
    newDiv.style.backgroundColor = "#ffffff";
    newDiv.style.textAlignment = "left";

    var newLyricType = document.createElement("p");
    newLyricType.innerHTML = "Lyric Type";
    newLyricType.contentEditable = "true";
    var newLyric = document.createElement("p");
    newLyric.innerHTML = "Lyric";
    newLyric.contentEditable = "true";
    newDiv.appendChild(newLyricType);
    newDiv.appendChild(newLyric);

    var page = document.getElementById(localStorage.getItem("selectedElement"));
    newDiv.onfocus = loadInfos(newDiv);
    page.appendChild(newDiv);
}