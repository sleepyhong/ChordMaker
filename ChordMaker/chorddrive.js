function resizeTable() {
    var table = document.getElementById("list");
    if (table != null)
    {
        var length = (window.innerWidth - 240).toString();
        var pixel = "px";
        var result = length.concat(pixel);
        table.style.width = result;
    }
    else
    {
        console.log("List Table Not Found");
    }
}

function assignValue(button) {
    var inputs = button.parentNode.parentNode.parentNode.parentNode.parentNode.childNodes;
    var infos = button.parentNode.parentNode.childNodes;

    inputs[1].value = infos[1].innerHTML;
    inputs[3].value = infos[3].innerHTML;
    inputs[5].value = infos[5].innerHTML;
    inputs[7].value = infos[7].innerHTML;
    localStorage.setItem("xml", infos[9].innerHTML);
}

function openMusic(openButton) {
    document.getElementById("form").action = "openmusic.php";
    assignValue(openButton);
}

function deleteMusic(deleteButton) {
    document.getElementById("form").action = "deletemusic.php";
    assignValue(deleteButton);
}