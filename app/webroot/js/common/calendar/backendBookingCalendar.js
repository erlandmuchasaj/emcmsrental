/*
* Title                   : Booking Calendar PRO (jQuery Plugin)
* Version                 : 1.2
* File                    : jquery.dop.BackendBookingCalendarPRO.js
* File Version            : 1.2
* Created / Last Modified : 20 May 2013
* Author                  : Dot on Paper
* Copyright               : © 2011 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking Calendar PRO Back End jQuery plugin.
*/
(function($){
	$.fn.DOPBackendBookingCalendarPRO = function(options){
		/* Some constants used to make calendar dynamic
			here we can pass Calendar ID and PropertyID to get the right calendar for 
			right Property
		*/
		var Data = {
			'AddtMonthViewText': 'Add Month View', // Add Month View button title (plus icon).
			'AvailableDays': [true, true, true, true, true, true, true], // Set available/unavailable days starting with Monday.
			'AvailableLabel': 'No. Available', // Form label for Number of Available Items.
			'AvailableOneText': 'available', // Available Day text for one item.
			'AvailableText': 'available', // Available text for more items.
			'SpecialOneText': 'special', // special Day text for one item.
			'SpecialText': 'special', // special text for more items.
			'BookedText': 'booked', // Booked Day text.
			'CloseLabel': 'Close', // Form label for Close button.
			'Currency': '€', // Currency icon Symbol. // $
			'DataURL': '', // URL from were JSON data is loaded. // loadURL
			'SaveURL': '', // URL to were JSON data is saved. // saveURL
			'DateEndLabel': 'End Date', // Form label for End Date.
			'DateStartLabel': 'Start Date', // Form label for Start Date.
			'DateType': 1, // Form date display type (1 = American, 2 = European)
			'DayNames': ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'], // Weekdays long names.
			'DayShortNames': ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'], // Weekdays short names.
			'FirstDay': 1, // Set the first day of the week (1 = Monday, 2 = Tuesday, 3 = Wednesday, 4 = Thursday, 5 = Friday, 6 = Saturday, 7 = Sunday)
			'GroupDaysLabel': 'Group Days', // Form label for Group Days checkbox.
			'ID': 0, // Calendar ID. Change it if you have more then one calendar. Make it the same as the Front End version.
			'InfoLabel': 'Information (users will see this message)', // Form label for Information field.
			'MonthNames': ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'], // Months long names.
			'MonthShortNames': ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], // Months short names.
			'MorningCheckOut': true, // Display the calendar with Morning Checkout days.
			'NextMonthText': 'Next Month', // Next Month button title.
			'NotesLabel': 'Notes (only you will see this message)', // Form label for Notes field.
			'PreviousMonthText': 'Previous Month', // Previous Month button title.
			'PriceLabel': 'Price', // Form label for Price Field.
			'PromoLabel': 'Modified Price', // Form label for Promo Price field.
			'Reinitialize': false, // Reinitialize the calendar if already loaded.
			'UserSubmit': false, // submit the form on user behalf
			'RemoveMonthViewText': 'Remove Month View', // Remove Month View button title (minus icon).
			'ResetConfirmation': 'Are you sure you want to reset calendar data?', // Form Reset Confirmation text.
			'ResetLabel': 'Reset', // Form label for Reset Button.
			'StatusAvailableText': 'Available', // Form Status - Available text.
			'StatusBookedText': 'Booked', // Form Status - Booked text.
			'StatusLabel': 'Status', // Form label for Status Select field.
			'StatusSpecialText': 'Special', // Form Status - Special text.
			'StatusUnavailableText': 'Unavailable', // Form Status - Unavailable text.
			'SubmitLabel': 'Submit', // Form label for Submit Button.
			'UnavailableText': 'unavailable', // Unavailable Day text.
			/*******************************************************************/
			'PropertyID'            : 0, // ID of the property that shis calendar belong to.
			'PropertyPrice'         : 0, // Inicialisation of the property price.
			'BeforeBookedLabel'     : 'Using', // Label before selection data of the user
			'UsingEmptyText'        : 'Select',
			'BookedUsingLabel'      : 'Booked Using',
			'UsingPortalText'       : 'Portal',
			'UsingViaEmailText'     : 'Via E-mail',
			'UsingOfflineSourceText': 'Offline Sources',
			'UsingOtherText'        : 'Other',

			'AddMonthViewText': 'Add month view',
			'CurrencyPosition': 'before',
			'MaxYear': new Date().getFullYear(),
			'SetDaysAvailabilityLabel': 'Set days availability',
			'LoadedText': 'Calendar data loaded successfully',
			'SavedText': 'Calendar data saved successfully',
			'SavingText': 'Saving calendar...',
		},
 
		Container = this, /* This is The HTML container. */
		Schedule = {}, /* This is the Schedule data sent via Ajax as a Json Array*/

		/* 
		* Inicialisation the days of the calendar
		*/
		StartDate   = new Date(),
		StartYear   = StartDate.getFullYear(),
		StartMonth  = StartDate.getMonth()+1,
		StartDay    = StartDate.getDate(),
		CurrYear    = StartYear,
		CurrMonth   = StartMonth,

		/* These are default Data  for the inicialisation of the calendar
			Each data Data['data_name'] passed through the user 
			overwrites these data
		*/
		AddtMonthViewText = 'Add Month View',
		AvailableDays = [true, true, true, true, true, true, true],
		AvailableLabel = 'No. Available',
		AvailableOneText = 'available',
		AvailableText = 'available',
		SpecialOneText = 'special', 
		SpecialText = 'special',
		BookedText = 'booked',
		CloseLabel = 'Close',
		Currency = '€ ',
		DataURL = 'load.php',
		DateEndLabel = 'End Date',
		DateStartLabel = 'Start Date',
		DateType = 1,
		DayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
		DayShortNames = ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
		FirstDay = 1,
		GroupDaysLabel = 'Group Days',
		ID = 0,
		InfoLabel = 'Informations',
		MonthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
		MonthShortNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
		MorningCheckOut = false,
		NextMonthText = 'Next Month',
		NotesLabel = 'Notes',
		PreviousMonthText = 'Previous Month',
		PriceLabel = 'Price',
		PromoLabel = 'Modified Price',
		RemoveMonthViewText = 'Remove Month View',
		ResetConfirmation = 'Are you sure you want to reset all data?',
		ResetLabel = 'Reset',
		SaveURL = 'save.php',
		StatusAvailableText = 'Available',
		StatusBookedText = 'Booked',
		StatusLabel = 'Status',
		StatusSpecialText = 'Special',
		StatusUnavailableText = 'Unavailable',
		SubmitLabel = 'Submit',
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

		AddMonthViewText = 'Add month view',
		CurrencyPosition = 'before',
		MaxYear = new Date().getFullYear(),
		SetDaysAvailabilityLabel = 'Set days availability',
		LoadedText = 'Calendar data loaded successfully',
		SavedText = 'Calendar data saved successfully',
		SavingText = 'Saving calendar...',

		showCalendar = true,
		firstYearLoaded = false,
		MessagesTimeout = 0,

		/*
		* This data is used for Day selectian Intervals
		*/
		noMonths = 1,
		dayStartSelection,
		dayEndSelection,
		dayFirstSelected = false,
		dayTimeDisplay = false,
		dayStartSelectionCurrMonth,
		dayNo = 0,

		yearStartSave,
		monthStartSave,
		yearEndSave,
		monthEndSave,

		methods = {  
			// Init Plugin.
			init:function( ){
				return this.each(function(){
					if (options){
						$.extend(Data, options);
					}
					
					if (!$(Container).hasClass('dopbcp-initialized') || Data['Reinitialize']) {
						// $('#DOPBackendBookingCalendarPRO_Info'+ID).remove();
						$(Container).addClass('dopbcp-initialized');
						methods.parseData();

						// $(window).on('resize.DOPBackendBookingCalendarPRO', methods.initRP);
						$(window).bind('resize', methods.initRP);
					}

				});
			},

			/*
				The data sent from user will overwrite default data.
				here is just the inicialisation of the data
			 */
			parseData:function(){
				
				AddtMonthViewText= Data['AddtMonthViewText'];
				AvailableDays[0] = Data['AvailableDays'][0];
				AvailableDays[1] = Data['AvailableDays'][1];
				AvailableDays[2] = Data['AvailableDays'][2];
				AvailableDays[3] = Data['AvailableDays'][3];
				AvailableDays[4] = Data['AvailableDays'][4];
				AvailableDays[5] = Data['AvailableDays'][5];
				AvailableDays[6] = Data['AvailableDays'][6];
				AvailableLabel   = Data['AvailableLabel'];
				AvailableOneText = Data['AvailableOneText'];
				AvailableText  	 = Data['AvailableText'];
				BookedText     	 = Data['BookedText'];
				CloseLabel     	 = Data['CloseLabel'];
				Currency       	 = Data['Currency'];
				DataURL        = prototypes.acaoBuster(Data['DataURL']);
				DateEndLabel   = Data['DateEndLabel'];
				DateStartLabel = Data['DateStartLabel'];
				DateType 	   = Data['DateType'];
				DayNames 	   = Data['DayNames'];
				DayShortNames  = Data['DayShortNames'];
				GroupDaysLabel = Data['GroupDaysLabel'];
				FirstDay 	   = Data['FirstDay'];
				ID 			   = Data['ID'];
				InfoLabel 	   = Data['InfoLabel'];
				MonthNames 	   = Data['MonthNames'];
				MonthShortNames= Data['MonthShortNames'];
				MorningCheckOut  = Data['MorningCheckOut'];
				NextMonthText  = Data['NextMonthText'];
				NotesLabel 	   = Data['NotesLabel'];
				PreviousMonthText   = Data['PreviousMonthText'];
				PriceLabel 			= Data['PriceLabel'];
				PromoLabel 			= Data['PromoLabel'];
				RemoveMonthViewText = Data['RemoveMonthViewText'];
				ResetConfirmation 	= Data['ResetConfirmation'];
				ResetLabel 			= Data['ResetLabel'];
				SaveURL = prototypes.acaoBuster(Data['SaveURL']);
				StatusAvailableText = Data['StatusAvailableText'];
				StatusBookedText 	= Data['StatusBookedText'];
				StatusLabel 		= Data['StatusLabel'];
				StatusSpecialText 	= Data['StatusSpecialText'];
				StatusUnavailableText = Data['StatusUnavailableText'];
				SubmitLabel 		= Data['SubmitLabel'];
				UnavailableText 	= Data['UnavailableText'];
				/***************************************/
                PropertyID            = Data['PropertyID'];
                PropertyPrice         = Data['PropertyPrice'];
                BeforeBookedLabel     = Data['BeforeBookedLabel'];
                BookedUsingLabel      = Data['BookedUsingLabel'];
                UsingEmptyText        = Data['UsingEmptyText'];
                UsingPortalText 	  = Data['UsingPortalText'];
                UsingViaEmailText     = Data['UsingViaEmailText'];
                UsingOfflineSourceText= Data['UsingOfflineSourceText'];
                UsingOtherText        = Data['UsingOtherText'];

                AddMonthViewText = Data['AddMonthViewText'];
                CurrencyPosition = Data['CurrencyPosition'];
                MaxYear = Data['MaxYear'];
                SetDaysAvailabilityLabel = Data['SetDaysAvailabilityLabel'];
                LoadedText = Data['LoadedText'];
                SavedText = Data['SavedText'];
                SavingText = Data['SavingText'];
				
				Container.html('<div class="DOPBackendBookingCalendarPRO_Container loader dopbcp-loader"></div>');

				methods.parseCalendarData();
			},

			/*
				Here data sent from the user are parsed as a Json array and sent via Ajax
				to the processing unit file.
			 */
			parseCalendarData:function(){
				
				var scheduleBuffer = {};

				Container.append(methods_message.display());

				$.post(DataURL, {calendar_id:ID, property_id: PropertyID}, function(data){
					data = $.trim(data).replace(/\\/gi, '');
					if (data != ''){
						scheduleBuffer = JSON.parse(data);
						$.extend(Schedule, scheduleBuffer);
					}

					showCalendar = false;
					$('.dopbcp-loader', Container).remove();
					methods.initCalendar();

				}).fail(function() {
					console.log('Given URL: ='+ DataURL +'= could not be accessed.');
				});
			},

			/*
				Inicialize calendar and show it in front end
			 */
			initCalendar:function(){
				/*
				 * Display calendar.
				 */    
				// Array that holds the data.
				var HTML = new Array();

				HTML.push('<div class="DOPBackendBookingCalendarPRO_Container">');                       
				HTML.push('    <div class="DOPBackendBookingCalendarPRO_Navigation">');
				HTML.push('        <div class="month_year"></div>');
				HTML.push('        <div class="week">');
				HTML.push('            <div class="day"></div>');
				HTML.push('            <div class="day"></div>');
				HTML.push('            <div class="day"></div>');
				HTML.push('            <div class="day"></div>');
				HTML.push('            <div class="day"></div>');
				HTML.push('            <div class="day"></div>');
				HTML.push('            <div class="day"></div>');
				HTML.push('            <br class="DOPBackendBookingCalendarPRO_Clear" />');
				HTML.push('        </div>');
				HTML.push('        <div class="add_btn" title="'+AddtMonthViewText+'"></div>');                        
				HTML.push('        <div class="remove_btn" title="'+RemoveMonthViewText+'"></div>');
				HTML.push('        <div class="previous_btn" title="'+PreviousMonthText+'"></div>');
				HTML.push('        <div class="next_btn" title="'+NextMonthText+'"></div>');
				HTML.push('    </div>');
				HTML.push('    <div class="DOPBackendBookingCalendarPRO_Calendar"></div>');
				HTML.push('    <div class="DOPBackendBookingCalendarPRO_FormWrapper">');
				HTML.push('        <div class="DOPBackendBookingCalendarPRO_FormBackground"></div>');
				HTML.push('        <div class="DOPBackendBookingCalendarPRO_FormContainer"></div>');
				HTML.push('    </div>');
				HTML.push('</div>');

				Container.append(HTML.join(''));
				$('.DOPBCPCalendar-tooltip').remove();
				$('body').append('<div class="DOPBackendBookingCalendarPRO_Info" id="DOPBackendBookingCalendarPRO_Info'+ID+'"></div>');
				
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
			
			initContainer:function(){// Init  Container
				methods.rpContainer();
			},

			rpContainer:function(){// RP Container
				var hiddenBustedItems = prototypes.doHideBuster($(Container));
				
				$('.DOPBackendBookingCalendarPRO_Container', Container).width(Container.width());
				
				if (Container.width() <= 280){
					$('.DOPBackendBookingCalendarPRO_Container .month_year', Container).html(MonthShortNames[(CurrMonth%12 != 0 ? CurrMonth%12:12)-1]+' '+CurrYear); 
				} else {
					$('.DOPBackendBookingCalendarPRO_Container .month_year', Container).html(MonthNames[(CurrMonth%12 != 0 ? CurrMonth%12:12)-1]+' '+CurrYear); 
				}
				
				prototypes.undoHideBuster(hiddenBustedItems);
			},
			
			initNavigation:function(){// Init Navigation
				methods.rpNavigation();
				
				if (!prototypes.isTouchDevice()){
					$('.DOPBackendBookingCalendarPRO_Navigation .previous_btn', Container).hover(function(){
						$(this).addClass('hover');
					}, function(){
						$(this).removeClass('hover');
					});

					$('.DOPBackendBookingCalendarPRO_Navigation .next_btn', Container).hover(function(){
						$(this).addClass('hover');
					}, function(){
						$(this).removeClass('hover');
					});

					$('.DOPBackendBookingCalendarPRO_Navigation .add_btn', Container).hover(function(){
						$(this).addClass('hover');
					}, function(){
						$(this).removeClass('hover');
					});

					$('.DOPBackendBookingCalendarPRO_Navigation .remove_btn', Container).hover(function(){
						$(this).addClass('hover');
					}, function(){
						$(this).removeClass('hover');
					});
				}
				
				$('.DOPBackendBookingCalendarPRO_Navigation .previous_btn', Container).off('click touchstart');
				$('.DOPBackendBookingCalendarPRO_Navigation .previous_btn', Container).on('click touchstart', function(){                                                            
					methods.generateCalendar(StartYear, CurrMonth-1);
					if (CurrMonth === StartMonth){
						$('.DOPBackendBookingCalendarPRO_Navigation .previous_btn', Container).css('display', 'none');
					}
				});
				
				$('.DOPBackendBookingCalendarPRO_Navigation .next_btn', Container).off('click touchstart');
				$('.DOPBackendBookingCalendarPRO_Navigation .next_btn', Container).on('click touchstart', function(){
					methods.generateCalendar(StartYear, CurrMonth+1);
					$('.DOPBackendBookingCalendarPRO_Navigation .previous_btn', Container).css('display', 'block');
				});
				
				$('.DOPBackendBookingCalendarPRO_Navigation .add_btn', Container).off('click touchstart');
				$('.DOPBackendBookingCalendarPRO_Navigation .add_btn', Container).on('click touchstart', function(){
					methods.hideForm();
					noMonths++;
					methods.generateCalendar(StartYear, CurrMonth);
					$('.DOPBackendBookingCalendarPRO_Navigation .remove_btn', Container).css('display', 'block');
				});
				
				
				$('.DOPBackendBookingCalendarPRO_Navigation .remove_btn', Container).off('click touchstart');
				$('.DOPBackendBookingCalendarPRO_Navigation .remove_btn', Container).on('click touchstart', function(){
					methods.hideForm();
					noMonths--;
					methods.generateCalendar(StartYear, CurrMonth);
					if(noMonths == 1){
						$('.DOPBackendBookingCalendarPRO_Navigation .remove_btn', Container).css('display', 'none');
					}
				});
			},

			rpNavigation:function(){ // RP Navigation
				var no = 0,
				hiddenBustedItems = prototypes.doHideBuster($(Container));
				
				$('.DOPBackendBookingCalendarPRO_Navigation .week .day', Container).width(parseInt(($('.DOPBackendBookingCalendarPRO_Navigation .week', Container).width()-parseInt($('.DOPBackendBookingCalendarPRO_Navigation .week', Container).css('padding-left'))+parseInt($('.DOPBackendBookingCalendarPRO_Navigation .week', Container).css('padding-right')))/7));
				
				no = FirstDay-1;
				
				$('.DOPBackendBookingCalendarPRO_Navigation .week .day', Container).each(function(){
					no++;
					if (no === 7){
						no = 0;
					}
						
					if ($(this).width() <= 70){
						$(this).html(DayShortNames[no]);
					} else{
						$(this).html(DayNames[no]);
					}
				});
				prototypes.undoHideBuster(hiddenBustedItems);
			},
			
			generateCalendar:function(year, month) { // Init Calendar
				CurrYear = new Date(year, month, 0).getFullYear();
				CurrMonth = month;    
										
				$('.DOPBackendBookingCalendarPRO_Navigation .month_year', Container).html(MonthNames[(CurrMonth%12 != 0 ? CurrMonth%12:12)-1]+' '+CurrYear);                        
				$('.DOPBackendBookingCalendarPRO_Calendar', Container).html('');                        
				
				for (var i=1; i<=noMonths; i++){
					methods.initMonth(CurrYear, month = month%12 != 0 ? month%12:12, i);
					month++;
					
					if (month % 12 == 1){
						CurrYear++;
						month = 1;
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
				
				monthHTML.push('<div class="DOPBackendBookingCalendarPRO_Month">');
				
				if (position > 1){
					monthHTML.push('<div class="month_year">'+MonthNames[(month%12 != 0 ? month%12:12)-1]+' '+year+'</div>');
				}
										
				if (firstDay == 0){
					start = 7;
				} else{
					start = firstDay;
				}
				
				for (i=start-1; i>=1; i--){
					totalDays++;
					
					d = new Date(year, month-2, noDaysPreviousMonth-i+1);
					cyear = d.getFullYear();
					cmonth = prototypes.timeLongItem(d.getMonth()+1);
					cday = prototypes.timeLongItem(d.getDate());
					day = (Schedule[cyear+'-'+cmonth+'-'+cday] != undefined) ? Schedule[cyear+'-'+cmonth+'-'+cday] : methods.defaultDay(methods.weekDay(cyear, cmonth, cday));
					
					if (StartYear == year && StartMonth == month){
						monthHTML.push(methods.initDay(
							'past_day', // TYPE
							ID+'_'+cyear+'-'+cmonth+'-'+cday, // ID
							d.getDate(),// DAY
							'', 		// AVAILABLE
							'', 		// BIND
							'', 		// INFO
							'', 		// NOTES
							'', 		// PRICE
							'', 		// PROMO
							'none', 	// STATUS
							'', 		// BOKED USING
							'' 			// USER_ID
						));
					} else {
						monthHTML.push(methods.initDay(
							'last_month'+(position>1 ?  ' mask':''), 
							position>1 ? ID+'_'+cyear+'-'+cmonth+'-'+cday+'_last':ID+'_'+cyear+'-'+cmonth+'-'+cday, 
							d.getDate(), 
							day['available'], 
							day['bind'], 
							day['info'], 
							day['notes'], 
							day['price'], 
							day['promo'], 
							day['status'], 
							day['booked_using'], 
							day['user_id']
						));
					}
				}
				
				for (i=1; i<=noDays; i++){
					totalDays++;
					
					d = new Date(year, month-1, i);
					cyear = d.getFullYear();
					cmonth = prototypes.timeLongItem(d.getMonth()+1);
					cday = prototypes.timeLongItem(d.getDate());
					day = (Schedule[cyear+'-'+cmonth+'-'+cday] != undefined) ? Schedule[cyear+'-'+cmonth+'-'+cday] : methods.defaultDay(methods.weekDay(cyear, cmonth, cday));
					
					if (StartYear == year && StartMonth == month && StartDay > d.getDate()){
						monthHTML.push(methods.initDay(
							'past_day', 
							ID+'_'+cyear+'-'+cmonth+'-'+cday, 
							d.getDate(),// DAY
							'', 		// AVAILABLE
							'', 		// BIND
							'', 		// INFO
							'', 		// NOTES
							'', 		// PRICE
							'', 		// PROMO
							'none', 	// STATUS
							'', 		// BOKED USING
							'' 			// USER_ID
						));    
					} else {
						monthHTML.push(methods.initDay(
							'curr_month', 
							ID+'_'+cyear+'-'+cmonth+'-'+cday, 
							d.getDate(), 
							day['available'], 
							day['bind'], 
							day['info'], 
							day['notes'], 
							day['price'], 
							day['promo'], 
							day['status'], 
							day['booked_using'], 
							day['user_id']
						));
					}
				}

				if (totalDays+7 < 42){
					for (i=1; i<=14-lastDay; i++){
						d = new Date(year, month, i);
						cyear = d.getFullYear();
						cmonth = prototypes.timeLongItem(d.getMonth()+1);
						cday = prototypes.timeLongItem(d.getDate());
						day = (Schedule[cyear+'-'+cmonth+'-'+cday] != undefined) ? Schedule[cyear+'-'+cmonth+'-'+cday]:methods.defaultDay(methods.weekDay(cyear, cmonth, cday));
					
						monthHTML.push(methods.initDay(
							'next_month'+(position<noMonths ?  ' hide':''), 
							position<noMonths ? ID+'_'+cyear+'-'+cmonth+'-'+cday+'_next':ID+'_'+cyear+'-'+cmonth+'-'+cday, 
							d.getDate(), 
							day['available'], 
							day['bind'], 
							day['info'], 
							day['notes'], 
							day['price'], 
							day['promo'], 
							day['status'], 
							day['booked_using'], 
							day['user_id']
						));
					}
				} else{
					for (i=1; i<=7-lastDay; i++){
						d = new Date(year, month, i);
						cyear = d.getFullYear();
						cmonth = prototypes.timeLongItem(d.getMonth()+1);
						cday = prototypes.timeLongItem(d.getDate());
						day = (Schedule[cyear+'-'+cmonth+'-'+cday] != undefined) ? Schedule[cyear+'-'+cmonth+'-'+cday]:methods.defaultDay(methods.weekDay(cyear, cmonth, cday));
						
						monthHTML.push(methods.initDay(
							'next_month'+(position<noMonths ?  ' hide':''), 
							position<noMonths ? ID+'_'+cyear+'-'+cmonth+'-'+cday+'_next':ID+'_'+cyear+'-'+cmonth+'-'+cday, 
							d.getDate(), 
							day['available'], 
							day['bind'], 
							day['info'], 
							day['notes'], 
							day['price'], 
							day['promo'], 
							day['status'], 
							day['booked_using'], 
							day['user_id']
						));
					}
				}

				monthHTML.push('    <br class="DOPBackendBookingCalendarPRO_Clear" />');
				monthHTML.push('</div>');
				
				$('.DOPBackendBookingCalendarPRO_Calendar', Container).append(monthHTML.join(''));
				
				methods.rpDays();                        
				methods.initDayEvents();
			},
			
			initDay:function(type, id, day, available, bind, info, notes, price, promo, status, booked_using, user_id) {// Init Day
				var dayHTML = Array(),
				contentLine1 = '&nbsp;', 
				contentLine2 = '&nbsp;',
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
							if (bind == 0 || bind == 1) {
								if (available > 1){
									contentLine2 = /*available+' '+*/'<span class="no-available-text">'+AvailableText+'</span>';
								} else if (available == 1) {
									contentLine2 = /*available+' '+*/'<span class="no-available-text">'+AvailableOneText+'</span>';
								} else {
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
								contentLine2 =/* available+' '+*/'<span class="no-available-text">'+SpecialText+'</span>';
							}
							break;
						case 'unavailable':
							type += ' unavailable';
							
							if (bind == 0 || bind == 1){
								contentLine2 = '<span class="no-available-text">'+UnavailableText+'</span>';
							}
							break;
					}
				}
				
				if (dayNo % 7 == 1){
					type += ' first-column';
				}
				
				if (dayNo % 7 == 0){
					type += ' last-column';
				}
										
				dayHTML.push('<div class="DOPBackendBookingCalendarPRO_Day '+type+'" id="'+id+'">');
				dayHTML.push('    <div class="bind-left'+(bind == 2 || bind == 3 ? '  enabled':'')+'">');
				dayHTML.push('        <div class="header">&nbsp;</div>');
				dayHTML.push('        <div class="content">&nbsp;</div>');
				dayHTML.push('    </div>');                        
				dayHTML.push('    <div class="bind-content group'+bind+'">');
				dayHTML.push('        <div class="header">');
				dayHTML.push('            <div class="day">'+day+'</div>');
				
				if (notes != '' && type != 'past_day' && (bind == 0 || bind == 3)){
					dayHTML.push('            <div class="notes" id="'+id+'_notes"></div>');
				}   
				
				if (info != '' && type != 'past_day' && (bind == 0 || bind == 3)){
					dayHTML.push('            <div class="info" id="'+id+'_info"></div>');
				}                     
				dayHTML.push('            <br class="DOPBackendBookingCalendarPRO_Clear" />');
				dayHTML.push('        </div>');
				dayHTML.push('        <div class="content">');
				dayHTML.push('            <div class="price">'+contentLine1+'</div>');
				
				if (promo > 0 && (bind == 0 || bind == 1)){
					dayHTML.push('            <div class="old-price">'+Currency+price+'</div>');
				}
				dayHTML.push('            <br class="DOPBackendBookingCalendarPRO_Clear" />');
				dayHTML.push('            <div class="available">'+contentLine2+'</div>');
				/********************************************************************************/
				if ($.trim(booked_using)!='' && status == 'booked' && (bind == 0 || bind == 3)){
					dayHTML.push('            <div class="available">'+BeforeBookedLabel+' '+BookedUsingText+'</div>');
				}
				/********************************************************************************/
				dayHTML.push('        </div>');  
				dayHTML.push('    </div>');
				dayHTML.push('    <div class="bind-right'+(bind == 1 || bind == 2 ? '  enabled':'')+'">');
				dayHTML.push('        <div class="header">&nbsp;</div>');
				dayHTML.push('        <div class="content">&nbsp;</div>');
				dayHTML.push('    </div>');
				dayHTML.push('</div>');

				
				return dayHTML.join('');
			}, 

			defaultDay:function(day){
				return {
					"available"	: "1",			 /* number of rooms available*/
					"bind"		: "0",			 /* type of connection (if group, 0-alone, 1- left, 2-middle, 3-right) */
					"info"		: "",			 /* Text box information */
					"notes"		: "",			 /* Text box for notes */
					"price"		: PropertyPrice ? PropertyPrice : 0, /* Inicial property price */
					"promo"		: "",			 /* Promo price for each day */
					"status"	: AvailableDays[day] ? "available" : "unavailable", /* Status on each day  */
					"booked_using":"",			/* type of booking */
					"user_id"	:"",			/* The user booked these days*/
				}
			}, 

			rpDays:function(){
				var maxHeight = 0,
				hiddenBustedItems = prototypes.doHideBuster($(Container));
				
				$('.DOPBackendBookingCalendarPRO_Day .content', Container).removeAttr('style');
			   
				$('.DOPBackendBookingCalendarPRO_Day', Container).width(parseInt(($('.DOPBackendBookingCalendarPRO_Month', Container).width()-parseInt($('.DOPBackendBookingCalendarPRO_Month', Container).css('padding-left'))+parseInt($('.DOPBackendBookingCalendarPRO_Month', Container).css('padding-right')))/7));
				$('.DOPBackendBookingCalendarPRO_Day .bind-content', Container).width($('.DOPBackendBookingCalendarPRO_Day', Container).width()-2);
			  
				if ($('.DOPBackendBookingCalendarPRO_Day', Container).width() <= 70){
					$('.DOPBackendBookingCalendarPRO_Day .no-available-text', Container).css('display', 'none');
				} else{
					$('.DOPBackendBookingCalendarPRO_Day .no-available-text', Container).css('display', 'inline');
				}
				
				if ($('.DOPBackendBookingCalendarPRO_Day', Container).width() <= 50){
					$('.DOPBackendBookingCalendarPRO_Day .bind-content .header .info', Container).css('display', 'none');
					$('.DOPBackendBookingCalendarPRO_Day .bind-content .header .notes', Container).css('display', 'none');
				} else{
					$('.DOPBackendBookingCalendarPRO_Day .bind-content .header .info', Container).css('display', 'block');
					$('.DOPBackendBookingCalendarPRO_Day .bind-content .header .notes', Container).css('display', 'block');
				}
				
				$('.DOPBackendBookingCalendarPRO_Day .bind-content .content', Container).each(function(){
					if (maxHeight < $(this).height()){
						maxHeight = $(this).height();
					}
				});
				
				$('.DOPBackendBookingCalendarPRO_Day .content', Container).height(maxHeight);
				
				prototypes.undoHideBuster(hiddenBustedItems);
			},

			initDayEvents:function(){// Init Events for the days of the Calendar.
				var xPos = 0, yPos = 0, touch;
				
				$('.DOPBackendBookingCalendarPRO_Day', Container).off('click touchstart');
				$('.DOPBackendBookingCalendarPRO_Day', Container).on('click touchstart', function(){
					var day = $(this);
						
					setTimeout(function() {
						if (!dayTimeDisplay){
							if (!day.hasClass('mask')){
								if (!day.hasClass('past_day')){
									if (!dayFirstSelected){
										dayFirstSelected = true;
										dayStartSelection = day.attr('id');
										dayStartSelectionCurrMonth = CurrMonth;
										methods.hideForm();
									}
									else{
										dayFirstSelected = false;
										dayEndSelection = day.attr('id');
										methods.showForm();
									}
									methods.showDaySelection(day.attr('id'));
								}
							}
						} else {
							dayTimeDisplay = false;
						}
					}, 10);
					return false;
				});
				
				if (!prototypes.isTouchDevice()){
					$('.DOPBackendBookingCalendarPRO_Day', Container).hover(function(){
						var day = $(this);
						if (dayFirstSelected){
							methods.showDaySelection(day.attr('id'));
						}
					});
				
					$('.DOPBackendBookingCalendarPRO_Day .info', Container).hover(function(){
						$(this).addClass('hover');
						methods.showInfo($(this).attr('id').split('_')[1], 'info');
					}, function(){
						$(this).removeClass('hover');
						methods.hideInfo();
					});
				
					$('.DOPBackendBookingCalendarPRO_Day .notes', Container).hover(function(){
						$(this).addClass('hover');
						methods.showInfo($(this).attr('id').split('_')[1], 'notes');
					}, function(){
						$(this).removeClass('hover');
						methods.hideInfo();
					});
				} else{
					$('.DOPBackendBookingCalendarPRO_Day .info', Container).off('click touchstart');
					$('.DOPBackendBookingCalendarPRO_Day .info', Container).on('click touchstart', function(e){
						e.preventDefault();
						touch = e.originalEvent.touches[0];
						xPos = touch.clientX+$(document).scrollLeft();
						yPos = touch.clientY+$(document).scrollTop();
						$('#DOPBackendBookingCalendarPRO_Info'+ID).css({'left': xPos, 'top': yPos});
						methods.showInfo($(this).attr('id').split('_')[1], 'info');
					});
					
					$('.DOPBackendBookingCalendarPRO_Day .notes', Container).off('click touchstart');
					$('.DOPBackendBookingCalendarPRO_Day .notes', Container).on('click touchstart', function(e){
						e.preventDefault();
						touch = e.originalEvent.touches[0];
						xPos = touch.clientX+$(document).scrollLeft();
						yPos = touch.clientY+$(document).scrollTop();
						$('#DOPBackendBookingCalendarPRO_Info'+ID).css({'left': xPos, 'top': yPos});
						methods.showInfo($(this).attr('id').split('_')[1], 'notes');
					});
				}
			},

			showDaySelection:function(id){
				var day, maxHeight = 0;
				$('.DOPBackendBookingCalendarPRO_Day', Container).removeClass('selected');
				methods.rpDays();
				
				if (id < dayStartSelection){
					$('.DOPBackendBookingCalendarPRO_Day', Container).each(function(){
					   day = $(this);
					   
					   if (day.attr('id') >= id && day.attr('id') <= dayStartSelection && !day.hasClass('past_day') && !day.hasClass('hide') && !day.hasClass('mask')){
						   day.addClass('selected');
					   }
					});
				} else {
					$('.DOPBackendBookingCalendarPRO_Day', Container).each(function(){
					   day = $(this);   
					   
					   if (day.attr('id') >= dayStartSelection && day.attr('id') <= id && !day.hasClass('past_day') && !day.hasClass('hide') && !day.hasClass('mask')){
						   day.addClass('selected');
					   }
					});
				}
				
				$('.DOPBackendBookingCalendarPRO_Day.selected .header', Container).removeAttr('style');
				$('.DOPBackendBookingCalendarPRO_Day.selected .content', Container).removeAttr('style');
				$('.DOPBackendBookingCalendarPRO_Day .content', Container).each(function(){
					if (maxHeight < $(this).height()){
						maxHeight = $(this).height();
					}
				});
				
				$('.DOPBackendBookingCalendarPRO_Day .content', Container).height(maxHeight);
			},
			
			initInfo:function(){
				var xPos = 0, yPos = 0;
				
				if (!prototypes.isTouchDevice()){
					$(document).mousemove(function(e){
						xPos = e.pageX+30;
						yPos = e.pageY;

						if ($(document).scrollTop()+$(window).height() < yPos+$('#DOPBackendBookingCalendarPRO_Info'+ID).height()+parseInt($('#DOPBackendBookingCalendarPRO_Info'+ID).css('padding-top'))+parseInt($('#DOPBackendBookingCalendarPRO_Info'+ID).css('padding-bottom'))+10){
						   yPos = $(document).scrollTop()+$(window).height()-$('#DOPBackendBookingCalendarPRO_Info'+ID).height()-parseInt($('#DOPBackendBookingCalendarPRO_Info'+ID).css('padding-top'))-parseInt($('#DOPBackendBookingCalendarPRO_Info'+ID).css('padding-bottom'))-10;
						}

						$('#DOPBackendBookingCalendarPRO_Info'+ID).css({'left': xPos, 'top': yPos});
					}); 
				} else {
					$('#DOPBackendBookingCalendarPRO_Info'+ID).off('click touchstart');
					$('#DOPBackendBookingCalendarPRO_Info'+ID).on('click touchstart', function(e){
						e.preventDefault();
						methods.hideInfo();
					});
				}
			},

			showInfo:function(date, type){
				var info = Schedule[date][type];
				$('#DOPBackendBookingCalendarPRO_Info'+ID).html(info);
				$('#DOPBackendBookingCalendarPRO_Info'+ID).css('display', 'block');                         
			},

			hideInfo:function(){
				$('#DOPBackendBookingCalendarPRO_Info'+ID).css('display', 'none');                        
			},
			
			showForm:function(){// Show Form
				var HTML = new Array(),
				startDate, sYear, sMonth, sMonthText, sDay,
				endDate, eYear, eMonth, eMonthText, eDay;
				
				HTML.push('<div class="DOPBackendBookingCalendarPRO_Form">');
				HTML.push('    <div class="container">');
				 
				// ***************************************************** Start Dates Info
				HTML.push('        <div class="section first">');
				
				if (dayStartSelection > dayEndSelection){
					endDate = dayStartSelection.split('_')[1];
					startDate = dayEndSelection.split('_')[1];
				} else {
					startDate = dayStartSelection.split('_')[1];
					endDate = dayEndSelection.split('_')[1];
				}

				sYear = startDate.split('-')[0];
				sMonth = startDate.split('-')[1];
				sMonthText = MonthNames[parseInt(sMonth, 10)-1];
				sDay = startDate.split('-')[2];

				eYear = endDate.split('-')[0];
				eMonth = endDate.split('-')[1];
				eMonthText = MonthNames[parseInt(eMonth, 10)-1];
				eDay = endDate.split('-')[2];
				
				if (dayStartSelection != dayEndSelection){
					if (DateType == 1){
						HTML.push('            <div class="section-item">');
						HTML.push('                <label class="left">'+DateStartLabel+'</label>');
						HTML.push('                <span class="date">'+sMonthText+' '+sDay+', '+sYear+'</span>');
						HTML.push('                <br class="DOPBackendBookingCalendarPRO_Clear" />');  
						HTML.push('            </div>');
						HTML.push('            <div class="section-item">');
						HTML.push('                <label class="left">'+DateEndLabel+'</label>');
						HTML.push('                <span class="date">'+eMonthText+' '+eDay+', '+eYear+'</span>');
						HTML.push('                <br class="DOPBackendBookingCalendarPRO_Clear" />');  
						HTML.push('            </div>');
					} else {
						HTML.push('            <div class="section-item">');
						HTML.push('                <label class="left">'+DateStartLabel+'</label>');
						HTML.push('                <span class="date">'+sDay+' '+sMonthText+' '+sYear+'</span>');
						HTML.push('                <br class="DOPBackendBookingCalendarPRO_Clear" />');  
						HTML.push('            </div>');
						HTML.push('            <div class="section-item">');
						HTML.push('                <label class="left">'+DateEndLabel+'</label>');
						HTML.push('                <span class="date">'+eDay+' '+eMonthText+' '+eYear+'</span>');
						HTML.push('                <br class="DOPBackendBookingCalendarPRO_Clear" />');  
						HTML.push('            </div>');
					}
				} else {
					HTML.push('            <div class="section-item">');                      
					HTML.push('                <span class="date">'+(DateType == 1 ? sMonthText+' '+sDay+', '+sYear:sDay+' '+sMonthText+' '+sYear)+'</span>');
					HTML.push('                <br class="DOPBackendBookingCalendarPRO_Clear" />');  
					HTML.push('            </div>');
				}
				HTML.push('        </div>');
				// ***************************************************** End Dates Info
				
				// ***************************************************** Start Form Fields
				HTML.push('        <div class="section">');
				HTML.push('         <div id="calendar_message" class="message"></div>');
				HTML.push('            <div class="section-item">');  
				HTML.push('                <label class="type2" for="DOPBCP_status">'+StatusLabel+'</label>');
				HTML.push('                <select name="DOPBCP_status" id="DOPBCP_status">');
				HTML.push('                    <option value="">Select</option>');
				HTML.push('                    <option value="available">'+StatusAvailableText+'</option>');
				HTML.push('                    <option value="booked">'+StatusBookedText+'</option>');
				// HTML.push('                    <option value="special">'+StatusSpecialText+'</option>');
				HTML.push('                    <option value="unavailable">'+StatusUnavailableText+'</option>');
				HTML.push('                </select>');
				HTML.push('                <br class="DOPBackendBookingCalendarPRO_Clear" />');
				HTML.push('                <div id="booked_select"> <br />');

				// HTML.push('                 <label class="type2" for="DOPBCP_booked_using">'+BookedUsingLabel+'</label>');
				// HTML.push('                 <select name="DOPBCP_booked_using" id="DOPBCP_booked_using" disabled="disabled">');
				// HTML.push('                    <option value="">'+UsingEmptyText+'</option>');
				// HTML.push('                    <option value="portal">'+UsingPortalText+'</option>');
				// HTML.push('                    <option value="via_email">'+UsingViaEmailText+'</option>');
				// HTML.push('                    <option value="offline_source">'+UsingOfflineSourceText+'</option>');
				// HTML.push('                    <option value="other">'+UsingOtherText+'</option>');
				// HTML.push('                 </select>');
				// HTML.push('                 <br class="DOPBackendBookingCalendarPRO_Clear" />');

				HTML.push('                </div>');
				HTML.push('            </div>');     
				
				HTML.push('            <div class="section-item">');
				HTML.push('                <label class="type2" for="DOPBCP_price">'+PriceLabel+'</label>');
				HTML.push('                <input type="text" name="DOPBCP_price" id="DOPBCP_price" value=""  disabled="disabled"/><span class="currency">'+Currency+'</span>');
				HTML.push('                <br class="DOPBackendBookingCalendarPRO_Clear" />');
				HTML.push('            </div>');                        
				// HTML.push('            <div class="section-item">');
				// HTML.push('                <label class="type2" for="DOPBCP_promo">'+PromoLabel+'</label>');
				// HTML.push('                <input type="text" name="DOPBCP_promo" id="DOPBCP_promo" value="" disabled="disabled" /><span class="currency">'+Currency+'</span>'); 
				// HTML.push('                <br class="DOPBackendBookingCalendarPRO_Clear" />');
				// HTML.push('            </div>');
				// HTML.push('            <div class="section-item">');
				// HTML.push('                <label class="type2" for="DOPBCP_available">'+AvailableLabel+'</label>');
				// HTML.push('                <input type="text" name="DOPBCP_available" id="DOPBCP_available" value="1" />');
				// HTML.push('                <br class="DOPBackendBookingCalendarPRO_Clear" />');
				// HTML.push('            </div>');

				HTML.push('            <div class="section-item" style="display:none;">');
				HTML.push('                <label class="type3" for="DOPBCP_info">'+InfoLabel+'</label>');
				HTML.push('                <textarea name="DOPBCP_info" id="DOPBCP_info"></textarea>');  
				HTML.push('            </div>');
				HTML.push('            <div class="section-item" style="display:none;">');
				HTML.push('                <label class="type4" for="DOPBCP_notes">'+NotesLabel+'</label>');
				HTML.push('                <textarea name="DOPBCP_notes" id="DOPBCP_notes"></textarea>'); 
				HTML.push('            </div>');  
				
				// HTML.push('            <div class="section-item">');
				// HTML.push('                <input type="checkbox" name="DOPBCP_group" id="DOPBCP_group" />');
				// HTML.push('                <label class="type5" for="DOPBCP_group">'+GroupDaysLabel+'</label>');
				// HTML.push('            </div>');   
				
				HTML.push('        </div>');
				// ***************************************************** End Form Fields
				
				HTML.push('        <div class="section">');
				HTML.push('            <input type="button" name="DOPBCP_submit" id="DOPBCP_submit" class="submit-style" title="'+SubmitLabel+'" value="'+SubmitLabel+'" />');
				// HTML.push('            <input type="button" name="DOPBCP_reset" id="DOPBCP_reset" class="submit-style" title="'+ResetLabel+'" value="'+ResetLabel+'" />');
				HTML.push('            <input type="button" name="DOPBCP_close" id="DOPBCP_close" class="submit-style" title="'+CloseLabel+'" value="'+CloseLabel+'" />');
				// HTML.push('            <input type="hidden" name="FormSubmit" id="FormSubmit" class="submit-style" title="Save" value="Save" />');

				HTML.push('                <br class="DOPBackendBookingCalendarPRO_Clear" />');
				HTML.push('        </div>');
				HTML.push('    </div>');                      
				HTML.push('</div>');
				
				methods.rpForm();
				
				$('.DOPBackendBookingCalendarPRO_FormContainer', Container).html(HTML.join(''));
				$('.DOPBackendBookingCalendarPRO_FormWrapper', Container).css('display', 'block');

				// ----------------------------------------------------- Start Form Actions
				$('#DOPBCP_status').off('change touchstart');
				$('#DOPBCP_status').on('change touchstart', function(){
					$('#DOPBCP_booked_using').prop('disabled', true);
					$('#DOPBCP_booked_using').val('');
					switch ($(this).val()){
						case 'available':
							$('#DOPBCP_price').removeAttr('disabled');
							// $('#DOPBCP_promo').attr('disabled', 'disabled');
							$('#DOPBCP_price').val(PropertyPrice);
							$('#DOPBCP_price').prop('disabled', false);
							$('#DOPBCP_promo').prop('disabled', true);
							$('#DOPBCP_promo').hide();

							// $('#DOPBCP_available').removeAttr('disabled');
							$('#DOPBCP_available').val('1');
							
							if (startDate != endDate){
								$('#DOPBCP_group').removeAttr('disabled');
							}
							break;
						case 'booked':
							$('#DOPBCP_price').attr('disabled', 'disabled');
							$('#DOPBCP_promo').attr('disabled', 'disabled');
							$('#DOPBCP_price').val('');
							$('#DOPBCP_promo').val('');
							$('#DOPBCP_available').attr('disabled', 'disabled');
							$('#DOPBCP_available').val('');

							// $('#DOPBCP_booked_using').removeAttr('disabled');
							$('#DOPBCP_booked_using').prop('disabled', false);
							
							if (startDate != endDate){
								$('#DOPBCP_group').removeAttr('disabled');
							}
							break;
						case 'special':
							// $('#DOPBCP_price').removeAttr('disabled');
							$('#DOPBCP_price').val(PropertyPrice);
							$('#DOPBCP_price').prop('readonly', true);
							$('#DOPBCP_price').prop('disabled', true);
							$('#DOPBCP_promo').prop('disabled', false);
							// $('#DOPBCP_promo').attr('disabled', 'disabled');

							$('#DOPBCP_available').removeAttr('disabled');
							$('#DOPBCP_available').val('1');
							
							if (startDate != endDate){
								$('#DOPBCP_group').removeAttr('disabled');
							}
							break;
						case 'unavailable':
							$('#DOPBCP_price').attr('disabled', 'disabled');
							$('#DOPBCP_promo').attr('disabled', 'disabled');
							$('#DOPBCP_price').val('');
							$('#DOPBCP_promo').val('');
							$('#DOPBCP_available').attr('disabled', 'disabled');
							$('#DOPBCP_available').val('');
							
							if (startDate != endDate){
								$('#DOPBCP_group').attr('disabled', 'disabled');
							}
							break;
						default:
							$('#DOPBCP_price').val('');
							$('#DOPBCP_price').prop('disabled', true);
							$('#DOPBCP_promo').prop('disabled', true);
					}
				});
				
				$('#DOPBCP_price').off('keyup touchstart');
				$('#DOPBCP_price').on('keyup touchstart', function(){
					prototypes.cleanInput(this, '0123456789.', '0', '');
					if ($(this).val() > '0'){
						$('#DOPBCP_promo').removeAttr('disabled');
					} else {
						$('#DOPBCP_promo').attr('disabled', 'disabled');
						$('#DOPBCP_promo').val('');                                
					}
				});

				$('#DOPBCP_promo').off('keyup touchstart');
				$('#DOPBCP_promo').on('keyup touchstart', function(){
					prototypes.cleanInput(this, '0123456789.', '0', '');
					if ($(this).val() > PropertyPrice || $(this).val() < PropertyPrice){
						 $('#calendar_message').removeClass('message-error').addClass('message-success').hide();
					} else {
						$('#calendar_message').removeClass('message-success').addClass('message-error').html('Promo price should be different then actual price').show();
						$('#DOPBCP_promo').val('');                              
					} 
				});
										
				$('#DOPBCP_available').off('keyup touchstart');
				$('#DOPBCP_available').on('keyup touchstart', function(){
					prototypes.cleanInput(this, '0123456789', '0', '');
				});

				$('#DOPBCP_submit').off('click touchstart');
				$('#DOPBCP_submit').on('click touchstart', function(){
					// do a validation before saving the data
					if ($.trim($('#DOPBCP_status').val())!='') {
						if ($('#DOPBCP_status').val() == 'special'){
							if ($('#DOPBCP_promo').val() > '0') {
								methods.setData();
							} else {
								alert('You must enter a promo price'); 
							}
						} else {
							methods.setData();
						}
					} else{
						methods.hideForm(); 
					};
				});

				$('#FormSubmit').off('click touchstart');
				$('#FormSubmit').on('click touchstart', function(){
					methods.setSaveData();
				});
				
				$('#DOPBCP_reset').off('click touchstart');
				$('#DOPBCP_reset').on('click touchstart', function(){
					methods.resetData();
				});
				
				$('#DOPBCP_close').off('click touchstart');
				$('#DOPBCP_close').on('click touchstart', function(){
					methods.hideForm();
				});
				// ----------------------------------------------------- End Form Actions

				$('body').animate({scrollTop: $(Container).offset().top-100}, 'slow');
			},

			hideForm:function(){
				$('.DOPBackendBookingCalendarPRO_FormWrapper', Container).css('display', 'none');
				$('.DOPBackendBookingCalendarPRO_Day', Container).removeClass('selected');   
				methods.rpDays();
			},

			rpForm:function(){
				$('.DOPBackendBookingCalendarPRO_FormBackground', Container).height($(Container).height());
				$('.DOPBackendBookingCalendarPRO_FormBackground', Container).width($(Container).width());
			},

			/******************************************************************/
			setData:function() {// Set submited data.
				var y, m, d, noDays, key,
				startDate, sYear, sMonth, sDay,
				endDate, eYear, eMonth, eDay,
				fromMonth, toMonth, fromDay, toDay,
				availableValue = $('#DOPBCP_available').val(),
				bindValue = 0,
				infoValue = $('#DOPBCP_info').val().replace(/\n/gi, '<br />'),
				notesValue = $('#DOPBCP_notes').val().replace(/\n/gi, '<br />'),
				priceValue = ($('#DOPBCP_price').val() != undefined) ? $('#DOPBCP_price').val() : '',
				promoValue = ($('#DOPBCP_promo').val() != undefined) ? $('#DOPBCP_promo').val() : '',
				statusValue = $('#DOPBCP_status').val(),
				bookedUsingValue = $('#DOPBCP_booked_using').val();
									
				startDate = dayStartSelection < dayEndSelection ? dayStartSelection.split('_')[1]:dayEndSelection.split('_')[1];
				endDate = dayStartSelection < dayEndSelection ? dayEndSelection.split('_')[1]:dayStartSelection.split('_')[1];

				sYear = parseInt(startDate.split('-')[0], 10);
				sMonth = parseInt(startDate.split('-')[1], 10);
				sDay = parseInt(startDate.split('-')[2], 10);

				eYear = parseInt(endDate.split('-')[0], 10);
				eMonth = parseInt(endDate.split('-')[1], 10);
				eDay = parseInt(endDate.split('-')[2], 10);

				if (Schedule[methods.previousDay(startDate)] != undefined) {
					if (Schedule[methods.previousDay(startDate)]['bind'] == 1) {
						Schedule[methods.previousDay(startDate)]['bind'] = 0;                                                                
					} else if (Schedule[methods.previousDay(startDate)]['bind'] == 2) {
						Schedule[methods.previousDay(startDate)]['bind'] = 3;                                
					}
				}
				
				if (Schedule[methods.nextDay(endDate)] != undefined){
					if (Schedule[methods.nextDay(endDate)]['bind'] == 2){
						Schedule[methods.nextDay(endDate)]['bind'] = 1;                                                                
					} else if (Schedule[methods.nextDay(endDate)]['bind'] == 3){
						Schedule[methods.nextDay(endDate)]['bind'] = 0;                                
					}
				}

				for (y=sYear; y<=eYear; y++){
					fromMonth = 1;

					if (y == sYear){
						fromMonth = sMonth;
					}

					toMonth = 12;

					if (y == eYear){
						toMonth = eMonth;
					}

					for (m=fromMonth; m<=toMonth; m++){
						noDays = new Date(y, m, 0).getDate();
						fromDay = 1;

						if (y == sYear && m == sMonth){
							fromDay = sDay;
						}

						toDay = noDays;

						if (y == eYear && m == eMonth){
							toDay = eDay;
						}

						for (d=fromDay; d<=toDay; d++){
							key = y+'-'+prototypes.timeLongItem(m)+'-'+prototypes.timeLongItem(d);

							if ($('#DOPBCP_group').is(':checked')){
								if (key == startDate){
									bindValue = 1;
								}                 
								else if (key == endDate){
									bindValue = 3;
								}   
								else{
									bindValue = 2;                                            
								}
							}

							Schedule[key] = {
								"available"	: availableValue,
								"bind"		: bindValue,
								"info"		: infoValue,
								"notes"		: notesValue,
								"price"		: priceValue,
								"promo"		: promoValue,
								"status"	: statusValue,
								"booked_using": bookedUsingValue,
								"user_id"	: "",
							};
						}
					}
				} 
				methods.saveData();
			},

			saveData:function(){// Save data.
				var today = new Date(),
				dd = prototypes.timeLongItem(today.getDate()),
				mm = prototypes.timeLongItem(today.getMonth()+1),
				yyyy = today.getFullYear();
				
				for (var day in Schedule){
					if (day < yyyy+'-'+mm+'-'+dd){
						delete Schedule[day];
					}                            
				}
				methods.hideForm();
				methods.generateCalendar(StartYear, dayStartSelectionCurrMonth);
				// $.post(SaveURL, {calendar_id:ID, property_id: PropertyID, calendar_data:JSON.stringify(Schedule)}, function(data){}); 

				$.post(SaveURL, {
					calendar_id: ID,
					property_id: PropertyID,
				    calendar_data: JSON.stringify(Schedule)
				}, function(data, textStatus, xhr) {
					if (textStatus == 'success') {
				    	methods_message.init('success', SavedText);
					}
				});                     
			},  

			resetData:function(){// Reset Selected days.
				if (confirm(ResetConfirmation)){
					var startDate = dayStartSelection < dayEndSelection ? dayStartSelection.split('_')[1]:dayEndSelection.split('_')[1],
					endDate = dayStartSelection < dayEndSelection ? dayEndSelection.split('_')[1]:dayStartSelection.split('_')[1];

					for (var day in Schedule){
						if (startDate <= day && day <= endDate){
							delete Schedule[day];
						}                            
					}
	
					methods.saveData();
				}
			},  
								
			previousDay:function(date){
				var previousDay = new Date(),
				parts = date.split('-');
				
				previousDay.setFullYear(parts[0], parseInt(parts[1])-1, parts[2]);
				previousDay.setTime(previousDay.getTime()-86400000);
										
				return previousDay.getFullYear()+'-'+prototypes.timeLongItem(previousDay.getMonth()+1)+'-'+prototypes.timeLongItem(previousDay.getDate());                        
			},

			nextDay:function(date){
				var nextDay = new Date(),
				parts = date.split('-');
				
				nextDay.setFullYear(parts[0], parts[1]-1, parts[2]);
				nextDay.setTime(nextDay.getTime()+86400000);
				   
				return nextDay.getFullYear()+'-'+prototypes.timeLongItem(nextDay.getMonth()+1)+'-'+prototypes.timeLongItem(nextDay.getDate());
			},

			weekDay:function(year, month, day){
				var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
				date = new Date(eval('"'+day+' '+months[parseInt(month, 10)-1]+', '+year+'"'));
				
				return date.getDay();
			}
		},

		// Message 
        methods_message = {
            
            display: function(){
                var HTML = new Array();
                
                // Message Box
                HTML.push('<div id="DOPBCP-messages-background" class=""></div>');   
                HTML.push('<div id="DOPBCP-messages-box" class="">');
                // HTML.push('     <a href="javascript:methods_message.init()" class="dopbcp-close"></a>');
                HTML.push('     <div class="dopbcp-icon-active"></div>');
                HTML.push('     <div class="dopbcp-icon-success"></div>');
                HTML.push('     <div class="dopbcp-icon-error"></div>');
                HTML.push('     <div class="dopbcp-message"></div>');
                HTML.push('</div>');
                // Confirmation Box
                HTML.push('<div id="DOPBCP-confirmation-box">');
                HTML.push('     <div class="dopbcp-icon"></div>');
                HTML.push('     <div class="dopbcp-message"></div>');
                HTML.push('     <div class="dopbcp-buttons">');
                HTML.push('         <a href="javascript:void(0)" class="dopbcp-button-yes">Yes</a>');
                HTML.push('         <a href="javascript:void(0)" class="dopbcp-button-no">No</a>');
                HTML.push('     </div>');
                HTML.push('</div>');
                
                return HTML.join('');
            },
            init: function(action, message){
               action = action === undefined ? 'none':action;
               message = message === undefined ? '':message;

               clearTimeout(MessagesTimeout);
               $('#DOPBCP-messages-background').removeClass('dopbcp-active');
               $('#DOPBCP-messages-box').removeClass('dopbcp-active')
                                        .removeClass('dopbcp-active-info')
                                        .removeClass('dopbcp-error')
                                        .removeClass('dopbcp-success')
                                        .addClass('dopbcp-'+action);
               $('#DOPBCP-messages-box .dopbcp-message').html(message);
               switch (action){
                   case 'active':
                       $('#DOPBCP-messages-background').addClass('dopbcp-active');
                       break;
                   case 'success':
                       MessagesTimeout = setTimeout(function(){
                            $('#DOPBCP-messages-box').removeClass('dopbcp-success');
                            $('#DOPBCP-messages-box .dopbcp-message').html('');
                       }, 2000);
                       break;
               }
           }
        },

        // Actions  Prototypes
		prototypes = {
			resizeItem:function(parent, child, cw, ch, dw, dh, pos){// Resize & Position an item (the item is 100% visible)
				var currW = 0, currH = 0;

				if (dw <= cw && dh <= ch){
					currW = dw;
					currH = dh;
				} else{
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
				}else{
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
				} else{
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