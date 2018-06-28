
////////////// modal youtube
$(document).ready(function(){
	
	$(document).on('click', '#getMedia', function(e){
		
		e.preventDefault();
		
		var uid = $(this).data('id');   // it will get id of clicked row
		
		$('#dynamic-content-media').html(''); // leave it blank before ajax call
		$('#modal-loader-media').show();      // load ajax loader
		
		$.ajax({
			url: 'video_youtube.php',
			type: 'POST',
			data: 'id='+uid,
			dataType: 'html'
		})
		.done(function(data){
			console.log(data);	
			$('#dynamic-content-media').html('');    
			$('#dynamic-content-media').html(data); // load response 
			$('#modal-loader-media').hide();		  // hide ajax loader	
		})
		.fail(function(){
			$('#dynamic-content-media').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
			$('#modal-loader-media').hide();
		});
		
	});
	
});
////////////// modal facebook
$(document).ready(function(){
	
	$(document).on('click', '#facebook', function(e){
		
		e.preventDefault();
		
		var uid = $(this).data('id');   // it will get id of clicked row
		
		$('#dynamic-content-facebook').html(''); // leave it blank before ajax call
		$('#modal-loader-facebook').show();      // load ajax loader
		
		$.ajax({
			url: 'video_facebook.php',
			type: 'POST',
			data: 'id='+uid,
			dataType: 'html'
		})
		.done(function(data){
			console.log(data);	
			$('#dynamic-content-facebook').html('');    
			$('#dynamic-content-facebook').html(data); // load response 
			$('#modal-loader-facebook').hide();		  // hide ajax loader	
		})
		.fail(function(){
			$('#dynamic-content-facebook').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
			$('#modal-loader-facebook').hide();
		});
		
	});
	
});
////////////// modal vimeo
$(document).ready(function(){
	
	$(document).on('click', '#vimeo', function(e){
		
		e.preventDefault();
		
		var uid = $(this).data('id');   // it will get id of clicked row
		
		$('#dynamic-content-vimeo').html(''); // leave it blank before ajax call
		$('#modal-loader-vimeo').show();      // load ajax loader
		
		$.ajax({
			url: 'video_vimeo.php',
			type: 'POST',
			data: 'id='+uid,
			dataType: 'html'
		})
		.done(function(data){
			console.log(data);	
			$('#dynamic-content-vimeo').html('');    
			$('#dynamic-content-vimeo').html(data); // load response 
			$('#modal-loader-vimeo').hide();		  // hide ajax loader	
		})
		.fail(function(){
			$('#dynamic-content-vimeo').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
			$('#modal-loader-vimeo').hide();
		});
		
	});
});	
////////////// modal playtube
$(document).ready(function(){
	
	$(document).on('click', '#playtube', function(e){
		
		e.preventDefault();
		
		var uid = $(this).data('id');   // it will get id of clicked row
		
		$('#dynamic-content-playtube').html(''); // leave it blank before ajax call
		$('#modal-loader-playtube').show();      // load ajax loader
		
		$.ajax({
			url: 'video_playtube.php',
			type: 'POST',
			data: 'id='+uid,
			dataType: 'html'
		})
		.done(function(data){
			console.log(data);	
			$('#dynamic-content-playtube').html('');    
			$('#dynamic-content-playtube').html(data); // load response 
			$('#modal-loader-playtube').hide();		  // hide ajax loader	
		})
		.fail(function(){
			$('#dynamic-content-playtube').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
			$('#modal-loader-playtube').hide();
		});
		
	})
});	
////////////// modal instagram
$(document).ready(function(){
	
	$(document).on('click', '#instagram', function(e){
		
		e.preventDefault();
		
		var uid = $(this).data('id');   // it will get id of clicked row
		
		$('#dynamic-content-instagram').html(''); // leave it blank before ajax call
		$('#modal-loader-instagram').show();      // load ajax loader
		
		$.ajax({
			url: 'video_instagram.php',
			type: 'POST',
			data: 'id='+uid,
			dataType: 'html'
		})
		.done(function(data){
			console.log(data);	
			$('#dynamic-content-instagram').html('');    
			$('#dynamic-content-instagram').html(data); // load response 
			$('#modal-loader-instagram').hide();		  // hide ajax loader	
		})
		.fail(function(){
			$('#dynamic-content-instagram').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
			$('#modal-loader-instagram').hide();
		});
		
	})	
	
});
////////////// modal flooxer
$(document).ready(function(){
	
	$(document).on('click', '#flooxer', function(e){
		
		e.preventDefault();
		
		var uid = $(this).data('id');   // it will get id of clicked row
		
		$('#dynamic-content-flooxer').html(''); // leave it blank before ajax call
		$('#modal-loader-flooxer').show();      // load ajax loader
		
		$.ajax({
			url: 'video_flooxer.php',
			type: 'POST',
			data: 'id='+uid,
			dataType: 'html'
		})
		.done(function(data){
			console.log(data);	
			$('#dynamic-content-flooxer').html('');    
			$('#dynamic-content-flooxer').html(data); // load response 
			$('#modal-loader-flooxer').hide();		  // hide ajax loader	
		})
		.fail(function(){
			$('#dynamic-content-flooxer').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
			$('#modal-loader-flooxer').hide();
		});
		
	})	
	
});
////////////// modal imgur
$(document).ready(function(){
	
	$(document).on('click', '#imgur', function(e){
		
		e.preventDefault();
		
		var uid = $(this).data('id');   // it will get id of clicked row
		
		$('#dynamic-content-imgur').html(''); // leave it blank before ajax call
		$('#modal-loader-imgur').show();      // load ajax loader
		
		$.ajax({
			url: 'video_imgur.php',
			type: 'POST',
			data: 'id='+uid,
			dataType: 'html'
		})
		.done(function(data){
			console.log(data);	
			$('#dynamic-content-imgur').html('');    
			$('#dynamic-content-imgur').html(data); // load response 
			$('#modal-loader-imgur').hide();		  // hide ajax loader	
		})
		.fail(function(){
			$('#dynamic-content-imgur').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
			$('#modal-loader-imgur').hide();
		});
		
	})	
	
});

