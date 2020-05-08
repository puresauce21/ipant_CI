<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<!DOCTYPE html>
<html lang='en' class=''>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<title>ipant</title>
<link rel="icon" href="<?php echo base_url('assets_frontend/images/favicon.png');?>" type="image/x-icon"> <!-- Favicon-->
 

  <script src='//production-assets.codepen.io/assets/editor/live/console_runner-079c09a0e3b9ff743e39ee2d5637b9216b3545af0de366d4b9aad9dc87e26bfd.js'></script><script src='//production-assets.codepen.io/assets/editor/live/events_runner-73716630c22bbc8cff4bd0f07b135f00a0bdc5d14629260c3ec49e5606f98fdd.js'></script><script src='//production-assets.codepen.io/assets/editor/live/css_live_reload_init-2c0dc5167d60a5af3ee189d570b1835129687ea2a61bee3513dee3a50c115a77.js'></script><meta charset='UTF-8'><meta name="robots" content="noindex">

<!--   <link rel="shortcut icon" type="image/x-icon" href="//production-assets.codepen.io/assets/favicon/favicon-8ea04875e70c4b0bb41da869e81236e54394d63638a1ef12fa558a4a835f1164.ico" />

  <link rel="mask-icon" type="" href="//production-assets.codepen.io/assets/favicon/logo-pin-f2d2b6d2c61838f7e76325261b7195c27224080bc099486ddd6dccb469b8e8e6.svg" color="#111" />
  <link rel="canonical" href="https://codepen.io/ikabot/pen/XgozPE?limit=all&page=9&q=coming+soon" /> -->


<style class="cp-pen-styles">* {
    border: 0;
    margin: 0;
    padding: 0;
}

html {
    font-family: -apple-system, BlinkMacSystemFont,
    "Segoe UI", "Roboto", "Oxygen",
    "Ubuntu", "Cantarell", "Fira Sans",
    "Droid Sans", "Helvetica Neue", sans-serif;
    font-size: 62.5%; /* 1rem vaut 10px */
}

body {
    font-size: 1.4rem; /* 1.4 rem vaut 14px */
    height: 100%;
}

.wrapper {
  display: flex;
  background-image: url('https://cdn.allwallpaper.in/wallpapers/2400x1350/926/fog-forests-landscapes-trees-2400x1350-wallpaper.jpg');
  background-size: cover;
  color: rgb(245,245,245);
  flex-direction: column;
  min-height: 100vh;
}

.main-content {
  display: flex;
  flex: 1;
}

.counterDown {
  margin: auto;
}

.counterDown h1 {
  font-size: 4rem;
}

hr {
  background-color: rgba(255,255,255, 0.8);
}

#demo {
  display: flex;
  flex-direction: row;
  font-size: 1.6rem;
}

#jours {
  font-family: "Roboto Mono", sans-serif;
  font-size: 4rem;
  height: 10rem;
  margin-right: 1rem;
  width: 8rem;
}

#heures {
  font-family: "Roboto Mono", sans-serif;
  font-size: 4rem;
  height: 10rem;
  margin-right: 1rem;
  width: 8rem;
}

#minutes {
  font-family: "Roboto Mono", sans-serif;
  font-size: 4rem;
  height: 10rem;
  margin-right: 1rem;
  width: 8rem;
}

#secondes {
  font-family: "Roboto Mono", sans-serif;
  font-size: 4rem;
  height: 10rem;
  margin: auto;
  width: 8rem;
}

#infos {
  color: rgba(126,85,39,1);
  display: flex;
  flex-direction: row;
  font-size: 1.6rem;
}

.infos-jours {
  font-family: "Roboto Mono", sans-serif;
  margin-right: 1rem;
  margin-top: -3rem;
  width: 8rem;
}

.infos-heures {
  font-family: "Roboto Mono", sans-serif;
  margin-right: 1rem;
  margin-top: -3rem;
  width: 8rem;
}

.infos-minutes {
  font-family: "Roboto Mono", sans-serif;
  margin-right: 1rem;
  margin-top: -3rem;
  width: 8rem;
}

.infos-secondes {
  font-family: "Roboto Mono", sans-serif;
  margin: auto;
  margin-top: -3rem;
  width: 8rem;
}

/* Footer */
footer {
  border-top: 1px solid rgba(255,255,255, 0.5);
  font-size: 1.3rem;
  padding-top: 0.6rem;
  margin-left: auto;
  margin-right: auto;
  width: 80%;
}</style></head><body>
<!-- BootStrap -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Roboto|Roboto+Mono" rel="stylesheet">

<body>
  <div class="wrapper">
    <!-- Content -->
    <div class="main-content">
      <div class="counterDown text-center">
        <h1>COMING SOON</h1>
        <hr>
         <p id="demo" style="font-size:30px;margin-left: 40px;"></p>
        <!-- <div id="demo">
          <div id="jours" class="text-center"></div>
          <div id="heures" class="text-center"></div>
          <div id="minutes" class="text-center"></div>
          <div id="secondes" class="text-center"></div>
        </div> -->
        <!-- <div id="infos">
         <div class="infos-jours">Jours</div>
            <div class="infos-heures">Heures</div> 
            <div class="infos-minutes">Minutes</div>
            <div class="infos-secondes">Secondes</div> 
        </div> -->
      </div>
    </div>
    
    <!-- Footer -->
    <footer class="text-center">
      <p>  © 2019, Developed by ipant </p>
    </footer>
  </div>
  
  <!-- JavaScript -->
  <script type="text/javascript">
 // Set the date we're counting down to
var countDownDate = new Date("april 1, 2019 15:37:25").getTime();

// Update the count down every 1 second
var countdownfunction = setInterval(function() {

  // Get todays date and time
  var now = new Date().getTime();
  
  // Find the distance between now an the count down date
  var distance = countDownDate - now;
  
  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
  
  // Output the result in an element with id="demo"
  document.getElementById("demo").innerHTML = days + "d " + hours + "h "
  + minutes + "m " + seconds + "s ";
  
  // If the count down is over, write some text 
  if (distance < 0) {
    clearInterval(countdownfunction);
    document.getElementById("demo").innerHTML = "EXPIRED";
  }
}, 1000);
  </script>
  
  <script type="text/javascript">
    var date = new Date();
    var annee = date.getFullYear();

    document.getElementById('annee').innerHTML = annee;
  </script>
  
</body>

</body></html>