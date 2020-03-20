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
function MusicPlayerInfo(titleAtr, artistAtr, albumAtr, coverAtr, fileLocation) {

    var title = document.getElementById("MusicPlayerTitle");
    var artist = document.getElementById("MusicPlayerArtist");
    var album = document.getElementById("MusicPlayerAlbum");
    var cover = document.getElementById("songCoverImage");

    var songLink = document.getElementById("video");

    title.innerHTML = titleAtr;
    artist.innerHTML = artistAtr;
    album.innerHTML = albumAtr;
    cover.src = coverAtr;

    songLink.src = fileLocation + "?enablejsapi=1&html5=1";


}

/*Veranderd play-pauze knop*/
function MusicPlayerPlay(action) {
    var play = document.getElementById("MusicPlayerPlay");
    var pause = document.getElementById("MusicPlayerPause");

    if (action == "play") {
        play.style.display = "none";
        pause.style.setProperty('display', 'block', 'important');
    } else if (action == "pause") {
        pause.style.display = "none";
        play.style.setProperty('display', 'block', 'important');
    }
}

// global variable for the player
var player;

// this function gets called when API is ready to use
function onYouTubePlayerAPIReady() {
    // create the global player from the specific iframe (#video)
    player = new YT.Player('video', {
        events: {
            // call this function when player is ready to use
            'onReady': onPlayerReady
        }
    });
}

function onPlayerReady(event) {

    // bind events
    var playButton = document.getElementById("MusicPlayerPlay");
    playButton.addEventListener("click", function () {
        player.playVideo();
    });

    var pauseButton = document.getElementById("MusicPlayerPause");
    pauseButton.addEventListener("click", function () {
        player.pauseVideo();
    });
}

// Inject YouTube API script
var tag = document.createElement('script');
tag.src = "https://www.youtube.com/player_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

/*Volume*/
function SetVolume(val) {
    player.volume = val / 100;
}