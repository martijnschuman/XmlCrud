function ShowMusicPlayer(titleAtr, artistAtr, albumAtr, coverAtr, fileLocationAtr) {

    var title = document.getElementById("MusicPlayerTitle");
    var artist = document.getElementById("MusicPlayerArtist");
    var album = document.getElementById("MusicPlayerAlbum");
    var cover = document.getElementById("songCoverImage");
    //var fileLocation = document.getElementById("MusicPlayerfileLocation");

    title.innerHTML = titleAtr;
    artist.innerHTML = artistAtr;
    album.innerHTML = albumAtr;
    cover.src = coverAtr;
    //fileLocation.innerHTML = fileLocationAtr;
}

/*Volume*/
function SetVolume(val) {
    var player = document.getElementById('video');
    console.log('Before: ' + player.volume);
    player.volume = val / 100;
    console.log('After: ' + player.volume);
}