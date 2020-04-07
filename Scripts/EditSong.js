function openOverlayEdit(id) {
    document.getElementById("overlay1").style.display = 'block';
    document.getElementById("divBox1").style.top = "200px";

    console.log(id);
    document.getElementById("EditSongHiddenInput").value = id;

    document.onkeydown = function (evt) {
        evt = evt || window.event;
        if (evt.keyCode == 27) {
            closeOverlay();
        }
    }
}



function closeOverlayEdit() {
    document.getElementById("divBox1").style.top = "-300px";
    document.getElementById("overlay1").style.display = 'none';
}