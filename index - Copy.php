<? include "config.php";?>

<html>

<body style='padding:0; border:0; margin:0;' bgcolor=black  onKeyDown="bdown(event);"  onKeyUp="bup(event);">
<canvas width=1000px height=600px onmousewheel="MouseScroll(event);" style='float:left;width:1000xp;height:600px;' id='mycan' name='mycan'  onMouseDown="mdown(event);"  onMouseMove="mmove(event);" onMouseUp="mup(event);"></canvas>

<div id='but1' style='background-color:red; text-align:center; padding-top:3px; font-size:24px; font-weight:bold; color:black; width:35px; height:30px; position:absolute; left:10px; top:10px;'>1</div>
<div id='but2'  style='background-color:white; text-align:center; padding-top:3px; font-size:24px; font-weight:bold; color:black; width:35px; height:30px; position:absolute; left:50px; top:10px;'>2</div>
<div id='but3'  style='background-color:white; text-align:center; padding-top:3px; font-size:24px; font-weight:bold; color:black; width:35px; height:30px; position:absolute; left:90px; top:10px;'>3</div>


<div id='infodiv' style='color:white; border:1px solid green;'></div>
<div id='infodiv2' style='color:white; border:1px solid red; width:200px;'></div>
</body>

<?

$r=mysql_query("SELECT * FROM users WHERE curmap='1' ORDER BY id ASC") or die(mysql_error());
$maxbots=mysql_num_rows($r);

$myid=1;

if (isset($_GET["myid"])){$myid=$_GET["myid"];}

echo "<script>var myid=$myid;
var maxrobo=$maxbots;
</script>";

?>

<script>


var robox= new Array();
var roboy= new Array();
var robrot=new Array();
var robx= new Array();
var roby= new Array();
var robdir=new Array();
var robvx=new Array();
var robvy=new Array();
var robside=new Array();

var robchsum=new Array();
var robsreqed=0;

robside[0]=1;
robx[0]=150;
roby[0]=500;
robox[0]=15;
roboy[0]=50;
robrot[0]=0;
robvx[0]=0;
robvy[0]=0;
robdir[0]=0;
robchsum[0]=0;


var myrob=0;

var mousex;;
var mousey;

var mfx;
var mfy;

var misdown=0;

function mdown(event)
{
  var x = event.clientX;
  var y = event.clientY;
	mousex=x;
	mousey=y;

	mfx=parseInt((x+(camerax/10)*curzoom)/curzoom);
	mfy=parseInt((600-y+(cameray/10)*curzoom)/curzoom)+1;
//	document.getElementById("infodiv2").innerHTML="mfx: "+mfx+" mfy: "+mfy;
		
	var realx=(x+(camerax/10)*curzoom)*10/curzoom;
	var realy=(600-y+(cameray/10)*curzoom)*10/curzoom;

	gunangle=Math.atan( (robx[myrob]-realx) / (roby[myrob]-realy) );
	if (realy<=roby[myrob] && realx>=robx[myrob])
		{
		gunangle=3.14+gunangle;
					robdir[myrob]=1;
		}
	else if (realy<=roby[myrob] && realx<=robx[myrob])
		{
		gunangle=3.14+gunangle;
		robdir[myrob]=0;
		}
	else if (realy>=roby[myrob] && realx<=robx[myrob])
		{
		gunangle=6.28+gunangle;
			robdir[myrob]=0;
		}
	else
		{
		robdir[myrob]=1;
		}

			if (curweapon==2)
			{
			if (gunangle<1)
				{gunangle=1;}
			else if (gunangle>=2.10 && gunangle<=3.14)
				{gunangle=2.10;}
			else if (gunangle<=4 && gunangle>=3.14)
				{gunangle=4;}
			else if (gunangle>=6.10 && gunangle<=6.28)
				{gunangle=6.10;}
			gunangle+=robrot[myrob];
			fire_gun();
			}

misdown=1;
}

var gunangle=0;

