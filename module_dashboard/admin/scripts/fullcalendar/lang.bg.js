!function(a){"function"==typeof define&&define.amd?define(["jquery","moment"],a):a(jQuery,moment)}(function(a,b){(b.defineLocale||b.lang).call(b,"bg",{months:"ÑÐ½ÑƒÐ°Ñ€Ð¸_Ñ„ÐµÐ²Ñ€ÑƒÐ°Ñ€Ð¸_Ð¼Ð°Ñ€Ñ‚_Ð°Ð¿Ñ€Ð¸Ð»_Ð¼Ð°Ð¹_ÑŽÐ½Ð¸_ÑŽÐ»Ð¸_Ð°Ð²Ð³ÑƒÑÑ‚_ÑÐµÐ¿Ñ‚ÐµÐ¼Ð²Ñ€Ð¸_Ð¾ÐºÑ‚Ð¾Ð¼Ð²Ñ€Ð¸_Ð½Ð¾ÐµÐ¼Ð²Ñ€Ð¸_Ð´ÐµÐºÐµÐ¼Ð²Ñ€Ð¸".split("_"),monthsShort:"ÑÐ½Ñ€_Ñ„ÐµÐ²_Ð¼Ð°Ñ€_Ð°Ð¿Ñ€_Ð¼Ð°Ð¹_ÑŽÐ½Ð¸_ÑŽÐ»Ð¸_Ð°Ð²Ð³_ÑÐµÐ¿_Ð¾ÐºÑ‚_Ð½Ð¾Ðµ_Ð´ÐµÐº".split("_"),weekdays:"Ð½ÐµÐ´ÐµÐ»Ñ_Ð¿Ð¾Ð½ÐµÐ´ÐµÐ»Ð½Ð¸Ðº_Ð²Ñ‚Ð¾Ñ€Ð½Ð¸Ðº_ÑÑ€ÑÐ´Ð°_Ñ‡ÐµÑ‚Ð²ÑŠÑ€Ñ‚ÑŠÐº_Ð¿ÐµÑ‚ÑŠÐº_ÑÑŠÐ±Ð¾Ñ‚Ð°".split("_"),weekdaysShort:"Ð½ÐµÐ´_Ð¿Ð¾Ð½_Ð²Ñ‚Ð¾_ÑÑ€Ñ_Ñ‡ÐµÑ‚_Ð¿ÐµÑ‚_ÑÑŠÐ±".split("_"),weekdaysMin:"Ð½Ð´_Ð¿Ð½_Ð²Ñ‚_ÑÑ€_Ñ‡Ñ‚_Ð¿Ñ‚_ÑÐ±".split("_"),longDateFormat:{LT:"H:mm",LTS:"LT:ss",L:"D.MM.YYYY",LL:"D MMMM YYYY",LLL:"D MMMM YYYY LT",LLLL:"dddd, D MMMM YYYY LT"},calendar:{sameDay:"[Ð”Ð½ÐµÑ Ð²] LT",nextDay:"[Ð£Ñ‚Ñ€Ðµ Ð²] LT",nextWeek:"dddd [Ð²] LT",lastDay:"[Ð’Ñ‡ÐµÑ€Ð° Ð²] LT",lastWeek:function(){switch(this.day()){case 0:case 3:case 6:return"[Ð’ Ð¸Ð·Ð¼Ð¸Ð½Ð°Ð»Ð°Ñ‚Ð°] dddd [Ð²] LT";case 1:case 2:case 4:case 5:return"[Ð’ Ð¸Ð·Ð¼Ð¸Ð½Ð°Ð»Ð¸Ñ] dddd [Ð²] LT"}},sameElse:"L"},relativeTime:{future:"ÑÐ»ÐµÐ´ %s",past:"Ð¿Ñ€ÐµÐ´Ð¸ %s",s:"Ð½ÑÐºÐ¾Ð»ÐºÐ¾ ÑÐµÐºÑƒÐ½Ð´Ð¸",m:"Ð¼Ð¸Ð½ÑƒÑ‚Ð°",mm:"%d Ð¼Ð¸Ð½ÑƒÑ‚Ð¸",h:"Ñ‡Ð°Ñ",hh:"%d Ñ‡Ð°ÑÐ°",d:"Ð´ÐµÐ½",dd:"%d Ð´Ð½Ð¸",M:"Ð¼ÐµÑÐµÑ†",MM:"%d Ð¼ÐµÑÐµÑ†Ð°",y:"Ð³Ð¾Ð´Ð¸Ð½Ð°",yy:"%d Ð³Ð¾Ð´Ð¸Ð½Ð¸"},ordinalParse:/\d{1,2}-(ÐµÐ²|ÐµÐ½|Ñ‚Ð¸|Ð²Ð¸|Ñ€Ð¸|Ð¼Ð¸)/,ordinal:function(a){var b=a%10,c=a%100;return 0===a?a+"-ÐµÐ²":0===c?a+"-ÐµÐ½":c>10&&20>c?a+"-Ñ‚Ð¸":1===b?a+"-Ð²Ð¸":2===b?a+"-Ñ€Ð¸":7===b||8===b?a+"-Ð¼Ð¸":a+"-Ñ‚Ð¸"},week:{dow:1,doy:7}}),a.fullCalendar.datepickerLang("bg","bg",{closeText:"Ð·Ð°Ñ‚Ð²Ð¾Ñ€Ð¸",prevText:"&#x3C;Ð½Ð°Ð·Ð°Ð´",nextText:"Ð½Ð°Ð¿Ñ€ÐµÐ´&#x3E;",nextBigText:"&#x3E;&#x3E;",currentText:"Ð´Ð½ÐµÑ",monthNames:["Ð¯Ð½ÑƒÐ°Ñ€Ð¸","Ð¤ÐµÐ²Ñ€ÑƒÐ°Ñ€Ð¸","ÐœÐ°Ñ€Ñ‚","ÐÐ¿Ñ€Ð¸Ð»","ÐœÐ°Ð¹","Ð®Ð½Ð¸","Ð®Ð»Ð¸","ÐÐ²Ð³ÑƒÑÑ‚","Ð¡ÐµÐ¿Ñ‚ÐµÐ¼Ð²Ñ€Ð¸","ÐžÐºÑ‚Ð¾Ð¼Ð²Ñ€Ð¸","ÐÐ¾ÐµÐ¼Ð²Ñ€Ð¸","Ð”ÐµÐºÐµÐ¼Ð²Ñ€Ð¸"],monthNamesShort:["Ð¯Ð½Ñƒ","Ð¤ÐµÐ²","ÐœÐ°Ñ€","ÐÐ¿Ñ€","ÐœÐ°Ð¹","Ð®Ð½Ð¸","Ð®Ð»Ð¸","ÐÐ²Ð³","Ð¡ÐµÐ¿","ÐžÐºÑ‚","ÐÐ¾Ð²","Ð”ÐµÐº"],dayNames:["ÐÐµÐ´ÐµÐ»Ñ","ÐŸÐ¾Ð½ÐµÐ´ÐµÐ»Ð½Ð¸Ðº","Ð’Ñ‚Ð¾Ñ€Ð½Ð¸Ðº","Ð¡Ñ€ÑÐ´Ð°","Ð§ÐµÑ‚Ð²ÑŠÑ€Ñ‚ÑŠÐº","ÐŸÐµÑ‚ÑŠÐº","Ð¡ÑŠÐ±Ð¾Ñ‚Ð°"],dayNamesShort:["ÐÐµÐ´","ÐŸÐ¾Ð½","Ð’Ñ‚Ð¾","Ð¡Ñ€Ñ","Ð§ÐµÑ‚","ÐŸÐµÑ‚","Ð¡ÑŠÐ±"],dayNamesMin:["ÐÐµ","ÐŸÐ¾","Ð’Ñ‚","Ð¡Ñ€","Ð§Ðµ","ÐŸÐµ","Ð¡ÑŠ"],weekHeader:"Wk",dateFormat:"dd.mm.yy",firstDay:1,isRTL:!1,showMonthAfterYear:!1,yearSuffix:""}),a.fullCalendar.lang("bg",{buttonText:{month:"ÐœÐµÑÐµÑ†",week:"Ð¡ÐµÐ´Ð¼Ð¸Ñ†Ð°",day:"Ð”ÐµÐ½",list:"Ð“Ñ€Ð°Ñ„Ð¸Ðº"},allDayText:"Ð¦ÑÐ» Ð´ÐµÐ½",eventLimitText:function(a){return"+Ð¾Ñ‰Ðµ "+a}})});