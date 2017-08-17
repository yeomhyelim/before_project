/************************************************************************
* Highgarden Web Wysiwyg Editor ver 1.0
* Copyright (C) 2008년 Highgarden
* email :  highgarden@naver.com
* nate_on :  high__garden@hotmail.com
*
* textarea의 title속성에 higheditor_type으로 사용
* type : simple - 간단한 기능
*        full - 모든 기능 사용
*           (다른 iconset 필요시 추가 가능)
*
* License
* ----------------------------------------------------------------------
* 본 프로그램은 LGPL을 따릅니다.
* 자세한 사항은 아래 링크를 참조해주시기 바랍니다.
* http://korea.gnu.org/people/chsong/copyleft/lgpl.ko.html
* ----------------------------------------------------------------------
*
* Special Thanks RURONY
************************************************************************/

/**
 * textarea 검색/등록 후 에디터 실행
 */
if(window.addEventListener) window.addEventListener("load", createEditor, false);
else if(window.attachEvent) window.attachEvent("onload", createEditor);

var EditorOnTxtAreaID = new Array();

function createEditor(){
  var txtArea = document.getElementsByTagName("textarea");
  var c = 0;
  for(i=0;i<txtArea.length;i++){
    if(txtArea[i].title){
      var txtAreaTitle = txtArea[i].getAttribute("title");

      var txtAreaTitleSplit = txtAreaTitle.split('_');

      if(txtAreaTitleSplit[0] == "higheditor" && txtAreaTitleSplit[1]){
        EditorOnTxtAreaID[c++] = txtArea[i].name;
        editor = new HighEditor(txtArea[i], txtAreaTitleSplit[1]);
        editor.addToolbar();
		if (editor.editorHTMLYN != "N")
		{
			editor.addHtmlToTextFunc();
		}
        editor.addInsertIcons();
        editor.createIframe();
        editor.createBottomArea();
        editor.createSuvDiv();
      }
    }
  }
}


/**
 * Highgarden Editor
 */
