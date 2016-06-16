//var game = new Phaser.Game(800, 600, Phaser.CANVAS, 'game-div', { preload: preload, create: create, update: update, render: render });
"use strict";
var game = new Phaser.Game(800, 600, Phaser.CANVAS, 'game-div', { preload: preload, create: create, update: update });

function preload() {

    game.load.image('space', 'assets/space.png');
    game.load.image('bullet', 'assets/laser.png');
    game.load.image('ship', 'assets/ship.png');
    game.load.image('asteroid1', 'assets/asteroid1.png');
    game.load.image('asteroid2', 'assets/asteroid2.png');
    game.load.image('asteroid3', 'assets/asteroid3.png');
    game.load.image('shielded_ship', 'assets/shielded_ship.png');
    game.load.image('shield', 'assets/shield.png');
    game.load.image('spreadShot', 'assets/spread_shot.png');
    game.load.image('gammaBlast', 'assets/gammaBlast.png');
    game.load.image('gammaBlastScreen', 'assets/gammaBlastScreen.png');

    game.load.image('alien', 'assets/alien.png');
    game.load.audio('sfx', 'assets/fx_mixdown.ogg');

}

var sprite;
var cursors;
var lives = 3;
var respawnDelay = 3000;
var died;
var respawning;
var justHit = false;
var showprompt = true;

var shielded;
var shield;
var shieldStart;
var shieldLength = 10000;
var shieldExists;
var shieldCreated;

var spreading;
var spreadShot;
var spreadShotStart;
var spreadShotLength = 10000;
var spreadShotExists;
var spreadShotCreated;

var gammaBlast;
var gammaBlastExists;
var gammaBlastCreated;


var powerupExistence = 5000;

var bullet;
var bullet1;
var bullet2;
var bullet3;
var bullets;
var bulletTime = 0;

var asteroidOne;
var asteroidTwo;
var asteroidThree;
var asteroidFour;
var asteroids;


var level = 1;
var levelText;
var score = 0;


//var count = 0.1;

var alien;
var alienWaitTime = 20000;
var alienChangeTime = 1500;
var alienExists;
var alienBullet;

var lifeCounter;
var lifeCounterSprite;
var scoreSprite;

var fx;

function create() {

    //  This will run in Canvas mode, so let's gain a little speed and display
    game.renderer.clearBeforeRender = false;
    game.renderer.roundPixels = true;

    //  We need arcade physics
    game.physics.startSystem(Phaser.Physics.ARCADE);

    //  A spacey background
    game.add.tileSprite(0, 0, game.width, game.height, 'space');


    //  Our ships bullets
    bullets = game.add.group();
    bullets.enableBody = true;
    bullets.physicsBodyType = Phaser.Physics.ARCADE;
    bullets.createMultiple(5, 'bullet');
    bullets.setAll('anchor.x', 0.5);
    bullets.setAll('anchor.y', 0.5);
    game.physics.enable(bullets, Phaser.Physics.ARCADE);

    // Setup for alien
    alienExists = false;
    setTimeout(spawnAlien, alienWaitTime);


    //  Our player ship
    respawn_ship();
    respawning = true;
    shielded = false;
    died = game.time.now;

    //  Game input
    cursors = game.input.keyboard.createCursorKeys();
    game.input.keyboard.addKeyCapture([Phaser.Keyboard.SPACEBAR]);

    //Set up the asteroids
    asteroids = game.add.group();
    createAsteroids(4, 1.5);

    shieldExists = false;
    spreadShotExists = false;
    gammaBlastExists = false;
    spreading = false;

    //set up level text
    levelText = game.add.text(game.world.centerX, game.world.centerY, "ASTEROIDS \n level " + level, {
        font: "65px Courier",
        fill: "#ffffff",
        align: "left"
    });

    levelText.anchor.setTo(0.5, 0.5);

    game.physics.arcade.enable(levelText);

    game.add.tween(levelText.scale).to({ x: 0.0, y: 0.0 }, 1500, Phaser.Easing.Linear.None, true);
    setTimeout(function() {
        levelText.destroy();

    }, 1250);


    lifeCounterSprite = game.add.sprite(725, 575, 'ship');
    lifeCounterSprite.anchor.set(0.5);
    lifeCounterSprite.scale = new PIXI.Point(0.5, 0.5);
    lifeCounterSprite.angle = -90;
    lifeCounter = game.add.text(765, 580, "x" + lives, { font: '15pt Courier New', fill: 'white' });
    lifeCounter.anchor.set(0.5);

    score = 0;
    scoreSprite = game.add.text(765, 10, score, { font: '15pt Courier New', fill: 'white' });
    scoreSprite.anchor.set(1, 0);

    // Audio 
    fx = game.add.audio('sfx');
    fx.allowMultiple = true;
    fx.addMarker('shot', 9, 0.1);
    fx.addMarker('death', 12, 4.2);
    fx.addMarker('powerup', 10, 1.0);
    fx.addMarker('gamma', 4, 3.2);
    fx.addMarker('spreadshot', 17, 1.0);
}