function mmove(event)
{

	  var x = event.clientX;
  var y = event.clientY;
	mousex=x;
	mousey=y;

if (misdown==1)
	{
		
	var realx=(x+(camerax/10)*curzoom)*10/curzoom;
	var realy=(600-y+(cameray/10)*curzoom)*10/curzoom;

	gunangle=Math.atan( (robx[myrob]-realx) / (roby[myrob]-realy) );
	if (realy<=roby[myrob] && realx>=robx[myrob])
		{
		gunangle=3.14+gunangle;
		robdir[myrob]=1;
		}
	else if (realy<=roby[myrob] && realx<=robx[myrob])
		{
		gunangle=3.14+gunangle;
		robdir[myrob]=0;
		}
	else if (realy>=roby[myrob] && realx<=robx[myrob])
		{
		gunangle=6.28+gunangle;
		robdir[myrob]=0;
		}
	else
		{
		robdir[myrob]=1;
		}

		if (curweapon==2)
			{
			if (gunangle<1)
				{gunangle=1;}
			else if (gunangle>=2.10 && gunangle<=3.14)
				{gunangle=2.10;}
			else if (gunangle<=4 && gunangle>=3.14)
				{gunangle=4;}
			else if (gunangle>=6.10 && gunangle<=6.28)
				{gunangle=6.10;}
						gunangle+=robrot[myrob];
			fire_gun();
			}

	}

	mfx=parseInt((x+(camerax/10)*curzoom)/curzoom);
	mfy=parseInt((600-y+(cameray/10)*curzoom)/curzoom)+1;


}

var bullet=new Array();

var bux=new Array();
var buy=new Array();


var buex=new Array();
var buey=new Array();

var butype=new Array();
var bua=new Array();
var bualive=new Array();
var bulife=new Array();


var bcount=0;

function fire_gun()
	{
	var sdvig;
	bua[bcount]=gunangle+ ( Math.random()*0.1-0.05);
	rdir=1;
	for (i=0;i<items[myrob].length ;i++ )
		{
		if (items[myrob][i][0]==4)
			{
			if (robdir[myrob]==1)
				{rdir=-1;}
			else {rdir=1;}

			if (robrot[myrob]<0 || robrot[myrob]>0)
				{sdvig=curzoom/2;}
			else {sdvig=0;}
			bux[bcount]=robx[myrob]
			buy[bcount]=roby[myrob]

			bux[bcount]+=items[myrob][i][1]*10*rdir+5;
			buy[bcount]+=items[myrob][i][2]*10-6;
		
			
			buex[bcount]=bux[bcount]+Math.sin(bua[bcount])*200;
			buey[bcount]=buy[bcount]+Math.cos(bua[bcount])*200;
		
			
			document.getElementById("infodiv").innerHTML=robx[myrob]+ " - " + roby[myrob]+ " = " +bux[bcount]+" - " +buy[bcount];

			i=100;
			}
		}
		bulife[bcount]=16;
	bualive[bcount]=1;
bcount++;


	}

function mup(event)
{
misdown=0;  DrujbaSound=0; myDrujba.pause();myGun.pause();
}
document.getElementById("mycan").addEventListener("DOMMouseScroll", MouseScroll, false);
var can=document.getElementById("mycan");
var ctx=can.getContext("2d");

var mica=new Array();

mica[1]=new Image();
mica[1].src="gnd.png";

mica[2]=new Image();
mica[2].src="iron.png";

mica[3]=new Image();
mica[3].src="oil.png";



var mica_grass=new Image();
mica_grass.src="gnd_grass.png";

var mica_left=new Image();
mica_left.src="gnd_left.png";
var mica_right=new Image();
mica_right.src="gnd_right.png";
var mica_vishka=new Image();
mica_vishka.src="vishka.png";

var myZrav = new Audio('traqtori.mp3'); 
myZrav.addEventListener('ended', function() {
    this.currentTime = 0;
    this.play();
}, false);


var xeli_left=new Image();
xeli_left.src="circular.png";



var gatling=new Image();
gatling.src="gatling.png";

