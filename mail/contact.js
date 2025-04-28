$(function () {
    $("#contactForm input, #contactForm textarea").jqBootstrapValidation({
        preventSubmit: true,
        submitSuccess: function ($form, event) {
            event.preventDefault();
            var name = $("input#name").val();
            var email = $("input#email").val();
            var subject = $("input#subject").val();
            var message = $("textarea#message").val();

            var $this = $("#sendMessageButton");
            $this.prop("disabled", true);

            $.ajax({
                url: "controllers/procesar_contacto.php",
                type: "POST",
                data: {
                    name: name,
                    email: email,
                    subject: subject,
                    message: message
                },
                dataType: "json",
                success: function (response) {
                    if (response.status === 'success') {
                        $('#success').html("<div class='alert alert-success'>");
                        $('#success > .alert-success')
                            .html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>")
                            .append("<strong>¡Tu mensaje ha sido enviado exitosamente!</strong>")
                            .append('</div>');
                        $('#contactForm').trigger("reset");
                        //
                        setTimeout(function () {
                            $('#success').html('');
                        }, 3000);
                    } else {
                        $('#success').html("<div class='alert alert-danger'>");
                        $('#success > .alert-danger')
                            .html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>")
                            .append("<strong>Error: " + response.message + "</strong>")
                            .append('</div>');
                            //
                            setTimeout(function () {
                                $('#success').html('');
                            }, 3000);
                    }
                },
                error: function () {
                    $('#success').html("<div class='alert alert-danger'>");
                    $('#success > .alert-danger')
                        .html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>")
                        .append("<strong>Lo sentimos, el servidor no responde. ¡Por favor, intenta más tarde!</strong>")
                        .append('</div>');
                    $('#contactForm').trigger("reset");
                },
                complete: function () {
                    setTimeout(function () {
                        $this.prop("disabled", false);
                    }, 1000);
                }
            });
        },
    });
});