function HighEditor(oldTxtArea, mode){
  var oldTxtArea = oldTxtArea;
  this.oldTextAreaObj = oldTxtArea;
  this.mode = mode;
  this.name = "new_" + oldTxtArea.name;
  //this.width = oldTxtArea.offsetWidth + "px";
	this.width = "100%";
  this.height = oldTxtArea.style.height;
  this.editorRoot = rootDir;
  this.editorUploadDir = uploadImg;
  this.editorUploadFile = uploadFile;
  this.editorHTMLYN = htmlYN;

  this.newTxtAreaId = this.name + "_iframe";

  this.iconSet = new Object();
  this.iconSet["full"] = ['fontsize', '-', 'fontname', '-',
                          'bold', 'underline', 'italic', 'StrikeThrough', 'ForeColor', 'BackColor',
                          'justifyleft', 'justifycenter', 'justifyright', 'justifyfull',
                          'insertorderedlist', 'insertunorderedlist', 'createlink', 'unlink',
                          'attachimage'
                          ];

/*
  this.iconSet["full"] = ['fontsize', '-', 'fontname', '-',
                          'bold', 'underline', 'italic', 'StrikeThrough', 'ForeColor', 'BackColor', '-',
                          'justifyleft', 'justifycenter', 'justifyright', 'justifyfull', '-',
                          'insertorderedlist', 'insertunorderedlist', '-',
                          'outdent', 'indent', '-',
                          'insertorderedlist', 'insertunorderedlist', 'createlink', 'unlink', 'layout','-','-','-','-',
                          'undo', 'redo', '-',
                          'removeformat', '-',
                          'emoticon', 'letter', '-',
                          'attachimage', '-',
                          'layout'
                          ];

*/   

  this.iconSet["simple"] = ['bold', 'underline', 'italic', 'StrikeThrough', 'ForeColor', 'BackColor', '-',
                          'justifyleft', 'justifycenter', 'justifyright', 'justifyfull', '-',
                          'removeformat', '-',
                          'emoticon', 'letter'
                          ];

  this.fontsize = ['1', '2', '3', '4', '5', '6'];
  this.fontname = ['굴림', '돋움', '바탕'];

  this.minusValue = 2;
  if(navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion.indexOf("MSIE 6") > -1){
    this.minusValue = 4;
  }

  /**
   * 툴바 추가
   */
  this.addToolbar = function(){
	this.toolbarId = this.name + "_toolbar";
    var toolbar = document.createElement("div");
    toolbar.setAttribute("id", this.toolbarId);
    toolbar.style.width = this.width;

    oldTxtArea.parentNode.insertBefore(toolbar, oldTxtArea);	

    this.iconAreaId = this.toolbarId + "_iconArea";

    var toolbarHtml = '';
    toolbarHtml += '<div id="' + this.iconAreaId + '" style="margin-right:2px;padding:5px;border:1px solid #dbdbdb;background:#F5F5F5;">';
    toolbarHtml += '</div>';
    document.getElementById(this.toolbarId).innerHTML = toolbarHtml;
  }


  /**
   * HTML <-> TEXTAREA 변환 checkbox 삽입
   */
  this.addHtmlToTextFunc = function(){
    var HtmlToTextCheckArea = document.createElement("div");
	HtmlToTextCheckArea.innerHTML  = "";


    //oldTxtArea.parentNode.insertBefore(HtmlToTextCheckArea, document.getElementById(this.toolbarId).nextSibling);
	oldTxtArea.parentNode.insertBefore(HtmlToTextCheckArea, document.getElementById(this.toolbarId));

    this.HtmlToTextCheckId = this.name + "_check";
    var HtmlToTextCheck = document.createElement("input");
    HtmlToTextCheck.setAttribute("id", this.HtmlToTextCheckId);
    HtmlToTextCheck.setAttribute("type", "checkbox");
    HtmlToTextCheck.setAttribute("value", "1");
    if(document.addEventListener){
      HtmlToTextCheck.addEventListener("click", this.editorModeSwap, false);
    }else if(document.attachEvent){
      HtmlToTextCheck.attachEvent("onclick", this.editorModeSwap);
    }

    var HtmlToTextCheckLabel = document.createElement("label");
    HtmlToTextCheckLabel.setAttribute("for", this.HtmlToTextCheckId);

    var HtmlToTextCheckLabelText = document.createElement("span");
    HtmlToTextCheckLabelText.style.cssText = "font-family:'돋움';font-size:12px;color:#757575;vertical-align:middle;";
    HtmlToTextCheckLabelText.innerHTML = "&nbsp;HTML";
    HtmlToTextCheckLabel.appendChild(HtmlToTextCheckLabelText);

    HtmlToTextCheckArea.appendChild(HtmlToTextCheck);
    HtmlToTextCheckArea.appendChild(HtmlToTextCheckLabel);
  }


  /**
   * HTML <-> TEXTAREA 변환 기능
   */
  this.editorModeSwap = function(event){
    event = event ? event : window.event;
    var checkObj;
    if(event.srcElement){
      checkObj = event.srcElement;
    }else{
      checkObj = event.target;
    }

    var editorToolbarId = "new_" + oldTxtArea.name + "_toolbar";
    var editorIframeId = "new_" + oldTxtArea.name + "_iframe";
    var editorBottomId = "new_" + oldTxtArea.name + "_bottom";

    if(checkObj.checked){
      oldTxtArea.style.display = "block";
      document.getElementById(editorToolbarId).style.display = "none";
      document.getElementById(editorIframeId).style.display = "none";
      document.getElementById(editorBottomId).style.display = "none";
      oldTxtArea.focus();
    }else{
      oldTxtArea.style.display = "none";
      document.getElementById(editorToolbarId).style.display = "block";
      document.getElementById(editorIframeId).style.display = "block";
      document.getElementById(editorBottomId).style.display = "block";
      document.getElementById(editorIframeId).contentWindow.focus();
    }

  }



  /**
   * 아이콘 삽입
   */
  this.addInsertIcons = function(){
    var iconHtml = '<div>';
    try{
      for(j=0;j<this.iconSet[this.mode].length;j++){
        if(this.iconSet[this.mode][j] == "-"){
          iconHtml += '<span style="width:3px">&nbsp;</span>';
        }else if(this.iconSet[this.mode][j] == "--"){
          iconHtml += '</div><div">';
        }else if(this.iconSet[this.mode][j] == "fontsize"){
          iconHtml += '<select style="width:60px;" name="fontsize" align="absolute middle" onchange="editorExec(\'' + this.iconSet[this.mode][j] + '\', false, this.value,\'' + this.newTxtAreaId + '\')">';
          for(k=0;k<this.fontsize.length;k++){
            iconHtml += '<option value="' + this.fontsize[k] + '">' + this.fontsize[k] + '</option>';
          }
          iconHtml += '</select>';
        }else if(this.iconSet[this.mode][j] == "fontname"){
          iconHtml += '<select style="width:60px;" name="fontname" align="absolute middle" onchange="editorExec(\'' + this.iconSet[this.mode][j] + '\', false, this.value,\'' + this.newTxtAreaId + '\')">';
          for(k=0;k<this.fontname.length;k++){
            iconHtml += '<option value="' + this.fontname[k] + '">' + this.fontname[k] + '</option>';
          }
          iconHtml += '</select>';
        }else if(this.iconSet[this.mode][j] == "ForeColor" || this.iconSet[this.mode][j] == "BackColor" || this.iconSet[this.mode][j] == "emoticon" || this.iconSet[this.mode][j] == "letter" || this.iconSet[this.mode][j] == "createlink" || this.iconSet[this.mode][j] == "table" || this.iconSet[this.mode][j] == "attachimage" || this.iconSet[this.mode][j] == "div" || this.iconSet[this.mode][j] == "layout"){
          iconHtml += '<img src="' + this.editorRoot + '/' + this.iconSet[this.mode][j] + '.gif" alt="' + this.iconSet[this.mode][j] + '" align="top" style="cursor:pointer;" onclick="editorSubDiv(event ,\'' + this.iconSet[this.mode][j] + '\',\'' + this.newTxtAreaId + '\')" onmouseover="this.src =\''  + this.editorRoot + '/' + this.iconSet[this.mode][j] + '_on.gif\'" onmouseout="this.src =\''  + this.editorRoot + '/' + this.iconSet[this.mode][j] + '.gif\'" title="' + this.iconSet[this.mode][j] + '" />';
        }else{
          iconHtml += '<img src="' + this.editorRoot + '/' + this.iconSet[this.mode][j] + '.gif" alt="' + this.iconSet[this.mode][j] + '" align="top" style="cursor:pointer;" onclick="editorExec(\'' + this.iconSet[this.mode][j] + '\', false, null,\'' + this.newTxtAreaId + '\')" onmouseover="this.src =\''  + this.editorRoot + '/' + this.iconSet[this.mode][j] + '_on.gif\'" onmouseout="this.src =\''  + this.editorRoot + '/' + this.iconSet[this.mode][j] + '.gif\'" title="' + this.iconSet[this.mode][j] + '" />';
        }
      }
      iconHtml += '</div>';
      document.getElementById(this.iconAreaId).innerHTML = iconHtml;
    }catch(exception){
      alert("textarea id(" + oldTxtArea.id + ")에 적용할 IconSet이 없습니다.");
      document.getElementById(this.iconAreaId).innerHTML = "등록된 IconSet이 없습니다.";
    }

  }


  /**
   * 아이프레임 생성
   */
  this.createIframe = function(){

//    var newTxtAreaId = this.newTxtAreaId;
    this.newTxtArea = document.createElement("iframe");
    this.newTxtArea.setAttribute("id", this.newTxtAreaId);
    this.newTxtArea.setAttribute("name", this.newTxtAreaId);
    this.newTxtArea.setAttribute("scrolling","auto");
    this.newTxtArea.setAttribute("frameBorder","no");
    this.newTxtArea.setAttribute("wrap","virtual");
    this.newTxtArea.cssText = "margin:0px;padding:0px;";
// this.newTxtArea.style.width = (oldTxtArea.offsetWidth - this.minusValue) + "px"; 2013.11.14 kim hee sung CRM 1:1게시판에서 디자인 깨짐
	this.newTxtArea.style.width = "100%";
    this.newTxtArea.style.height = (oldTxtArea.offsetHeight - document.getElementById(this.toolbarId).offsetHeight - this.minusValue - 10) + "px";
    this.newTxtArea.style.borderLeft = "1px solid #D0D0D0";
    this.newTxtArea.style.borderRight = "1px solid #D0D0D0";
    this.newTxtArea.style.borderBottom = "1px solid #D0D0D0";
    oldTxtArea.parentNode.insertBefore(this.newTxtArea, oldTxtArea);

    document.getElementById(oldTxtArea.id).style.display = "none";

    var editorDoc = document.getElementById(this.newTxtAreaId).contentWindow.document;
    editorDoc.open();
    editorDoc.write("<html><head><title>Highgarden Editor</title>");
    editorDoc.write("<meta http-equiv='Content-Type' content='text/html; charset=euc-kr' />");
    editorDoc.write("<style type='text/css'>");
    editorDoc.write("body,p,table,div,blockquote{margin:0px; font-family:'돋움';font-size:12px;line-height: 20px;}");
    editorDoc.write("body{padding:5px;");
    editorDoc.write("scrollbar-3dlight-color:#dbdbdb;");
    editorDoc.write("scrollbar-arrow-color:#dbdbdb;");
    editorDoc.write("scrollbar-base-color:#dbdbdb;");
    editorDoc.write("scrollbar-darkshadow-color:#ffffff;");
    editorDoc.write("scrollbar-face-color:#ffffff;");
    editorDoc.write("scrollbar-highlight-color:#ffffff;");
    editorDoc.write("scrollbar-shadow-color:#dbdbdb;");
    editorDoc.write("}");
    editorDoc.write("ul,ol{margin-top:0px; margin-bottom:0px;}");
    editorDoc.write(".basicBorder{border:1px dashed #dbdbdb;}");
    editorDoc.write("</style>");
    editorDoc.write("<body bgcolor='#FFFFFF'>" + oldTxtArea.value + "</body>");
    editorDoc.write("</html>");
    editorDoc.close();

    if(editorDoc.contentEditable){
      editorDoc.contentEditable = "true";
    }else{
      editorDoc.designMode = "on";
    }

    if(document.addEventListener){
      editorDoc.addEventListener("mouseup", htmlTotext, false);
      editorDoc.addEventListener("mouseout", htmlTotext, false);
      editorDoc.addEventListener("keyup", htmlTotext, false);
      editorDoc.addEventListener("blur", htmlTotext, false);
      editorDoc.addEventListener("mousedown", this.hiddenSuvDiv, false);
      oldTxtArea.addEventListener("mouseup", textTohtml, false);
      oldTxtArea.addEventListener("mouseout", textTohtml, false);
      oldTxtArea.addEventListener("keyup", textTohtml, false);
      oldTxtArea.addEventListener("blur", textTohtml, false);
    }else if(document.attachEvent){
      editorDoc.attachEvent("onmouseup", htmlTotext);
      editorDoc.attachEvent("onmouseout", htmlTotext);
      editorDoc.attachEvent("onkeyup", htmlTotext);
      editorDoc.attachEvent("onblur", htmlTotext);
      editorDoc.attachEvent("onmousedown", this.hiddenSuvDiv);
      oldTxtArea.attachEvent("onmouseup", textTohtml);
      oldTxtArea.attachEvent("onmouseout", textTohtml);
      oldTxtArea.attachEvent("onkeyup", textTohtml);
      oldTxtArea.attachEvent("onblur", textTohtml);
    }

  }


  /**
   * 하단 사이즈 조절창 생성
   */
  this.createBottomArea = function(){
    this.bottomAreaId = this.name + "_bottom";
    var bottomArea = document.createElement("div");
    bottomArea.setAttribute("id", this.bottomAreaId);
    bottomArea.style.width = this.width;

    oldTxtArea.parentNode.insertBefore(bottomArea, oldTxtArea);

    var bottomHtml = '';
    bottomHtml += '<div style="margin-right:2px;padding:3px;background:url(' + this.editorRoot + '/control_size.gif) no-repeat center; border-left:1px solid #dbdbdb; border-right:1px solid #dbdbdb; border-bottom:1px solid #b5b5b5;cursor:n-resize;font-size:5px;" onmousedown="editorResize(event, \'' + this.name + '_iframe\')">&nbsp;</div>';

    document.getElementById(this.bottomAreaId).innerHTML = bottomHtml;
  }


  /**
   * 서브메뉴용 DIV 생성
   */
  this.createSuvDiv = function(){
    var suvDivId = "higheditor_subdiv";
    var suvDiv = document.createElement("div");
    suvDiv.setAttribute("id", suvDivId);
    suvDiv.style.cssText = "border-right:1px solid #888888; border-bottom:1px solid #888888; background:#fbfbfb; position:absolute; z-index:100; filter:alpha(opacity=95);opacity:.95;";
    suvDiv.style.display = "none";

    document.body.appendChild(suvDiv);
  }


  /**
   * 서브메뉴용 DIV 사라짐
   */
  this.hiddenSuvDiv = function(event){
    event = event ? event : window.event;
    var eventObj = document.getElementById("higheditor_subdiv");
    if(eventObj.hasChildNodes()){
      for(k=0;k<eventObj.childNodes .length;k++){
        eventObj.removeChild(eventObj.childNodes[k]);
      }
    }
    eventObj.style.display = "none";
  }

}