function generatePowerup(x, y) {
    var powerup = getRandomInt(1, 3);

    if (powerup == 1) {
        if (!gammaBlastExists) {
            generateGammaBlast(x, y);
            fx.play('powerup');
        }
    } else if (powerup == 2) {
        if (!shieldExists) {
            generateShield(x, y);
            fx.play('powerup');
        }
    } else {
        if (!spreadShotExists) {
            generateSpreadShot(x, y);
            fx.play('powerup');
        }
    }
}

function generateShield(x, y) {
    shield = game.add.sprite(x, y, 'shield');
    shield.anchor.set(0.5);
    game.physics.enable(shield, Phaser.Physics.ARCADE);
    shield.body.enable = true;
    shieldCreated = game.time.now;
    shieldExists = true;
}

function generateSpreadShot(x, y) {
    spreadShot = game.add.sprite(x, y, 'spreadShot');
    spreadShot.anchor.set(0.5);
    game.physics.enable(spreadShot, Phaser.Physics.ARCADE);
    spreadShot.body.enable = true;
    spreadShotCreated = game.time.now;
    spreadShotExists = true;
}

function generateGammaBlast(x, y) {
    gammaBlast = game.add.sprite(x, y, 'gammaBlast');
    gammaBlast.anchor.set(0.5);
    game.physics.enable(gammaBlast, Phaser.Physics.ARCADE);
    gammaBlast.body.enable = true;
    gammaBlastCreated = game.time.now;
    gammaBlastExists = true;
}

function fireSpreadShot() {
    spreadShot.kill();
    bullets.createMultiple(10, 'bullet');
    bullets.setAll('anchor.x', 0.5);
    bullets.setAll('anchor.y', 0.5);
    game.physics.enable(bullets, Phaser.Physics.ARCADE);
    spreadShotStart = game.time.now;
    spreading = true;
}

function stopSpreadShot() {
    bullets.removeAll(true);

    bullets.createMultiple(5, 'bullet');
    bullets.setAll('anchor.x', 0.5);
    bullets.setAll('anchor.y', 0.5);
    game.physics.enable(bullets, Phaser.Physics.ARCADE);
}

function fireGammaBlast() {
    gammaBlast.kill();
    fx.play('gamma');
    asteroids.forEach(function(asteroid) {
        asteroid.kill();
    }, this);
    sprite.kill();

    var gammaScreen = game.add.tileSprite(0, 0, game.width, game.height, 'gammaBlastScreen');

    setTimeout(function() {
        gammaScreen.kill();
        var background = game.add.tileSprite(0, 0, game.width, game.height, 'space');

        justHit = false;
        background.sendToBack();
        respawn_ship();
        levelUp();
    }, 500);
}

