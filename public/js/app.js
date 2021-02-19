$("#create-event-form").submit(function (e) {
  $("#btn-create-event").prop("disabled", true);
});

$("#datepicker").datepicker({
  format: "dd-m-yyyy",
  showOn: "button",
  orientation: "auto",
});

function getPlyerNumber(playerNumberId) {
  let number;

  switch (playerNumberId) {
    case "player_1":
      number = 1;
      break;
    case "player_2":
      number = 2;
      break;
    case "player_3":
      number = 3;
      break;
    case "player_4":
      number = 4;
      break;
    default:
      break;
  }

  return number;
}

function exitFromEvent(id) {
  // var url = Routing.generate("event_exit");
  var playerPosition = $(".clickable").attr("id");
  var number = getPlyerNumber(playerPosition);

  console.log(number);

  swal({
    title: "¿Quieres cancelar tu inscripción partido?",
    buttons: {
      cancel: {
        text: "No",
        value: false,
        visible: true,
        closeModal: true,
      },
      confirm: {
        text: "Si",
        value: true,
        visible: true,
        closeModal: true,
      },
    },
  }).then((isConfirm) => {
    if (isConfirm) {
      $.ajax({
        type: "POST",
        url: url,
        data: {
          eventId: id,
          playerNumber: number,
        },
        async: true,
        dataType: "json",
        success: function (response) {
          if (response.success) {
            swal(response.message, {
              icon: "success",
              closeModal: true,
            }).then((isConfirm) => {
              if (isConfirm) {
                location.reload();
              }
            });
          } else {
            swal(response.message, {
              icon: "error",
              closeModal: true,
              dangerMode: true,
            }).then((isConfirm) => {
              if (isConfirm) {
                location.reload();
              }
            });
          }
        },
      });
    }
  });
}

function joinEvent(id) {
  var url = Routing.generate("event_join");
  swal({
    title: "¿Quieres apuntarte al partido?",
    buttons: {
      cancel: {
        text: "Cancelar",
        value: false,
        visible: true,
        closeModal: true,
      },
      confirm: {
        text: "Aceptar",
        value: true,
        visible: true,
        closeModal: true,
      },
    },
  }).then((isConfirm) => {
    if (isConfirm) {
      $.ajax({
        type: "POST",
        url: url,
        data: { eventId: id },
        async: true,
        dataType: "json",
        success: function (response) {
          if (response.success) {
            swal(response.message, {
              icon: "success",
              closeModal: true,
            }).then((isConfirm) => {
              if (isConfirm) {
                location.reload();
              }
            });
          } else {
            swal(response.message, {
              icon: "error",
              closeModal: true,
              dangerMode: true,
            }).then((isConfirm) => {
              if (isConfirm) {
                location.reload();
              }
            });
          }
        },
      });
    }
  });
}