////////////// modal dailymotion
$(document).ready(function(){
	
	$(document).on('click', '#dailymotion', function(e){
		
		e.preventDefault();
		
		var uid = $(this).data('id');   // it will get id of clicked row
		
		$('#dynamic-content-dailymotion').html(''); // leave it blank before ajax call
		$('#modal-loader-dailymotion').show();      // load ajax loader
		
		$.ajax({
			url: 'video_dailymotion.php',
			type: 'POST',
			data: 'id='+uid,
			dataType: 'html'
		})
		.done(function(data){
			console.log(data);	
			$('#dynamic-content-dailymotion').html('');    
			$('#dynamic-content-dailymotion').html(data); // load response 
			$('#modal-loader-dailymotion').hide();		  // hide ajax loader	
		})
		.fail(function(){
			$('#dynamic-content-dailymotion').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
			$('#modal-loader-dailymotion').hide();
		});
		
	})	
	
});

////////////// modal liveleak
$(document).ready(function(){
	
	$(document).on('click', '#liveleak', function(e){
		
		e.preventDefault();
		
		var uid = $(this).data('id');   // it will get id of clicked row
		
		$('#dynamic-content-liveleak').html(''); // leave it blank before ajax call
		$('#modal-loader-liveleak').show();      // load ajax loader
		
		$.ajax({
			url: 'video_liveleak.php',
			type: 'POST',
			data: 'id='+uid,
			dataType: 'html'
		})
		.done(function(data){
			console.log(data);	
			$('#dynamic-content-liveleak').html('');    
			$('#dynamic-content-liveleak').html(data); // load response 
			$('#modal-loader-liveleak').hide();		  // hide ajax loader	
		})
		.fail(function(){
			$('#dynamic-content-liveleak').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
			$('#modal-loader-liveleak').hide();
		});
		
	})	
	
});

