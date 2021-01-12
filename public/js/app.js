function joinEvent(id) {
  var url = Routing.generate("event_join");
  $.ajax({
    type: "POST",
    url: url,
    data: { eventId: id },
    async: true,
    dataType: "json",
    success: function (response) {
      console.log(response["event_join"]);
    },
  });
}
