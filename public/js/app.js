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
          console.log(response);
          if (response.success) {
            swal(response.message, {
              icon: "success",
              closeModal: true,
            });
          } else {
            swal(response.message, {
              icon: "error",
              closeModal: true,
              dangerMode: true,
            });
          }
        },
      });
    }
  });
}