/**
 * 포커스(for IE)
 */
var focusObj;

setFocus = function(ifrmObjId){
  if(document.all){
    focusObj = document.getElementById(ifrmObjId).contentWindow.document.selection.createRange();
  }
}

getFocus = function(){
  if(document.all){
//    focusObj.collapse(false);
    focusObj.select();
  }
}


/**
 * 편집기능 실행
 */
editorExec = function(command, bool, commandValue, ifrmObjId){

  if(navigator.appName != "Microsoft Internet Explorer" && command=="BackColor") command = "hilitecolor";
  var ifrmObj;
  if(document.all){
    ifrmObj = frames[ifrmObjId];
  }else{
    ifrmObj = document.getElementById(ifrmObjId).contentWindow;
  }

  ifrmObj.focus();

  ifrmObj.document.execCommand(command, bool, commandValue);
  htmlTotext();

  editor.hiddenSuvDiv();
}


editorExecInput = function(command, bool, commandValue, ifrmObjId){
  var ifrmObj;
  if(document.all){
    ifrmObj = frames[ifrmObjId];
  }else{
    ifrmObj = document.getElementById(ifrmObjId).contentWindow;
  }

  getFocus();

  ifrmObj.document.execCommand(command, bool, commandValue);
  htmlTotext();

  editor.hiddenSuvDiv();
}


editorInsertHTML = function(commandValue, ifrmObjId){
  var ifrmObj;
  if(document.all){
    ifrmObj = frames[ifrmObjId];
  }else{
    ifrmObj = document.getElementById(ifrmObjId).contentWindow;
  }
  ifrmObj.focus();

  if(document.all){
    var temp = ifrmObj.document.selection.createRange();
    temp.pasteHTML(commandValue);
  }else{
    ifrmObj.document.execCommand("InsertHTML", false, commandValue);
  }
  htmlTotext();
  editor.hiddenSuvDiv();
}


/**
 * iframe -> textarea 복사
 */
htmlTotext = function(){
  for(j=0;j<EditorOnTxtAreaID.length;j++){
    var newIframeId = "new_" + EditorOnTxtAreaID[j] + "_iframe";
	document.getElementById(EditorOnTxtAreaID[j]).value = document.getElementById(newIframeId).contentWindow.document.body.innerHTML;
  }
}


/**
 * textarea -> iframe 복사
 */
textTohtml = function(){
  for(j=0;j<EditorOnTxtAreaID.length;j++){
    var newIframeId = "new_" + EditorOnTxtAreaID[j] + "_iframe";
    document.getElementById(newIframeId).contentWindow.document.body.innerHTML = document.getElementById(EditorOnTxtAreaID[j]).value;
  }
}


/**
 * 서브메뉴용 div에 맞는 기능 삽입
 */
editorSubDiv = function(event, divType, ifrmObjId, mode){

  setFocus(ifrmObjId);

  event = event ? event : window.event;

  var suvDivObj = document.getElementById("higheditor_subdiv");

  var subDivHtml;
  if(divType == "ForeColor" || divType == "BackColor"){
    subDivHtml = colorPicker(divType, 'normal', ifrmObjId);
  }else if(divType == "emoticon"){
    subDivHtml = emoticon(divType, mode, ifrmObjId);
  }else if(divType == "letter"){
    subDivHtml = letter(divType, mode, ifrmObjId);
  }else if(divType == "createlink"){
    subDivHtml = createlink(ifrmObjId);
  }else if(divType == "table"){
    subDivHtml = table(ifrmObjId);
  }else if(divType == "attachimage"){
    subDivHtml = attachImage(ifrmObjId);
  }else if(divType == "div"){
    subDivHtml = createDiv(ifrmObjId);
  }else if(divType == "layout"){
    subDivHtml = createLayout(ifrmObjId);
  }else{
    return;
  }

  suvDivObj.innerHTML = subDivHtml;

  suvDivObj.style.left = event.clientX + "px";
  if((navigator.userAgent.toUpperCase().indexOf("SAFARI") > 0)){
    suvDivObj.style.top = (document.body.scrollTop + event.clientY) + "px";
  }else{
    suvDivObj.style.top = (document.documentElement.scrollTop + event.clientY) + "px";
	//alert(document.body.scrollTop)
	//suvDivObj.style.top = window.event.clientY + "px";
  }
  suvDivObj.style.display = "block";

  if(divType == "attachimage"){
    attachImageForm(ifrmObjId);
  }
//  getFocus();
}