function createAsteroids(count, scale, xi, yi, parentSprite, velocityScalar) {

    for (var i = 0; i < count; i++) {
        var imageName = parentSprite || 'asteroid' + getRandomInt(1, 3);
        var xPos = xi || getRandomInt(0, game.width);
        var yPos = yi || getRandomInt(0, game.height);

        //make sure the asteroids aren't too close to the ship
        if (Math.abs(sprite.x - xPos) < 100) {
            xPos += (-1 + getRandomInt(1)) * 100;
        }
        if (Math.abs(sprite.y - yPos) < 100) {
            yPos += (-1 + getRandomInt(1)) * 100;
        }

        var asteroid = asteroids.create(xPos, yPos, imageName);
        asteroid.anchor.set(0.5);
        asteroid.rotation = getRandomInt(0, 2 * Math.PI);
        asteroid.scale = new PIXI.Point(scale, scale);
        asteroid.physicsBodyType = Phaser.Physics.ARCADE;
        asteroid.rotation = getRandomInt(0, 2 * Math.PI);
        game.physics.enable(asteroid, Phaser.Physics.ARCADE);
        asteroid.body.angularVelocity = getRandomInt(-100, 100);
        velocityScalar = velocityScalar || 1;
        asteroid.body.velocity.setTo(getRandomInt(-100, 100), getRandomInt(-100, 100));

    }


}

function update() {
    // This gives the ship a 3 second delay of invulnerability after respawning
    if (respawning && ((game.time.now - died) > respawnDelay)) {
        respawning = false;
        sprite.loadTexture('ship');
    }

    if (shielded && ((game.time.now - shieldStart) > shieldLength)) {
        sprite.loadTexture('ship');
        shielded = false;
    }

    if (spreading && ((game.time.now - spreadShotStart) > spreadShotLength)) {
        spreading = false;
        stopSpreadShot();
    }

    if (shieldExists && ((game.time.now - shieldCreated) > powerupExistence)) {
        shieldExists = false;
        shield.kill();
    }

    if (gammaBlastExists && ((game.time.now - gammaBlastCreated) > powerupExistence)) {
        gammaBlastExists = false;
        gammaBlast.kill();
    }

    if (spreadShotExists && ((game.time.now - spreadShotCreated) > powerupExistence)) {
        spreadShotExists = false;
        spreadShot.kill();
    }

    game.physics.arcade.collide(sprite, shield, shield_ship);
    game.physics.arcade.collide(sprite, gammaBlast, fireGammaBlast);
    game.physics.arcade.collide(sprite, spreadShot, fireSpreadShot);

    //Unless respawning or shield: if the ship and an asteroid collides, 
    //call ship_dies()
    if (shielded || respawning)
        game.physics.arcade.collide(sprite, asteroids);
    else

        game.physics.arcade.collide(sprite, asteroids, ship_dies);

    //If a bullet hits an asteroid, call asteroid_hit()

    game.physics.arcade.collide(asteroids, bullets, asteroid_hit);

    //If a bullet hits an alien, call alien_hit()
    game.physics.arcade.collide(alien, bullets, alien_hit);

    //If an alien's bullet hits the player, call alien_hit_ship()
    if (alienExists)
        game.physics.arcade.collide(sprite, alienBullet, alien_hit_ship);

    //If asteroids collide, have them bounce off each other.
    game.physics.arcade.collide(asteroids, asteroids);

    // Detect user input
    if (cursors.up.isDown) {
        game.physics.arcade.accelerationFromRotation(sprite.rotation, 200, sprite.body.acceleration);
    } else {
        sprite.body.acceleration.set(0);
    }

    if (cursors.left.isDown) {
        sprite.body.angularVelocity = -300;
    } else if (cursors.right.isDown) {
        sprite.body.angularVelocity = 300;
    } else {
        sprite.body.angularVelocity = 0;
    }

    if (game.input.keyboard.isDown(Phaser.Keyboard.SPACEBAR)) {
        if (spreading)
            fireSpreadShotBullets();
        else
            fireBullet();
    }

    //Wrap any objects that have gone off the screen to the other side
    screenWrap(sprite);
    if (alienExists) {
        screenWrap(alien);
    }
    asteroids.forEachExists(screenWrap, this);

    scoreSprite.text = score;

}

