// The MIT License (MIT)

// Copyright (c) 2016 Jordan Hendley, Ryan Welling

// Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in 
// the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of 
// the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

// The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

// THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS 
// FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, 
// WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

function tetrisController() {
    var GRID_WIDTH = 10;
    var GRID_HEIGHT = 20;
    var SPRITE_WIDTH = 24;
    var SCOREBOARD_WIDTH = SPRITE_WIDTH * 5;
    var CANVAS_WIDTH = GRID_WIDTH * SPRITE_WIDTH;
    var CANVAS_HEIGHT = GRID_HEIGHT * SPRITE_WIDTH;
    var stage = new PIXI.Container();
    var renderer = PIXI.autoDetectRenderer(CANVAS_WIDTH, CANVAS_HEIGHT);
    document.getElementById("tetris").appendChild(renderer.view);
    var orientation = 0;
    var shapes = ['t', 'l', 'j', 'z', 's', 'i', 'q'];
    var score = 0;
    var scoreString = new PIXI.Text(score.toString(), {
        fill: 0xffffff
    });
    stage.addChild(scoreString);
    scoreString.x = 10;
    scoreString.y = 10;
    var showprompt = true;
    var grid = new Array(GRID_HEIGHT);
    for (var i = 0; i < GRID_HEIGHT; i++) {
        grid[i] = new Array(GRID_WIDTH)
    }
    var piece = new Array();
    newPiece(0xff0000);
    renderer.render(stage);
    requestAnimationFrame(animate);

    function addRectangle(x, y, color) {
        var rectangle = new PIXI.Graphics();
        rectangle.beginFill(color);
        rectangle.lineStyle(2, 0x000000);
        rectangle.position.set(x * SPRITE_WIDTH, y * SPRITE_WIDTH);
        rectangle.drawRect(0, 0, SPRITE_WIDTH, SPRITE_WIDTH);
        grid[y][x] = rectangle;
        stage.addChild(rectangle);
        return rectangle
    }

    function random(min, max) {
        return Math.round(Math.random() * (max - min) + min)
    }

    function newPiece(color) {
        shape = shapes[random(0, 7)];
        if (shape === 'z') {
            if (!isEmpty(5, 1) || !isEmpty(4, 1) || !isEmpty(4, 2) || !isEmpty(5, 0)) {
                endgame()
            } else {
                piece = [addRectangle(5, 1, 0xff0000), addRectangle(4, 1, 0xff0000), addRectangle(4, 2, 0xff0000), addRectangle(5, 0, 0xff0000)]
            }
        } else if (shape === 's') {
            if (!isEmpty(4, 1) || !isEmpty(5, 1) || !isEmpty(5, 2) || !isEmpty(4, 0)) {
                endgame()
            } else {
                piece = [addRectangle(4, 1, 0x00ff00), addRectangle(5, 1, 0x00ff00), addRectangle(5, 2, 0x00ff00), addRectangle(4, 0, 0x00ff00)]
            }
        } else if (shape === 't') {
            if (!isEmpty(5, 0) || !isEmpty(4, 0) || !isEmpty(6, 0) || !isEmpty(5, 1)) {
                endgame()
            } else {
                piece = [addRectangle(5, 0, 0x0000ff), addRectangle(4, 0, 0x0000ff), addRectangle(6, 0, 0x0000ff), addRectangle(5, 1, 0x0000ff)]
            }
        } else if (shape === 'q') {
            if (!isEmpty(4, 0) || !isEmpty(4, 1) || !isEmpty(5, 0) || !isEmpty(5, 1)) {
                endgame()
            } else {
                piece = [addRectangle(4, 0, 0x00ffff), addRectangle(4, 1, 0x00ffff), addRectangle(5, 0, 0x00ffff), addRectangle(5, 1, 0x00ffff)]
            }
        } else if (shape === 'i') {
            if (!isEmpty(5, 2) || !isEmpty(5, 0) || !isEmpty(5, 1) || !isEmpty(5, 3)) {
                endgame()
            } else {
                piece = [addRectangle(5, 2, 0xff00ff), addRectangle(5, 0, 0xff00ff), addRectangle(5, 1, 0xff00ff), addRectangle(5, 3, 0xff00ff)]
            }
        } else if (shape === 'j') {
            if (!isEmpty(5, 1) || !isEmpty(6, 0) || !isEmpty(5, 0) || !isEmpty(5, 2)) {
                endgame()
            } else {
                piece = [addRectangle(5, 1, 0xffff00), addRectangle(6, 0, 0xffff00), addRectangle(5, 0, 0xffff00), addRectangle(5, 2, 0xffff00)]
            }
        } else if (shape === 'l') {
            if (!isEmpty(5, 1) || !isEmpty(4, 0) || !isEmpty(5, 0) || !isEmpty(5, 2)) {
                endgame()
            } else {
                piece = [addRectangle(5, 1, 0xffffff), addRectangle(4, 0, 0xffffff), addRectangle(5, 0, 0xffffff), addRectangle(5, 2, 0xffffff)]
            }
        } else {
            if (!isEmpty(5, 0) || !isEmpty(4, 0) || !isEmpty(6, 0) || !isEmpty(5, 1)) {
                endgame()
            } else {
                shape = 't';
                piece = [addRectangle(5, 0, 0x0000ff), addRectangle(4, 0, 0x0000ff), addRectangle(6, 0, 0x0000ff), addRectangle(5, 1, 0x0000ff)]
            }
        }
        orientation = 0
    }

    function isEmpty(x, y) {
        if (x < 0 || y < 0 || x >= GRID_WIDTH || y >= GRID_HEIGHT) return false;
        if (typeof grid[y][x] === 'undefined') return true;
        else return false
    }

    function getX(rectangle) {
        return rectangle.position.x / SPRITE_WIDTH
    }

    function getY(rectangle) {
        return rectangle.position.y / SPRITE_WIDTH
    }

    function setX(rectangle, x) {
        rectangle.position.x = x * SPRITE_WIDTH
    }

    function setY(rectangle, y) {
        rectangle.position.y = y * SPRITE_WIDTH
    }

    function moveRectangle(x1, y1, x2, y2) {
        grid[y2][x2] = grid[y1][x1];
        grid[y1][x1] = undefined;
        grid[y2][x2].position.x = x2 * SPRITE_WIDTH;
        grid[y2][x2].position.y = y2 * SPRITE_WIDTH
    }

    function rotatePiece() {
        if (shape === 'q') return;
        if (shape === 't') {
            if (orientation === 0) {
                if (isEmpty(getX(piece[0]), getY(piece[0]) - 1)) {
                    moveRectangle(getX(piece[0]) + 1, getY(piece[0]), getX(piece[0]), getY(piece[0]) - 1);
                    orientation = 1
                }
            } else if (orientation === 1) {
                if (isEmpty(getX(piece[0]) + 1, getY(piece[0]))) {
                    moveRectangle(getX(piece[0]), getY(piece[0]) + 1, getX(piece[0]) + 1, getY(piece[0]));
                    orientation = 2
                }
            } else if (orientation === 2) {
                if (isEmpty(getX(piece[0]), getY(piece[0]) + 1)) {
                    moveRectangle(getX(piece[0]) - 1, getY(piece[0]), getX(piece[0]), getY(piece[0]) + 1);
                    orientation = 3
                }
            } else if (orientation === 3) {
                if (isEmpty(getX(piece[0]) - 1, getY(piece[0]))) {
                    moveRectangle(getX(piece[0]), getY(piece[0]) - 1, getX(piece[0]) - 1, getY(piece[0]));
                    orientation = 0
                }
            }
        }
        if (shape === 's') {
            if (orientation === 0) {
                if (isEmpty(getX(piece[0]) - 1, getY(piece[0]) + 1) && isEmpty(getX(piece[0]), getY(piece[0]) + 1)) {
                    moveRectangle(getX(piece[0]) + 1, getY(piece[0]) + 1, getX(piece[0]) - 1, getY(piece[0]) + 1);
                    moveRectangle(getX(piece[0]) + 1, getY(piece[0]), getX(piece[0]), getY(piece[0]) + 1);
                    moveRectangle(getX(piece[0]), getY(piece[0]) - 1, getX(piece[0]) + 1, getY(piece[0]));
                    orientation = 1
                }
            } else if (orientation === 1) {
                if (isEmpty(getX(piece[0]) - 1, getY(piece[0]) - 1) && isEmpty(getX(piece[0]) - 1, getY(piece[0]))) {
                    moveRectangle(getX(piece[0]) - 1, getY(piece[0]) + 1, getX(piece[0]) - 1, getY(piece[0]) - 1);
                    moveRectangle(getX(piece[0]), getY(piece[0]) + 1, getX(piece[0]) - 1, getY(piece[0]));
                    moveRectangle(getX(piece[0]) + 1, getY(piece[0]), getX(piece[0]), getY(piece[0]) + 1);
                    orientation = 2
                }
            } else if (orientation === 2) {
                if (isEmpty(getX(piece[0]) + 1, getY(piece[0]) - 1) && isEmpty(getX(piece[0]), getY(piece[0]) - 1)) {
                    moveRectangle(getX(piece[0]) - 1, getY(piece[0]) - 1, getX(piece[0]) + 1, getY(piece[0]) - 1);
                    moveRectangle(getX(piece[0]) - 1, getY(piece[0]), getX(piece[0]), getY(piece[0]) - 1);
                    moveRectangle(getX(piece[0]), getY(piece[0]) + 1, getX(piece[0]) - 1, getY(piece[0]));
                    orientation = 3
                }
            } else if (orientation === 3) {
                if (isEmpty(getX(piece[0]) + 1, getY(piece[0]) + 1) && isEmpty(getX(piece[0]) + 1, getY(piece[0]))) {
                    moveRectangle(getX(piece[0]) + 1, getY(piece[0]) - 1, getX(piece[0]) + 1, getY(piece[0]) + 1);
                    moveRectangle(getX(piece[0]), getY(piece[0]) - 1, getX(piece[0]) + 1, getY(piece[0]));
                    moveRectangle(getX(piece[0]) - 1, getY(piece[0]), getX(piece[0]), getY(piece[0]) - 1);
                    orientation = 0
                }
            }
        }
        if (shape === 'z') {
            if (orientation === 0) {
                if (isEmpty(getX(piece[0]) - 1, getY(piece[0]) - 1) && isEmpty(getX(piece[0]) + 1, getY(piece[0]))) {
                    moveRectangle(getX(piece[0]) - 1, getY(piece[0]) + 1, getX(piece[0]) - 1, getY(piece[0]) - 1);
                    moveRectangle(getX(piece[0]), getY(piece[0]) - 1, getX(piece[0]) + 1, getY(piece[0]));
                    moveRectangle(getX(piece[0]) - 1, getY(piece[0]), getX(piece[0]), getY(piece[0]) - 1);
                    orientation = 1
                }
            } else if (orientation === 1) {
                if (isEmpty(getX(piece[0]) + 1, getY(piece[0]) - 1) && isEmpty(getX(piece[0]), getY(piece[0]) + 1)) {
                    moveRectangle(getX(piece[0]) - 1, getY(piece[0]) - 1, getX(piece[0]) + 1, getY(piece[0]) - 1);
                    moveRectangle(getX(piece[0]) + 1, getY(piece[0]), getX(piece[0]), getY(piece[0]) + 1);
                    moveRectangle(getX(piece[0]), getY(piece[0]) - 1, getX(piece[0]) + 1, getY(piece[0]));
                    orientation = 2
                }
            } else if (orientation === 2) {
                if (isEmpty(getX(piece[0]) + 1, getY(piece[0]) + 1) && isEmpty(getX(piece[0]) - 1, getY(piece[0]))) {
                    moveRectangle(getX(piece[0]) + 1, getY(piece[0]) - 1, getX(piece[0]) + 1, getY(piece[0]) + 1);
                    moveRectangle(getX(piece[0]), getY(piece[0]) + 1, getX(piece[0]) - 1, getY(piece[0]));
                    moveRectangle(getX(piece[0]) + 1, getY(piece[0]), getX(piece[0]), getY(piece[0]) + 1);
                    orientation = 3
                }
            } else if (orientation === 3) {
                if (isEmpty(getX(piece[0]) - 1, getY(piece[0]) + 1) && isEmpty(getX(piece[0]), getY(piece[0]) - 1)) {
                    moveRectangle(getX(piece[0]) + 1, getY(piece[0]) + 1, getX(piece[0]) - 1, getY(piece[0]) + 1);
                    moveRectangle(getX(piece[0]) - 1, getY(piece[0]), getX(piece[0]), getY(piece[0]) - 1);
                    moveRectangle(getX(piece[0]), getY(piece[0]) + 1, getX(piece[0]) - 1, getY(piece[0]));
                    orientation = 0
                }
            }
        }
        if (shape === 'i') {
            if (orientation === 0) {
                if (isEmpty(getX(piece[0]) + 1, getY(piece[0])) && isEmpty(getX(piece[0]) - 1, getY(piece[0])) && isEmpty(getX(piece[0]) - 2, getY(piece[0]))) {
                    moveRectangle(getX(piece[0]), getY(piece[0]) + 1, getX(piece[0]) + 1, getY(piece[0]));
                    moveRectangle(getX(piece[0]), getY(piece[0]) - 1, getX(piece[0]) - 1, getY(piece[0]));
                    moveRectangle(getX(piece[0]), getY(piece[0]) - 2, getX(piece[0]) - 2, getY(piece[0]));
                    orientation = 1
                }
            } else if (orientation === 1) {
                if (isEmpty(getX(piece[0]), getY(piece[0]) + 1) && isEmpty(getX(piece[0]), getY(piece[0]) - 1) && isEmpty(getX(piece[0]), getY(piece[0]) - 2)) {
                    moveRectangle(getX(piece[0]) + 1, getY(piece[0]), getX(piece[0]), getY(piece[0]) + 1);
                    moveRectangle(getX(piece[0]) - 1, getY(piece[0]), getX(piece[0]), getY(piece[0]) - 1);
                    moveRectangle(getX(piece[0]) - 2, getY(piece[0]), getX(piece[0]), getY(piece[0]) - 2);
                    orientation = 0
                }
            }
        }
        if (shape === 'j') {
            if (orientation === 0) {
                if (isEmpty(getX(piece[0]) + 1, getY(piece[0])) && isEmpty(getX(piece[0]) - 1, getY(piece[0])) && isEmpty(getX(piece[0]) + 1, getY(piece[0]) + 1)) {
                    moveRectangle(getX(piece[0]), getY(piece[0]) + 1, getX(piece[0]) + 1, getY(piece[0]));
                    moveRectangle(getX(piece[0]), getY(piece[0]) - 1, getX(piece[0]) - 1, getY(piece[0]));
                    moveRectangle(getX(piece[0]) + 1, getY(piece[0]) - 1, getX(piece[0]) + 1, getY(piece[0]) + 1);
                    orientation = 1
                }
            } else if (orientation === 1) {
                if (isEmpty(getX(piece[0]), getY(piece[0]) + 1) && isEmpty(getX(piece[0]), getY(piece[0]) - 1) && isEmpty(getX(piece[0]) - 1, getY(piece[0]) + 1)) {
                    moveRectangle(getX(piece[0]) + 1, getY(piece[0]), getX(piece[0]), getY(piece[0]) + 1);
                    moveRectangle(getX(piece[0]) - 1, getY(piece[0]), getX(piece[0]), getY(piece[0]) - 1);
                    moveRectangle(getX(piece[0]) + 1, getY(piece[0]) + 1, getX(piece[0]) - 1, getY(piece[0]) + 1);
                    orientation = 2
                }
            } else if (orientation === 2) {
                if (isEmpty(getX(piece[0]) + 1, getY(piece[0])) && isEmpty(getX(piece[0]) - 1, getY(piece[0])) && isEmpty(getX(piece[0]) - 1, getY(piece[0]) - 1)) {
                    moveRectangle(getX(piece[0]), getY(piece[0]) + 1, getX(piece[0]) + 1, getY(piece[0]));
                    moveRectangle(getX(piece[0]), getY(piece[0]) - 1, getX(piece[0]) - 1, getY(piece[0]));
                    moveRectangle(getX(piece[0]) - 1, getY(piece[0]) + 1, getX(piece[0]) - 1, getY(piece[0]) - 1);
                    orientation = 3
                }
            } else if (orientation === 3) {
                if (isEmpty(getX(piece[0]), getY(piece[0]) + 1) && isEmpty(getX(piece[0]), getY(piece[0]) - 1) && isEmpty(getX(piece[0]) + 1, getY(piece[0]) - 1)) {
                    moveRectangle(getX(piece[0]) + 1, getY(piece[0]), getX(piece[0]), getY(piece[0]) + 1);
                    moveRectangle(getX(piece[0]) - 1, getY(piece[0]), getX(piece[0]), getY(piece[0]) - 1);
                    moveRectangle(getX(piece[0]) - 1, getY(piece[0]) - 1, getX(piece[0]) + 1, getY(piece[0]) - 1);
                    orientation = 0
                }
            }
        }
        if (shape === 'l') {
            if (orientation === 0) {
                if (isEmpty(getX(piece[0]) + 1, getY(piece[0])) && isEmpty(getX(piece[0]) - 1, getY(piece[0])) && isEmpty(getX(piece[0]) + 1, getY(piece[0]) - 1)) {
                    moveRectangle(getX(piece[0]), getY(piece[0]) + 1, getX(piece[0]) + 1, getY(piece[0]));
                    moveRectangle(getX(piece[0]), getY(piece[0]) - 1, getX(piece[0]) - 1, getY(piece[0]));
                    moveRectangle(getX(piece[0]) - 1, getY(piece[0]) - 1, getX(piece[0]) + 1, getY(piece[0]) - 1);
                    orientation = 1
                }
            } else if (orientation === 1) {
                if (isEmpty(getX(piece[0]), getY(piece[0]) + 1) && isEmpty(getX(piece[0]), getY(piece[0]) - 1) && isEmpty(getX(piece[0]) + 1, getY(piece[0]) + 1)) {
                    moveRectangle(getX(piece[0]) + 1, getY(piece[0]), getX(piece[0]), getY(piece[0]) + 1);
                    moveRectangle(getX(piece[0]) - 1, getY(piece[0]), getX(piece[0]), getY(piece[0]) - 1);
                    moveRectangle(getX(piece[0]) + 1, getY(piece[0]) - 1, getX(piece[0]) + 1, getY(piece[0]) + 1);
                    orientation = 2
                }
            } else if (orientation === 2) {
                if (isEmpty(getX(piece[0]) + 1, getY(piece[0])) && isEmpty(getX(piece[0]) - 1, getY(piece[0])) && isEmpty(getX(piece[0]) - 1, getY(piece[0]) + 1)) {
                    moveRectangle(getX(piece[0]), getY(piece[0]) + 1, getX(piece[0]) + 1, getY(piece[0]));
                    moveRectangle(getX(piece[0]), getY(piece[0]) - 1, getX(piece[0]) - 1, getY(piece[0]));
                    moveRectangle(getX(piece[0]) + 1, getY(piece[0]) + 1, getX(piece[0]) - 1, getY(piece[0]) + 1);
                    orientation = 3
                }
            } else if (orientation === 3) {
                if (isEmpty(getX(piece[0]), getY(piece[0]) + 1) && isEmpty(getX(piece[0]), getY(piece[0]) - 1) && isEmpty(getX(piece[0]) - 1, getY(piece[0]) - 1)) {
                    moveRectangle(getX(piece[0]) + 1, getY(piece[0]), getX(piece[0]), getY(piece[0]) + 1);
                    moveRectangle(getX(piece[0]) - 1, getY(piece[0]), getX(piece[0]), getY(piece[0]) - 1);
                    moveRectangle(getX(piece[0]) - 1, getY(piece[0]) + 1, getX(piece[0]) - 1, getY(piece[0]) - 1);
                    orientation = 0
                }
            }
        }
    }

    function compareNumbers(a, b) {
        return a - b
    }

    function compareNumbersReverse(a, b) {
        return b - a
    }

    function moveLeft() {
        var coords = {};
        for (var i = 0; i < piece.length; ++i) {
            if (coords.hasOwnProperty(getY(piece[i]).toString())) {
                coords[getY(piece[i]).toString()].push(getX(piece[i]))
            } else {
                coords[getY(piece[i]).toString()] = new Array();
                coords[getY(piece[i]).toString()].push(getX(piece[i]))
            }
        }
        var empty = true;
        for (var key in coords) {
            if (coords.hasOwnProperty(key)) {
                coords[key].sort(compareNumbers);
                empty = isEmpty(coords[key][0] - 1, key);
                if (!empty) return
            }
        }
        if (empty) {
            for (var y in coords) {
                if (coords.hasOwnProperty(y)) {
                    for (var x in coords[y]) {
                        moveRectangle(coords[y][x], y, coords[y][x] - 1, y)
                    }
                }
            }
        }
    }

    function moveRight() {
        var coords = {};
        for (var i = 0; i < piece.length; ++i) {
            if (coords.hasOwnProperty(getY(piece[i]).toString())) {
                coords[getY(piece[i]).toString()].push(getX(piece[i]))
            } else {
                coords[getY(piece[i]).toString()] = new Array();
                coords[getY(piece[i]).toString()].push(getX(piece[i]))
            }
        }
        var empty = true;
        for (var key in coords) {
            if (coords.hasOwnProperty(key)) {
                coords[key].sort(compareNumbersReverse);
                empty = isEmpty(coords[key][0] + 1, key);
                if (!empty) return
            }
        }
        if (empty) {
            for (var y in coords) {
                if (coords.hasOwnProperty(y)) {
                    for (var x in coords[y]) {
                        moveRectangle(coords[y][x], y, coords[y][x] + 1, y)
                    }
                }
            }
        }
    }

    function drop() {
        var coords = {};
        for (var i = 0; i < piece.length; ++i) {
            if (coords.hasOwnProperty(getX(piece[i]).toString())) {
                coords[getX(piece[i]).toString()].push(getY(piece[i]))
            } else {
                coords[getX(piece[i]).toString()] = new Array();
                coords[getX(piece[i]).toString()].push(getY(piece[i]))
            }
        }
        var empty = true;
        for (var key in coords) {
            if (coords.hasOwnProperty(key)) {
                coords[key].sort(compareNumbersReverse);
                empty = isEmpty(key, coords[key][0] + 1);
                if (!empty) return false
            }
        }
        if (empty) {
            for (var x in coords) {
                if (coords.hasOwnProperty(x)) {
                    for (var y in coords[x]) {
                        moveRectangle(x, coords[x][y], x, coords[x][y] + 1)
                    }
                }
            }
        }
        return true
    }

    function checkClear() {
        var set = new Set();
        for (var i = 0; i < piece.length; ++i) {
            set.add(getY(piece[i]))
        }
        var clearedSet = new Set();
        for (let y of set) {
            var clear = true;
            for (var i = 0; i < grid[y].length; ++i) {
                if (typeof grid[y][i] === 'undefined') {
                    clear = false
                }
            }
            if (clear) clearedSet.add(y)
        }
        var clearedArray = new Array();
        for (let y of clearedSet) {
            for (var i = 0; i < grid[y].length; ++i) {
                stage.removeChild(grid[y][i]);
                grid[y][i] = undefined
            }
            clearedArray.push(y)
        }
        score += 100 * clearedArray.length;
        scoreString.text = score.toString();
        clearedArray.sort(compareNumbersReverse);
        for (var i = clearedArray[0]; i >= 0; --i) {
            for (var j = 0; j < grid[i].length; ++j) {
                if (!isEmpty(j, i)) {
                    moveRectangle(getX(grid[i][j]), getY(grid[i][j]), getX(grid[i][j]), getY(grid[i][j]) + clearedArray.length)
                }
            }
        }
    }
    window.addEventListener("keydown", function(e) {
        e.preventDefault();
        if (e.keyCode === 32) {
            rotatePiece()
        }
        if (e.keyCode === 37) {
            moveLeft()
        }
        if (e.keyCode === 38) {
            rotatePiece()
        }
        if (e.keyCode === 39) {
            moveRight()
        }
        if (e.keyCode === 40) {
            drop()
        }
        renderer.render(stage)
    });

    function animate() {
        var myTimer = setTimeout(animate, 1000);
        if (!drop()) {
            clearTimeout(myTimer);
            checkClear();
            newPiece(0xff0000);
            myTimer = setTimeout(animate, 1000)
        }
        renderer.render(stage)
    };

    function endgame() {
        cancelAnimationFrame(animate);
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
};