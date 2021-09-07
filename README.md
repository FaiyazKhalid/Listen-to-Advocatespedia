# Listen-to-Advocatespedia
Advocatespedia Listen is a visual spark particle representation of total hitting counted by Advocatespedia. The script is in Javascript language and PHP 7 written by Adv. Faiyaz Khalid
![image](https://user-images.githubusercontent.com/15283416/132361029-ed8dd979-1682-4c01-a7da-80a5be9c0fb6.png)

# How it works
1. Suppose you have a website and you want to know web hitting(Statistics/counting) update in real time. 
2. There is a PHP script Back.php it has a table that compare store htting details to current update.
3. These below code show current update in real time in javascript
4. <script>
5. var timeout = setInterval(checkUpdate, 2000);    
function checkUpdate()
{
    $.post("back.php", function(data, status)
    {
       if (data.toString()=="true")
       {
  //add anything here 
  //so i added random music tone javacript code: On every change or update random tone will be played automatically.
          playRandomSound();
  //secondly i wanted to show visual representation particles so i found bubble particle code from codepen site and added here  
  // Create initial bubbles: On every change or update random bubble particle will be visualised automatically.
    for (var i = 0; i < maxCount; i++) {
        new Bubble();
    }
  //finished
  
      }
    });
}
</script>

6. These are the code for bubble particles
7. Those above code are also included in this single java script  
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
Below this is canvas
   <canvas id="canvas"></canvas>
   
 Thanks
 Feedback is always appreciated 
 -By Adv. Faiyaz Khalid  