/**
 * 서브메뉴용 div에 맞는 기능 삽입(팝업 위치변경 없음)
 */
editorSubDivChangeInner = function(event, divType, ifrmObjId, mode){
  event = event ? event : window.event;

  var suvDivObj = document.getElementById("higheditor_subdiv");

  var subDivHtml;
  if(divType == "ForeColor" || divType == "BackColor"){
    subDivHtml = colorPicker(divType, 'normal', ifrmObjId);
  }else if(divType == "emoticon"){
    subDivHtml = emoticon(divType, mode, ifrmObjId);
  }else if(divType == "letter"){
    subDivHtml = letter(divType, mode, ifrmObjId);
  }

  suvDivObj.innerHTML = subDivHtml;
  suvDivObj.style.display = "block";

  var ifrmObj;
  if(document.all){
    ifrmObj = frames[ifrmObjId];
  }else{
    ifrmObj = document.getElementById(ifrmObjId).contentWindow;
  }

  getFocus();
}


/**
 * 에디터 사이즈 조절
 */
var resizeEditor;
var resizeEditorEventY;
var tempY;
editorResize = function(event, ifrmObjId){
  event = event ? event : window.event;
  resizeEditor = document.getElementById(ifrmObjId);
  tempY = resizeEditor.offsetHeight;
  resizeEditorEventY = event.clientY;
  document.onmousemove = editorResizeExec;
}
editorResizeExec = function(event){
  event = event ? event : window.event;
  if(resizeEditor){
    if(tempY + event.clientY - resizeEditorEventY<50){
      return;
    }else{
      resizeEditor.style.height = (tempY + event.clientY - resizeEditorEventY) + "px";
    }
  }
}
document.onmouseup = new Function("resizeEditor=null");


/**
 * forecolor, backcolor용 컬러 피커
 */
colorPicker = function(mode, type, ifrmObjId){
  this.mode = mode;
  this.type = type;
  this.ifrmObjId = ifrmObjId;

  this.colorSet = new Object();
  this.colorSet["pastel"] = ["#ff99cc","#ffcc99","#ffff99","#ccffcc","#ccffff","#99ccfe","#cc99ff","#ffffff"
                          ];
  this.colorSet["normal"] = ["#000000","#993300","#333300","#003300","#003366","#000099","#333399","#333333",
                             "#990000","#ff6600","#999900","#009900","#009999","#0000ff","#666699","#669999",
                             "#ff0000","#ff9900","#99cc00","#339966","#33cccc","#3366ff","#81007e","#999999",
                             "#ff00ff","#ffcc00","#ffff00","#00ff00","#00ffff","#00ccff","#993366","#cccccc",
                             "#ff99cc","#ffcc99","#ffff99","#ccffcc","#ccffff","#99ccfe","#cc99ff","#ffffff"
                          ];

  var colorPickerHtml = '';
  colorPickerHtml += '<div style="padding:3px;border:1px solid #dbdbdb;background:fbfbfb">';
  colorPickerHtml += '<table border="0" cellpadding="0" cellspacing="1" style=""><tr>';

  for(i=0;i<this.colorSet[type].length;i++){
    colorPickerHtml += '<td width="12px" height="12px" style="cursor:pointer; background:' + this.colorSet[type][i] + ';" onmousedown="editorExec(\'' + mode + '\', false,\'' + this.colorSet[type][i] + '\',\'' + ifrmObjId + '\')"></td>';
    if((i+1)%8 == 0){
      colorPickerHtml += '</tr><tr>';
    }
  }
  colorPickerHtml += "</tr></table>";
  colorPickerHtml += "</div>";
  return colorPickerHtml;

}


/**
 * 이모티콘
 */
emoticon = function(mode, type, ifrmObjId){
  if(!type){
    type="MSN";
  };
  this.mode = mode;
  this.type = type;
  this.ifrmObjId = ifrmObjId;
  this.emoticonRoot = editor.editorRoot + "/emoticon";

  this.emoticonSet = new Object();
  this.emoticonSet["MSN"] = ["msn001","msn002","msn003","msn004","msn005","msn006","msn007","msn008",
                             "msn009","msn010","msn011","msn012","msn013","msn014","msn015","msn016",
                             "msn017","msn018","msn019","msn020","msn021","msn022","msn023","msn024",
                             "msn025","msn026","msn027","msn028","msn029","msn030","msn031","msn032",
                             "msn033","msn034","msn035","msn036","msn037","msn038","msn039","msn040"
                            ];
  this.emoticonSet["MSN_ANI"] = ["01","02","03","04","05","06","07","08",
                                "09","10","11","12","13","14","15","16"
                               ];

  var emoticonHtml = '';
  emoticonHtml += '<div style="padding:3px;border:1px solid #dbdbdb;background:fbfbfb">';
  emoticonHtml += '<div style="padding-top:8px;padding-bottom:5px;padding-left:5px;padding-right:5px;">';
  for(key in emoticonSet){
    if(type == key){
      emoticonHtml += '<span style="margin-right:10px; font-size:12px; font-weight:bold; color:#757575; cursor:pointer;" onclick="editorSubDivChangeInner(event, \'' + mode + '\',\'' + ifrmObjId + '\', \'' + key + '\')">' + key;
      emoticonHtml += "</span>";
    }else{
      emoticonHtml += '<span style="margin-right:10px; font-size:12px; color:#757575; cursor:pointer;" onclick="editorSubDivChangeInner(event, \'' + mode + '\',\'' + ifrmObjId + '\', \'' + key + '\')">' + key;
      emoticonHtml += "</span>";
    }
  }
  emoticonHtml += "</div>";
  emoticonHtml += '<div id="emoticonArea" style="padding:3px;border:1px solid #dbdbdb;background:#ffffff">';
  emoticonHtml += '<table border="0" cellpadding="0" cellspacing="0" style=""><tr>';

  for(i=0;i<this.emoticonSet[type].length;i++){
    var emoticonSrc = this.emoticonRoot + '/' + type + '/' + this.emoticonSet[type][i] + '.gif';
    emoticonHtml += '<td align="center" style="padding:3px; border:2px solid #ffffff;" onmouseover="onOverStyle(this)" onmouseout="onOutStyle(this)">';
    emoticonHtml += '<img src="' + emoticonSrc + '" onmousedown="editorExec(\'insertimage\', false,\'' + emoticonSrc + '\',\'' + ifrmObjId + '\')" style="cursor:pointer;"></td>';
    emoticonHtml += '</td>';
    if((i+1)%8 == 0){
      emoticonHtml += '</tr><tr>';
    }
  }
  emoticonHtml += "</tr></table>";
  emoticonHtml += "</div>";
  emoticonHtml += "</div>";
  return emoticonHtml;

}


/**
 * 특수문자
 */
