$(function(){
	$('#swfupload-control').swfupload({
		upload_url: "upload-file.php?upload=true",
		file_post_name: 'uploadfile',
		file_size_limit : "30024",
		file_types : "*.jpg;*.jpeg;*.x-png;*.png;*.gif",
		file_types_description : "Image files",
		//file_upload_limit : 5,
		flash_url : "swfupload/swfupload.swf",
		button_image_url : 'swfupload/wdp_buttons_upload_114x29.png',
		button_width : 114,
		button_height : 29,
		button_placeholder : $('#button1')[0],
		debug: false
	})
	//<p class="removefile" id="removefile" onclick="cancelupload(\''+file.name+'\')">Pending</p>
		.bind('fileQueued', function(event, file){
			var listitem='<li id="'+file.id+'" >'+
			'<div><div class="uploadimage"><p>'+file.name+ '('+Math.round(file.size/1024)+' KB) </p></div>'+
			'<div class="progressblock"><span class="progressvalue"></span><div class="progressbar"><div class="progress" ></div></div></div><p class="status" >Pending</p><span class="cancel" >&nbsp;</span>'+
			'</li>';
			$('#log').append(listitem);

			$('li#'+file.id+' .cancel').bind('click', function(){
				//alert(file.name);
				var filename=file.name;
				nocache = Math.random();
				var uri = 'upload-file.php?nocache = '+nocache;
				$.post( uri,{removefile:filename},
				function(data){	});
				var swfu = $.swfupload.getInstance('#swfupload-control');
				swfu.cancelUpload(file.id);
				$('li#'+file.id).slideUp('fast');
			});
			// start the upload since it's queued
			$(this).swfupload('startUpload');
		})
		.bind('fileQueueError', function(event, file, errorCode, message){
		alert('Size of the file '+file.name+' is greater than limit');
		})
		.bind('fileDialogComplete', function(event, numFilesSelected, numFilesQueued){
			//$('#queuestatus').text('Files Selected: '+numFilesSelected+' / Queued Files: '+numFilesQueued);
		})
		.bind('uploadStart', function(event, file){
			$('#log li#'+file.id).find('p.status').text('Uploading...');
			$('#log li#'+file.id).find('span.progressvalue').text('0%');
			//$('#log li#'+file.id).find('span.cancel').hide();			
		})
		.bind('uploadProgress', function(event, file, bytesLoaded){
			//Show Progress
			var percentage=Math.round((bytesLoaded/file.size)*100);
			$('#log li#'+file.id).find('div.progress').css('width', percentage+'%');
			$('#log li#'+file.id).find('span.progressvalue').text(percentage+'%');
		})
		.bind('uploadSuccess', function(event, file, serverData){
			var item=$('#log li#'+file.id);
			item.find('div.progress').css('width', '100%');
			item.find('span.progressvalue').text('100%');
			$('#log li#'+file.id).find('div.progressblock').hide();
			var pathtofile='<a href="uploads/'+file.name+'" target="_blank" >ნახვა &raquo;</a>';
			item.addClass('success').find('p.status').html(pathtofile);
			//item.addClass('uploadimage').find('p.status').html('ატვირთულია!!! | '+pathtofile);
			var showfile='<img src="uploads/'+file.name+'" width="100px" id="file_'+file.id+'" alt="'+file.name+'" />';
			//item.find('div.uploadimage').html(showfile);
			item.addClass('uploadimage').find('div.uploadimage').html(showfile);
			//<img src="cancel.png" alt="წაშლა" />
			item.addClass('success').find('p.removefile').text('cashla');
		})
		.bind('uploadComplete', function(event, file){
			// upload has completed, try the next one in the queue
			$(this).swfupload('startUpload');
		})
	
});	