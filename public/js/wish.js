//slimit, nlimit
function loadUserWishes(uID,k) {
	var slimit = 0;
	var nlimit = 10;
	//&nlimit='+nlimit+'
	//var total_groups = '$total_groups';
	//alert(total_groups);
	//alert(BASE_URL);
    loadAjax('/ajax/LoadWishes', 'uid='+uID+'&slimit='+slimit+'&u_key='+k, function(d){
        //console.log('Start debug res..');
        //console.log(d);
		//alert(d);
		//am clasit tagshi svavs
        $('.wish-container').prepend(d);
    });
}

function loadUserWishes1(uID,k,total) {
	var track_load = 0; //total loaded record group(s)
	var loading  = false; //to prevents multipal ajax loads
	var total_groups = total; //total record group(s)	
	$('.wish-container').load(BASE_URL+'/ajax/LoadWishes1', {'uid':uID, 'u_key':k, 'group_no': track_load}, function() {track_load++;}); //load first group	2
	//$('#wish-container').load("autoload_process.php", {'group_no': track_load}, function() {track_load++;}); //load first group	1
	$(window).scroll(function() { //detect page scroll		
		if($(window).scrollTop() + $(window).height() == $(document).height())  //user scrolled to bottom of the page?
		{			
			if(track_load <= total_groups && loading == false) //there's more data to load
			{
				loading = true; //prevent further ajax loading
				$('.animation_image').show(); //show loading image
				//load data from the server using a HTTP POST request
				$.post(BASE_URL+'/ajax/LoadWishes1',{'uid':uID, 'u_key':k, 'group_no': track_load}, function(data){									
					$(".wish-container").append(data); //append received data into the element
					//hide loading image
					$('.animation_image').hide(); //hide loading image once data is received					
					track_load ++; //loaded group increment
					loading = false; 				
				}).fail(function(xhr, ajaxOptions, thrownError) { //any errors?					
					alert(thrownError); //alert with HTTP error
					$('.animation_image').hide(); //hide loading image
					loading = false;				
				});				
			}
		}//scrollTop
	});//$(window).scroll(function()	
}//loadUserWishes1


function fr(act, frid, k, bt) {
    loadAjax(BASE_URL+'/ajax/friend', 'act='+act+'&frId='+frid+'&u_key='+k, function(d){
        //console.log('Start debug res..');
        //console.log(d);
        //$('.wish-container').prepend(d);
		//<a href='#' onclick=\"addFriend("+frd+", 'd2ds4g');"."return false;\"><button>დამეგობრება123</button></a>		
		if(act == 'remove')
		{
			document.getElementById("showfriends").innerHTML = d;	
		} else {
			document.getElementById("frb"+frid).innerHTML = bt;
			alert(d); 
		}
    });
}

function findfr(act, findfr, k, bt) {
    loadAjax(BASE_URL+'/ajax/friend', 'act='+act+'&frId='+findfr+'&u_key='+k, function(d){
		//alert(d);
        //console.log('Start debug res..');
        //console.log(d);
        //$('.wish-container').prepend(d);
		//<a href='#' onclick=\"addFriend("+frd+", 'd2ds4g');"."return false;\"><button>დამეგობრება123</button></a>		
		document.getElementById("showfriends").innerHTML = d;	
		//found-friends		
    });
}

function addFriend(frid, k) {//megobrobis shetavazeba
	var bt = "<a href='#' onclick=\"cancelFriend("+frid+",'d2ds4g'); return false;\"><button>შეთავაზება გაგზავნილია(გაუქმება)</button></a>";
   return fr('add', frid, k, bt);
}

function acceptFriend(frid, k) {
	var bt = "";
   return fr('accept', frid, k, bt);
}

function rejectFriend(frid, k) {
   var bt = "<a href='#' onclick=\"addFriend("+frid+",'d2ds4g'); return false;\"><button>დამეგობრება</button></a>";
   return fr('reject', frid, k, bt);
}

function unFriend(frid, k) {
	var bt = "<a href='#' onclick=\"addFriend("+frid+",'d2ds4g'); return false;\"><button>დამეგობრება</button></a>";
	return fr('remove', frid, k, bt);
}

function cancelFriend(frid, k) {
   var bt = "<a href='#' onclick=\"addFriend("+frid+",'d2ds4g'); return false;\"><button>დამეგობრება</button></a>";
   return fr('cancel', frid, k, bt);
}

function findFriend(findFriendtext, k){
	var findfriendtext = document.getElementById('findfriends').value;
	//alert(findfriendtext);
	bt = "";
	//alert(findFriendtext);
	//loadAjax(BASE_URL+'/ajax/friend', 'act='+act+'&frId='+frid+'&u_key='+k, function(d){
	return findfr('find', findfriendtext, k, bt);
	/*	nocache = Math.random();
	//alert(nickname);
	var uri = 'ajax-validation.php?&amp;nocache = '+nocache;
	//,action:checkuser
	$.post( uri,{findfriends:findfriendtext},
	function( data ) {
	document.getElementById('validateUsername').innerHTML = data;  
	//console.log(data); 
	});*/
}

function loadAjax(uri, dt, callback) {
	//alert("text");
    console.log(uri+'?'+dt);
	//alert(callback);
    $.ajax({
        dataType: 'html',
        data: dt,
        type: 'POST',
        url: uri,
        success: function(data) {
           //$('#debug').html(data);
		   callback(data);
        },
        complete: function(jqXHR, textStatus) {
         console.log(jqXHR+" "+textStatus);
        },
        error: function(jqXHR, textStatus, errorThrown) {
         console.log(jqXHR+" "+textStatus+" "+errorThrown);
        },
    });
}


function wish( wid, k, act, data, func ) {
    loadAjax(BASE_URL+'/ajax/wish', 'act='+act+'&wid='+wid+'&u_key='+k + data, func);
}

function change_privacy(wid, privacy, k) {
	wish(wid, k, 'change_privacy', '&privacy='+privacy, function(d) {
		//console.log(d);
	});
}


function show_privacy(wid, privacy, k){
/*jQuery(document).ready(function(){ 
	//$("ul").hide();
	$(".click").click(function(){
		//alert("text");
		var currendidname = $(this).attr("id");
		var currendid = '#'+currendidname;
		var dval = $(this).attr("data-value");
		var ulid = '#sharelist'+dval;
		$("ul").hide();			
		$(ulid).slideDown(200);
		$(ulid+' li').slideDown(200);
		var allOptions = $(ulid).children('li');
		$(ulid).on("click", "li", function() {
			allOptions.removeClass('selected');
			$(this).addClass('selected');
			var lidval = $(this).attr("data-value");

			$(currendid).html($(this).html());
			allOptions.slideUp();
			$(ulid).slideUp();
		});//ulid func
	});//click
});//document
*/
}