var xeli_right=new Image();
xeli_right.src="circular.png";


var myDrujba = new Audio('drujba_tux.mp3'); 
myDrujba.addEventListener('ended', function() {
    this.currentTime = 0;
    this.play();
}, false);
myDrujba.volume=0.3;



var myGun = new Audio('gun.mp3'); 
myGun.addEventListener('ended', function() {
    this.currentTime = 0;
    this.play();
}, false);
myGun.volume=0.3;

var starterS=0;

var myQoqv = new Audio('daqoqva.mp3'); 

myQoqv.volume=1;

var myMusic = new Audio('8bit.wav'); 
myMusic.addEventListener('ended', function() {
    this.currentTime = 0;
    this.play();
}, false);
myMusic.volume=0.2;
//myMusic.play();


var parts=new Array();
var alter=new Array();

parts[0]=new Array();
parts[0][0]=new Image();
parts[0][0].src="tavi_left.png";
parts[0][1]=new Image();
parts[0][1].src="tavi_right.png";

alter[0]=new Array();
alter[0][0]=new Image();
alter[0][0].src="blue_head_left.png";
alter[0][1]=new Image();
alter[0][1].src="blue_head_right.png";


parts[0]=new Array();
parts[0][0]=new Image();
parts[0][0].src="tavi_left.png";
parts[0][1]=new Image();
parts[0][1].src="tavi_right.png";

parts[1]=new Array();
parts[1][0]=new Image();
parts[1][0].src="track_left.png";
parts[1][1]=new Image();
parts[1][1].src="track_right.png";

parts[2]=new Array();
parts[2][0]=new Image();
parts[2][0].src="springs_left.png";
parts[2][1]=new Image();
parts[2][1].src="springs_right.png";


parts[4]=new Array();
parts[4][0]=new Image();
parts[4][0].src="box_left.png";
parts[4][1]=new Image();
parts[4][1].src="box_right.png";


parts[5]=new Array();
parts[5][0]=new Image();
parts[5][0].src="box_left.png";
parts[5][1]=new Image();
parts[5][1].src="box_right.png";

var foni=new Image();
foni.src="cat.jpg";


var curzoom=25;

var RKey=0;
var LKey=0;

function bdown(event)
	{
	var allow=1;


	if (event.keyCode==68 && RKey==0)
		{
		RKey=1;
		starterS=10;
		myQoqv.play();
		}
	else if (event.keyCode==65  && LKey==0)
		{
		LKey=1;
				starterS=10;
			myQoqv.play();
		}


	
	else if (event.keyCode==83)
		{
		if (cameray>0)
			{
			cameray=cameray-10;
			}
		}
	
	else if (event.keyCode==87)
		{
		if (robvy[myrob]==0)
			{

			robvy[myrob]=12;
			roby[myrob]=		roby[myrob]+10;
			}
		}
DrawWorld(0,0);
	}

var curweapon=1;

function bup(event)
	{
	
	if (event.keyCode==68)
		{
		RKey=0;
		}
	else if (event.keyCode==65)
		{
		LKey=0;
		}
	else if (event.keyCode==49)
		{
		curweapon=1;
		document.getElementById("but2").style.backgroundColor="white";
		document.getElementById("but3").style.backgroundColor="white";
		document.getElementById("but1").style.backgroundColor="red";
		}
	else if (event.keyCode==50)
		{
		curweapon=2;
				document.getElementById("but1").style.backgroundColor="white";
		document.getElementById("but3").style.backgroundColor="white";
				document.getElementById("but2").style.backgroundColor="red";
		}
	else if (event.keyCode==51)
		{
		curweapon=3;
				document.getElementById("but2").style.backgroundColor="white";
		document.getElementById("but1").style.backgroundColor="white";
				document.getElementById("but3").style.backgroundColor="red";
		}
	else if (event.keyCode==69)
		{
		document.location.href="http://design.ge/bigbang/components.php?myid="+myid;
		}
	}




