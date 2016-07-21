// Segédfüggvények armadája
function $(element){
  return document.querySelector(element);
}

function $$(element){
  return document.querySelectorAll(element);
}

function kezelotRegisztral(elem, tipus, kezelo) {
  //Szabványos módszer
  if (elem.addEventListener) {
    elem.addEventListener(tipus, kezelo, false);
  }
  //Microsoft módszer
  else if (elem.attachEvent) {
    elem.attachEvent('on' + tipus, function () {
      return kezelo.call(elem, window.event);
    });
  }
  //Tradicionális módszer
  else {
    elem['on' + tipus] = kezelo;
  }
}

function delegate(parentSelector, type, selector, fn) {

  function delegatedFunction(e) {
    var target = e.target;

    while (target && !target.matches(selector)) {
      if (target === parent) {
        return;
      }
      target = target.parentNode;
    }
    e.delegatedTarget = target;
    return fn.call(target, e);
  }

  var parent = $(parentSelector);
  kezelotRegisztral(parent, type, delegatedFunction);
}


function init() {
	$('#UjJatek').addEventListener('click', ujJatek, false);
	document.addEventListener('keydown',fordul,false);
}

window.addEventListener('load', init, false);

function veletlen(n) {
	return Math.floor(Math.random()*n);
}

var targyPoz = [];
var vege;
var hossz = [];
var n;
var m;
var t;
var pozX;
var pozY;
var irany;
var tukor;
var count;
var sebesseg;
var novekszik;
var tekercsSzin = "#a1a112";
var palyaSzin = "#004d00";
var sarkanySzin = "#295629";
var tekercs;
var fordul;
var vanTekercs;

function ujJatek(e) {
	while(targyPoz.length > 0 ){
		targyPoz.pop();
	}
	while(hossz.length > 0){
		hossz.pop();
	}
	
	n = parseInt( $('#Szelesseg').value, 10 );
	console.log(n);
	m = parseInt( $('#Magassag').value, 10 );
	t = parseInt( $('#Terept').value, 10 );
	vanTekercs = false;
	tukor = false;
	var ky = Math.floor(m/2);
	var kezdo = {x:0, y:ky};
	hossz.push(kezdo);
	pozX = 0;
	pozY = ky;
	count = 0;
	novekszik = false;
	sebesseg = 350;
	irany = 6;
	fordul = false;
	
	$('#Tekercs').innerHTML = '';
	
	for(var i = 0; i<t; ++i){
		var tmpX = veletlen(n);
		var tmpY = veletlen(m);
		while(vanOttTargy(tmpX,tmpY) || (kezdo.x === tmpX && kezdo.y === tmpY) || (kezdo.x+1 === tmpX && kezdo.y === tmpY)){
			tmpX = veletlen(n);
			tmpY = veletlen(m);
		}
		var tmp = {x: tmpX, y: tmpY};
		targyPoz.push(tmp);
	}
	
	vege = false;
	
	if(n < 1 || m < 1 || t < 0){
		$('#Error').innerHTML = "A pálya magasságának és szélességének is minimum 1-nek kell lennie, és legalább 0 tereptárgynak kell lennie!";
	}else{
		$('#Error').innerHTML = "";
		$('#Palya').innerHTML = genTable(n,m);
		halad();
	}
}


function genTable(n,m) {
	var s = '';
	for (var i = 0; i < m; i++) {
		s += '<tr>';
		for (var j = 0; j < n; j++) {
			if(vanOttTargy(j,i)){
				s += '<td bgcolor="#4d1300"></td>';
			}else{
				s += '<td bgcolor="#004d00"></td>';
			}
			
		}
		s += '</tr>';
	}
	return s;
}


function vanOttTargy(n,m){
	for(var i = 0; i<targyPoz.length; ++i){
		if(targyPoz[i].x === n && targyPoz[i].y === m){
			return true;
		}
	}
	return false;
}

function farkabaHarap(n,m){
	if(hossz.length > 1){
		for(var i = 0; i<hossz.length; ++i){
			if(hossz[i].x === n && hossz[i].y === m){
				return true;
			}
		}
	}
	return false;
}


function fordul(e){
	var table = document.getElementById("Palya");
	var row = table.getElementsByTagName("tr");
	if(vege){
		return;
	}else if(e.keyCode === 38){//fel
		if(irany === 4 || irany === 6 || hossz.length === 1){
			if(tukor){
				irany = 2;
			}else{
				irany = 8;
			}
		}
	}else if(e.keyCode === 40){//le
		if(irany === 4 || irany === 6 || hossz.length === 1){
			if(tukor){
				irany = 8;
			}else{
				irany = 2;
			}
		}
	}else if(e.keyCode === 39){//jobbra
		if(irany === 8 || irany === 2 || hossz.length === 1){
			if(tukor){
				irany = 4;
			}else{
				irany = 6;
			}
		}
	}else if(e.keyCode ===37){//balra
		if(irany === 8 || irany === 2 || hossz.length === 1){
			if(tukor){
				irany = 6;
			}else{
				irany = 4;
			}
		}
	}
}