letter = function(mode, type, ifrmObjId){
  if(!type){
    type="일반기호";
  };
  this.mode = mode;
  this.type = type;
  this.ifrmObjId = ifrmObjId;

  this.letterSet = new Object();
  this.letterSet["일반기호"] = ["＃","＆","＊","＠","§","※","☆","○","●","◎","◇","◆","□","■","△","▲","▽","▼",
                               "→","←","↑","↓","↔","〓","◁","◀","▷","▶","♤","♠","♡","♥","♧","♣","⊙","◈",
                               "▣","◐","◑","▒","▤","▥","▨","▧","▦","▩","♨","☏","☎","☜","☞","¶","†","‡",
                               "↕","↗","↙","↖","↘","♭","♩","♪","♬","㉿","㈜","№","㏇","™","㏂","㏘","℡","\u00AE",
                               "ª","º","＂","（","）","［","］","｛","｝","‘","’","“","”","〔","〕","〈","〉","《",
                               "》","「","」","『","』","【","】","！","＇","，","．","／","：","；","？","＾","＿","｀",
                               "｜","￣","、","。","·","‥","…","¨","〃","―","∥","＼","∼","´","～","ˇ","˘","˝",
                               "˚","˙","¸","˛","¡","¿","ː"
                              ];
  this.letterSet["수학부호/단위"] = ["＋", "－", "＜", "＝", "＞", "±", "×", "÷", "≠", "≤", "≥", "∞", "∴", "♂", "♀", "∠", "⊥", "⌒", "∂", "∇",
                                   "≡", "≒", "≪", "≫", "√", "∽", "∝", "∵", "∫", "∬", "∈", "∋", "⊆", "⊇", "⊂", "⊃", "∪", "∩", "∧", "∨",
                                   "￢", "⇒", "⇔", "∀", "∃", "∮", "∑", "∏", "＄", "％", "￦", "Ｆ", "′", "″", "℃", "Å", "￠", "￡", "￥", "¤", "℉",
                                   "‰", "?", "㎕", "㎖", "㎗", "ℓ", "㎘", "㏄", "㎣", "㎤", "㎥", "㎥", "㎦", "㎙", "㎚", "㎛", "㎜", "㎝", "㎞", "㎟",
                                   "㎠", "㎡", "㎢", "㏊", "㎍", "㎎", "㎏", "㏏", "㎈", "㎉", "㏈", "㎧", "㎨", "㎰", "㎱", "㎲", "㎳", "㎴", "㎵", "㎶",
                                   "㎷", "㎸", "㎹", "㎀", "㎁", "㎂", "㎃", "㎄", "㎺", "㎻", "㎼", "㎽", "㎾", "㎿", "㎐", "㎑", "㎒", "㎓", "㎔", "Ω",
                                   "㏀", "㏁", "㎊", "㎋", "㎌", "㏖", "㏅", "㎭", "㎮", "㎯", "㏛", "㎩", "㎪", "㎫", "㎬", "㏝", "㏐", "㏓", "㏃", "㏉",
                                   "㏜", "㏆"
                                 ];
  this.letterSet["원/괄호문자"] = ["㉠", "㉡", "㉢", "㉣", "㉤", "㉥", "㉦", "㉧", "㉨", "㉩", "㉪", "㉫", "㉬", "㉭", "㉮", "㉯", "㉰", "㉱", "㉲", "㉳",
                                  "㉴", "㉵", "㉶", "㉷", "㉸", "㉹", "㉺", "㉻", "㈀", "㈁", "㈂", "㈃", "㈄", "㈅", "㈆", "㈇", "㈈", "㈉", "㈊", "㈋",
                                  "㈌", "㈍", "㈎", "㈏", "㈐", "㈑", "㈒", "㈓", "㈔", "㈕", "㈖", "㈗", "㈘", "㈙", "㈚", "㈛", "ⓐ", "ⓑ", "ⓒ", "ⓓ",
                                  "ⓔ", "ⓕ", "ⓖ", "ⓗ", "ⓘ", "ⓙ", "ⓚ", "ⓛ", "ⓜ", "ⓝ", "ⓞ", "ⓞ", "ⓟ", "ⓠ", "ⓡ", "ⓢ", "ⓣ", "ⓤ", "ⓥ", "ⓦ",
                                  "ⓧ", "ⓨ", "ⓩ", "①", "②", "③", "④", "⑤", "⑥", "⑦", "⑧", "⑨", "⑩", "⑪", "⑫", "⑬", "⑭", "⑮", "⒜", "⒝",
                                  "⒞", "⒟", "⒠", "⒡", "⒢", "⒣", "⒤", "⒥", "⒦", "⒧", "⒨", "⒩", "⒪", "⒫", "⒬", "⒭", "⒮", "⒯", "⒰", "⒱",
                                  "⒲", "⒳", "⒴", "⒵", "⑴", "⑵", "⑶", "⑷", "⑸", "⑹", "⑺", "⑻", "⑼", "⑽", "⑾", "⑿", "⒀", "⒁", "⒂"
                                ];
  this.letterSet["문자이모티콘"] = ["s(￣▽￣)/", "(*￣ .￣)a", "o(T^T)o", "♬(^0^)~♪", "＼(*｀Д´)/",
                                  "(/ㅡ_-)/~", "∠(- o -)", "(ㅡㅡ^)", "s(￣▽￣)v", "o(^-^)o", "s(￣へ￣ )z", "(づ_-)",
                                  "(-_ど)", "(づ_ど)", "s(ごoご)グ", "(づ_T)", "[_]a(^^* )", "☞^.^☜","ㅡ..ㅡㆀ",
                                  "(*^.☜)", "(/^o^)/♡", "[(￣.￣)]zZ", "┏(;-_-)┛",
                                  "┗(-_- )┓", "(^(oo)^)", "(^(oo)~)", "(T(oo)T)", "(-(oo)-)", "O(￣▽￣)o ", "ご,.ごㆀ",
                                  "(-.-)凸", "☞(>.<)☜", ">(/////)<", "＼(^0^*)/",
                                  "(ㅜ.ㅜ)", "☜(^^*)☞", "(ㅠ.ㅠ)", "(@.@)", "↖(^▽^)↗", "(☞^o^☜)",
                                  ">>---▷♡", "ミⓛㅅⓛミ", "=^ⓛㅅⓛ^=", "s(￣ 3￣)す=33", "へ(￣⌒￣へ)"
                                ];

  var letterHtml = '';
  letterHtml += '<div style="padding:3px;border:1px solid #dbdbdb;background:fbfbfb">';
  letterHtml += '<div style="padding-top:8px;padding-bottom:5px;padding-left:5px;padding-right:5px;">';
  for(key in letterSet){
    if(type == key){
      letterHtml += '<span style="margin-right:10px; font-size:12px; font-weight:bold; color:#757575; cursor:pointer;" onclick="editorSubDivChangeInner(event, \'' + mode + '\',\'' + ifrmObjId + '\', \'' + key + '\')">' + key;
      letterHtml += "</span>";
    }else{
      letterHtml += '<span style="margin-right:10px; font-size:12px; color:#757575; cursor:pointer;" onclick="editorSubDivChangeInner(event, \'' + mode + '\',\'' + ifrmObjId + '\', \'' + key + '\')">' + key;
      letterHtml += "</span>";
    }
  }
  letterHtml += "</div>";
  letterHtml += '<div id="letterArea" style="padding:3px;border:1px solid #dbdbdb;background:#ffffff">';
  letterHtml += '<table border="0" cellpadding="0" cellspacing="0" style=""><tr>';

  var cellCnt = 18;
  for(i=0;i<this.letterSet[type].length;i++){
    if(type == "문자이모티콘") cellCnt=5;
    letterHtml += '<td align="center" style="padding:3px; border:2px solid #ffffff;" onmouseover="onOverStyle(this)" onmouseout="onOutStyle(this)">';
    letterHtml += '<span onmousedown="editorInsertHTML(\'' + this.letterSet[type][i] + '\',\'' + ifrmObjId + '\')" style="cursor:pointer;font-size:12px;">' + this.letterSet[type][i] + '</span>';
    letterHtml += '</td>';
    if((i+1)%cellCnt == 0){
      letterHtml += '</tr><tr>';
    }
  }
  letterHtml += "</tr></table>";
  letterHtml += "</div>";
  letterHtml += "</div>";
  return letterHtml;

}


