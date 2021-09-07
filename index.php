<!DOCTYPE html>
<html lang="en" >
<body>
<canvas id="canvas"></canvas>
<!-- partial -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>  
<link href="https://fonts.googleapis.com/css?family=Press+Start+2P" rel="stylesheet">

<script type="text/javascript">
  (function() {
    "use strict";

 
    // Canvas things
    var canvas = document.getElementById('canvas'),
        ctx = canvas.getContext('2d'),
        canvasWidth = canvas.width = window.innerWidth,
        canvasHeight = canvas.height = window.innerHeight;

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
        bgcolor = 'hsl(235,60%,13%)', // Canvas bg
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


    


var timeout = setInterval(checkUpdate, 2000);    
function checkUpdate()
{
    $.post("back.php", function(data, status)
    {
       if (data.toString()=="true")
       {
          playRandomSound();
    
     // Create initial bubbles
    for (var i = 0; i < maxCount; i++) {
        new Bubble();
    }



       }
    });
}

}());

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
    
    
</script>
<audio id="sound1" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/celesta/c001.mp3" type="audio/mpeg"></audio>
<audio id="sound2" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/celesta/c002.mp3" type="audio/mpeg"></audio>
<audio id="sound3" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/celesta/c003.mp3" type="audio/mpeg"></audio>
<audio id="sound4" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/celesta/c004.mp3" type="audio/mpeg"></audio>
<audio id="sound5" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/celesta/c005.mp3" type="audio/mpeg"></audio>
<audio id="sound6" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/celesta/c006.mp3" type="audio/mpeg"></audio>
<audio id="sound7" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/celesta/c007.mp3" type="audio/mpeg"></audio>
<audio id="sound8" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/celesta/c008.mp3" type="audio/mpeg"></audio>
<audio id="sound9" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/celesta/c009.mp3" type="audio/mpeg"></audio>
<audio id="sound10" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/celesta/c010.mp3" type="audio/mpeg"></audio>
<audio id="sound11" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/celesta/c011.mp3" type="audio/mpeg"></audio>
<audio id="sound12" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/celesta/c012.mp3" type="audio/mpeg"></audio>
<audio id="sound13" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/celesta/c013.mp3" type="audio/mpeg"></audio>
<audio id="sound14" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/celesta/c014.mp3" type="audio/mpeg"></audio>
<audio id="sound15" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/celesta/c015.mp3" type="audio/mpeg"></audio>
<audio id="sound16" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/celesta/c016.mp3" type="audio/mpeg"></audio>
<audio id="sound17" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/celesta/c017.mp3" type="audio/mpeg"></audio>
<audio id="sound18" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/celesta/c018.mp3" type="audio/mpeg"></audio>
<audio id="sound19" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/celesta/c019.mp3" type="audio/mpeg"></audio>
<audio id="sound20" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/celesta/c020.mp3" type="audio/mpeg"></audio>
<audio id="sound21" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/celesta/c021.mp3" type="audio/mpeg"></audio>
<audio id="sound22" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/celesta/c022.mp3" type="audio/mpeg"></audio>
<audio id="sound23" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/celesta/c023.mp3" type="audio/mpeg"></audio>
<audio id="sound24" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/celesta/c024.mp3" type="audio/mpeg"></audio>
<audio id="sound25" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/celesta/c025.mp3" type="audio/mpeg"></audio>
<audio id="sound26" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/celesta/c026.mp3" type="audio/mpeg"></audio>
<audio id="sound27" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/celesta/c027.mp3" type="audio/mpeg"></audio>
<audio id="sound28" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/clav/c001.mp3" type="audio/mpeg"></audio>
<audio id="sound29" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/clav/c002.mp3" type="audio/mpeg"></audio>
<audio id="sound30" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/clav/c003.mp3" type="audio/mpeg"></audio>
<audio id="sound31" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/clav/c004.mp3" type="audio/mpeg"></audio>
<audio id="sound32" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/clav/c005.mp3" type="audio/mpeg"></audio>
<audio id="sound33" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/clav/c006.mp3" type="audio/mpeg"></audio>
<audio id="sound34" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/clav/c007.mp3" type="audio/mpeg"></audio>
<audio id="sound35" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/clav/c008.mp3" type="audio/mpeg"></audio>
<audio id="sound36" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/clav/c009.mp3" type="audio/mpeg"></audio>
<audio id="sound37" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/clav/c010.mp3" type="audio/mpeg"></audio>
<audio id="sound38" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/clav/c011.mp3" type="audio/mpeg"></audio>
<audio id="sound39" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/clav/c012.mp3" type="audio/mpeg"></audio>
<audio id="sound40" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/clav/c013.mp3" type="audio/mpeg"></audio>
<audio id="sound41" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/clav/c014.mp3" type="audio/mpeg"></audio>
<audio id="sound42" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/clav/c015.mp3" type="audio/mpeg"></audio>
<audio id="sound43" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/clav/c016.mp3" type="audio/mpeg"></audio>
<audio id="sound44" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/clav/c017.mp3" type="audio/mpeg"></audio>
<audio id="sound45" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/clav/c018.mp3" type="audio/mpeg"></audio>
<audio id="sound46" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/clav/c019.mp3" type="audio/mpeg"></audio>
<audio id="sound47" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/clav/c020.mp3" type="audio/mpeg"></audio>
<audio id="sound48" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/clav/c021.mp3" type="audio/mpeg"></audio>
<audio id="sound49" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/clav/c022.mp3" type="audio/mpeg"></audio>
<audio id="sound50" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/clav/c023.mp3" type="audio/mpeg"></audio>
<audio id="sound51" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/clav/c024.mp3" type="audio/mpeg"></audio>
<audio id="sound52" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/clav/c025.mp3" type="audio/mpeg"></audio>
<audio id="sound53" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/clav/c026.mp3" type="audio/mpeg"></audio>
<audio id="sound54" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/clav/c027.mp3" type="audio/mpeg"></audio>
<audio id="sound55" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/swells/swell1.mp3" type="audio/mpeg"></audio>
<audio id="sound56" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/swells/swell2.mp3" type="audio/mpeg"></audio>
<audio id="sound57" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/swells/swell3.mp3" type="audio/mpeg"></audio>
<audio id="sound58" src="https://advocatespedia.com/internship/obs/obcs/admin/live/sounds/swells/swell4.mp3" type="audio/mpeg"></audio>
<script>
    $(document).ready(function(){
        setInterval(function(){
            $("#count").load('display.php')
        }, 2000);
    });
</script>
<center><div id="count"  class="c"></div>  </center>
<style>
div.c {
  font-size: 550%;
  color:red;
}

</style>
</body>
</html>
