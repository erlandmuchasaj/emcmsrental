
/*
* Title                   : Booking Calendar PRO (jQuery Plugin)
* Version                 : 1.2
* File                    : jquery.dop.FrontendBookingCalendarPRO.js
* File Version            : 1.2
* Created / Last Modified : 20 May 2013
* Author                  : Dot on Paper
* Copyright               : © 2011 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking Calendar PRO Front End jQuery plugin.
*/

(function($){
    $.fn.DOPFrontendBookingCalendarPRO = function(options){
        // plugin default values
        var Data = {
            'AddtMonthViewText': 'Add Month View', // Add Month View button title (plus icon).
            'AvailableDays': [true, true, true, true, true, true, true], // Set available/unavailable days starting with Monday.
            'AvailableOneText': 'available', // Available Day text for one item.
            'AvailableText': 'available', // Available text for more items.
            'BookedText': 'booked', // Booked Day text.
            'Currency': '€', // Currency icon. $
            'DataURL': '', // URL from were JSON data is loaded.
            'DayNames': ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'], // Weekdays long names.
            'DayShortNames': ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'], // Weekdays short names.
            'FirstDay': 1, // Set the first day of the week (1 = Monday, 2 = Tuesday, 3 = Wednesday, 4 = Thursday, 5 = Friday, 6 = Saturday, 7 = Sunday)
            'ID': 0, // Calendar ID. Change it if you have more then one calendar. Make it the same as the Back End version.
            'MonthNames': ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'], // Months long names.
            'MonthShortNames': ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], // Months short names.
            'MorningCheckOut': true, // Display the calendar with Morning Checkout days.
            'NextMonthText': 'Next Month', // Next Month button title.
            'PreviousMonthText': 'Previous Month', // Previous Month button title.
            'Reinitialize': false, // Reinitialize the calendar if already loaded.
            'RemoveMonthViewText': 'Remove Month View', // Remove Month View button title (minus icon).
            'UnavailableText': 'unavailable',
            /*******************************************************************/
            'PropertyID'            : 0, // ID of the property that shis calendar belong to.
            'PropertyPrice'         : 0, // Inicialisation of the property price.
            'BeforeBookedLabel'     : 'Using', // Label before selection data of the user
            'UsingEmptyText'        : 'Select',
            'BookedUsingLabel'      : 'Booked Using',
            'UsingPortalText'       : 'Portal',
            'UsingViaEmailText'     : 'Via E-mail',
            'UsingOfflineSourceText': 'Offline Sources',
            'UsingOtherText'        : 'Other'
        }, // Unavailable Day text.
        
        Container = this,
        
        Schedule = {},

        StartDate = new Date(),
        StartYear = StartDate.getFullYear(),
        StartMonth = StartDate.getMonth()+1,
        StartDay = StartDate.getDate(),
        CurrYear = StartYear,
        CurrMonth = StartMonth,      

        AddtMonthViewText = 'Add Month View',
        AvailableDays = [true, true, true, true, true, true, true],
        AvailableOneText = 'available',
        AvailableText = 'available',
        BookedText = 'booked',
        Currency = '$',
        DataURL = 'dopbcp/php-file/load.php',
        DayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
        DayShortNames = ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
        FirstDay = 1,
        ID = 0,
        MonthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        MonthShortNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        MorningCheckOut = false,
        NextMonthText = 'Next Month',
        PreviousMonthText = 'Previous Month',
        RemoveMonthViewText = 'Remove Month View',
        UnavailableText = 'unavailable',
        /***************************************/
        PropertyID            = 0,
        PropertyPrice         = 0,
        BeforeBookedLabel     = 'Using',
        BookedUsingLabel      = 'Booked Using',
        UsingEmptyText        = 'Select',
        UsingPortalText       = 'Portal',
        UsingViaEmailText     = 'Via E-mail',
        UsingOfflineSourceText= 'Offline Sources',
        UsingOtherText        = 'Other',

        noMonths = 1,
        dayPreviousStatus = '',
        dayPreviousBind = 0,
        dayNo = 0,

        methods = {
            init:function( ){// Init Plugin.
                return this.each(function(){
                    if (options){
                        $.extend(Data, options);
                    }
                    
                    if (!$(Container).hasClass('dopbcp-initialized') || Data['Reinitialize']){
                        $('#DOPFrontendBookingCalendarPRO_Info'+ID).remove();
                        $(Container).addClass('dopbcp-initialized');
                        methods.parseData();
                        $(window).on('resize.DOPFrontendBookingCalendarPRO', methods.initRP);                          
                    }
                });
            },
            
            parseData:function(){
                Container.html('<div class="DOPFrontendBookingCalendarPRO_Container loader"></div>');
                
                AddtMonthViewText = Data['AddtMonthViewText'];
                AvailableDays[0] = Data['AvailableDays'][0];
                AvailableDays[1] = Data['AvailableDays'][1];
                AvailableDays[2] = Data['AvailableDays'][2];
                AvailableDays[3] = Data['AvailableDays'][3];
                AvailableDays[4] = Data['AvailableDays'][4];
                AvailableDays[5] = Data['AvailableDays'][5];
                AvailableDays[6] = Data['AvailableDays'][6];  
                AvailableOneText = Data['AvailableOneText'];
                AvailableText = Data['AvailableText'];
                BookedText = Data['BookedText'];
                Currency = Data['Currency'];
                DataURL = Data['DataURL'];
                DayNames = Data['DayNames'];
                DayShortNames = Data['DayShortNames'];
                FirstDay = parseInt(Data['FirstDay']);
                ID = Data['ID'];
                PropertyID = Data['PropertyID'];
                MonthNames = Data['MonthNames'];
                MonthShortNames = Data['MonthShortNames'];
                MorningCheckOut = Data['MorningCheckOut'];
                NextMonthText = Data['NextMonthText'];
                PreviousMonthText = Data['PreviousMonthText'];
                RemoveMonthViewText = Data['RemoveMonthViewText'];
                UnavailableText = Data['UnavailableText'];
                /***************************************/
                PropertyID            = Data['PropertyID'];
                PropertyPrice         = Data['PropertyPrice'];
                BeforeBookedLabel     = Data['BeforeBookedLabel'];
                BookedUsingLabel      = Data['BookedUsingLabel'];
                UsingEmptyText        = Data['UsingEmptyText'];
                UsingPortalText       = Data['UsingPortalText'];
                UsingViaEmailText     = Data['UsingViaEmailText'];
                UsingOfflineSourceText= Data['UsingOfflineSourceText'];
                UsingOtherText        = Data['UsingOtherText'];
                
                methods.parseCalendarData();
            },

            parseCalendarData:function(){ 
                $.post(prototypes.acaoBuster(DataURL), {calendar_id:ID, property_id: PropertyID}, function(data){
                    data = $.trim(data).replace(/\\/gi, '');
                    if (data != ''){
                        Schedule = JSON.parse(data);
                    }                            
                    methods.initCalendar();
                });
            },

            initCalendar:function(){// Init  Calendar
                var HTML = new Array();
                
                // ***************************************************** Calendar HTML
                HTML.push('<div class="DOPFrontendBookingCalendarPRO_Container">'); 
                HTML.push('    <div class="DOPFrontendBookingCalendarPRO_Navigation">');
                HTML.push('        <div class="month_year"></div>');
                HTML.push('        <div class="week">');
                HTML.push('            <div class="day"></div>');
                HTML.push('            <div class="day"></div>');
                HTML.push('            <div class="day"></div>');
                HTML.push('            <div class="day"></div>');
                HTML.push('            <div class="day"></div>');
                HTML.push('            <div class="day"></div>');
                HTML.push('            <div class="day"></div>');
                HTML.push('            <br class="DOPFrontendBookingCalendarPRO_Clear" />');
                HTML.push('        </div>');
                HTML.push('        <div class="add_btn" title="'+AddtMonthViewText+'"></div>');                        
                HTML.push('        <div class="remove_btn" title="'+RemoveMonthViewText+'"></div>');
                HTML.push('        <div class="previous_btn" title="'+PreviousMonthText+'"></div>');
                HTML.push('        <div class="next_btn" title="'+NextMonthText+'"></div>');
                HTML.push('    </div>');
                HTML.push('    <div class="DOPFrontendBookingCalendarPRO_Calendar"></div>');
                HTML.push('</div>');
                
                Container.html(HTML.join(''));
                $('body').append('<div class="DOPFrontendBookingCalendarPRO_Info" id="DOPFrontendBookingCalendarPRO_Info'+ID+'"></div>');
                
                methods.initSettings();
            },

            initSettings:function(){// Init  Settings
                methods.initContainer();
                methods.initNavigation();
                methods.initInfo();
                methods.generateCalendar(StartYear, StartMonth);
            },

            initRP:function(){
                methods.rpContainer();
                methods.rpNavigation();
                methods.rpDays();
            },
            
            initContainer:function(){// Init Container
                methods.rpContainer();
            },

            rpContainer:function(){// RP Container
                var hiddenBustedItems = prototypes.doHideBuster($(Container));
                
                $('.DOPFrontendBookingCalendarPRO_Container', Container).width(Container.width());
                
                if (Container.width() <= 280){
                    $('.DOPFrontendBookingCalendarPRO_Navigation .month_year', Container).html(MonthShortNames[(CurrMonth%12 != 0 ? CurrMonth%12:12)-1]+' '+CurrYear); 
                }
                else{
                    $('.DOPFrontendBookingCalendarPRO_Navigation .month_year', Container).html(MonthNames[(CurrMonth%12 != 0 ? CurrMonth%12:12)-1]+' '+CurrYear); 
                }
                
                prototypes.undoHideBuster(hiddenBustedItems);
            },
            
            initNavigation:function(){// Init Navigation
                methods.rpNavigation();
                
                if (!prototypes.isTouchDevice()){
                    $('.DOPFrontendBookingCalendarPRO_Navigation .previous_btn', Container).hover(function(){
                        $(this).addClass('hover');
                    }, function(){
                        $(this).removeClass('hover');
                    });

                    $('.DOPFrontendBookingCalendarPRO_Navigation .next_btn', Container).hover(function(){
                        $(this).addClass('hover');
                    }, function(){
                        $(this).removeClass('hover');
                    });

                    $('.DOPFrontendBookingCalendarPRO_Navigation .add_btn', Container).hover(function(){
                        $(this).addClass('hover');
                    }, function(){
                        $(this).removeClass('hover');
                    });

                    $('.DOPFrontendBookingCalendarPRO_Navigation .remove_btn', Container).hover(function(){
                        $(this).addClass('hover');
                    }, function(){
                        $(this).removeClass('hover');
                    }); 
                }
                
                $('.DOPFrontendBookingCalendarPRO_Navigation .previous_btn', Container).off('click');
                $('.DOPFrontendBookingCalendarPRO_Navigation .previous_btn', Container).on('click', function(){
                    methods.generateCalendar(StartYear, CurrMonth-1);
                    if (CurrMonth == StartMonth){
                        $('.DOPFrontendBookingCalendarPRO_Navigation .previous_btn', Container).css('display', 'none');
                    }
                });
                
                $('.DOPFrontendBookingCalendarPRO_Navigation .next_btn', Container).off('click');
                $('.DOPFrontendBookingCalendarPRO_Navigation .next_btn', Container).on('click', function(){
                    methods.generateCalendar(StartYear, CurrMonth+1);
                    $('.DOPFrontendBookingCalendarPRO_Navigation .previous_btn', Container).css('display', 'block');
                });
                
                $('.DOPFrontendBookingCalendarPRO_Navigation .add_btn', Container).off('click');
                $('.DOPFrontendBookingCalendarPRO_Navigation .add_btn', Container).on('click', function(){
                    noMonths++;
                    methods.generateCalendar(StartYear, CurrMonth);
                    $('.DOPFrontendBookingCalendarPRO_Navigation .remove_btn', Container).css('display', 'block');
                });
                                        
                $('.DOPFrontendBookingCalendarPRO_Navigation .remove_btn', Container).off('click');
                $('.DOPFrontendBookingCalendarPRO_Navigation .remove_btn', Container).on('click', function(){
                    noMonths--;
                    methods.generateCalendar(StartYear, CurrMonth);
                    if(noMonths == 1){
                        $('.DOPFrontendBookingCalendarPRO_Navigation .remove_btn', Container).css('display', 'none');
                    }
                });
            },

            rpNavigation:function(){ // RP Navigation
                var no = 0,
                hiddenBustedItems = prototypes.doHideBuster($(Container));
                
                $('.DOPFrontendBookingCalendarPRO_Navigation .week .day', Container).width(parseInt(($('.DOPFrontendBookingCalendarPRO_Navigation .week', Container).width()-parseInt($('.DOPFrontendBookingCalendarPRO_Navigation .week', Container).css('padding-left'))+parseInt($('.DOPFrontendBookingCalendarPRO_Navigation .week', Container).css('padding-right')))/7));
                
                no = FirstDay-1;
                
                $('.DOPFrontendBookingCalendarPRO_Navigation .week .day', Container).each(function(){
                    no++;
                    
                    if (no == 7){
                        no = 0;
                    }
                        
                    if ($(this).width() <= 70){
                        $(this).html(DayShortNames[no]);
                    }
                    else{
                        $(this).html(DayNames[no]);
                    }
                });
                
                prototypes.undoHideBuster(hiddenBustedItems);
            },
            
            generateCalendar:function(startYear, startMonth){// Init Calendar
                CurrYear = new Date(startYear, startMonth, 0).getFullYear();
                CurrMonth = startMonth;    
                
                if (startYear != StartYear || startMonth != StartMonth){
                    $('.DOPFrontendBookingCalendarPRO_Navigation .previous_btn', Container).css('display', 'block');
                }
                
                dayPreviousStatus = '';
                dayPreviousBind = 0;
                               
                if (Container.width() <= 280){
                    $('.DOPFrontendBookingCalendarPRO_Navigation .month_year', Container).html(MonthShortNames[(CurrMonth%12 != 0 ? CurrMonth%12:12)-1]+' '+CurrYear); 
                } else {
                    $('.DOPFrontendBookingCalendarPRO_Navigation .month_year', Container).html(MonthNames[(CurrMonth%12 != 0 ? CurrMonth%12:12)-1]+' '+CurrYear); 
                }
                $('.DOPFrontendBookingCalendarPRO_Calendar', Container).html('');   

                for (var i=1; i<=noMonths; i++) {
                    methods.initMonth(CurrYear, startMonth = startMonth%12 != 0 ? startMonth%12:12, i);
                    startMonth++;

                    if (startMonth % 12 == 1){
                        CurrYear++;
                        startMonth = 1;
                    }                            
                }
            },

            initMonth:function(year, month, position){// Init Month
                var i, d, cyear, cmonth, cday, start, totalDays = 0,
                noDays = new Date(year, month, 0).getDate(),
                noDaysPreviousMonth = new Date(year, month-1, 0).getDate(),
                firstDay = new Date(year, month-1, 2-FirstDay).getDay(),
                lastDay = new Date(year, month-1, noDays-FirstDay+1).getDay(),
                monthHTML = new Array(), 
                day = methods.defaultDay();
                
                dayNo = 0;
                
                monthHTML.push('<div class="DOPFrontendBookingCalendarPRO_Month">');
                
                if (position > 1){
                    monthHTML.push('<div class="month_year">'+MonthNames[(month%12 != 0 ? month%12:12)-1]+' '+year+'</div>');
                }
                                        
                if (firstDay == 0){
                    start = 7;
                } else {
                    start = firstDay;
                }
                
                for (i=start-1; i>=1; i--){
                    totalDays++;
                    
                    d = new Date(year, month-2, noDaysPreviousMonth-i+1);
                    cyear = d.getFullYear();
                    cmonth = prototypes.timeLongItem(d.getMonth()+1);
                    cday = prototypes.timeLongItem(d.getDate());
                    day = Schedule[cyear+'-'+cmonth+'-'+cday] != undefined ? Schedule[cyear+'-'+cmonth+'-'+cday]:methods.defaultDay(methods.weekDay(cyear, cmonth, cday));
                    
                    dayPreviousStatus = dayPreviousStatus == '' ? Schedule[methods.previousDay(cyear+'-'+cmonth+'-'+cday)] != undefined ? Schedule[methods.previousDay(cyear+'-'+cmonth+'-'+cday)]['status']:'none':dayPreviousStatus;
                    dayPreviousBind = dayPreviousBind == 0 ? Schedule[methods.previousDay(cyear+'-'+cmonth+'-'+cday)] != undefined ? Schedule[methods.previousDay(cyear+'-'+cmonth+'-'+cday)]['group']:0:dayPreviousBind;
                    
                    if (StartMonth == month && StartYear == year){
                        monthHTML.push(methods.initDay('past_day', 
                                                       ID+'_'+cyear+'-'+cmonth+'-'+cday, 
                                                       d.getDate(), 
                                                       '', '', '', '', '', '', 'none',''));            
                    }
                    else{
                        monthHTML.push(methods.initDay('last_month'+(position>1 ?  ' mask':''), 
                                                       position>1 ? ID+'_'+cyear+'-'+cmonth+'-'+cday+'_last':ID+'_'+cyear+'-'+cmonth+'-'+cday, 
                                                       d.getDate(), 
                                                       day['available'], day['bind'], day['info'], day['notes'], day['price'], day['promo'], day['status'], day['booked_using']));
                    }
                }
                
                for (i=1; i<=noDays; i++){
                    totalDays++;
                    
                    d = new Date(year, month-1, i);
                    cyear = d.getFullYear();
                    cmonth = prototypes.timeLongItem(d.getMonth()+1);
                    cday = prototypes.timeLongItem(d.getDate());
                    day = Schedule[cyear+'-'+cmonth+'-'+cday] != undefined ? Schedule[cyear+'-'+cmonth+'-'+cday]:methods.defaultDay(methods.weekDay(cyear, cmonth, cday));
                    
                    if (StartMonth == month && StartYear == year && StartDay > d.getDate()){
                        monthHTML.push(methods.initDay('past_day', 
                                                       ID+'_'+cyear+'-'+cmonth+'-'+cday, 
                                                       d.getDate(), 
                                                       '', '', '', '', '', '', 'none',''));    
                    }
                    else{
                        monthHTML.push(methods.initDay('curr_month', 
                                                       ID+'_'+cyear+'-'+cmonth+'-'+cday, 
                                                       d.getDate(), 
                                                       day['available'], day['bind'], day['info'], day['notes'], day['price'], day['promo'], day['status'], day['booked_using']));
                    }
                }

                if (totalDays+7 < 42){
                    for (i=1; i<=14-lastDay; i++){
                        d = new Date(year, month, i);
                        cyear = d.getFullYear();
                        cmonth = prototypes.timeLongItem(d.getMonth()+1);
                        cday = prototypes.timeLongItem(d.getDate());
                        day = Schedule[cyear+'-'+cmonth+'-'+cday] != undefined ? Schedule[cyear+'-'+cmonth+'-'+cday]:methods.defaultDay(methods.weekDay(cyear, cmonth, cday));
                    
                        monthHTML.push(methods.initDay('next_month'+(position<noMonths ?  ' hide':''), 
                                                       position<noMonths ? ID+'_'+cyear+'-'+cmonth+'-'+cday+'_next':ID+'_'+cyear+'-'+cmonth+'-'+cday, 
                                                       d.getDate(), 
                                                       day['available'], day['bind'], day['info'], day['notes'], day['price'], day['promo'], day['status'], day['booked_using']));
                    }
                }
                else{
                    for (i=1; i<=7-lastDay; i++){
                        d = new Date(year, month, i);
                        cyear = d.getFullYear();
                        cmonth = prototypes.timeLongItem(d.getMonth()+1);
                        cday = prototypes.timeLongItem(d.getDate());
                        day = Schedule[cyear+'-'+cmonth+'-'+cday] != undefined ? Schedule[cyear+'-'+cmonth+'-'+cday]:methods.defaultDay(methods.weekDay(cyear, cmonth, cday));
                        
                        monthHTML.push(methods.initDay('next_month'+(position<noMonths ?  ' hide':''), 
                                                       position<noMonths ? ID+'_'+cyear+'-'+cmonth+'-'+cday+'_next':ID+'_'+cyear+'-'+cmonth+'-'+cday, 
                                                       d.getDate(), 
                                                       day['available'], day['bind'], day['info'], day['notes'], day['price'], day['promo'], day['status'], day['booked_using']));
                    }
                }

                monthHTML.push('    <br class="DOPFrontendBookingCalendarPRO_Clear" />');
                monthHTML.push('</div>');

                $('.DOPFrontendBookingCalendarPRO_Calendar', Container).append(monthHTML.join(''));
                
                methods.rpDays();
                methods.initDayEvents();
            },
            
            initDay:function(type, id, day, available, bind, info, notes, price, promo, status, booked_using){// Init Day
                var dayHTML = Array(),
                contentLine1 = '&nbsp;', 
                contentLine2 = '&nbsp;';
                BookedUsingText = '&nbsp;';
                
                dayNo++;
                
                if (price > 0 && (bind == 0 || bind == 1)){
                    contentLine1 = Currency+price;
                }
                                        
                if (promo > 0 && (bind == 0 || bind == 1)){
                    contentLine1 = Currency+promo;
                }
                
                if (type != 'past_day'){
                    switch (status){
                        case 'available':
                            type += ' available';
                            /*Remove commented line to show number of available */
                            if (bind == 0 || bind == 1){
                                if (available > 1){
                                    contentLine2 = available+' '+'<span class="no-available-text">'+AvailableText+'</span>';
                                } else if (available == 1){
                                    contentLine2 = available+' '+'<span class="no-available-text">'+AvailableOneText+'</span>';
                                } else{
                                    contentLine2 = '<span class="text">'+AvailableOneText+'</span>';
                                }
                            }
                            break;
                        case 'booked':
                            type += ' booked';
                            if (bind == 0 || bind == 1){
                                contentLine2 = '<span class="no-available-text">'+BookedText+'</span>'; 
                            }
                            switch(booked_using){
                                case 'portal':
                                    BookedUsingText = UsingPortalText;
                                    break;
                                case 'via_email':
                                    BookedUsingText = UsingViaEmailText;
                                    break;
                                case 'offline_source':
                                    BookedUsingText = UsingOfflineSourceText;
                                    break;
                                case 'other':
                                    BookedUsingText = UsingOtherText;
                                    break;
                                default:
                                    BookedUsingText = UsingPortalText;
                                    break;
                            }                                    
                            break;
                        case 'special':
                            type += ' special';

                            if (bind == 0 || bind == 1){
                                if (available > 1){
                                    contentLine2 = available+' '+'<span class="no-available-text">'+AvailableText+'</span>';
                                }
                                else if (available == 1){
                                    contentLine2 = available+' '+'<span class="no-available-text">'+AvailableOneText+'</span>';
                                }
                            }
                            break;
                        case 'unavailable':
                            type += ' unavailable';
                            contentLine2 = '<span class="no-available-text">'+UnavailableText+'</span>';
                            break;
                    }
                }
                
                if (dayNo % 7 == 1){
                    type += ' first-column';
                }
                
                if (dayNo % 7 == 0){
                    type += ' last-column';
                }
                
                dayHTML.push('<div class="DOPFrontendBookingCalendarPRO_Day '+type+'" id="'+id+'">');
                dayHTML.push('    <div class="bind-left'+((bind == 2 || bind == 3) && (status == 'available' || status == 'special') ? ' enabled':'')+(dayPreviousBind == 3 && MorningCheckOut && (dayPreviousStatus == 'available' || dayPreviousStatus == 'special') ? ' extended '+dayPreviousStatus:'')+'">');
                dayHTML.push('        <div class="header">&nbsp;</div>');
                dayHTML.push('        <div class="content">&nbsp;</div>');
                dayHTML.push('    </div>');                        
                dayHTML.push('    <div class="bind-content group'+((status == 'available' || status == 'special') ? bind:'0')+(bind == 3 && MorningCheckOut && (status == 'available' || status == 'special') ? ' extended':'')+(dayPreviousBind == 3 && MorningCheckOut && (dayPreviousStatus == 'available' || dayPreviousStatus == 'special') ? ' extended':'')+'">');
                dayHTML.push('        <div class="header">');
                dayHTML.push('            <div class="co '+(MorningCheckOut ? dayPreviousStatus:status)+'"></div>');
                dayHTML.push('            <div class="ci '+status+'"></div>');
                dayHTML.push('            <div class="day">'+day+'</div>');
               
                if (info != '' && type != 'past_day'){
                    switch (status){
                        case 'available':
                            if (bind == 0 || bind == 3){
                                dayHTML.push('            <div class="info" id="'+id+'_info"></div>');
                            }
                            break;
                        case 'booked':
                            dayHTML.push('            <div class="info" id="'+id+'_info"></div>');                                   
                            break;
                        case 'special':
                            if (bind == 0 || bind == 3){
                                dayHTML.push('            <div class="info" id="'+id+'_info"></div>');
                            }
                            break;
                        case 'unavailable':
                            dayHTML.push('            <div class="info" id="'+id+'_info"></div>');
                            break;
                    }
                }
                
                dayHTML.push('            <br class="DOPFrontendBookingCalendarPRO_Clear" />');
                dayHTML.push('        </div>');
                dayHTML.push('        <div class="content">');
                dayHTML.push('            <div class="co '+(MorningCheckOut ? dayPreviousStatus:status)+'"></div>');
                dayHTML.push('            <div class="ci '+status+'"></div>');
                dayHTML.push('            <div class="price">'+contentLine1+'</div>');
                
                if (promo > 0 && (bind == 0 || bind == 1)){
                    dayHTML.push('            <div class="old-price">'+Currency+price+'</div>');
                }
                dayHTML.push('            <br class="DOPFrontendBookingCalendarPRO_Clear" />');
                dayHTML.push('            <div class="available">'+contentLine2+'</div>');
                /********************************************************************************/
                if ($.trim(booked_using)!='' && status == 'booked' && (bind == 0 || bind == 1)){
                dayHTML.push('            <div class="available">'+BeforeBookedLabel+' '+BookedUsingText+'</div>');
                }
                /********************************************************************************/
                dayHTML.push('        </div>');  
                dayHTML.push('    </div>');
                dayHTML.push('    <div class="bind-right'+((bind == 1 || bind == 2) && (status == 'available' || status == 'special') ? ' enabled':'')+(bind == 3 && MorningCheckOut && (status == 'available' || status == 'special') ? ' extended':'')+'">');
                dayHTML.push('        <div class="header">&nbsp;</div>');
                dayHTML.push('        <div class="content">&nbsp;</div>');
                dayHTML.push('    </div>');
                dayHTML.push('</div>');
                
                if (type != 'past_day'){
                    dayPreviousStatus = status;
                    dayPreviousBind = bind;
                }
                else{
                    dayPreviousStatus = 'none';
                    dayPreviousBind = 0;
                }
                
                return dayHTML.join('');
            }, 

            defaultDay:function(day){
                return {
                    "available": "",
                    "bind": "0",
                    "info": "",
                    "notes": "",
                    "price": "", 
                    "promo": "",
                    "status": AvailableDays[day] ? "none" : "unavailable",
                    "booked_using":""
                }
            },

            rpDays:function(){
                var maxHeight = 0,
                hiddenBustedItems = prototypes.doHideBuster($(Container));
                
                $('.DOPFrontendBookingCalendarPRO_Day .content', Container).removeAttr('style');
                $('.DOPFrontendBookingCalendarPRO_Day', Container).width(parseInt(($('.DOPFrontendBookingCalendarPRO_Month', Container).width()-parseInt($('.DOPFrontendBookingCalendarPRO_Month', Container).css('padding-left'))+parseInt($('.DOPFrontendBookingCalendarPRO_Month', Container).css('padding-right')))/7));
                $('.DOPFrontendBookingCalendarPRO_Day .bind-content', Container).width($('.DOPFrontendBookingCalendarPRO_Day', Container).width()-2);
              
                if ($('.DOPFrontendBookingCalendarPRO_Day', Container).width() <= 70){
                    $('.DOPFrontendBookingCalendarPRO_Day .no-available-text', Container).css('display', 'none');
                } else {
                    $('.DOPFrontendBookingCalendarPRO_Day .no-available-text', Container).css('display', 'inline');
                }
                
                if ($('.DOPFrontendBookingCalendarPRO_Day', Container).width() <= 35){
                    $('.DOPFrontendBookingCalendarPRO_Day .bind-content .header .info', Container).css('display', 'none');
                } else {
                    $('.DOPFrontendBookingCalendarPRO_Day .bind-content .header .info', Container).css('display', 'block');
                }
                
                $('.DOPFrontendBookingCalendarPRO_Day .bind-content .content', Container).each(function(){
                    if (maxHeight < $(this).height()){
                        maxHeight = $(this).height();
                    }
                });
                
                $('.DOPFrontendBookingCalendarPRO_Day .content', Container).height(maxHeight);
                $('.DOPFrontendBookingCalendarPRO_Day .content .co', Container).height(maxHeight);
                $('.DOPFrontendBookingCalendarPRO_Day .content .ci', Container).height(maxHeight);
                
                prototypes.undoHideBuster(hiddenBustedItems);
            },   

            initDayEvents:function(){// Init Events for the days of the Calendar. 
                var xPos = 0, yPos = 0, touch;
                
                if (!prototypes.isTouchDevice()){
                    $('.DOPFrontendBookingCalendarPRO_Day .info', Container).hover(function(){
                        $(this).addClass('hover');
                        methods.showInfo($(this).attr('id').split('_')[1], '', 'info');
                    }, function(){
                        $(this).removeClass('hover');
                        methods.hideInfo();
                    });
                } else {
                    $('.DOPFrontendBookingCalendarPRO_Day .info', Container).off('touchstart');
                    $('.DOPFrontendBookingCalendarPRO_Day .info', Container).on('touchstart', function(e){
                        e.preventDefault();
                        touch = e.originalEvent.touches[0];
                        xPos = touch.clientX+$(document).scrollLeft();
                        yPos = touch.clientY+$(document).scrollTop();
                        $('#DOPFrontendBookingCalendarPRO_Info'+ID).css({'left': xPos, 'top': yPos});
                        methods.showInfo($(this).attr('id').split('_')[1], '', 'info');
                    });
                }
            },
                     
            initInfo:function(){
                var xPos = 0, yPos = 0, touch;
                
                if (!prototypes.isTouchDevice()){
                    $(document).mousemove(function(e){
                        xPos = e.pageX+30;
                        yPos = e.pageY;

                        if ($(document).scrollTop()+$(window).height() < yPos+$('#DOPFrontendBookingCalendarPRO_Info'+ID).height()+parseInt($('#DOPFrontendBookingCalendarPRO_Info'+ID).css('padding-top'))+parseInt($('#DOPFrontendBookingCalendarPRO_Info'+ID).css('padding-bottom'))+10){
                           yPos = $(document).scrollTop()+$(window).height()-$('#DOPFrontendBookingCalendarPRO_Info'+ID).height()-parseInt($('#DOPFrontendBookingCalendarPRO_Info'+ID).css('padding-top'))-parseInt($('#DOPFrontendBookingCalendarPRO_Info'+ID).css('padding-bottom'))-10;
                        }
                        $('#DOPFrontendBookingCalendarPRO_Info'+ID).css({'left': xPos, 'top': yPos});
                    }); 
                } else {
                    $('#DOPFrontendBookingCalendarPRO_Info'+ID).off('touchstart');
                    $('#DOPFrontendBookingCalendarPRO_Info'+ID).on('touchstart', function(e){
                        e.preventDefault();
                        methods.hideInfo();
                    });
                }
            },

            showInfo:function(date, hour, type){
                var info = hour == '' ? Schedule[date][type]:Schedule[date]['hours'][hour][type],
                xPos = 0, yPos = 0, touch;
                
                $('#DOPFrontendBookingCalendarPRO_Info'+ID).html(info);
                $('#DOPFrontendBookingCalendarPRO_Info'+ID).css('display', 'block');                         
            },

            hideInfo:function(){
                $('#DOPFrontendBookingCalendarPRO_Info'+ID).css('display', 'none');                        
            },
      
            previousDay:function(date){
                var previousDay = new Date(),
                parts = date.split('-');
                
                previousDay.setFullYear(parts[0], parseInt(parts[1])-1, parts[2]);
                previousDay.setTime(previousDay.getTime()-86400000);
                                        
                return previousDay.getFullYear()+'-'+prototypes.timeLongItem(previousDay.getMonth()+1)+'-'+prototypes.timeLongItem(previousDay.getDate());                        
            },

            weekDay:function(year, month, day){
                var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                date = new Date(eval('"'+day+' '+months[parseInt(month, 10)-1]+', '+year+'"'));
                
                return date.getDay();
            }
        },

        prototypes = {
            resizeItem:function(parent, child, cw, ch, dw, dh, pos){// Resize & Position an item (the item is 100% visible)
                var currW = 0, currH = 0;

                if (dw <= cw && dh <= ch){
                    currW = dw;
                    currH = dh;
                }
                else{
                    currH = ch;
                    currW = (dw*ch)/dh;

                    if (currW > cw){
                        currW = cw;
                        currH = (dh*cw)/dw;
                    }
                }

                child.width(currW);
                child.height(currH);
                switch(pos.toLowerCase()){
                    case 'top':
                        prototypes.topItem(parent, child, ch);
                        break;
                    case 'bottom':
                        prototypes.bottomItem(parent, child, ch);
                        break;
                    case 'left':
                        prototypes.leftItem(parent, child, cw);
                        break;
                    case 'right':
                        prototypes.rightItem(parent, child, cw);
                        break;
                    case 'horizontal-center':
                        prototypes.hCenterItem(parent, child, cw);
                        break;
                    case 'vertical-center':
                        prototypes.vCenterItem(parent, child, ch);
                        break;
                    case 'center':
                        prototypes.centerItem(parent, child, cw, ch);
                        break;
                    case 'top-left':
                        prototypes.tlItem(parent, child, cw, ch);
                        break;
                    case 'top-center':
                        prototypes.tcItem(parent, child, cw, ch);
                        break;
                    case 'top-right':
                        prototypes.trItem(parent, child, cw, ch);
                        break;
                    case 'middle-left':
                        prototypes.mlItem(parent, child, cw, ch);
                        break;
                    case 'middle-right':
                        prototypes.mrItem(parent, child, cw, ch);
                        break;
                    case 'bottom-left':
                        prototypes.blItem(parent, child, cw, ch);
                        break;
                    case 'bottom-center':
                        prototypes.bcItem(parent, child, cw, ch);
                        break;
                    case 'bottom-right':
                        prototypes.brItem(parent, child, cw, ch);
                        break;
                }
            },

            resizeItem2:function(parent, child, cw, ch, dw, dh, pos){// Resize & Position an item (the item covers all the container)
                var currW = 0, currH = 0;

                currH = ch;
                currW = (dw*ch)/dh;

                if (currW < cw){
                    currW = cw;
                    currH = (dh*cw)/dw;
                }

                child.width(currW);
                child.height(currH);

                switch(pos.toLowerCase()){
                    case 'top':
                        prototypes.topItem(parent, child, ch);
                        break;
                    case 'bottom':
                        prototypes.bottomItem(parent, child, ch);
                        break;
                    case 'left':
                        prototypes.leftItem(parent, child, cw);
                        break;
                    case 'right':
                        prototypes.rightItem(parent, child, cw);
                        break;
                    case 'horizontal-center':
                        prototypes.hCenterItem(parent, child, cw);
                        break;
                    case 'vertical-center':
                        prototypes.vCenterItem(parent, child, ch);
                        break;
                    case 'center':
                        prototypes.centerItem(parent, child, cw, ch);
                        break;
                    case 'top-left':
                        prototypes.tlItem(parent, child, cw, ch);
                        break;
                    case 'top-center':
                        prototypes.tcItem(parent, child, cw, ch);
                        break;
                    case 'top-right':
                        prototypes.trItem(parent, child, cw, ch);
                        break;
                    case 'middle-left':
                        prototypes.mlItem(parent, child, cw, ch);
                        break;
                    case 'middle-right':
                        prototypes.mrItem(parent, child, cw, ch);
                        break;
                    case 'bottom-left':
                        prototypes.blItem(parent, child, cw, ch);
                        break;
                    case 'bottom-center':
                        prototypes.bcItem(parent, child, cw, ch);
                        break;
                    case 'bottom-right':
                        prototypes.brItem(parent, child, cw, ch);
                        break;
                }
            },

            topItem:function(parent, child, ch){// Position item on Top
                parent.height(ch);
                child.css('margin-top', 0);
            },

            bottomItem:function(parent, child, ch){// Position item on Bottom
                parent.height(ch);
                child.css('margin-top', ch-child.height());
            },

            leftItem:function(parent, child, cw){// Position item on Left
                parent.width(cw);
                child.css('margin-left', 0);
            },

            rightItem:function(parent, child, cw){// Position item on Right
                parent.width(cw);
                child.css('margin-left', parent.width()-child.width());
            },

            hCenterItem:function(parent, child, cw){// Position item on Horizontal Center
                parent.width(cw);
                child.css('margin-left', (cw-child.width())/2);
            },

            vCenterItem:function(parent, child, ch){// Position item on Vertical Center
                parent.height(ch);
                child.css('margin-top', (ch-child.height())/2);
            },

            centerItem:function(parent, child, cw, ch){// Position item on Center
                prototypes.hCenterItem(parent, child, cw);
                prototypes.vCenterItem(parent, child, ch);
            },

            tlItem:function(parent, child, cw, ch){// Position item on Top-Left
                prototypes.topItem(parent, child, ch);
                prototypes.leftItem(parent, child, cw);
            },

            tcItem:function(parent, child, cw, ch){// Position item on Top-Center
                prototypes.topItem(parent, child, ch);
                prototypes.hCenterItem(parent, child, cw);
            },

            trItem:function(parent, child, cw, ch){// Position item on Top-Right
                prototypes.topItem(parent, child, ch);
                prototypes.rightItem(parent, child, cw);
            },

            mlItem:function(parent, child, cw, ch){// Position item on Middle-Left
                prototypes.vCenterItem(parent, child, ch);
                prototypes.leftItem(parent, child, cw);
            },

            mrItem:function(parent, child, cw, ch){// Position item on Middle-Right
                prototypes.vCenterItem(parent, child, ch);
                prototypes.rightItem(parent, child, cw);
            },

            blItem:function(parent, child, cw, ch){// Position item on Bottom-Left
                prototypes.bottomItem(parent, child, ch);
                prototypes.leftItem(parent, child, cw);
            },

            bcItem:function(parent, child, cw, ch){// Position item on Bottom-Center
                prototypes.bottomItem(parent, child, ch);
                prototypes.hCenterItem(parent, child, cw);
            },

            brItem:function(parent, child, cw, ch){// Position item on Bottom-Right
                prototypes.bottomItem(parent, child, ch);
                prototypes.rightItem(parent, child, cw);
            },
            
            touchNavigation:function(parent, child){// One finger navigation for touchscreen devices
                var prevX, prevY, currX, currY, touch, childX, childY;
                
                parent.on('touchstart', function(e){
                    touch = e.originalEvent.touches[0];
                    prevX = touch.clientX;
                    prevY = touch.clientY;
                });

                parent.on('touchmove', function(e){                                
                    touch = e.originalEvent.touches[0];
                    currX = touch.clientX;
                    currY = touch.clientY;
                    childX = currX>prevX ? parseInt(child.css('margin-left'))+(currX-prevX):parseInt(child.css('margin-left'))-(prevX-currX);
                    childY = currY>prevY ? parseInt(child.css('margin-top'))+(currY-prevY):parseInt(child.css('margin-top'))-(prevY-currY);

                    if (childX < (-1)*(child.width()-parent.width())){
                        childX = (-1)*(child.width()-parent.width());
                    }
                    else if (childX > 0){
                        childX = 0;
                    }
                    else{                                    
                        e.preventDefault();
                    }

                    if (childY < (-1)*(child.height()-parent.height())){
                        childY = (-1)*(child.height()-parent.height());
                    }
                    else if (childY > 0){
                        childY = 0;
                    }
                    else{                                    
                        e.preventDefault();
                    }

                    prevX = currX;
                    prevY = currY;

                    if (parent.width() < child.width()){
                        child.css('margin-left', childX);
                    }
                    
                    if (parent.height() < child.height()){
                        child.css('margin-top', childY);
                    }
                });

                parent.on('touchend', function(e){
                    if (!prototypes.isChromeMobileBrowser()){
                        e.preventDefault();
                    }
                });
            },

			rgb2hex:function(rgb){// Convert RGB color to HEX
                            var hexDigits = new Array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');

                            rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);

                            return (isNaN(rgb[1]) ? '00':hexDigits[(rgb[1]-rgb[1]%16)/16]+hexDigits[rgb[1]%16])+
                                   (isNaN(rgb[2]) ? '00':hexDigits[(rgb[2]-rgb[2]%16)/16]+hexDigits[rgb[2]%16])+
                                   (isNaN(rgb[3]) ? '00':hexDigits[(rgb[3]-rgb[3]%16)/16]+hexDigits[rgb[3]%16]);
			},

			idealTextColor:function(bgColor){// Set text color depending on the background color
			    var rgb = /rgb\((\d+).*?(\d+).*?(\d+)\)/.exec(bgColor);
    
			    if (rgb != null){
			        return parseInt(rgb[1], 10)+parseInt(rgb[2], 10)+parseInt(rgb[3], 10) < 3*256/2 ? 'white' : 'black';
			    }
			    else{
			        return parseInt(bgColor.substring(0, 2), 16)+parseInt(bgColor.substring(2, 4), 16)+parseInt(bgColor.substring(4, 6), 16) < 3*256/2 ? 'white' : 'black';
			    }
			},

            dateDiference:function(date1, date2){// Diference between 2 dates
                var time1 = date1.getTime(),
                time2 = date2.getTime(),
                diff = Math.abs(time1-time2),
                one_day = 1000*60*60*24;
                
                return parseInt(diff/(one_day))+1;
            },

            noDays:function(date1, date2){// Returns no of days between 2 days
                var time1 = date1.getTime(),
                time2 = date2.getTime(),
                diff = Math.abs(time1-time2),
                one_day = 1000*60*60*24;
                
                return Math.round(diff/(one_day))+1;
            },

            timeLongItem:function(item){// Return day/month with 0 in front if smaller then 10
                if (item < 10){
                    return '0'+item;
                }
                else{
                    return item;
                }
            },

            timeToAMPM:function(item){// Returns time in AM/PM format
                var hour = parseInt(item.split(':')[0], 10),
                minutes = item.split(':')[1],
                result = '';
                
                if (hour == 0){
                    result = '12';
                }
                else if (hour > 12){
                    result = prototypes.timeLongItem(hour-12);
                }
                else{
                    result = prototypes.timeLongItem(hour);
                }
                
                result += ':'+minutes+' '+(hour < 12 ? 'AM':'PM');
                
                return result;
            },

            stripslashes:function(str){// Remove slashes from string
                return (str + '').replace(/\\(.?)/g, function (s, n1) {
                    switch (n1){
                        case '\\':
                            return '\\';
                        case '0':
                            return '\u0000';
                        case '':
                            return '';
                        default:
                            return n1;
                    }
                });
            },
            
            randomize:function(theArray){// Randomize the items of an array
                theArray.sort(function(){
                    return 0.5-Math.random();
                });
                return theArray;
            },

            randomString:function(string_length){// Create a string with random elements
                var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz",
                random_string = '';

                for (var i=0; i<string_length; i++){
                    var rnum = Math.floor(Math.random()*chars.length);
                    random_string += chars.substring(rnum,rnum+1);
                }
                return random_string;
            },

            isIE8Browser:function(){// Detect the browser IE8
                var isIE8 = false,
                agent = navigator.userAgent.toLowerCase();

                if (agent.indexOf('msie 8') != -1){
                    isIE8 = true;
                }
                return isIE8;
            },

            isIEBrowser:function(){// Detect the browser IE
                var isIE = false,
                agent = navigator.userAgent.toLowerCase();

                if (agent.indexOf('msie') != -1){
                    isIE = true;
                }
                return isIE;
            },

            isChromeMobileBrowser:function(){// Detect the browser Mobile Chrome
                var isChromeMobile = false,
                agent = navigator.userAgent.toLowerCase();
                
                if ((agent.indexOf('chrome') != -1 || agent.indexOf('crios') != -1) && prototypes.isTouchDevice()){
                    isChromeMobile = true;
                }
                return isChromeMobile;
            },

            isAndroid:function(){// Detect the browser Mobile Chrome
                var isAndroid = false,
                agent = navigator.userAgent.toLowerCase();

                if (agent.indexOf('android') != -1){
                    isAndroid = true;
                }
                return isAndroid;
            },

            isTouchDevice:function(){// Detect touchscreen devices
                var os = navigator.platform;
                
                if (os.toLowerCase().indexOf('win') != -1){
                    return window.navigator.msMaxTouchPoints;
                }
                else {
                    return 'ontouchstart' in document;
                }
            },

            openLink:function(url, target){// Open a link
                switch (target.toLowerCase()){
                    case '_blank':
                        window.open(url);
                        break;
                    case '_top':
                        top.location.href = url;
                        break;
                    case '_parent':
                        parent.location.href = url;
                        break;
                    default:    
                        window.location = url;
                }
            },

            validateCharacters:function(str, allowedCharacters){// Verify if a string contains allowed characters
                var characters = str.split(''), i;

                for (i=0; i<characters.length; i++){
                    if (allowedCharacters.indexOf(characters[i]) == -1){
                        return false;
                    }
                }
                return true;
            },

            cleanInput:function(input, allowedCharacters, firstNotAllowed, min){// Remove characters that aren't allowed from a string
                var characters = $(input).val().split(''),
                returnStr = '', i, startIndex = 0;

                if (characters.length > 1 && characters[0] == firstNotAllowed){
                    startIndex = 1;
                }
                
                for (i=startIndex; i<characters.length; i++){
                    if (allowedCharacters.indexOf(characters[i]) != -1){
                        returnStr += characters[i];
                    }
                }
                    
                if (min > returnStr){
                    returnStr = min;
                }
                
                $(input).val(returnStr);
            },

            validEmail:function(email){// Validate email
                var filter = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
                
                if (filter.test(email)){
                    return true;
                }
                return false;
            },
            
            $_GET:function(variable){// Parse $_GET variables
                var url = window.location.href.split('?')[1],
                variables = url != undefined ? url.split('&'):[],
                i; 
                
                for (i=0; i<variables.length; i++){
                    if (variables[i].indexOf(variable) != -1){
                        return variables[i].split('=')[1];
                        break;
                    }
                }
                
                return undefined;
            },

            acaoBuster:function(dataURL){// Access-Control-Allow-Origin buster
                var topURL = window.location.href,
                pathPiece1 = '', pathPiece2 = '';
                
                if (dataURL.indexOf('https') != -1 || dataURL.indexOf('http') != -1){
                    if (topURL.indexOf('http://www.') != -1){
                        pathPiece1 = 'http://www.';
                    }
                    else if (topURL.indexOf('http://') != -1){
                        pathPiece1 = 'http://';
                    }
                    else if (topURL.indexOf('https://www.') != -1){
                        pathPiece1 = 'https://www.';
                    }
                    else if (topURL.indexOf('https://') != -1){
                        pathPiece1 = 'https://';
                    }
                        
                    if (dataURL.indexOf('http://www.') != -1){
                        pathPiece2 = dataURL.split('http://www.')[1];
                    }
                    else if (dataURL.indexOf('http://') != -1){
                        pathPiece2 = dataURL.split('http://')[1];
                    }
                    else if (dataURL.indexOf('https://www.') != -1){
                        pathPiece2 = dataURL.split('https://www.')[1];
                    }
                    else if (dataURL.indexOf('https://') != -1){
                        pathPiece2 = dataURL.split('https://')[1];
                    }
                    
                    return pathPiece1+pathPiece2;
                }
                else{
                    return dataURL;
                }
            },
            
            doHideBuster:function(item){// Make all parents & current item visible
                var parent = item.parent(),
                items = new Array();
                    
                if (item.prop('tagName') != undefined && item.prop('tagName').toLowerCase() != 'body'){
                    items = prototypes.doHideBuster(parent);
                }
                
                if (item.css('display') == 'none'){
                    item.css('display', 'block');
                    items.push(item);
                }
                
                return items;
            },

            undoHideBuster:function(items){// Hide items in the array
                var i;
                
                for (i=0; i<items.length; i++){
                    items[i].css('display', 'none');
                }
            },
           
            setCookie:function(c_name, value, expiredays){// Set cookie (name, value, expire in no days)
                var exdate = new Date();
                exdate.setDate(exdate.getDate()+expiredays);

                document.cookie = c_name+"="+escape(value)+((expiredays==null) ? "" : ";expires="+exdate.toUTCString())+";javahere=yes;path=/";
            },

            readCookie:function(name){// Read cookie (name) 
                var nameEQ = name+"=",
                ca = document.cookie.split(";");

                for (var i=0; i<ca.length; i++){
                    var c = ca[i];

                    while (c.charAt(0)==" "){
                        c = c.substring(1,c.length);            
                    } 

                    if (c.indexOf(nameEQ) == 0){
                        return unescape(c.substring(nameEQ.length, c.length));
                    } 
                }
                return null;
            },

            deleteCookie:function(c_name, path, domain){// Delete cookie (name, path, domain)
                if (readCookie(c_name)){
                    document.cookie = c_name+"="+((path) ? ";path="+path:"")+((domain) ? ";domain="+domain:"")+";expires=Thu, 01-Jan-1970 00:00:01 GMT";
                }
            }
        };

        return methods.init.apply(this);
    }
})(jQuery);