/**
 * 링크 삽입
 */
createlink = function(ifrmObjId){
  var createlinkHtml = '';
  createlinkHtml += '<div style="padding:3px;border:1px solid #dbdbdb;background:#fbfbfb">';
  createlinkHtml += '<div style="padding-top:8px;padding-bottom:5px;padding-left:5px;padding-right:5px;">';
  createlinkHtml += '<span style="margin-right:10px; font-size:12px; color:#757575;">선택된 부분에 삽입될 URL을 입력해주세요.';
  createlinkHtml += '</span>';
  createlinkHtml += '</div>';
  createlinkHtml += '<div style="padding:3px;border:1px solid #dbdbdb;background:#ffffff">';
  createlinkHtml += '<table border="0" cellpadding="0" cellspacing="0" style=""><tr>';
  createlinkHtml += '<td style="width:250px;height:40px;padding:3px; border:2px solid #ffffff;">';
  createlinkHtml += '<input type="text" id="createLinkUrl" style="border:1px solid #b5b5b5;width:250px;" value="http://" />';
  createlinkHtml += '</td></tr><tr><td align="right">';
  createlinkHtml += '<input type="button" style="border:1px solid #b5b5b5;width:50px;background:#fbfbfb;color:#757575;font-weight:bold;" value="확인" onclick="editorExecInput(\'createlink\', false, document.getElementById(\'createLinkUrl\').value, \'' + ifrmObjId + '\');" />';
  createlinkHtml += '</td></tr></table>';
  createlinkHtml += '</div>';
  createlinkHtml += '</div>';
  return createlinkHtml;
}


/**
 * 테이블 삽입
 */
table = function(ifrmObjId){
  var tableHtml = '';
  tableHtml += '<div style="padding:3px;border:1px solid #dbdbdb;background:#fbfbfb">';
  tableHtml += '<div style="padding-top:8px;padding-bottom:5px;padding-left:5px;padding-right:5px;">';
  tableHtml += '<span style="margin-right:10px; font-size:12px; color:#757575;"><b>표 삽입</b>';
  tableHtml += '</span>';
  tableHtml += '</div>';
  tableHtml += '<div id="tableArea" style="width:250px;padding:5px;border:1px solid #dbdbdb;background:#ffffff">';
  tableHtml += '<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#dbdbdb" >';
  tableHtml += '<tr bgcolor="#ffffff">';
  tableHtml += '<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>';
  tableHtml += '</tr>';
  tableHtml += '<tr bgcolor="#ffffff">';
  tableHtml += '<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>';
  tableHtml += '</tr>';
  tableHtml += '</table>';
  tableHtml += '</div>';
  tableHtml += '<div style="font-size:12px; color:#757575; padding:5px;">';
  tableHtml += '행 <input type="text" value="2" id="sampleTable_rowCnt" style="border:1px solid #b5b5b5;width:30px;background:#ffffff;color:#757575;text-align:right;padding-right:3px;margin-right:10px;" onchange="previewSampleTable();" />';
  tableHtml += '열 <input type="text" value="3" id="sampleTable_cellCnt" style="border:1px solid #b5b5b5;width:30px;background:#ffffff;color:#757575;text-align:right;padding-right:3px;" onchange="previewSampleTable();" />';
  tableHtml += '<div align="right" style="text-align:right;align:right;">';
  tableHtml += '<input type="button" style="border:1px solid #b5b5b5;width:50px;background:#fbfbfb;color:#757575;font-weight:bold;" value="삽입" onclick="editorInsertHTML(document.getElementById(\'tableArea\').innerHTML, \'' + ifrmObjId + '\');" />';
  tableHtml += '</div>';
  tableHtml += '</div>';
  tableHtml += '</div>';
  return tableHtml;
}
previewSampleTable = function(){
  var rowCnt = document.getElementById("sampleTable_rowCnt").value;
  var cellCnt = document.getElementById("sampleTable_cellCnt").value;
  var tableArea = document.getElementById("tableArea");
  var sampleTableHtml = '<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#dbdbdb" >';
  for(i=0;i<rowCnt;i++){
    sampleTableHtml += '<tr bgcolor="#ffffff">';
    sampleTableHtml += '<td>&nbsp;</td>';
    for(j=0;j<cellCnt-1;j++){
      sampleTableHtml += '<td>&nbsp;</td>';
    }
    sampleTableHtml += '</tr>';
  }
  sampleTableHtml += '</table>';

  tableArea.innerHTML = sampleTableHtml;
}


/**
 * 이미지 첨부
 */
attachImage = function(ifrmObjId){
  var createlinkHtml = '';
  createlinkHtml += '<div style="padding:3px;border:1px solid #dbdbdb;background:#fbfbfb">';
  createlinkHtml += '<div style="padding-top:8px;padding-bottom:5px;padding-left:5px;padding-right:5px;">';
  createlinkHtml += '<span style="margin-right:10px; font-size:12px; color:#757575;"><b>내컴퓨터 이미지 삽입</b>';
  createlinkHtml += '</span>';
  createlinkHtml += '</div>';
  createlinkHtml += '<div style="width:250px;height:45px;padding:6px;border:1px solid #dbdbdb;background:#ffffff">';
  createlinkHtml += '<div id="attachImage_frame">';
  createlinkHtml += '</div>';
  createlinkHtml += '<div style="padding-top:3px;text-align:right;">';
  createlinkHtml += '<input type="button" style="border:1px solid #b5b5b5;width:50px;background:#fbfbfb;color:#757575;font-weight:bold;" value="삽입" onmousedown="attachImage_local(\'' + ifrmObjId + '\');" />';
  createlinkHtml += '</div>';
  createlinkHtml += '</div>';
  createlinkHtml += '<div style="padding-top:8px;padding-bottom:5px;padding-left:5px;padding-right:5px;">';
  createlinkHtml += '<span style="margin-right:10px; font-size:12px; color:#757575;"><b>URL 이미지 삽입</b>';
  createlinkHtml += '</span>';
  createlinkHtml += '</div>';
  createlinkHtml += '<div id="attachImage_url" style="width:250px;height:45px;padding:6px;border:1px solid #dbdbdb;background:#ffffff">';
  createlinkHtml += '<input type="text" id="high_attachImage_url" style="width:148px;"><input style="font-size:13px;color:#000000;width:98px;" type="button" value="미리보기..." onclick="attachImage_preview(document.getElementById(\'high_attachImage_url\').value);">';
  createlinkHtml += '<div style="padding-top:3px;text-align:right;">';
  createlinkHtml += '<input type="button" style="border:1px solid #b5b5b5;width:50px;background:#fbfbfb;color:#757575;font-weight:bold;" value="삽입" onmousedown="attachImage_insertURL(document.getElementById(\'high_attachImage_url\').value, \'' + ifrmObjId + '\')" />';
  createlinkHtml += '</div>';
  createlinkHtml += '</div>';
  createlinkHtml += '<div style="padding-top:8px;padding-bottom:5px;padding-left:5px;padding-right:5px;text-align:center;">';
  createlinkHtml += '<span style="margin-right:10px; font-size:12px; color:#757575;text-align:center;">미리보기';
  createlinkHtml += '</span>';
  createlinkHtml += '</div>';
  createlinkHtml += '<div id="preview" style="width:250px;height:180px;padding:6px;border:1px solid #dbdbdb;background:#ffffff;text-align:center;vertical-align:middle;font-size:12px;color:#757575;">';
  createlinkHtml += 'URL 이미지 삽입만 지원합니다.';
  createlinkHtml += '</div>';
  createlinkHtml += '</div>';
  return createlinkHtml;
}


