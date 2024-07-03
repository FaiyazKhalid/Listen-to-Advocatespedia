<!DOCTYPE html>
<html lang="en" >
<style>
    * {
    margin: 0;
}
body {
    margin: 0;
    font: 1em sans-serif;
}
circle {
    fill-opacity: .5;
}
h1 {
    padding: 0.2em 0 0.2em 0.5em;
    margin: 0;
    color: #1c2733;
}
p {
    line-height: 1.5em;
    margin-bottom: .5em;
}
a {
    color: #306596;
}
a:hover {
    color: #cc4731;
}
label {
    margin-left: .5em;
}

#area {
    overflow: hidden;
}
#header {
    background: #f8f8f8;
    margin: 0;
}
#rc-log-c {
    margin: 0.5em;
    line-height: 1.5em;
    font-size: .8em;
    border: 1px solid #2f6fab;
}
#rc-log-c h3 {
    padding: .5em;
    margin: 0;
    background: #fff;
    border-bottom: 1px solid #d8e6ec;
    font-size: 2em;
}
#rc-log {
    list-style-type: none;
    height: 400px;
    overflow: hidden;
}
.note {
    margin: 0;
    padding: .5em;
    background: rgb(248, 248, 248);
    border-top: 1px solid #d8e6ec;
    font-size: .8em;
    color: #ccc;
    padding-bottom: 1px;
}
#edit_counter {
    font-size: 1.5em;
    color: #000;
}
#edit_counter span {
    color: #cc4731;
}
#content {
    margin: 1em auto 4em auto;
    max-width: 960px;
    position: relative;
}
.foot {
    margin: 0 auto 4em auto;
    max-width: 960px;
    position: relative;
    padding: 0 .5em 0 .5em;
}
.foot h3 {
    padding-top: 1em;
    margin-bottom: 1em;
    border-bottom: 1px solid #eee;
}
.conStatus {
    color: #bdc3c7;
}
.bg {
    padding: 3px;
    background: #fff;
    border-radius: 3px;
    margin: 1em;
}
.article-label {
    font: 1.0em sans-serif;
    text-shadow:1px 1px 0 rgb(28, 39, 51),
    -1px -1px 0 rgb(28, 39, 51),
    1px -1px 0 rgb(28, 39, 51),
    -1px 1px 0 rgb(28, 39, 51),
    0px 1px 0 rgb(28, 39, 51),
    1px 0px 0 rgb(28, 39, 51),
    0px -1px 0 rgb(28, 39, 51),
    -1px 0px 0 rgb(28, 39, 51);
    }
.newuser-label {
    font: 1em sans-serif;
    opacity: 1;
}
.about-link {
    float: right;
    font-weight: normal;
    font-style: normal;
    font-size: 1em;
    padding-right: 2em;
    padding-top: 1em;
}
.lang {
    color: #bdc3c7;
    padding: auto .5em;
}
.log-bot {
    color: rgb(155, 89, 182);
}
.log-anon {
    color: rgb(46, 204, 113);
}
.log-undo {
    color: rgb(236, 112, 99)
}
.loc {
    border-bottom: 1px dashed #ccc;
}

#lang-boxes p {
    float: left;
    width: 20em;
    font-size: .9em;
}

.clear br {
    clear: left;
}

#loading {
    position:absolute;
    top:3em;
    left:0;
    right:0;
    margin-left:auto;
    margin-right:auto;
    padding: 0;
    font-size: 4em;
    color: #fff;
    background-color: rgba(189, 195, 199, 0.6);
}
.unmute {
    color: #cc4732;
}

#loading p, {
    text-align: center;
    margin: 0.5em;
}

.small {
    margin-top: 3em;
    font-size: 0.8em;
}


/* volume stuff */
#volumeWrapper {
  width: 70px;
	margin: 2em;
}

#volumeControl {
	cursor: pointer;
	opacity: 0.5;
}

#volumeControl:hover {
	opacity: 1;
}

#volumeSlider {
  width: 70px;
  display: inline-block;
  background-color: rgba(192,192,192,0.4);
}