function halad(){

	var table = document.getElementById("Palya");
	var row = table.getElementsByTagName("tr");
	if(!vanTekercs){
		tekercsetElhelyez();
	}
	if(vege){
		return;
	}else if(irany === 6){
		if(pozX < n-1 && !vanOttTargy(pozX+1,pozY) && !farkabaHarap(pozX+1,pozY)){
			++pozX;
			tekercsetMegszerez(pozX,pozY);
			hosszSzab(pozX, pozY)
			row[pozY].cells[pozX].style.backgroundColor = sarkanySzin;
			setTimeout(halad,sebesseg);
		}else{
			vege = true;
		}
	}else if(irany === 2){
		if(pozY < m-1 && !vanOttTargy(pozX,pozY+1) && !farkabaHarap(pozX,pozY+1)){
			++pozY;
			tekercsetMegszerez(pozX,pozY);
			hosszSzab(pozX, pozY)
			row[pozY].cells[pozX].style.backgroundColor = sarkanySzin;
			setTimeout(halad,sebesseg);
		}else{
			vege = true;
		}
	}else if(irany === 4){
		if(pozX > 0 && !vanOttTargy(pozX-1,pozY) && !farkabaHarap(pozX-1,pozY)){
			--pozX;
			tekercsetMegszerez(pozX,pozY);
			hosszSzab(pozX, pozY)
			row[pozY].cells[pozX].style.backgroundColor = sarkanySzin;
			setTimeout(halad,sebesseg);
		}else{
			vege = true;
		}
	}else if(irany === 8){
		if(pozY > 0 && !vanOttTargy(pozX,pozY-1) && !farkabaHarap(pozX,pozY-1)){
			--pozY;
			tekercsetMegszerez(pozX,pozY);
			hosszSzab(pozX, pozY)
			row[pozY].cells[pozX].style.backgroundColor = sarkanySzin;
			setTimeout(halad,sebesseg);
		}else{
			vege = true;
		}
	}
	if(fordul){
		row[tekercs.y].cells[tekercs.x].style.backgroundColor = palyaSzin;
		fordul = false;
	}
	
	$('#Pont').innerHTML = hossz.length;
	
}

function hosszSzab(pozX, pozY){
	var table = document.getElementById("Palya");
	var row = table.getElementsByTagName("tr");
	novekszik = (count > 0);
	if(!novekszik){
		var tmp = hossz.shift();
		row[tmp.y].cells[tmp.x].style.backgroundColor = palyaSzin;
	}
	if(novekszik){
		count--;
	}	
	var hozzaAd = {x: pozX, y: pozY};
	hossz.push(hozzaAd);
	
	
}


var tekercsTipus;
function tekercsetElhelyez(){
	var table = document.getElementById("Palya");
	var row = table.getElementsByTagName("tr");
	var tx = veletlen(n);
	var ty = veletlen(m);
	while(vanOttTargy(tx,ty) || farkabaHarap(tx,ty)){
		tx = veletlen(n);
		ty = veletlen(m);
	}
	tekercs = {x: tx, y: ty};
	tekercsTipus = Math.floor(Math.random()*100);
	row[ty].cells[tx].style.backgroundColor = tekercsSzin;
	vanTekercs = true;
	
}
function tekercsetMegszerez(x,y){
	if(tekercs.x === x && tekercs.y === y){
		tukor = false;
		sebesseg = 350;
		if(tekercsTipus <= 80){
			count += 4;
			$('#Tekercs').innerHTML = 'Bölcsesség tekercs';
		}else if(tekercsTipus > 80 && tekercsTipus <= 84){
			tukor = true;
			$('#Tekercs').innerHTML = 'Tükör tekercs';
		}else if(tekercsTipus >84 && tekercsTipus <= 88){
			mohosagTekercs();
		}else if(tekercsTipus > 88 && tekercsTipus <= 92){
			lustasagTekercs();
		}else if(tekercsTipus >92 && tekercsTipus <= 96){
			count += 10;
			$('#Tekercs').innerHTML = 'Falánkság tekercs';
		}else if(tekercsTipus > 96){
			forditasTekercs();
		}
		vanTekercs = false;
	}
}


var tmp = sebesseg;
function mohosagTekercs(){
	tmp = sebesseg;
	sebesseg = sebesseg/(3/2);
	$('#Tekercs').innerHTML = 'Mohóság tekercs';
	setTimeout(sebessegVissza,5000);
}


function lustasagTekercs(){
	tmp = sebesseg;
	sebesseg = sebesseg*(3/2);
	$('#Tekercs').innerHTML = 'Lustaság tekercs';
	setTimeout(sebessegVissza,5000);
}

function sebessegVissza(){
	sebesseg = tmp;
	$('#Tekercs').innerHTML = '';
}


function forditasTekercs(){
	
	hossz.reverse();
	var ind = hossz.length-1;
	var table = document.getElementById("Palya");
	var row = table.getElementsByTagName("tr");
		
	pozX = hossz[ind].x;
	pozY = hossz[ind].y;
	if(hossz.length >1){
		if(hossz[ind].x === hossz[ind-1].x){
			if((hossz[ind].y - hossz[ind-1].y) > 0){
				if(pozY < m-1){
					irany = 2;
					++pozY;
					hosszSzab(pozX, pozY)			
					
				}else{
					vege = true;
				}
			} else{
				if(pozY > 0){
					irany = 8;
					--pozY;
					hosszSzab(pozX, pozY)
					
				}else{
					vege = true;
				}
			}
		}
		if(hossz[ind].y === hossz[ind-1].y){
			if((hossz[ind].x - hossz[ind-1].x) > 0){
				if(pozX < n-1){
					irany = 6;
					++pozX;
					hosszSzab(pozX, pozY)
					
				}else{
					vege = true;
				}
			}else{
				if(pozX > 0){
					irany = 4;
					--pozX;
					hosszSzab(pozX, pozY)
					
				}else{
					vege = true;
				}
			}
		}
	}else{
		if(irany === 4) {
			irany = 6;
		}else if(irany === 6) {
			irany = 4;
		}else if(irany === 8) {
			irany = 2;
		}else if(irany === 2) {
			irany = 8;
		}
	}
	fordul = true;
	$('#Tekercs').innerHTML = 'Fordítás tekercs';
	
}