attachImageForm = function(ifrmObjId){

  this.attachImageFrmId = ifrmObjId + "_attachimage";
  this.attachImageFrm = document.createElement("iframe");
  this.attachImageFrm.setAttribute("id", this.attachImageFrmId);
  this.attachImageFrm.setAttribute("name", this.attachImageFrmId);
  this.attachImageFrm.setAttribute("scrolling","no");
  this.attachImageFrm.setAttribute("frameBorder","no");
  this.attachImageFrm.setAttribute("wrap","virtual");
  this.attachImageFrm.style.width = "250px";
  this.attachImageFrm.style.height = "22px";
  document.getElementById("attachImage_frame").appendChild(this.attachImageFrm);

  var attachImageFrmDoc = document.getElementById(this.attachImageFrmId).contentWindow.document;

  attachImageFrmDoc.open();
  attachImageFrmDoc.write("<html><head><title>Highgarden Editor</title>");
  attachImageFrmDoc.write("<meta http-equiv='Content-Type' content='text/html; charset=euc-kr' />");
  attachImageFrmDoc.write("<style type='text/css'>");
  attachImageFrmDoc.write("body,p{margin:0px; font-family:'돋움'; font-size:12px; line-height: 20px;}");
  attachImageFrmDoc.write("</style></head>");
  attachImageFrmDoc.write("<body style='width:100px;'>");
  attachImageFrmDoc.write("      <form name='attachImage_form' method='post' action='" + editor.editorRoot + "/attach_image.jsp'  enctype='multipart/form-data'>");
  attachImageFrmDoc.write("        <input name='high_attachImage' id='high_attachImage' type='file' />");
  attachImageFrmDoc.write("      </form>");
  attachImageFrmDoc.write("</body>");
  attachImageFrmDoc.write("</html>");
  attachImageFrmDoc.close();
}

attachImage_preview = function(value){
  if (/(\.gif|\.jpg|\.jpeg|\.png)$/i.test(value) == false) { alert("잘못된 이미지 URL입니다."); return; }
  document.getElementById("preview").innerHTML = "<img src='" + value + "' width='250' height='180'>";
}

attachImage_insertURL = function(value, ifrmObjId){
  if (/(\.gif|\.jpg|\.jpeg|\.png)$/i.test(value) == false) { alert("잘못된 이미지 URL입니다."); return; }
  editorExec('insertimage', false, value, ifrmObjId);
}

/* 내컴퓨터 이미지 삽입 부분 */
attachImage_local = function(ifrmObjId){

  var value = document.getElementById(ifrmObjId + "_attachimage").contentWindow.document.getElementById("high_attachImage").value;
  if (/(\.gif|\.jpg|\.jpeg|\.png)$/i.test(value) == false) { alert("잘못된 이미지 화일명입니다."); return; }
  document.getElementById(ifrmObjId + "_attachimage").contentWindow.document.forms[0].action = editor.editorUploadFile + "?menuType=etc&mode=attachImage&editor_upload=" + editor.editorUploadDir + "&ifrmObjId=" + ifrmObjId;
  document.getElementById(ifrmObjId + "_attachimage").contentWindow.document.forms[0].submit();
}


/**
 * div 삽입
 */
createDiv = function(ifrmObjId){
//  alert(document.getElementById(ifrmObjId).contentWindow.document.selection);
  this.ifrmObjId = ifrmObjId;

  this.divSet = new Object();
  this.divSet["quotation_1"] = ["border-left:2px solid #dbdbdb;padding:10px;width:80%;"];
  this.divSet["quotation_2"] = ["border:1px solid #dbdbdb;padding:10px;width:80%;"];
  this.divSet["quotation_3"] = ["border:2px solid #dbdbdb;padding:10px;width:80%;"];
  this.divSet["quotation_4"] = ["border:1px dashed #dbdbdb;padding:10px;width:80%;"];
  this.divSet["quotation_5"] = ["border:1px solid #dbdbdb;padding:10px;width:80%;background:#ebebeb"];
  this.divSet["quotation_6"] = ["border:1px dashed #dbdbdb;padding:10px;width:80%;background:#ebebeb"];

  var divSetHtml = '';
  divSetHtml += '<div style="padding:3px;border:1px solid #dbdbdb;background:fbfbfb">';
  divSetHtml += '<table border="0" cellpadding="0" cellspacing="0" style=""><tr>';

  for(key in divSet){
    var divIconSrc = editor.editorRoot + '/' + key + '.gif';
    divSetHtml += '<td align="center" style="padding:3px; border:2px solid #ffffff;" onmouseover="onOverStyle(this)" onmouseout="onOutStyle(this)">';
    divSetHtml += '<img src="' + divIconSrc + '" onmousedown="insertDiv(\'' + this.divSet[key][0] + '\',\'' + ifrmObjId + '\')" style="cursor:pointer;"></td>';
    divSetHtml += '</td>';
  }

  divSetHtml += "</tr></table>";
  divSetHtml += "</div>";

  return divSetHtml;

}

insertDiv = function(value, ifrmObjId){
  var divHtml = "<blockquote style='" + value + "'>&nbsp;</blockquote>";
  editorInsertHTML(divHtml, ifrmObjId);
}


/**
 * 레이아웃 삽입
 */
createLayout = function(ifrmObjId){
  this.ifrmObjId = ifrmObjId;

  this.layoutSet = new Array("layout_1", "layout_2", "layout_3", "layout_4", "layout_5", "layout_6", "layout_7", "layout_8", "layout_9");

  var layoutHtml = '';
  layoutHtml += '<div style="padding:3px;border:1px solid #dbdbdb;background:fbfbfb">';
  layoutHtml += '<table border="0" cellpadding="0" cellspacing="0" style=""><tr>';

  for(var i=0; i<layoutSet.length;i++){
    var layoutIconSrc = editor.editorRoot + '/' + layoutSet[i] + '.gif';
    layoutHtml += '<td align="center" style="padding:3px; border:2px solid #ffffff;" onmouseover="onOverStyle(this)" onmouseout="onOutStyle(this)">';
    layoutHtml += '<img src="' + layoutIconSrc + '" style="cursor:pointer;" onmousedown="insertLayout(\'' + ifrmObjId + '\', \'' + layoutSet[i] + '\')"></td>';
//    divSetHtml += '<img src="' + layoutIconSrc + '" onmousedown="insertDiv(\'' + this.layoutSet[key][0] + '\',\'' + ifrmObjId + '\')" style="cursor:pointer;"></td>';
    layoutHtml += '</td>';
  }

  layoutHtml += "</tr></table>";
  layoutHtml += "</div>";

  return layoutHtml;
}

