
$('#team_id').on('change', function(e){
	e.preventDefault();
	var team_id = $(this).val();

        $("#owner_id").empty();

        $("<option>").val("").text("Loading...").appendTo("#owner_id");
	
	$.ajax({
		method:"get",
		url: baseUrl + "/get-team-members/" + team_id,
		dataType: "json",
		success: function(data){
        $("#owner_id").empty();
			$("<option>").val('All').text('All').appendTo("#owner_id");
			$.each(data.members, function(index, member) {
			$("<option>").val(member.id).text(member.name + ' ' + member.last_name).appendTo("#owner_id");
			})
		}

	})
});