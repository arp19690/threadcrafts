<!-- include if not exist -->
<!-- script src="js/lib/jqueryui/jquery-ui.custom.min.js" -->
<script type="text/javascript">
var ajax ;
	var data_ajax;
  $(function() {
    var input_search = $("form[name=search_form] input[type=text]");
	input_search.autocomplete
	({
		minLength: 0,
	  source: function (request, response) 
	  {
		  var q = input_search.val();
		  if(ajax != null)
		  	ajax.abort();
		  ajax =  $.ajax({
			  url: '{"products.search"|fn_url}'+ '&' + $('form[name=search_form]').serialize(),
			  dataType: "json",
			  data:{},
			  success: function (data) {
				data_ajax = data.html;
				response($.map(data, function(v,i)
				  {
					   if(input_search.val().length >= 1)
					  {
						  return 1;
					  }
				  }));
			  }
		  });
	  },
	  open: function ()
	  {
		  $('ul.ui-autocomplete').html(data_ajax);
	  }
	});
 });
</script>