function Timer(elem,circleColor,startDate,finishDate,circleRadius,circleWidth){
	var circleColor = (elem.getAttribute("data-color"))?elem.getAttribute("data-color"):circleColor;
	var startDate = (elem.getAttribute("data-startDate"))?elem.getAttribute("data-startDate"):startDate;
	var finishDate = (elem.getAttribute("data-finishDate"))?elem.getAttribute("data-finishDate"):finishDate;
	var circleRadius = circleRadius || 20;
	var circleWidth = circleWidth || 8;
	var defaultMargin = 6;
	var fontFamily = "Open Sans";
	var fontWeight = "normal";
	var marginInnerCircle = 3;
	var marginText = 5;
	var radiusInnerCircle = 2;
	var stepsOpacity = [0.7,0.6,0.5,0.4];
	var widthArc = 2;
	var mInDay = 86400000;
	var mInHour = 3600000;
	var mInMinute = 60000;
	var currentCursorPosition = {"pageX":-1,"pageY":-1};
	var context = elem.getContext('2d');
	var circle = {};
	var circles = [];
	var balance = {"days":0,"hours":0,"minutes":0,"seconds":0};
	var installDate = parseDate(finishDate);
	var allDay = Math.floor(installDate/mInDay-parseDate(startDate)/mInDay);
	var isReturnPosition = false;
	var nesReturn = false;
	var timerAnimation;
	var dateTimer;
	var returnOpacityTimers = [];
	var returnOpacityCounter = 0;
	var onHoverCircle = -1;
	var isMouse = true;
	var elemWidth = elem.width;

	function addEvent(element,event_,f){
		try{
		element = addEventListener(event_,f);
		}catch(error){
			element = attachEvent("on"+event_,f);
		}
	}

	function parseDate(date){
		var year = date.match(/^\d*\d\/\d*\d\/(\d{4})/);
		var number = date.match(/^\d*\d\/(\d*\d)/);
		var month = date.match(/^(\d*\d)/);
		var hour = date.match(/^\d*\d\/\d*\d\/\d{4} +(\d*\d)/);
		var minute = date.match(/^\d*\d\/\d*\d\/\d{4} +\d*\d:(\d*\d)/);
		var returnDate = new Date(year[1], parseInt(month[1])-1, number[1], hour[1], minute[1]).getTime();
		return returnDate;
	}
	
	function getBalance(){
		var balanceSeconds = installDate-Date.now();
		if (balanceSeconds < 0){
			balance.days = 0;
			balance.hours = 0;
			balance.minutes = 0;
			balance.seconds = 0;
		}else{
			balance.days = Math.floor(balanceSeconds/mInDay);
			balanceSeconds -= balance.days*mInDay;
			balance.hours = Math.floor(balanceSeconds/mInHour);
			balanceSeconds -= balance.hours*mInHour;
			balance.minutes = Math.floor(balanceSeconds/mInMinute);
			balanceSeconds -= balance.minutes*mInMinute;
			balance.seconds = Math.floor(balanceSeconds/1000);	
		}
		if(onHoverCircle !== -1){
			drawText(onHoverCircle);
		}else{
			drawCircle();
		}
	}

	function initialCircle(circleMargin){
		var circleMargin = circleMargin || (elem.width-defaultMargin-8*circleRadius+4*circleWidth)/3;
		for (var i = 0; i < 4; i++){
			circle = {};
			circle.x = defaultMargin+circleRadius+i*(circleMargin+circleRadius)+circleWidth/2;
			circle.y = circleRadius+defaultMargin;
			circle.opacity = stepsOpacity[i];
			circles[i] = circle;
		}
		drawCircle();
	}

	function clearCanvas(){
		context.clearRect(0,0,elem.width,elem.height);
	}

	function drawCircle(){
		clearCanvas();
		var innerCircleX = 0;
		var innerCircleY = 0;
		var innerRadius = circleRadius-marginInnerCircle-Math.floor(circleWidth/2);
		var degArcStart = 0;
		var degArcEnd = 0;
		for(var i = 0; i < 4; i++){
			context.beginPath();
			context.arc(circles[i].x,circles[i].y,circleRadius, 0,2*Math.PI, false);
			context.strokeStyle = "rgba("+circleColor+","+circles[i].opacity+")";
			context.lineWidth = circleWidth;
			context.stroke();
			context.closePath();
			context.beginPath();
			switch(i){
				case 0:
					degArcStart = 1.5*Math.PI-((Math.PI*2)/allDay)*balance.days;
					break;
				case 1:
					degArcStart = -1*((Math.PI*2)/24)*balance.hours;
					break;
				case 2:
					degArcStart = 0.5*Math.PI-((Math.PI*2)/60)*balance.minutes;
					break;
				case 3:
					degArcStart = Math.PI-((Math.PI*2)/60)*balance.seconds;
					break;
			}
			innerCircleX = circles[i].x+innerRadius*Math.cos(degArcStart);
			innerCircleY = circles[i].y+innerRadius*Math.sin(degArcStart);
			context.arc(innerCircleX, innerCircleY, radiusInnerCircle, 0,2*Math.PI, false);
			context.fillStyle= "rgba(" + circleColor+","+circles[i].opacity+")";
			context.lineWidth = circleWidth;
			context.fill();
			context.closePath();
		}
		if (onHoverCircle !== -1){
			context.beginPath();
			switch(onHoverCircle){
				case 3:
					degArcStart = Math.PI-((Math.PI*2)/60)*balance.seconds;
					degArcEnd = Math.PI;
					break;
				case 2:
					degArcStart = 0.5*Math.PI-((Math.PI*2)/60)*balance.minutes;
					degArcEnd = 0.5*Math.PI;
					break;
				case 1:
					degArcStart = -1*((Math.PI*2)/24)*balance.hours;
					degArcEnd = 0;
					break;
				case 0:
					degArcStart = 1.5*Math.PI-((Math.PI*2)/allDay)*balance.days;
					degArcEnd = 1.5*Math.PI;
					break;
			}
			context.arc(circles[onHoverCircle].x,circles[onHoverCircle].y,innerRadius, degArcStart, degArcEnd, false);
			context.lineWidth = widthArc;
			context.strokeStyle = "rgba("+circleColor+","+(circles[onHoverCircle].opacity-0.3)+")";
			context.stroke();
			context.closePath();
		}
	}

	function drawText(indexCircle){
		clearCanvas();
		drawCircle();
		var text = "";
		var subText = "";
		var textX = 0;
		var textY = 0;
		var subTextX = 0;
		var subTextY = 0;
		switch(indexCircle){
			case 0: text = balance.days+'';
				subText = "DAYS";
				break;
			case 1: text = balance.hours+'';
				subText = "HOURS";
				break;
			case 2: text = balance.minutes+'';
				subText = "MINUTES";
				break;
			case 3: text = balance.seconds+'';
				subText = "SECONDS";
				break;
			default:
				return;
		}
		textX = circles[indexCircle].x;
		textY = circles[indexCircle].y+circleRadius*2+circleWidth+marginText;
		subTextX =circles[indexCircle].x;
		subTextY = textY+18;
		context.textAlign = "center";
		context.font = fontWeight+" 24px "+fontFamily;
		context.fillStyle = "rgba("+circleColor+","+circles[indexCircle].opacity+")";
		context.fillText(text,textX,textY);
		context.font = fontWeight+" 14px "+fontFamily;
		context.fillText(subText,subTextX,subTextY);
	}

	function deltaHover(progress){
		return Math.pow(progress,3);
	}

	function returnPositionAnimation(status,touch,duration){
		clearInterval(timerAnimation);
		isReturnPosition = true;
		var margin = defaultMargin+(elemWidth-2*defaultMargin-1.5*circleWidth-8*circleRadius)/2;
		var interval = interval || 18;
		var duration = duration || 100;
		var startDate = new Date().getTime();
		var startPosition = [];
		var stopPosition = [];
		var status = status || '';
		for(var i = 0; i < 4; i++){
			stopPosition[i] = margin+circleRadius+circleWidth/2+i*(circleRadius*2);
			startPosition[i] = circles[i].x;
		}
		timerAnimation = setInterval(function(){
			var curDate = (new Date().getTime()) - startDate;
			var progress = curDate/duration;
			var stepTransition, stepOpacity;
			progress = (progress > 1)?1:progress;
			for(var i = 0; i < 4; i++){
				stepTransition = (stopPosition[i]-startPosition[i])*deltaHover(progress)+startPosition[i];
				circles[i].x = stepTransition;
			}
			drawCircle();
			if(progress === 1){
				clearInterval(timerAnimation);
				if (status === "start"){
					startAnimation();
				}else{
					if(status === "returnOpacity"){
						returnOpacity(touch);
					}
					else{
						isReturnPosition = false;
						nesReturn = false;
					}
				}
			}
		},interval);
	}

	function returnOpacity(touch,duration,interval){
		var interval = interval || 14;
		var duration = duration || 200;
		var counter = returnOpacityCounter++;
		var startOpacity = [];
		var stopOpacity = [];
		var startDate = new Date().getTime();
		for(var i = 0; i < 4; i++){
				startOpacity[i] = circles[i].opacity;
				stopOpacity[i] = stepsOpacity[i];
		}
		returnOpacityTimers[counter] = setInterval(function(){
			var curDate = (new Date().getTime()) - startDate;
			var progress = curDate/duration;
			var stepOpacity;
			progress = (progress > 1)?1:progress;
			for(var i = 0; i < 4; i++){
				stepOpacity = (stopOpacity[i]-startOpacity[i])*progress+startOpacity[i];
				circles[i].opacity = stepOpacity;
			}
			drawCircle();
			if(progress === 1){
				clearInterval(returnOpacityTimers[counter]);
				isReturnPosition = false;
				nesReturn = false;
				if (!isMouse){
					onHoverCircle = -1;
					setAnimateCircle(touch);
				}else{
					move(currentCursorPosition);
				}
			}
		},interval);
	}

	function startAnimation(mode,duration,interval){
		isReturnPosition = true;
		var mode = mode || 'show';
		var interval = interval || 14;
		var duration = duration || 200;
		var startDate = new Date().getTime();
		var startOpacity = [];
		var stopOpacity = [];
		for(var i = 0; i < 4; i++){
				startOpacity[i] = circles[i].opacity;
				stopOpacity[i] = (mode === 'show')?1:stepsOpacity[i];
		}
		timerAnimation = setInterval(function(){
			var curDate = (new Date().getTime()) - startDate;
			var progress = curDate/duration;
			var stepOpacity;
			progress = (progress > 1)?1:progress;
			for(var i = 0; i < 4; i++){
				stepOpacity = (stopOpacity[i]-startOpacity[i])*progress+startOpacity[i];
				circles[i].opacity = stepOpacity;
			}
			drawCircle();
			if(progress === 1){
				clearInterval(timerAnimation);
				(mode === 'show')?startAnimation("hide",250):isReturnPosition = false;
			}
		},interval);
	}

	function animateHover(staticIndex,duration,interval){
		isReturnPosition = true;
		nesReturn = true;
		var interval = interval || 14;
		var duration = duration || 250;
		var startDate = new Date().getTime();
		var startPosition = [];
		var stopPosition = [];
		var startOpacity;
		for(var i = 0; i < 4; i++){
			if(staticIndex !== i){
				startPosition[i] = circles[i].x;
				stopPosition[i] = (i > staticIndex)?circles[i].x+circleRadius*2:circles[i].x-circleRadius*2;
			}else{
				startOpacity = circles[i].opacity;
			}
		}
		timerAnimation = setInterval(function(){
			var curDate = (new Date().getTime()) - startDate;
			var progress = curDate/duration;
			var stepTransition, stepOpacity;
			progress = (progress > 1)?1:progress;
			for(var i = 0; i < 4; i++){
				if(i !== staticIndex){
					stepTransition = (stopPosition[i]-startPosition[i])*deltaHover(progress)+startPosition[i];
					circles[i].x = stepTransition;
				}else{
					stepOpacity = (1-startOpacity)*deltaHover(progress)+startOpacity;
					circles[i].opacity = stepOpacity;
				}
			}
			drawText(staticIndex);
			if(progress === 1){
				clearInterval(timerAnimation);
				isReturnPosition = false;
			}
		},interval);
	}


	function checkBall(x0,y0,x1,y1){
		return Math.sqrt((x0-x1)*(x0-x1)+(y0-y1)*(y0-y1)) <= circleRadius+circleWidth;
	}

	function pixelRatio(){
		var canvas = elem,
        context = canvas.getContext('2d'),
        devicePixelRatio = window.devicePixelRatio || 1,
        backingStoreRatio = context.webkitBackingStorePixelRatio ||
                            context.mozBackingStorePixelRatio ||
                            context.msBackingStorePixelRatio ||
                            context.oBackingStorePixelRatio ||
                            context.backingStorePixelRatio || 1,
        ratio = devicePixelRatio / backingStoreRatio;
		if (devicePixelRatio !== backingStoreRatio) {
	        var oldWidth = canvas.width;
	        var oldHeight = canvas.height;
	        canvas.width = oldWidth * ratio;
	        canvas.height = oldHeight * ratio;
	        canvas.style.width = oldWidth + 'px';
	        canvas.style.height = oldHeight + 'px';
	        context.scale(ratio, ratio);
    	}
	}

	function setAnimateCircle(index){
		switch(index){
			case 0: if(onHoverCircle !== 0){ 
				onHoverCircle = 0;
				animateHover(0);
			}
			return;
			case 1: if(onHoverCircle !== 1){ 
				onHoverCircle = 1;
				animateHover(1);
			}
			return;
			case 2: if(onHoverCircle !== 2){ 
				onHoverCircle = 2;
				animateHover(2);
			}
			return;
			case 3: if(onHoverCircle !== 3){ 
				onHoverCircle = 3;
				animateHover(3);
			}
			return;
		}
	}

	function getOffset(elem) {
		if (elem.getBoundingClientRect) {
			return getOffsetRect(elem);
		} else {
			return getOffsetSum(elem);
		}
	}

	function getOffsetSum(elem) {
		var top=0, left=0;
		while(elem) {
			top = top + parseInt(elem.offsetTop);
			left = left + parseInt(elem.offsetLeft);
			elem = elem.offsetParent;
		}
		return {top: top, left: left};
	}

	function getOffsetRect(elem) {
		var box = elem.getBoundingClientRect();
		var body = document.body;
		var docElem = document.documentElement;
		var scrollTop = window.pageYOffset || docElem.scrollTop || body.scrollTop;
		var scrollLeft = window.pageXOffset || docElem.scrollLeft || body.scrollLeft;
		var clientTop = docElem.clientTop || body.clientTop || 0;
		var clientLeft = docElem.clientLeft || body.clientLeft || 0;
		var top  = box.top +  scrollTop - clientTop;
		var left = box.left + scrollLeft - clientLeft;
		return { top: Math.round(top), left: Math.round(left) };
	}

	function move(e){
		var e = e || event;
		var on = false;
		var selectCircle = -1;
		currentCursorPosition.pageX = e.pageX;
		currentCursorPosition.pageY = e.pageY;
		if (!isReturnPosition){
			var offset = getOffset(elem);
			for (var i = 0; i < 4; i++){
				if (checkBall(offset.left+circles[i].x,offset.top+circles[i].y,e.pageX,e.pageY)){
					if(onHoverCircle === i || onHoverCircle === -1){
						on = true;
						selectCircle = i;
					}
					break;
				}
			}
			if (nesReturn && !on){
				returnPositionAnimation("returnOpacity");
				nesReturn = false;
				onHoverCircle = -1;
			}
			setAnimateCircle(selectCircle);
		}
	}

	function clickmove(e){
		var posX = -1;
		var posY = -1;
		if ((e.clientX)&&(e.clientY)) {
		posX = e.clientX;
		posY = e.clientY;
		} else if (e.targetTouches) {
			posX = e.targetTouches[0].clientX;
			posY = e.targetTouches[0].clientY;
		}
		isMouse = false;
		currentCursorPosition.pageX = posX;
		currentCursorPosition.pageY = posY;
		if (!isReturnPosition){
			for (var i = 0; i < 4; i++){
				var offset = getOffset(elem);
				if (checkBall(offset.left+circles[i].x,offset.top+circles[i].y,posX,posY)){
					if(onHoverCircle === -1){
						setAnimateCircle(i);
						return;
					}
					if(onHoverCircle === i){
						returnPositionAnimation("returnOpacity");
						onHoverCircle = -1;
						return;
					}
					else{
						returnPositionAnimation("returnOpacity",i);
						onHoverCircle = -1;
						return;
					}
				}
				else{
					if(onHoverCircle !== -1){
						returnPositionAnimation("returnOpacity");
					}
				}
			}
		}
	}

	if ('ontouchstart' in window) {
		addEvent(elem,"touchstart",clickmove);
	}else{
		addEvent(document,"mousemove",move);
	}
	pixelRatio();
	initialCircle();
	getBalance();
	returnPositionAnimation("start",null,500);
	dateTimer = setInterval(getBalance,1000);
}

