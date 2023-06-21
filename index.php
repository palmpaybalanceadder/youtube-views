<!DOCTYPE html>
<html>
<head>
    <title>YouTube Video Player</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A YouTube video player that allows you to play multiple videos simultaneously. Developed by Harshitethic">
    <meta property="og:image" content="screenshot.png">
    <script src="https://www.youtube.com/player_api"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .header {
            background-color: #f00;
            padding: 20px;
            text-align: center;
            color: #fff;
        }

        h1 {
            margin: 0;
        }

        .container {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            width: 400px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
            padding: 20px;
        }

        form {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        input[type="submit"] {
            padding: 10px;
            margin: 5px;
        }

        .play-button {
            padding: 10px 20px;
            background-color: #f00;
            color: #fff;
            border: none;
            cursor: pointer;
            font-weight: bold;
            border-radius: 4px;
        }

        .play-button:hover {
            background-color: #555;
        }

        #player {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .player-card {
            width: 250px;
            height: 150px;
            margin: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            border-radius: 4px;
            overflow: hidden;
        }

        .player-card iframe {
            width: 100%;
            height: 100%;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #333;
            color: #fff;
            font-size: 14px;
        }

        .dark-mode {
            background-color: #f00;
            color: #fff;
        }

        .dark-mode input[type="text"],
        .dark-mode input[type="number"],
        .dark-mode input[type="submit"] {
            background-color: #222;
            color: #fff;
            border: none;
        }

        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>YouTube Video Player</h1>
    </div>

    <div class="container">
        <div id="card-container">
            <div class="card">
                <form method="post" id="play-form">
                    <label for="youtube_url">YouTube URL:</label>
                    <br>
                    <input type="text" name="youtube_url" id="youtube_url" required>
                    <br><br>
                    <label for="play_count">Number of Plays:</label>
                    <br>
                    <input type="number" name="play_count" id="play_count" min="1" required>
                    <br><br>
                    <label for="loop_count">Number of Loops:</label>
                    <br>
                    <input type="number" name="loop_count" id="loop_count" min="1" required>
                    <br><br>
                    <input type="submit" value="Play" class="play-button">
                </form>
            </div>
        </div>
    </div>

    <div id="player"></div>

    <footer class="dark-mode">
        Developed by <a href="https://harshitethic.in" target="_blank" style="color: inherit;">harshitethic.in</a>
    </footer>

    <script>
var videoUrl = "";
var playCount = 0;
var loopCount = 0;
var videoId = "";
var players = []; // Store all player objects
var loopCounters = []; // Store loop counters for each player

function extractVideoId(url) {
  var videoId = "";
  var match = url.match(/[?&]v=([^&#]+)/);
  if (match) {
    videoId = match[1];
  } else {
    var match = url.match(/\/([^\/?&]+)/);
    if (match) {
      videoId = match[1];
    }
  }
  return videoId;
}

function createVideoPlayer() {
  var playerDiv = document.createElement("div");
  playerDiv.setAttribute("class", "player-card");
  document.getElementById("player").appendChild(playerDiv);

  var playerElementId = "player-" + Math.floor(Math.random() * 1000000); // Generate a unique player element ID
  playerDiv.setAttribute("id", playerElementId);

  var loopCounter = 0; // Initialize the loop counter

  var player = new YT.Player(playerElementId, {
    videoId: videoId,
    playerVars: {
      autoplay: 1,
      controls: 0,
      mute: 1
    },
    events: {
      onReady: function() {
        player.playVideo();
      },
      onStateChange: function(event) {
        if (event.data === YT.PlayerState.ENDED) {
          loopCounter++;
          if (loopCounter < loopCount) {
            player.playVideo();
          }
        }
      }
    }
  });

  players.push(player); // Add player to the array
  loopCounters.push(loopCounter); // Add loop counter to the array
}

function onYouTubeIframeAPIReady() {
  var playForm = document.getElementById("play-form");
  var cardContainer = document.getElementById("card-container");

  playForm.addEventListener("submit", function(e) {
    e.preventDefault();

    videoUrl = document.getElementById("youtube_url").value;
    playCount = parseInt(document.getElementById("play_count").value);
    loopCount = parseInt(document.getElementById("loop_count").value);
    videoId = extractVideoId(videoUrl);

    if (videoUrl && playCount > 0) {
      for (var i = 0; i < playCount; i++) {
        createVideoPlayer();
      }

      cardContainer.classList.add("hidden");
    }
  });
}
    </script>
</body>
</html>