function update_data()
	{		
	if(gamehttp.readyState == 4)
		{
		mr=gamehttp.responseText;
		if (mr!="")
			{
			var a=new Array();

			a=mr.split("|");
			maxrobo=a[0];
			var b=new Array();

			b=a[1].split("[");

var kc=new Array();
			var c=new Array();
			
			for (ii=0;ii<b.length-1;ii++)
				{
				var kc=b[ii].split(">");
				c=kc[0].split(";");
				
				if (robsreqed==0 ||  myrob!=ii)
					{
					if (c[0]==myid)			{myrob=ii;	}
					robside[ii]=parseInt(c[1]);
					
					robx[ii]=parseInt(c[3]);
					roby[ii]=parseInt(c[4]);
					robox[ii]=parseInt(robx[ii]/10);
					roboy[ii]=parseInt(roby[ii]/10);
						

					robrot[ii]=parseFloat(c[6]);

					robvx[ii]=parseInt(c[8]);
					robvy[ii]=parseInt(c[9]);
					robdir[ii]=parseInt(c[5]);
					robchsum[ii]=c[7];
					items[ii]=new Array();
	// 0 -type, 1-x, 2-y, 3-angle
					c=kc[1].split("]");
					var d=new Array();
					for (iii=0;iii<c.length-1 ;iii++ )
						{
						d=c[iii].split(";");
						items[ii][iii]=new Array();
						items[ii][iii][0]=d[0];
						items[ii][iii][1]=d[1];
						items[ii][iii][2]=d[2];
						items[ii][iii][3]=d[3];
						}

					

					

					}

				}
			//bot_chsum=a[2];

			if (a[2]!=last_chsum)
				{req_map();			}
			robsreqed=1;

			}
		}
	}


function update_map()
	{		
	if(maphttp.readyState == 4)
		{
		mr=maphttp.responseText;
		if (mr!="")
			{
			var a=new Array();
			var b=new Array();
			a=mr.split("|");

			if (mapsize!=a[0])
				{

				for (i=0;i<a[0]*2 ;i++ )
					{
					svetebi[i]=new Array();
					kubh[i]=new Array();
					frot[i]=new Array();
					}

				}
			

			b=a[1].split("]");
			var c=new Array();
			var d=new Array();
			for (i=0;i<b.length-1 ;i++ )
				{
				c=b[i].split(":");
				svid=c[0];
				d=c[1].split(";");
				for (ii=0;ii<70 ;ii++ )
					{
					svetebi[svid][ii]=d[ii];
					}
				
				d=c[2].split(";");
				for (ii=0;ii<70 ;ii++ )
					{
					kubh[svid][ii]=d[ii];
					}
				}

			last_chsum=a[2];
			DrawWorld();

			if (mapsize!=a[0])
				{
				mapsize=a[0];
			
				fizika();
				}
			}
		}
	}

var gamehttp;
if (window.XMLHttpRequest) {gamehttp=new XMLHttpRequest();}
else if (window.ActiveXObject) {gamehttp=new ActiveXObject('Microsoft.XMLHTTP');}
else {alert('Your browser does not support XMLHTTP!');}
gamehttp.onreadystatechange=update_data;


var maphttp;
if (window.XMLHttpRequest) {maphttp=new XMLHttpRequest();}
else if (window.ActiveXObject) {maphttp=new ActiveXObject('Microsoft.XMLHTTP');}
else {alert('Your browser does not support XMLHTTP!');}
maphttp.onreadystatechange=update_map;

var svetebi = new Array();
var kubh=new Array();
var sglaj=3;
var mina=1;

var frot=new Array();


var camerax=0;
var cameray=150;

var mapsize=0;
var minheight=20;
var raod=parseInt(Math.random()*50);
var cina=raod;
var changeval=parseInt(Math.random()*3)-1;

  function MouseScroll (event)
	  {
            var rolled = 0;
            if ('wheelDelta' in event) {
                rolled = event.wheelDelta;
            }
            else {  // Firefox
                    // The measurement units of the detail and wheelDelta properties are different.
                rolled = -40 * event.detail;
            }
            
		if (rolled>0 && curzoom<50)
			{
			curzoom++;
			}
		else if (rolled<0 && curzoom>10)
			{
			curzoom=curzoom-1;
			}
	DrawWorld(0,0);
        }