#volumeSlider div {
  display: inline-block;
}
</style>
</head>
<body>
    <div id='header'>
      <span class="about-link">
        <span id="volumeWrapper" class="interface">
          <span id="volumeSlider" class="noUiSlider"></span>
        </span><a id="about-link" href="">about</a> </span>
      <h1>Listen to Advocatespedia</h1>
    </div>
    <canvas id="canvas"></canvas>
    <div id='content'>
        <div class='bg'>
            <div id='rc-log-c'>
                <h3>Recent changes</h3>
                
                <ul id='count'>
                </ul>
                 <div class="note">
                 
                </div>
            </div>
        </div>
    </div>
<body>
<!-- partial:index.partial.html -->

<!-- partial -->


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Press+Start+2P" rel="stylesheet">
<script language="javascript" type="text/javascript">
    
</script>


<!-- id="jsid" --->

<script type="text/javascript" >
      (function() {
    "use strict";

    // Canvas things
    var canvas = document.getElementById('canvas'),
        ctx = canvas.getContext('2d'),
        canvasWidth = canvas.width = window.innerWidth,
        canvasHeight = canvas.height = window.innerHeight;

          

var timeout = setInterval(checkUpdate, 1000);    
function checkUpdate()
{
    $.post("back.php", function(data, status)
    {
       if (data.toString()=="true")
       {
          playRandomSound();
  // Click to add new bubble
   for (var i = 0; i < maxCount; i++) {
        new Bubble();
    }

       }
    });


function playRandomSound()
{
  var pattern = [],
    tone;
  pattern.push(Math.floor(Math.random() * 58));
  tone = "#sound" + pattern[0];
  //$(tone).trigger('play');  //uncomment to play
  //$(tone).get(0).play();    //uncomment to play
  $(tone)[0].play();          //comment to turn off
}
    audio.play();
    
} 




    // Mouse things
    var mouseX,
        mouseY,
        pop = false,
        attract = false;

    // Check if mouse event is over a bubble
    var mouseOver = function(x, y, radius) {
        var diffX = mouseX - x;
        var diffY = mouseY - y;

        if (diffX < radius && diffX > (radius * -1) && diffY < radius && diffY > (radius * -1)) {
            return true;
        }

        return false;
    }

    // Used for randomizing everything
    var randomNum = function (min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    };

    // Used for changing settings with a random number
    var changeSettings = function(setting, min, max, prob) {
        var chance = randomNum(0, prob);

        if(setting < min || chance === 1) {
            return 1;
        } else if (setting > max || chance === 2) {
            return -1;
        } else {
            return 0;
        }
    };

    // Bubble config
    var bubbles = [], // Holds all the bubbles as objects
        count = 0, // Bubble count
        maxCount = 1, // Max bubbles to render on start
        maxSize = 100,
        minSize = 5,
        minSpeed = 5,
        maxSpeed = 10,
        text='hello',
        bgcolor = 'hsl(235,60%,13%)', //  hsl(0, 100%, 1%) Canvas bg
        colors = [ // Color palette
            { color1 : '#fa4c2b', color2 : '#6aff6e'},
            { color1 : '#ffff82', color2 : '#ffce72'},
            { color1 : '#fa4c2b', color2 : '#0bfcff'}
        ];

    // Bubble constructor
    var Bubble = function(x, y, size) {
        this.id = count+1;
        this.x = x || randomNum(0, canvasWidth);
        this.y =  y || randomNum(0, canvasHeight);
        this.radius = size || randomNum(minSize, maxSize);
        this.color = colors[randomNum(0,colors.length-1)];
        this.text='hello',
        this.speed = randomNum(minSpeed, maxSpeed)/10;
        this.speedBackup = this.speed;
        this.directionX = randomNum(-1,1) || 1;
        this.directionY = randomNum(-1,1) || 1;
        this.flicker = 0;

        count++; // Number bubbles
        bubbles[count] = this; // Add to main object
    };
  
    // When popping a bubble
    Bubble.prototype.destroy = function() {
        // Generate number of smaller bubbles based on radius
        var popCount = this.radius/10 > 0 ? this.radius/10 : 2;

        // Generate smaller bubbles, size based on radius
        for(var i = 0; i < popCount; i++) {
            new Bubble(this.x, this.y, randomNum(this.radius/4,this.radius/2));
        }
        
        // Make popped bubble smaller and change color
        this.radius = randomNum(this.radius/4,this.radius/2);
        this.color = colors[randomNum(0,colors.length-1)];
    };

    // Bubble drawing animation
    Bubble.prototype.draw = function() {

        // Reset speed
        this.speed = this.speedBackup;

        // If mouse is held down & bubble is within 200px of mouse
        if (attract === true && mouseOver(this.x,this.y,200)) {
            var moveTowardMouse = randomNum(0,15); // Chance of being attracted by mouse
            if(moveTowardMouse === 5){
                this.directionX = mouseX - this.x > 0 ? 1 : -1;
            } else if (moveTowardMouse === 1) {
                this.directionY = mouseY - this.y > 0 ? 1 : -1;
            }

            this.speed = 1.25; // Speed up
        }

        // Move bubbles
        this.x += this.speed * this.directionX;
        this.y += this.speed * this.directionY;

        // Change radius
        this.radius += changeSettings(this.radius, minSize, maxSize, 15);

        // Draw the bubbles
        ctx.save();
        ctx.globalCompositeOperation = 'color-dodge';
        ctx.beginPath();

        var gradient = ctx.createRadialGradient(this.x, this.y, 0, this.x, this.y, this.radius);
        gradient.addColorStop(0, this.color.color1);
        gradient.addColorStop(0.5, this.color.color2);
        gradient.addColorStop(1, 'rgba(250,76,43,0)');

        ctx.arc(this.x, this.y, this.radius, 0, Math.PI*2, true);
        ctx.fillStyle = gradient;
        ctx.fill();
        ctx.closePath();
        ctx.restore();

        // Pop bubbles if mouse coords match
        if(pop === true && mouseOver(this.x,this.y,this.radius)) {
            bubbles[this.id].destroy();
            pop = false;
        }

    };

    // Create initial bubbles
    

    // Call animation
    var animate = function() {

        // Clear canvas and fill with background color
        ctx.fillStyle = bgcolor;
        ctx.fillRect(0, 0, canvasWidth, canvasHeight);

        // Draw bubbles
        for (var i = 1; i <= count; i++) {
            bubbles[i].draw();
        }

        requestAnimationFrame(animate);

    };

    requestAnimationFrame(animate);

    // Click to add new bubble

        canvas.addEventListener('mouseover', function () {
        new Bubble(e.pageX, e.pageY);
    });

  
       // Sets mouse coords for popping bubbles
    canvas.addEventListener('contextmenu',function(e){
        mouseX = e.pageX;
        mouseY = e.pageY;
        pop = true;
        e.preventDefault();
    });

    // Attract bubbles
    var startAttracting;
  
    canvas.addEventListener('mousedown',function(e){
        mouseX = e.pageX;
        mouseY = e.pageY;
      
        // Wait 0.5s before attracting bubbles
        clearTimeout(startAttracting);
        startAttracting = setTimeout(function(){
            return attract = true;
        }, 500);
    });

    // If mouse held down, update coords as the mouse moves
    canvas.addEventListener('mousemove',function(e){
        if(attract) {
            mouseX = e.pageX;
            mouseY = e.pageY;
        }
    });


    
    // Clear attract
    canvas.addEventListener('mouseup',function(e){
        clearTimeout(startAttracting);
        attract = false;
    });
  
    // Resize canvas with window resize
    var resizing;

    window.addEventListener('resize', function(){
        clearTimeout(resizing);
        resizing = setTimeout(function(){
          canvasWidth = canvas.width = window.innerWidth;
          canvasHeight = canvas.height = window.innerHeight;
        }, 500);
    });

}());

