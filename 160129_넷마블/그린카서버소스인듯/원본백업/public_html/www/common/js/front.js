//----------------------------------------
// 이미지 Rolling
//----------------------------------------
function ImageRotation() {
    var scroll = {time:1, start:0, change:0, duration:25, timer:null};
    var originaltime = scroll.time;
    var objWidth = 0;
    var currentNum = 0;
    var tmpName, tmpWrap, tmpListId, tmpNext, tmpPrev, tmpNum, tmpTime, moveEvent, restNum, objNum, nowNum, totNum, cntTmp, nowTmp, totTmp, cntNum, tmpTit, tmpDir, tmpPage, cntRoll, tmpMg;
    this.GoodsSetTime = null;
    var cloneElement = [];

    this.setScrollType = function (obj) {}


	this.initialize = function () {
        tmpNum = this.listNum;
        tmpTime = this.GoodsSetTime;
        tmpDir = this.scrollDirection;
        tmpMg = this.mg;
        tmpWrap = document.getElementById(this.wrapId);
        tmpListId = document.getElementById(this.listId);
        tmpNext = document.getElementById(this.btnNext);
        tmpPrev = document.getElementById(this.btnPrev);
        nowNum = document.getElementById(this.nowCnt);
        totNum = document.getElementById(this.totCnt);
        //tmpTit = document.getElementById(this.titName);
        tmpPage = document.getElementById(this.cntPage);
        cntRoll = this.sRoll;


        objNum = tmpListId.getElementsByTagName('li').length;
        cntNum = tmpNum;

		liWidth = tmpListId.getElementsByTagName('li')[0].offsetWidth + tmpMg; // + parseInt(li.style.marginLeft) + parseInt(li.style.marginRight);

	//	if (liWidth == 0){liWidth = tmpWdth;}
		
        tmpListId.style.width = (objNum * liWidth) + 'px';

		objWidth = liWidth * tmpNum;
		
        tmpListId.style.overflow = 'hidden';
        tmpWrap.style.overflow = 'hidden';

        tmpNext.onclick = setPrev;
        tmpPrev.onclick = setNext;

        if (this.autoScroll == 'none') {
                // do nothing.
        } else {
            clearInterval(tmpTime);
            /* 0525
            if(tmpDir == 'direction'){moveEvent = 'setPrev';}
            else{moveEvent = 'setNext';}
            tmpTime = setInterval(function () { eval(moveEvent + '();'); }, this.scrollGap);
			*/
			this.startTimer();
        }

        // count
        if(totNum){totNum.innerHTML= objNum/tmpNum;}

        //img name
        //if(tmpTit){tmpTit.innerHTML = tmpListId.getElementsByTagName("img")[0].alt;}

        // PAGES
        if(tmpPage){setPages(1);}

    }

    var setPages = function (pNum) {
        var pBtn;

        totNum = parseInt(objNum/tmpNum);


        if(totNum){
            for (var i=1; i<totNum+1; i++){
                if(pBtn == undefined){pBtn = "";}
                if(i == pNum){pBtn += "<strong  id='"+cntRoll+"_sBtn"+i+"' class='on'></strong>";}
                else{pBtn += "<strong id='"+cntRoll+"_sBtn"+i+"' class='off'></strong>";}
            }
            tmpPage.innerHTML = pBtn;
        }
        nowNum = pNum;
    }


    var setNext = function () {
        if (objNum <= tmpNum) return false;
        // count
        cntNum = cntNum - tmpNum;
        if(cntNum < 1){cntNum = objNum;}
        if(nowNum){nowNum.innerHTML = parseInt(cntNum/tmpNum);}

        // PAGES
        if(tmpPage){setPages(parseInt(cntNum/tmpNum));}

        //moveEvent = 'setNext';
        for (var i=0; i<tmpNum; i++) {
            var objLastNode = tmpListId.removeChild(tmpListId.getElementsByTagName('li')[objNum - 1]);
            tmpListId.insertBefore(objLastNode, tmpListId.getElementsByTagName('li')[0]);

            //img name
            //if(tmpTit){tmpTit.innerHTML = tmpListId.getElementsByTagName("img")[tmpNum-1].alt;}
        }

        tmpWrap.scrollLeft = objWidth;
        var position = getActionPoint('indirect');
        startScroll(position.start, position.end, 'next');
        return false;
    }

    var setPrev = function () {
        if (objNum <= tmpNum) return false;
        // count
        cntNum = cntNum + tmpNum;
        if(objNum < cntNum){cntNum = tmpNum;}
        if(nowNum){nowNum.innerHTML = parseInt(cntNum/tmpNum);}

        // PAGES
        if(tmpPage){setPages(parseInt(cntNum/tmpNum));}

        //moveEvent = 'setPrev';
        var position = getActionPoint('direct');
        startScroll(position.start, position.end, 'prev');
        return false;
    }

    var startScroll = function (start, end, location) {
        if (scroll.timer != null) {
            clearInterval(scroll.timer);
            scroll.timer = null;
        }

        scroll.start = start;
        scroll.change = end - start;
        scroll.timer = setInterval(function () {
            scrollHorizontal(location);
        }, 15);
    }

    var scrollHorizontal = function (location) {
        if (scroll.time > scroll.duration) {
            clearInterval(scroll.timer);
            scroll.time = originaltime;
            scroll.timer = null;
            if (location == 'prev') {
                for (var i=0; i<tmpNum; i++) {
                    var objFirstNode = tmpListId.removeChild(tmpListId.getElementsByTagName('li')[0]);
                    tmpListId.appendChild(objFirstNode);
                    //img name
                    //if(tmpTit){tmpTit.innerHTML = tmpListId.getElementsByTagName("img")[tmpNum-1].alt;}
                }

            }
            tmpWrap.scrollLeft = 0;
        } else {
            tmpWrap.scrollLeft = sineInOut(scroll.time, scroll.start, scroll.change, scroll.duration);
            scroll.time++;
        }
    }

    var getActionPoint = function (dir) {
        var end;

        if (dir == 'direct') end = tmpWrap.scrollLeft + objWidth;
        else end = tmpWrap.scrollLeft - objWidth;

        var start = tmpWrap.scrollLeft;

        var position = {start:0, end:0};
        position.start = start;
        position.end = end;

        return position;
    }

    var sineInOut = function (t, b, c, d) { return -c/2 * (Math.cos(Math.PI*t/d) - 1) + b; }

    var findElementPos = function (elemFind) {
        var elemX = 0;
        elemX = tmpWidth*(elemFind/tmpNum);
        return elemX;
 }

    /*0525*/
	this.stopTimer=function(){
		if(tmpTime!=0)
		{
			clearInterval(tmpTime);
			tmpTime=0;
		}
	}

	this.startTimer=function(){
			if(tmpTime==0 || tmpTime==null)
			{
       		     tmpTime = setInterval(function () { setPrev() }, this.scrollGap);
			}
      }

}


