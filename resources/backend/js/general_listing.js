$(function(){
	'use strict';
	$('#example23').DataTable({

		rowReorder: {
            selector: 'td:nth-child(2)'
        },
        order: [[ 0, "desc" ]],
        responsive: true,
		dom: 'Bfrtip',
		buttons: [
			{
				extend: 'copyHtml5'
			
			},
			{
				extend: 'csvHtml5'
			
			},
			{
				extend: 'excelHtml5'
			
			},
			{
				extend: 'pdfHtml5'
			
			},
			{
				extend: 'print'
			
			},
		],
		
	});
});

function actRecurrent(val)
{
	if(val==0)
	{
		$(".recurrent_info").hide();
		$(".recurrent_info2").show();
	}
	else{
		$(".recurrent_info2").hide();
		$(".recurrent_info").show();	
	}
}