</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
<audio id="sound1" src="https://flow.advocatepedia.com/sounds/celesta/c001.mp3" type="audio/mpeg"></audio>
<audio id="sound2" src="https://flow.advocatepedia.com/sounds/celesta/c002.mp3" type="audio/mpeg"></audio>
<audio id="sound3" src="https://flow.advocatepedia.com/sounds/celesta/c003.mp3" type="audio/mpeg"></audio>
<audio id="sound4" src="https://flow.advocatepedia.com/sounds/celesta/c004.mp3" type="audio/mpeg"></audio>
<audio id="sound5" src="https://flow.advocatepedia.com/sounds/celesta/c005.mp3" type="audio/mpeg"></audio>
<audio id="sound6" src="https://flow.advocatepedia.com/sounds/celesta/c006.mp3" type="audio/mpeg"></audio>
<audio id="sound7" src="https://flow.advocatepedia.com/sounds/celesta/c007.mp3" type="audio/mpeg"></audio>
<audio id="sound8" src="https://flow.advocatepedia.com/sounds/celesta/c008.mp3" type="audio/mpeg"></audio>
<audio id="sound9" src="https://flow.advocatepedia.com/sounds/celesta/c009.mp3" type="audio/mpeg"></audio>
<audio id="sound10" src="https://flow.advocatepedia.com/sounds/celesta/c010.mp3" type="audio/mpeg"></audio>
<audio id="sound11" src="https://flow.advocatepedia.com/sounds/celesta/c011.mp3" type="audio/mpeg"></audio>
<audio id="sound12" src="https://flow.advocatepedia.com/sounds/celesta/c012.mp3" type="audio/mpeg"></audio>
<audio id="sound13" src="https://flow.advocatepedia.com/sounds/celesta/c013.mp3" type="audio/mpeg"></audio>
<audio id="sound14" src="https://flow.advocatepedia.com/sounds/celesta/c014.mp3" type="audio/mpeg"></audio>
<audio id="sound15" src="https://flow.advocatepedia.com/sounds/celesta/c015.mp3" type="audio/mpeg"></audio>
<audio id="sound16" src="https://flow.advocatepedia.com/sounds/celesta/c016.mp3" type="audio/mpeg"></audio>
<audio id="sound17" src="https://flow.advocatepedia.com/sounds/celesta/c017.mp3" type="audio/mpeg"></audio>
<audio id="sound18" src="https://flow.advocatepedia.com/sounds/celesta/c018.mp3" type="audio/mpeg"></audio>
<audio id="sound19" src="https://flow.advocatepedia.com/sounds/celesta/c019.mp3" type="audio/mpeg"></audio>
<audio id="sound20" src="https://flow.advocatepedia.com/sounds/celesta/c020.mp3" type="audio/mpeg"></audio>
<audio id="sound21" src="https://flow.advocatepedia.com/sounds/celesta/c021.mp3" type="audio/mpeg"></audio>
<audio id="sound22" src="https://flow.advocatepedia.com/sounds/celesta/c022.mp3" type="audio/mpeg"></audio>
<audio id="sound23" src="https://flow.advocatepedia.com/sounds/celesta/c023.mp3" type="audio/mpeg"></audio>
<audio id="sound24" src="https://flow.advocatepedia.com/sounds/celesta/c024.mp3" type="audio/mpeg"></audio>
<audio id="sound25" src="https://flow.advocatepedia.com/sounds/celesta/c025.mp3" type="audio/mpeg"></audio>
<audio id="sound26" src="https://flow.advocatepedia.com/sounds/celesta/c026.mp3" type="audio/mpeg"></audio>
<audio id="sound27" src="https://flow.advocatepedia.com/sounds/celesta/c027.mp3" type="audio/mpeg"></audio>
<audio id="sound28" src="https://flow.advocatepedia.com/sounds/clav/c001.mp3" type="audio/mpeg"></audio>
<audio id="sound29" src="https://flow.advocatepedia.com/sounds/clav/c002.mp3" type="audio/mpeg"></audio>
<audio id="sound30" src="https://flow.advocatepedia.com/sounds/clav/c003.mp3" type="audio/mpeg"></audio>
<audio id="sound31" src="https://flow.advocatepedia.com/sounds/clav/c004.mp3" type="audio/mpeg"></audio>
<audio id="sound32" src="https://flow.advocatepedia.com/sounds/clav/c005.mp3" type="audio/mpeg"></audio>
<audio id="sound33" src="https://flow.advocatepedia.com/sounds/clav/c006.mp3" type="audio/mpeg"></audio>
<audio id="sound34" src="https://flow.advocatepedia.com/sounds/clav/c007.mp3" type="audio/mpeg"></audio>
<audio id="sound35" src="https://flow.advocatepedia.com/sounds/clav/c008.mp3" type="audio/mpeg"></audio>
<audio id="sound36" src="https://flow.advocatepedia.com/sounds/clav/c009.mp3" type="audio/mpeg"></audio>
<audio id="sound37" src="https://flow.advocatepedia.com/sounds/clav/c010.mp3" type="audio/mpeg"></audio>
<audio id="sound38" src="https://flow.advocatepedia.com/sounds/clav/c011.mp3" type="audio/mpeg"></audio>
<audio id="sound39" src="https://flow.advocatepedia.com/sounds/clav/c012.mp3" type="audio/mpeg"></audio>
<audio id="sound40" src="https://flow.advocatepedia.com/sounds/clav/c013.mp3" type="audio/mpeg"></audio>
<audio id="sound41" src="https://flow.advocatepedia.com/sounds/clav/c014.mp3" type="audio/mpeg"></audio>
<audio id="sound42" src="https://flow.advocatepedia.com/sounds/clav/c015.mp3" type="audio/mpeg"></audio>
<audio id="sound43" src="https://flow.advocatepedia.com/sounds/clav/c016.mp3" type="audio/mpeg"></audio>
<audio id="sound44" src="https://flow.advocatepedia.com/sounds/clav/c017.mp3" type="audio/mpeg"></audio>
<audio id="sound45" src="https://flow.advocatepedia.com/sounds/clav/c018.mp3" type="audio/mpeg"></audio>
<audio id="sound46" src="https://flow.advocatepedia.com/sounds/clav/c019.mp3" type="audio/mpeg"></audio>
<audio id="sound47" src="https://flow.advocatepedia.com/sounds/clav/c020.mp3" type="audio/mpeg"></audio>
<audio id="sound48" src="https://flow.advocatepedia.com/sounds/clav/c021.mp3" type="audio/mpeg"></audio>
<audio id="sound49" src="https://flow.advocatepedia.com/sounds/clav/c022.mp3" type="audio/mpeg"></audio>
<audio id="sound50" src="https://flow.advocatepedia.com/sounds/clav/c023.mp3" type="audio/mpeg"></audio>
<audio id="sound51" src="https://flow.advocatepedia.com/sounds/clav/c024.mp3" type="audio/mpeg"></audio>
<audio id="sound52" src="https://flow.advocatepedia.com/sounds/clav/c025.mp3" type="audio/mpeg"></audio>
<audio id="sound53" src="https://flow.advocatepedia.com/sounds/clav/c026.mp3" type="audio/mpeg"></audio>
<audio id="sound54" src="https://flow.advocatepedia.com/sounds/clav/c027.mp3" type="audio/mpeg"></audio>
<audio id="sound55" src="https://flow.advocatepedia.com/sounds/swells/swell1.mp3" type="audio/mpeg"></audio>
<audio id="sound56" src="https://flow.advocatepedia.com/sounds/swells/swell2.mp3" type="audio/mpeg"></audio>
<audio id="sound57" src="https://flow.advocatepedia.com/sounds/swells/swell3.mp3" type="audio/mpeg"></audio>
<audio id="sound58" src="https://flow.advocatepedia.com/sounds/swells/swell4.mp3" type="audio/mpeg"></audio>
<script>
    $(document).ready(function(){
        setInterval(function(){
            $("#count").load('rc.php')
        }, 2000);
    });
</script>

<style>



div.c {
  font-size: 550%;
  color:red;
}

</style>
</body>
</html>
