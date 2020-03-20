/*Opent muziek speler*/
function MusicPlayerOpen() {
    document.getElementById("MusicPlayer").style.display = "block";
    document.getElementById("MusicPlayerOpen").style.setProperty('display', 'none', 'important');
}

/*Sluit muziek speker*/
function MusicPlayerClose() {
    document.getElementById("MusicPlayer").style.display = "none";
    document.getElementById("MusicPlayerOpen").style.setProperty('display', 'block', 'important');
}

/*Laat nummer informatie in de muziek speler zien*/
function MusicPlayerInfo(titleAtr, artistAtr, albumAtr, coverAtr) {

    var title = document.getElementById("MusicPlayerTitle");
    var artist = document.getElementById("MusicPlayerArtist");
    var album = document.getElementById("MusicPlayerAlbum");
    var cover = document.getElementById("songCoverImage");
    title.innerHTML = titleAtr;
    artist.innerHTML = artistAtr;
    album.innerHTML = albumAtr;
    cover.src = coverAtr;
}

/*Volume*/
function SetVolume(val) {
    var player = document.getElementById('audio');
    player.volume = val / 100;
}

/*Veranderd play-pauze knop*/
function MusicPlayerPlayPause() {
    var play = document.getElementById("MusicPlayerPlay");

    if (play.className == "fa fa-play PlayMusicButton") {
        play.className = "fa fa-pause PlayMusicButton";
        play.style.marginRight = "17px";
    }
    else if (play.className == "fa fa-pause PlayMusicButton") {
        play.className = "fa fa-play PlayMusicButton";
        play.style.marginRight = "20px";
    }
}

/*Volgend nummer */
function MusicPlayerPrevSong() {
    console.log("Vorig nummer");
}

/*Vorig nummer */
function MusicPlayerNextSong() {
    console.log("Volgend nummer");
}