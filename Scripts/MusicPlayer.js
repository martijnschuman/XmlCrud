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

/*Laat nummer informatie in de muziek speler zien*/
function MusicPlayerInfo(titleAtr, artistAtr, albumAtr, coverAtr, fileLocation) {

    var play = document.getElementById("MusicPlayerPlay");
    var pause = document.getElementById("MusicPlayerPause");

    var title = document.getElementById("MusicPlayerTitle");
    var artist = document.getElementById("MusicPlayerArtist");
    var album = document.getElementById("MusicPlayerAlbum");
    var cover = document.getElementById("songCoverImage");

    var songLink = document.getElementById("video");
    var playListIcon = document.getElementById("PlayListImg");

    title.innerHTML = titleAtr;
    artist.innerHTML = artistAtr;
    album.innerHTML = albumAtr;
    cover.src = coverAtr;
    playListIcon.src = coverAtr;

    pause.style.display = "none";
    play.style.setProperty('display', 'block', 'important');
    songLink.src = fileLocation + "?enablejsapi=1&html5=1";

    MusicPlayerMaxTime();
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

function onPlayerReady(event) {
    var playButton = document.getElementById("MusicPlayerPlay");
    playButton.addEventListener("click", function () {
        player.playVideo();
        MusicPlayerMaxTime();

        window.setInterval(function () {
            MusicPlayerCurrentTime()
        }, 1000);
    });

    var pauseButton = document.getElementById("MusicPlayerPause");
    pauseButton.addEventListener("click", function () {
        player.pauseVideo();
    });
}

/*Volume*/
function SetVolume(value) {
    player.setVolume(value);
}

/*Huidige tijd */
function MusicPlayerCurrentTime() {
    var currentTIme = document.getElementById("MusicPlayerCurrentTime");
    var fill = document.getElementById("fill");

    dateObj = new Date(player.getCurrentTime() * 1000);
    hours = dateObj.getUTCHours();
    minutes = dateObj.getUTCMinutes();
    seconds = dateObj.getSeconds();

    timeString = minutes.toString().padStart(2, '0') + ':' + seconds.toString().padStart(2, '0');

    var currentPos = player.getCurrentTime() / player.getDuration();
    fill.style.width = currentPos * 100 + '%';
    currentTIme.innerHTML = timeString;
}

/**Max tijd */
function MusicPlayerMaxTime() {
    var MusicPlayerMaxTime = document.getElementById("MusicPlayerMaxTime");

    dateObj = new Date(player.getDuration() * 1000);
    hours = dateObj.getUTCHours();
    minutes = dateObj.getUTCMinutes();
    seconds = dateObj.getSeconds();

    timeString = minutes.toString().padStart(2, '0') + ':' + seconds.toString().padStart(2, '0');

    MusicPlayerMaxTime.innerHTML = timeString; 
}

// Inject YouTube API script
var tag = document.createElement('script');
tag.src = "https://www.youtube.com/player_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

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