function editTeam(team_id) {
    // alert(team_id);
    // $("#invoice-payment-modal-form").modal("show");

    $.ajax({
        url: baseUrl + "/team/fetch/" + team_id,
        type: "GET",
        dataType: "json",
        success: function (data) {
            $("#team_id").val(data.team.id);
            $("#team_name_id").val(data.team.team_name);
            $("#description_id").text(data.team.description);
        },
    });
}

function addTeamMember(team_id, team_name) {
    $("#teamId").val(team_id);
    $("#teamName").text(team_name);
}