//Location setups
var connections=[];
var con = {};
con.from=0;
con.to=1;
con.dir=0;
con.methode = 'normal';
connections.push(con);

var con = {};
con.from=1;
con.to=0;
con.dir=2;
con.methode = 'normal';
connections.push(con);

var con = {};
con.from=1;
con.to=0;
con.dir=0;
con.methode = 'reverse';
connections.push(con);

var con = {};
con.from=0;
con.to=1;
con.dir=2;
con.methode = 'reverse';
connections.push(con);

//Switch photos

function showTour(place, direction) {
  var container = document.getElementById('container');
  console.log("showTour: " + place + ' ' + direction);
  var str = 'url("img/img' + place + '_'+ direction +'.jpg")';
  container.style.backgroundImage=str;
}

showTour(0, 0);

//Buttons Movements

var direction = 0;
var place = 0;

var forward = document.getElementById('forward');
var right = document.getElementById('right');
var backwards = document.getElementById('backwards');
var left = document.getElementById('left');

forward.addEventListener('click',goForward);

right.addEventListener('click',rechtsAf);

backwards.addEventListener('click', goBackwards);

left.addEventListener('click', goLeft);

// Movement functions

function goLeft(ev) {
  direction --;
  if(direction < 0) {
    direction=3;
  }
  showTour(place, direction);
}

function rechtsAf(ev) {
  direction ++;
  if (direction > 3) {
    direction = 0;
  }
  showTour(place, direction);
}

function goForward() {
  var found_connection=false;
  for (var i = 0; i < connections.length; i++) {
    var con = connections[i];
    console.log(con.from+"=="+place+" && "+con.dir+"=="+direction);
    if (con.from==place && con.dir==direction && con.methode == 'normal') {
      found_connection=true;
      place=con.to;
      showTour(place, direction);
    }
  }
  if( found_connection==false)
  {
    console.log("je kunt hier niet naar voren, "+place+","+direction+" alle connecties: "+JSON.stringify(connections));
  };
}

function goBackwards() {
  for (var i = 0; i < connections.length; i++) {
    var con = connections[i];
    if (con.from==place && con.dir==direction && con.methode == 'reverse') {
      place=con.to;
      console.log(con.from==1 + ' ' + con.dir==0);
      console.log(place);
      showTour(place, direction);
    }
  }
}