function fireBullet() {
    //You can only fire if you still have lives left and you're not respawning
    if (lives > 0 && !justHit) {
        if (game.time.now > bulletTime) {
            bullet = bullets.getFirstExists(false);

            if (bullet) {
                fx.play('shot');
                bullet.reset(sprite.body.x + 38, sprite.body.y + 38);
                bullet.lifespan = 1800;
                bullet.rotation = sprite.rotation;
                game.physics.arcade.velocityFromRotation(sprite.rotation, 400, bullet.body.velocity);
                bulletTime = game.time.now + 100;

            }
        }
    }
}

function fireSpreadShotBullets() {
    //You can only fire if you still have lives left and you're not respawning
    if (lives > 0 && !justHit) {
        if (game.time.now > bulletTime) {
            fx.play('spreadshot');
            bullet1 = bullets.getFirstExists(false);
            if (bullet1) {
                bullet1.reset(sprite.body.x + 38, sprite.body.y + 38);
                bullet1.lifespan = 1800;
                bullet1.rotation = sprite.rotation;
                game.physics.arcade.velocityFromRotation(sprite.rotation - 100, 400, bullet1.body.velocity);
            }

            bullet2 = bullets.getFirstExists(false);
            if (bullet2) {
                bullet2.reset(sprite.body.x + 38, sprite.body.y + 38);
                bullet2.lifespan = 1800;
                bullet2.rotation = sprite.rotation;
                game.physics.arcade.velocityFromRotation(sprite.rotation, 400, bullet2.body.velocity);
            }

            bullet3 = bullets.getFirstExists(false);
            if (bullet3) {
                bullet3.reset(sprite.body.x + 38, sprite.body.y + 38);
                bullet3.lifespan = 1800;
                bullet3.rotation = sprite.rotation;
                game.physics.arcade.velocityFromRotation(sprite.rotation + 100, 400, bullet3.body.velocity);
            }

            bulletTime = game.time.now + 100;
        }
    }
}

//If an object went offscreen, wrap it to the other side.
function screenWrap(sprite) {


    if (sprite.x < 0) {
        sprite.x = game.width;
    } else if (sprite.x > game.width) {

        sprite.x = 0;
    }

    if (sprite.y < 0) {
        sprite.y = game.height;
    } else if (sprite.y > game.height) {
        sprite.y = 0;
    }

}

//called when a laser collides with an asteroid

function asteroid_hit(_asteroid, _bullet) {
    if (_asteroid.scale.x > 0.4) {
        //create a new asteroid in the former asteroid's position
        createAsteroids(4, _asteroid.scale.x / 4, _asteroid.body.x, _asteroid.body.y, _asteroid.key);
        _asteroid.kill();
        score += 50;

        var random = getRandomInt(1, 100);
        if (random < 20)
            generatePowerup(_asteroid.x, _asteroid.y);
    } else {
        _asteroid.kill();
        score += 75;
    }
    _bullet.kill();
    var aliveCount = 0;
    asteroids.forEachExists(function(a) {

        if (a.alive) {
            aliveCount++;
        }
    }, this);

    if (aliveCount == 0) {
        levelUp();

    }


}

