// jquery and javascript code for parsing xml feed
$(document).ready(function(){
	// Loaded function
	// variables
	var bookSelect = "Gen";
	var chapter = "1";
	$(function(){
	 // console.log('loaded versions data');

		$.ajax({
			url: 'versions.xml',
			type: 'GET',
			dataType: 'xml',
			success: function(data){
				// console.log(data);
				$(data).find('version').each(function(){
					// console.log($(this).find('name'));
					var vName = $(this).find('name').text();
					var vId = $(this).find('id').text();
					// $(vName).appendTo('.body');
					if(vId == 'eng-KJV'){
						$('<option selected class="versions" value="'+ vId +'">'+vName + ' - '+ vId +'</option> ').appendTo('.version')
					}else{
						$('<option class="versions" value="'+ vId +'">'+vName + ' - '+ vId +'</option> ').appendTo('.version');
					}
				});
				books();
				chapters();
				heading();
				verses();

			}
		});

	});
	// Version Changed function
	$('.version').change(function(){
		books();
		// $('.chapters').empty();
  		chapters();
  		$('.heading').empty();
		$('.body').empty();
		$('.vFooter').empty();
		heading();
		verses();
	})
	// books changed function
	$('.books').change(function(){
		$('.chapter').empty();
		chapters();
		$('.heading').empty();
		$('.body').empty();
		$('.vFooter').empty();
		heading();
		verses();
	})
	$('.chapter').change(function(){

		// $('.chapters').empty();
		// chapters();
		$('.heading').empty();
		$('.body').empty();
		$('.vFooter').empty();
		heading();
		verses();
	})

	// function call for  books

	function books(){
		$(function(){
			var selected = $('.version').val();
			// console.log('version changed'+ ' - ' + selected);
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
			    if (xhttp.readyState == 4 && xhttp.status == 200) {
			      // document.getElementById("demo").innerHTML = xhttp.responseText;
			      // attach changes to html here
			      var xmlDoc = xhttp.responseXML;

			    	for (var i = 0; i < 66; i++ ){
			    		var x = xmlDoc;
				     	item = x.documentElement.childNodes.item(0).childNodes.item(i);
				     	// console.log(item);
				     	var bName = x.documentElement.childNodes.item(0).childNodes.item(i).childNodes.item(1).textContent;
				     	var abbr = x.documentElement.childNodes.item(0).childNodes.item(i).childNodes.item(2).textContent;
				    	// console.log("Book Name: "+bName);
				    	// console.log("abbr: "+abbr);
				    	// console.log('<option value="'+abbr+'">'+ bName +'</option> ');
				    	$('<option value="RR">Domestic</option> ').appendTo('.classes');
				    	$('<option value="SS">Import</option> ').appendTo('.classes');
				    	$('<option value="TT">Custom</option> ').appendTo('.classes');
			    		// console.log(x)
			    	};
					// $('<option>'+ x +'</option> ').appendTo('.books');

			    }
			}
			xhttp.open("GET", "books.php?value="+selected, true);
	  		xhttp.send();
		})
	}
	// function call for chapters
	function chapters(){
		$(function(){
			var versionSelect = $('.version').val();
			if($(".books").val() == null){
				// console.log(versionSelect +':'+bookSelect);
			}else{
				bookSelect = $('.books').val();
				// console.log(versionSelect +':'+bookSelect);
			}
			// bookSelect = $('.books').val();
			// console.log('version changed'+ ' - ' + versionSelect +' - '+ bookSelect);
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
			    if (xhttp.readyState == 4 && xhttp.status == 200) {
			      // document.getElementById("demo").innerHTML = xhttp.responseText;
			      // attach changes to html here
			      var xmlDoc = xhttp.responseXML;
			      var x = xmlDoc;
			      var item = x.documentElement.childNodes.item(0).childNodes;
			      // console.log(item.length);
			      // console.log(item);
			    	for (var i = 0; i < item.length; i++ ){
			    		var chapter = x.documentElement.childNodes.item(0).childNodes.item(i).childNodes.item(2).textContent;
						//    	console.log(chapter);
				     	if(chapter == "int"){

				     	}else{
				    		$('<option value="'+ chapter+'">'+ chapter +'</option> ').appendTo('.chapter');
				    	}
			    		// console.log(x)
			    	};
					// $('<option>'+ x +'</option> ').appendTo('.books');

			    }
			}
			xhttp.open("GET", "chapters.php?book="+bookSelect+"&version="+versionSelect, true);
	  		xhttp.send();
		})
	}

	function verses(){
		$(function(){
			var versionSelect = $('.version').val();
			// chapter = $('#chapters').val();
			if($(".chapter").val() == null){
				console.log(versionSelect +':'+bookSelect+'.'+chapter);
			}else{
				book = $('.books').val();
				chapter = $('.chapter').val();
				console.log(versionSelect +':'+bookSelect+'.'+chapter);
			}
			// bookSelect = $('.books').val();
			// console.log('version changed'+ ' - ' + versionSelect +' - '+ bookSelect);
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
			    if (xhttp.readyState == 4 && xhttp.status == 200) {
			      // document.getElementById("demo").innerHTML = xhttp.responseText;
			      // attach changes to html here
			      var xmlDoc = xhttp.responseXML;
			      var x = xmlDoc;
			      var item = x.documentElement.childNodes.item(0).childNodes;
			      // console.log(item.length);

			    	for (var i = 0; i < item.length; i++ ){
			    		var verse = x.documentElement.childNodes.item(0).childNodes.item(i);
				     	// console.log(verse);
				     	verse = x.documentElement.childNodes.item(0).childNodes.item(i).childNodes.item(9).textContent;
				     	// console.log(verse);
				    	$('<a href="#" class="highlight">'+verse+'</a>').appendTo('.body');
			    		// console.log(x)
			    	};
			    	var copy = x.documentElement.childNodes.item(0).childNodes.item(1).childNodes.item(13).textContent;
			      $(copy).appendTo('.vFooter');
			      console.log(copy);
					// $('<option>'+ x +'</option> ').appendTo('.books');

			    }
			}
			xhttp.open("GET", "verses.php?book="+bookSelect+"&version="+versionSelect+"&chapter="+chapter, true);
	  		xhttp.send();
		})
	}
	function heading(){
		$(function(){
			var versionSelect = $('.version').val();
			// chapter = $('#chapters').val();
			if($(".chapter").val() == null){
				// console.log(versionSelect +':'+bookSelect+'.'+chapter);
			}else{
				book = $('.books').val();
				chapter = $('.chapter').val();
				// console.log(versionSelect +':'+bookSelect+'.'+chapter);
			}
			// bookSelect = $('.books').val();
			// console.log('version changed'+ ' - ' + versionSelect +' - '+ bookSelect);
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
			    if (xhttp.readyState == 4 && xhttp.status == 200) {
			      // document.getElementById("demo").innerHTML = xhttp.responseText;
			      // attach changes to html here
			      var xmlDoc = xhttp.responseXML;
			      var x = xmlDoc;
			      var item = x.documentElement.childNodes.item(0).childNodes;
			      // console.log(item.length);
			      // console.log(item);
			      var verse = x.documentElement.childNodes.item(0).childNodes.item(0);
				     	// console.log(verse);
				     	verse = x.documentElement.childNodes.item(0).childNodes.item(0).childNodes.item(10).childNodes.item(0).childNodes.item(1).textContent;
						//    	console.log(verse);
				    	$("<h2>"+verse+"</h2>").appendTo('.heading');

					// $('<option>'+ x +'</option> ').appendTo('.books');

			    }
			}
			xhttp.open("GET", "verses.php?book="+bookSelect+"&version="+versionSelect+"&chapter="+chapter, true);
	  		xhttp.send();
		})
	}

})