var last_chsum=-1;

//DrawWorld(0,0);
req_map();

function req_map()
	{

	url="http://design.ge/bigbang/req_map.php?curmap=1&chsum="+last_chsum;

	maphttp.open('GET',url,true);
	maphttp.send(null);
	
	
	}

function dig_field(mx, my)
	{
	url="http://design.ge/bigbang/req_map.php?curmap=1&dig=1&x="+mx+"&y="+my+"&chsum="+last_chsum;
	maphttp.open('GET',url,true);
	maphttp.send(null);
	}

var bot_chsum=-1;
function req_bots()
	{
	if (robsreqed==0)
		{
		url="http://design.ge/bigbang/req_bots.php?curmap=1&chsum="+bot_chsum;
		}
	else
		{
		url="http://design.ge/bigbang/req_bots.php?curmap=1&chsum="+bot_chsum+"&myid="+myid+"&mx="+robx[myrob]+"&my="+roby[myrob]+"&ma="+robrot[myrob]+"&mdir="+robdir[myrob]+"&vx="+robvx[myrob]+"&vy="+robvy[myrob];

		}


	gamehttp.open('GET',url,true);
	gamehttp.send(null);
	}


function Collideme(nx, ny)
	{
	var cx, cy;
	var cxo, cyo;
	var adx, ady;

	

	var colided=0;
	for (i=1;i<items[myrob].length ;i++ )
		{
		
		cx=nx+Math.cos(robrot[myrob])*10*items[myrob][i][1]+Math.sin(robrot[myrob])*9*items[myrob][i][2];
		cy=ny+Math.sin(robrot[myrob])*10*items[myrob][i][1]+Math.cos(robrot[myrob])*9*items[myrob][i][2];
		
		

		cxo=parseInt(cx/10);
		cyo=parseInt(cy/10);

		var c;

	var dist;
	
		for (ii=cxo-2;ii<=cxo+2 ; ii++)
			{
			for (iii=cyo-2;iii<=cyo+2 ;iii++ )
				{
				if (svetebi[ii][iii]>0)
					{

		
					if (frot[ii][iii]==0)
						{dist=10;}
					if (frot[ii][iii]==1)
						{dist=7;}
					if (frot[ii][iii]==2)
						{dist=7;}
				
					c=parseInt(Math.sqrt( Math.pow ( (cx-(ii*10)),2) +  Math.pow ( (cy-(iii*10)),2) ))

					if (c<=dist)
						{
	
						colided=1;

						return false;

						i=1000;
						ii=1000;
						iii=1000;
						}
					}
				}
			}


		}
	//	document.getElementById("infodiv2").innerHTML=colided;
	if (colided==0)
		{return true; 					}
else
		{	 return false; 					}


	

	}

