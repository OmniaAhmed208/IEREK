<link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet"></link>
 src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"

    $(function()
{
	 $( "#user_id" ).autocomplete({
             
	  source: "/admin/invoices/autocomplete",
	  minLength: 3,
	  select: function(event, ui) {
             
	  	$('#user_id').val(ui.item.value);
	  }
	});
});