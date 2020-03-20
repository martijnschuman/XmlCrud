function openOverlay(id) {
    document.getElementById("overlay").style.display = 'block';
    document.getElementById("divBox").style.top = "200px";

    console.log(id);
    document.getElementById("DeleteSongHiddenInput").value = id;

    document.onkeydown = function (evt) {
        evt = evt || window.event;
        if (evt.keyCode == 27) {
            closeOverlay();
        }
    }
}

function closeOverlay() {
    document.getElementById("divBox").style.top = "-300px";
    document.getElementById("overlay").style.display = 'none';
}