var ZravSound=0;
var DrujbaSound=0;
var nakopitel=0;
// ------------------------------------------------------------------------------------------- fizika
function fizika()
	{
	
		req_bots();
	
	

	if (robsreqed==1)
		{
		
		if (RKey==1)
			{
			if (robvx[myrob]<3)
				{robvx[myrob]+=2;
			robdir[myrob]=1;
				}
			}
		
		if (LKey==1)
			{
		
			if (robvx[myrob]>-3)
				{robvx[myrob]-=2;
					robdir[myrob]=0;
				}
			}

		if (misdown==1)
			{
			if (DrujbaSound==0)
				{
				
				DrujbaSound=1; 
				if (curweapon==1)
					{
					myDrujba.play();	
					}
				else if (curweapon==2)
					{
					myGun.play();	
					}

				}
//				document.getElementById("infodiv").innerHTML=mfx+" - " + mfy + " = "+robox[myrob]+ " - " + roboy[myrob];
			if (svetebi[mfx][mfy]>0)
				{

				if (mfx<=(robox[myrob]+2) && mfx>=(robox[myrob]-1) && mfy<=(roboy[myrob]+2) && mfy>=(roboy[myrob]-1))
					{
					kubh[mfx][mfy]=kubh[mfx][mfy]-10;
					if (kubh[mfx][mfy]<=0)
						{
						dig_field(mfx, mfy);
						}
					}
				}
			}
		else if (DrujbaSound==1)
			{DrujbaSound=0;myGun.pause(); myDrujba.pause(); 
			}


		if (robvy[myrob]>-9)
			{
			robvy[myrob]=	robvy[myrob]-1;
			}

	var mozraoba=0;


		if (robvx[myrob]>0)
			{robvx[myrob]=robvx[myrob]-1; mozraoba=1;	}
		else if (robvx[myrob]<0)
			{robvx[myrob]=robvx[myrob]+1;	mozraoba=1;}

		var nx, ny;

		ny=roby[myrob]+robvy[myrob];
		nx=robx[myrob]+robvx[myrob];

		if (Collideme(nx, ny))
			{
	
			roby[myrob]=ny;
			robx[myrob]=nx;

			}


		if (mozraoba==1 && ZravSound==0)
			{
			if (starterS==0)
				{	
				ZravSound=1;myZrav.play(); 
				}
			else
				{starterS=starterS-1;}
			}
		else if (mozraoba==0 && ZravSound==1)
			{ZravSound=0;myZrav.pause(); 	}


//	document.getElementById("infodiv").innerHTML=roby[myrob] + " V:"+robvy[myrob];
		xa1=robx[myrob];
		ya1=roby[myrob];

		xa2=robx[myrob]+10;
		ya2=roby[myrob];

		x1=parseInt(robx[myrob]/10);
		y1=parseInt(roby[myrob]/10);

		x2=parseInt((robx[myrob]+10)/10);
		y2=parseInt(roby[myrob]/10);
;
	

	var ertimainc=0;
	for (i=y1+1;i>y1-2 ;i-- )
		{
		
		if (svetebi[x1][i]>0)
			{
			if ( frot[x1][i]==0)
				{
				ya1=i*10+10;
				}
			else if ( frot[x1][i]==1)
				{
				xc=xa1-x1*10;
				ya1=i*10+xc;
				}
			else if ( frot[x1][i]==2)
				{
				xc=xa1-x1*10;
				ya1=i*10+(10-xc);
				}
			robvy[myrob]=0;
			i=y1-2;
			ertimainc=1;
			}
		}

	var orimainc=0;
	for (i=y2+1;i>y2-2 ;i-- )
		{
		if (svetebi[x2][i]>0 )
			{
			if ( frot[x2][i]==0)
				{
				ya2=i*10+10;

				}
			else if ( frot[x2][i]==1)
				{
				xc=xa2-x2*10;
				ya2=i*10+xc;
				}
			else if ( frot[x2][i]==2)
				{
				xc=xa2-x2*10;
				ya2=i*10+(10-xc);
				}
			robvy[myrob]=0;
			i=y2-2;
			orimainc=1;
			}
		}

	if (ertimainc==0 && orimainc==1)
		{	
		ya1=ya2-10;
		}
	else if (ertimainc==1 && orimainc==0)
		{	
		ya2=ya1-10;
		}
	else if (ertimainc==1 && orimainc==1)
		{
		if ((ya2-ya1)>10)
			{
			ya1=ya1-1;
			ya2=ya1+9;
			}
		else 	if ((ya1-ya2)>10)
			{
				ya2=ya2-1;
			ya1=ya2+9;
			}
		}
//		document.getElementById("infodiv").innerHTML=ertimainc+" - " +orimainc+ " = "+ ya1 + " - "+ya2
//	document.getElementById("infodiv").innerHTML+=" y1: "+ya1+" y2: "+ya2+" my1: "+x1 + " my2: "+x2+ " cam:"+camerax;

		roby[myrob]=parseInt((ya1+ya2)/2);
		roboy[myrob]=parseInt((roby[myrob])/10);
	robox[myrob]=parseInt((robx[myrob])/10);

		if (robox[myrob]>(500/curzoom))
			{
			camerax=robx[myrob]-parseInt(500/curzoom)*10;
			}

		if (roboy[myrob]>(300/curzoom))
			{
			cameray=roby[myrob]-parseInt(300/curzoom)*10;
			}

		 if (ya1>ya2)
			{
			 robrot[myrob]=(ya1-ya2)*(0.785/10);
			}
		else  if (ya2>ya1)
			{
			 robrot[myrob]=-(ya2-ya1)*(0.785/10);
			}
		else
			{
			robrot[myrob]=0;
			}
		if (robsreqed==1)
			{
		



			DrawWorld(robox[myrob]-1, robox[myrob]+1);
			}
		}
	setTimeout("fizika()",30);
	}

