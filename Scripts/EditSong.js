function openOverlayEditSong(id) {
    document.getElementById("overlay1").style.display = 'block';
    document.getElementById("divBox1").style.top = "200px";

    //Debug only
    console.log(id);
    //Debug only
    document.getElementById("EditSongHiddenInput").value = id;

    document.onkeydown = function (evt) {
        evt = evt || window.event;
        if (evt.keyCode == 27) {
            closeOverlay();
        }
    }
}


function closeOverlayEditSong() {
    document.getElementById("divBox1").style.top = "-300px";
    document.getElementById("overlay1").style.display = 'none';
}