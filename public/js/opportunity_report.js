
$('#team_id').on('change', function(e){
	e.preventDefault();
	var team_id = $(this).val();

	$.ajax({
		method:"get",
		url: baseUrl + "/get-team-members/" + team_id,
		dataType: "json",
		success: function(data){
			console.log(data)
		}

	})
});