var items=new Array();



function DrawWorld(segx1, segx2)
	{
		ctx.clearRect ( 0 , 0 , 1000 , 600 );
	if (segx1==0 && segx2==0)
		{
	
		can.width = can.width;

		ctx.drawImage(foni,0,0);

		segx1=parseInt(camerax/10);
		segx2=(parseInt(camerax/10)+parseInt(1000/curzoom)) ;
		}
	else
		{
	
			
		can.width = can.width;
		ctx.drawImage(foni,0,0);

		segx1=parseInt(camerax/10);
		segx2=(parseInt(camerax/10)+parseInt(1000/curzoom)) ;
		}
	for (i=segx1;i<=segx2+1;i++ )
		{
	
		for (ii=0;ii<70 ;ii++)
			{

			if ((i==0 || i==mapsize ) && svetebi[i][ii]>0)
				{
				ctx.drawImage(mica[svetebi[i][ii]],curzoom*i-(camerax/10)*curzoom,600-curzoom*ii+(cameray/10)*curzoom,curzoom,curzoom);
				}
			else if (svetebi[i][ii]>0)
				{
			
				if (svetebi[i-1][ii]==0 && svetebi[i+1][ii]>0 && svetebi[i][ii+1]==0 )
					{
					ctx.drawImage(mica_left,curzoom*i-(camerax/10)*curzoom,600-curzoom*ii+(cameray/10)*curzoom,curzoom,curzoom);
					frot[i][ii]=1;
					}
				else if (svetebi[i-1][ii]>0 && svetebi[i+1][ii]==0 && svetebi[i][ii+1]==0)
					{
					ctx.drawImage(mica_right,curzoom*i-(camerax/10)*curzoom,600-curzoom*ii+(cameray/10)*curzoom,curzoom,curzoom);
					frot[i][ii]=2;
					}
				else if (svetebi[i-1][ii]==0 && svetebi[i+1][ii]==0 && svetebi[i][ii+1]==0)
					{
					ctx.drawImage(mica_vishka,curzoom*i-(camerax/10)*curzoom,600-curzoom*ii+(cameray/10)*curzoom,curzoom,curzoom);
					frot[i][ii]=3;
					}
				else
					{
					if (svetebi[i][ii+1]==0)
						{
						ctx.drawImage(mica_grass,curzoom*i-(camerax/10)*curzoom,600-curzoom*ii+(cameray/10)*curzoom,curzoom,curzoom);
						}
					else
						{
						ctx.drawImage(mica[svetebi[i][ii]],curzoom*i-(camerax/10)*curzoom,600-curzoom*ii+(cameray/10)*curzoom,curzoom,curzoom);
										
						}
						frot[i][ii]=0;
					}
				}
			}
		}



	for (i=0;i<bcount ;i++ )
		{
		if (bualive[i]==1)
			{
			bulife[i]=bulife[i]-1;
			if (bulife[i]<=0)
				{
				bualive[i]=0;
				}
			 ctx.beginPath();
		  ctx.moveTo(curzoom*(bux[i]/10)-(camerax/10)*curzoom,  600-curzoom*(buy[i]/10)+(cameray/10)*curzoom);
		  ctx.lineTo(curzoom*(buex[i]/10)-(camerax/10)*curzoom+200, 600-curzoom*(buey[i]/10)+(cameray/10)*curzoom);
		  ctx.lineWidth = 3;

		  // set line color
		  ctx.strokeStyle = '#ff0000';
		  ctx.stroke();
			}
		}

	// ROBOTEBIS DAXATVA
	if (robsreqed==1)
		{
		var rdir=1;
		var sdvig=0;
		for (i=0;i<maxrobo ;i++ )
			{	
			if (robrot[i]<0 || robrot[i]>0)
				{sdvig=curzoom/2;}
			else {sdvig=0;}
			sdvig=0;
			ctx.save(); 
			 ctx.translate(curzoom*(robx[i]/10)-(camerax/10)*curzoom, 600-curzoom*(roby[i]/10)+(cameray/10)*curzoom+sdvig); 
			 
			ctx.translate(curzoom/2, curzoom); 
			ctx.rotate(robrot[i]); 
//		 document.getElementById("infodiv").innerHTML="";
if (robdir[i]==1)
	{rdir=-1;}
else {rdir=1;}

			for (ii=0;ii<items[i].length ;ii++ )
				{
//				document.getElementById("infodiv").innerHTML+=i+" - " + ii + " - " +items[i][ii][0]+  " = "+ items[i][ii][1] + " | "+ items[i][ii][2] + " ] " + robdir[i] +"<BR>";

				if (items[i][ii][0]==0 && robside[i]==2)
					{
					ctx.drawImage(alter[ items[i][ii][0] ][robdir[i]],-curzoom/2-items[i][ii][1]*curzoom*rdir, -curzoom-items[i][ii][2]*curzoom+curzoom/10,curzoom,curzoom);
					}
				else if (items[i][ii][0]==4)
					{
				
						ctx.drawImage(parts[ items[i][ii][0] ][robdir[i]],-curzoom/2-items[i][ii][1]*curzoom*rdir, -curzoom-items[i][ii][2]*curzoom+curzoom/10,curzoom,curzoom);
						ctx.translate(-curzoom/2-items[i][ii][1]*curzoom*rdir+curzoom/2, +curzoom/3-curzoom-items[i][ii][2]*curzoom+curzoom/10+4); 
						if (myrob==i && misdown==1 && curweapon==2)
							{
							ctx.rotate(gunangle-1.57-robrot[i]);
							}
						else
							{
							if (robdir[i]==0)
								{	ctx.rotate(3.14);
								}
							}
						ctx.drawImage(gatling,-curzoom/8,-curzoom/2,curzoom,curzoom);
						if (myrob==i && misdown==1 && curweapon==2)
							{
							ctx.rotate(-(gunangle-1.57-robrot[i]));
							}
						else
							{
							if (robdir[i]==0)
								{	ctx.rotate(-3.14);
								}
							}
	ctx.translate(+curzoom/2+items[i][ii][1]*curzoom*rdir-curzoom/2, -curzoom/3+curzoom+items[i][ii][2]*curzoom-curzoom/10-4); 
				
					}
				else
					{
					ctx.drawImage(parts[ items[i][ii][0] ][robdir[i]],-curzoom/2-items[i][ii][1]*curzoom*rdir, -curzoom-items[i][ii][2]*curzoom+curzoom/10,curzoom,curzoom);
					}

				}

			
			


		//	ctx.drawImage(parts[4][robdir[i]],-curzoom/4, -curzoom-curzoom-curzoom,curzoom,curzoom);
	
			
			
			if (myrob==i && misdown==1)
				{
				if (curweapon==1)
					{
					ctx.translate(0,- curzoom+4); 
					ctx.rotate(gunangle-1.57-robrot[i]);
					ctx.drawImage(xeli_right,0 , -curzoom,curzoom*1.7,curzoom*1.7);
					}
			
				}

			ctx.restore();
			}
		}
	

	}




</script>


</html>


<?



?>