//up the difficulty
function levelUp() {

    level++;
    var asteroidCount = Math.min(100, level + 4);
    createAsteroids(asteroidCount, 1.5, getRandomInt(1000), getRandomInt(1000));

    levelText = game.add.text(game.world.centerX, game.world.centerY, "Level " + level, {
        font: "65px Arial",
        fill: "#ffffff",
        align: "center"
    });

    levelText.anchor.setTo(0.5, 0.5);

    //destroy the level text sprite after 1.25 seconds
    setTimeout(function() {
        levelText.destroy();
    }, 1250);

    game.add.tween(levelText.scale).to({ x: 0.0, y: 0.0 }, 1100, Phaser.Easing.Linear.None, true);

}
// Called when the ship collides with an asteroid
function ship_dies() {
    sprite.kill();
    lives = lives - 1;
    lifeCounter.text = 'x' + lives;
    respawning = true;
    died = game.time.now;
    fx.play('death');
    // If there are still lives left, respawn the ship
    if (lives > 0) {
        respawn_ship();
    } else {
        levelText = game.add.text(game.world.centerX, game.world.centerY, "GAME OVER \n SCORE: " + score, {
            font: "65px Arial",
            fill: "#ffffff",
            align: "center"
        });
        var lowest_score = $("#lowest").text();
        if (score > lowest_score) {
            if (showprompt) {
                showprompt = false;
                var initials = prompt("~NEW HIGH SCORE!~\nEnter your initials");
                if (initials) {
                    $("#scoreboard").load("highscore_controller.php?init=" + initials + "&score=" + score)
                } else {
                    alert("no initials!")
                }
            }
        }
    }

    levelText.anchor.setTo(0.5, 0.5);
    justHit = true;


}

// Create the ship
function respawn_ship() {

    sprite = game.add.sprite(300, 300, 'ship');
    sprite.tint = 0x555555;
    sprite.anchor.set(0.5);
    game.physics.enable(sprite, Phaser.Physics.ARCADE);
    sprite.body.drag.set(100);
    sprite.body.maxVelocity.set(200);
    sprite.body.enable = true;
    setTimeout(function() {
        sprite.tint = 0xFFFFFF;
        justHit = false;
    }, 1000);
}

function shield_ship() {
    sprite.loadTexture('shielded_ship');
    shielded = true;
    shieldStart = game.time.now;
    shield.kill();
    shieldExists = false;
}


function render() {}

function spawnAlien() {
    var spawnX = 0;
    var spawnY = 0;
    if (Math.random() > 0.5) {
        spawnX = 800;
    }
    if (Math.random() > 0.5) {
        spawnY = 600;
    }
    alien = game.add.sprite(spawnX, spawnY, 'alien');
    alien.physicsBodyType = Phaser.Physics.ARCADE;
    game.physics.enable(alien, Phaser.Physics.ARCADE);
    alienExists = true;
    alien.anchor.set(0.5);
    alien.body.allowRotation = false;
    alien.body.angularVelocity = getRandomInt(-100, 100);
    alien.body.velocity.setTo(100, 100);
    setTimeout(alienChangeDirection, alienChangeTime);


    alienBullet = game.add.sprite(spawnX, spawnY, 'bullet');
    alienBullet.physicsBodyType = Phaser.Physics.ARCADE;
    game.physics.enable(alienBullet, Phaser.Physics.ARCADE);
    alienBullet.anchor.set(0.5);
    alienBullet.kill();
}

function alienChangeDirection() {
    if (alienExists) {
        alienBullet.position = new PIXI.Point(alien.x, alien.y);
        alienBullet.revive();
        alienBullet.rotation = getRandomInt(0, 2 * Math.PI)
        game.physics.arcade.velocityFromRotation(getRandomInt(0, 2 * Math.PI), 100, alien.body.velocity);
        game.physics.arcade.velocityFromRotation(alienBullet.rotation, 400, alienBullet.body.velocity);
        setTimeout(alienChangeDirection, alienChangeTime);
    }
}

function alien_hit(alien, bullet) {
    alien.kill();
    bullet.kill();
    alienBullet.kill();
    alienExists = false;
    setTimeout(spawnAlien, alienWaitTime);
    score += 150;
}

function alien_hit_ship() {
    alienBullet.kill();
    ship_dies();
}

function render() {}

function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}
