function openOverlayEditSong(id, title, artist, album,  cover, filelocation) {
    document.getElementById("overlay1").style.display = 'block';
    document.getElementById("divBox1").style.top = "200px";

    //Debug only
    console.log(id);
    console.log(title);
    console.log(cover);
    console.log(filelocation);
    //Debug only

    document.getElementById("EditSongTitle").value = title;
    document.getElementById("EditSongArtist").value = artist;
    document.getElementById("EditSongAlbum").value = album;
    document.getElementById("EditSongHiddenInputID").value = id;
    document.getElementById("EditSongHiddenInputCover").value = cover;
    document.getElementById("EditSongHiddenInputFileLocation").value = filelocation;

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