/*
 +-------------------------------------------------------------------+
 |                    J S - L O A D E R   (v1.4)                     |
 |                          P a r t   I                              |
 |                                                                   |
 | Copyright Gerd Tentler               www.gerd-tentler.de/tools    |
 | Created: Mar. 26, 2002               Last modified: Mar. 28, 2006 |
 +-------------------------------------------------------------------+
 | This program may be used and hosted free of charge by anyone for  |
 | personal purpose as long as this copyright notice remains intact. |
 |                                                                   |
 | Obtain permission before selling the code for this program or     |
 | hosting this software on a commercial website or redistributing   |
 | this software over the Internet or in any other medium. In all    |
 | cases copyright must remain intact.                               |
 +-------------------------------------------------------------------+

======================================================================================================
 This script was tested with the following systems and browsers:

 - Windows XP: IE 6, NN 7, Opera 7, Firefox 1
 - Mac OS X:   IE 5

 If you use another browser or system, this script may not work for you - sorry.

 NOTE: Safari 1 (Mac OS X) does not support "document.images[].complete", so the progress bar will
       not be shown.
======================================================================================================
*/
//----------------------------------------------------------------------------------------------------
// Configuration
//----------------------------------------------------------------------------------------------------

  var boxText = "Cargando ... espere por favor!";   // dialog box message
  var boxFont = "bold 12px Arial,Helvetica";  // dialog box font (CSS spec: "style size family")
  var boxFontColor = "#000000";               // dialog box font color
  var boxWidth = 250;                         // dialog box width (pixels)
  var boxHeight = 100;                        // dialog box height (pixels)
  var boxBGColor = "url(images/ajax-loader/ajax-loader14.gif) transparent no-repeat 0px 0px";                 // dialog box background color
  var boxBorder = "0px outset #E0E0E0";       // dialog box border (CSS spec: "size style color")

  var barLength = 200;                        // progress bar length (pixels)
  var barHeight = 15;                         // progress bar height (pixels)
  var barColor = "#fffff";                   // progress bar color
  var barBGColor = "rgba(68, 67, 40, 0.68)";                 // progress bar background color

  var fadeInSpeed = 30;                       // content fade-in speed (0 - 30; 0 = no fading)*

// * Fading was successfully tested only on Windows XP with IE 6, NN 7 and Firefox 1. It seems that
//   other browsers and systems do not support this feature.

//----------------------------------------------------------------------------------------------------
// Build dialog box and progress bar
//----------------------------------------------------------------------------------------------------

  var safari = (navigator.userAgent.indexOf('Safari') != -1) ? true : false;

  if((document.all || document.getElementById) && !safari) {
    document.write('<style> .clsBox { ' +
                   'position:absolute; top:50%; left:50%; ' +
                   'width:' + boxWidth + 'px; ' +
                   'height:' + boxHeight + 'px; ' +
                   'margin-top:-' + Math.round(boxHeight / 2) + 'px; ' +
                   'margin-left:-' + Math.round(boxWidth / 2) + 'px; ' +
                    (boxBorder ? 'border:' + boxBorder + '; ' : '') +
                   'z-index:69; ' +
                   '} .clsBarBG { ' +
                   'width:' + (barLength + 4) + 'px; ' +
                   'height:' + (barHeight + 4) + 'px; ' +
                   'border-top:0px solid black; border-left:0px solid black; ' +
                   'border-bottom:0px solid silver; border-right:0px solid silver; ' +
                   'margin:0px; padding:0px; ' +
                   '} .clsBar { ' +
                   'width:0px; height:' + barHeight + 'px; ' +
                   'background:' + boxBGColor + '; ' +
                   'border-top:0px solid silver; border-left:0px solid silver; ' +
                   'border-bottom:0px solid black; border-right:0px solid black; ' +
                   'margin:1px; padding:0px; ' +
                   'font-size:1px; ' +
                   '} .clsText { ' +
                   'font:' + boxFont + '; ' +
                   'color:' + boxFontColor + '; ' +
                   '} </style> ' +
                   '<div id="divBox" class="clsBox">' +
                   '<table border=0 cellspacing=0 cellpadding=0><tr>' +
                   '<td width=' + boxWidth + ' height=' + boxHeight + ' align=center>' +
                   (boxText ? '<p class="clsText" align=left>' + boxText + '</p>' : '') +
                   '<table border=0 cellspacing=0 cellpadding=0><tr><td width=' + barLength + '>' +
                   '<div id="divBarBG" class="clsBarBG"><div id="divBar" class="clsBar"></div></div>' +
                   '</td></tr></table>' +
                   '</td></tr></table></div>' +
                   '<div id="Content" style="width:100%; visibility:hidden">');
  }

//----------------------------------------------------------------------------------------------------