insertLayout = function(ifrmObjId, layout){
  var insertLayoutHtml;
  var layoutImgSrc = editor.editorRoot + "/layout/acts_letter";
  switch(layout){
    case 'layout_1':
      insertLayoutHtml = '<table cellpadding="0" cellspacing="5"><tr><td class="basicBorder" valign="top" width="320px" height="460px">&nbsp;</td><td class="basicBorder" valign="top" width="320px">&nbsp;</td></tr></table>';
      break;
    case 'layout_2':
      insertLayoutHtml = '<table cellpadding="0" cellspacing="5"><tr><td class="basicBorder" valign="top" width="210px" height="460px">&nbsp;</td><td class="basicBorder" valign="top" width="210px">&nbsp;</td><td class="basicBorder" valign="top" width="210px">&nbsp;</td></tr></table>';
      break;
    case 'layout_3':
      insertLayoutHtml = '<table cellpadding="0" cellspacing="5"><tr><td class="basicBorder" valign="top" width="640px" height="230px">&nbsp;</td></tr><tr><td class="basicBorder" valign="top" width="640px" height="230px">&nbsp;</td></tr></table>';
      break;
    case 'layout_4':
      insertLayoutHtml = '<table cellpadding="0" cellspacing="5"><tr><td class="basicBorder" valign="top" width="320px" height="230px">&nbsp;</td><td class="basicBorder" valign="top" width="320px" rowspan="2">&nbsp;</td></tr>';
      insertLayoutHtml += '<tr><td class="basicBorder" valign="top" width="320px" height="230px">&nbsp;</td></tr></table>';
      break;
    case 'layout_5':
      insertLayoutHtml = '<table cellpadding="0" cellspacing="5"><tr><td class="basicBorder" valign="top" width="320px" rowspan="2">&nbsp;</td><td class="basicBorder" valign="top" width="320px" height="230px">&nbsp;</td></tr>';
      insertLayoutHtml += '<tr><td class="basicBorder" valign="top" width="320px" height="230px">&nbsp;</td></tr></table>';
      break;
    case 'layout_6':
      insertLayoutHtml = '<table cellpadding="0" cellspacing="5"><tr><td class="basicBorder" valign="top" width="320px" height="230px">&nbsp;</td><td class="basicBorder" valign="top" width="320px" height="230px">&nbsp;</td></tr>';
      insertLayoutHtml += '<tr><td class="basicBorder" valign="top" width="320px" height="230px">&nbsp;</td><td class="basicBorder" valign="top" width="320px" height="230px">&nbsp;</td></tr></table>';
      break;
    case 'layout_7':
      insertLayoutHtml = '<table cellpadding="0" cellspacing="5"><tr><td class="basicBorder" valign="top" width="320px" height="150px">&nbsp;</td><td class="basicBorder" valign="top" width="320px" rowspan="3">&nbsp;</td></tr>';
      insertLayoutHtml += '<tr><td class="basicBorder" valign="top" width="320px" height="150px">&nbsp;</td></tr><tr><td class="basicBorder" valign="top" width="150px" height="150px">&nbsp;</td></tr></table>';
      break;
    case 'layout_8':
      insertLayoutHtml = '<table cellpadding="0" cellspacing="5"><tr><td class="basicBorder" valign="top" width="320px" rowspan="3">&nbsp;</td><td class="basicBorder" valign="top" width="320px" height="150px">&nbsp;</td></tr>';
      insertLayoutHtml += '<tr><td class="basicBorder" valign="top" width="320px" height="150px">&nbsp;</td></tr><tr><td class="basicBorder" valign="top" width="150px" height="150px">&nbsp;</td></tr></table>';
      break;
    case 'layout_9':
      insertLayoutHtml = '<table width="640" border="0" cellspacing="0" cellpadding="0" style="background:' + layoutImgSrc + '/top_bg.gif top"><tr><td height="116" colspan="3" align="right" valign="bottom" background="' + layoutImgSrc + '/top.gif" style="font-size:12px; color:757575; padding:0 30 20 0px;"><span style="color:#3399ff; font-weight:bold;">제3호</span> 2008년 4월 3일 목요일 </td></tr>';
      insertLayoutHtml += '<tr><td width="27" valign="top" background="' + layoutImgSrc + '/bg_l.gif"><img src="' + layoutImgSrc + '/bg_l_sky.gif" width="27" height="283"></td><td width="586">';
      insertLayoutHtml += '<table width="100%" border="0" cellpadding="0" cellspacing="0" background="' + layoutImgSrc + '/top_bg.gif">';
      insertLayoutHtml += '<tr><td class="basicBorder" width="284" height="184"></td><td width="18"></td><td class="basicBorder" width="284" height="184"></td></tr>';
      insertLayoutHtml += '<tr><td height="10"></td><td></td><td></td></tr>';
      insertLayoutHtml += '<tr><td class="basicBorder" height="184"></td><td width="18"></td><td class="basicBorder"></td></tr>';
      insertLayoutHtml += '<tr><td height="10"></td><td></td><td></td></tr>';
      insertLayoutHtml += '<tr><td class="basicBorder" height="184"></td><td width="18"></td><td class="basicBorder"></td></tr>';
      insertLayoutHtml += '<tr><td height="10"></td><td></td><td></td></tr>';
      insertLayoutHtml += '<tr><td class="basicBorder" height="184"></td><td width="18"></td><td class="basicBorder"></td></tr>';
      insertLayoutHtml += '<tr><td height="20"></td><td></td><td></td></tr>';
      insertLayoutHtml += '</table></td><td width="27" valign="top" background="' + layoutImgSrc + '/bg_r.gif"><img src="' + layoutImgSrc + '/bg_r_sky.gif" width="27" height="283"></td></tr>';
      insertLayoutHtml += '<tr><td colspan="7"><img src="' + layoutImgSrc + '/copy.gif" width="640" height="92" border="0"></td></tr></table>';
      break;
  }

  editorInsertHTML(insertLayoutHtml, ifrmObjId);
}


/**
 * 서브메뉴 DIV 내용 객체 Style onmouseover, onmouseout
 */
onOverStyle = function(obj){
  obj.style.cssText = "padding:3px;border:2px solid #0066cc";
}

onOutStyle = function(obj){
  obj.style.cssText = "padding:3px;border:2px solid #ffffff";
}




/**
 * bug report 2008-07-11
 *
 * - sapari html <-> textarea 전환시 editor iframe 위치 바뀜
 *
 * 실제 페이지에 삽입시
  * - fire fox html <-> textarea 전환시 tool바 표시 안됨
 * - textarea 높이 계산 수정 필요
 */
