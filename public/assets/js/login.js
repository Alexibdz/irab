$(document).ready(function() { 
// función para notif flotantes con animaciones
    function mostrarMensaje(mensaje, tipo = 'danger', duracion = 3000) {
        const toastContenedor = $('#toast-flotante');
        const toastColor = $('#toast-color');
        const toastMensaje = $('#toast-mensaje');

        // kimpia loscolores de notificaciones anteriores
        toastColor.removeClass('alert-danger alert-success bg-danger bg-success text-white');

        // se le da la clase si es de tipo 'danger' o 'success' para cambiar el color del cartel
        if (tipo === 'danger') {
            toastColor.addClass('alert-danger text-danger');
        } else {
            toastColor.addClass('bg-success text-white border-success'); 
        }

        // se le inserta el msj
        toastMensaje.text(mensaje);

        // se muestra unos seg
        toastContenedor.fadeIn(300);

        //  el cartel se oculta al finalizar el tiempo
        setTimeout(function() {
            toastContenedor.fadeOut(300);
        }, duracion);
    }

    //Al presionar se dispara:
    $('#form-login').on('submit', function(e) {
        e.preventDefault(); // detiene la recarga del formulario

        let form = $(this);
        let btnSubmit = form.find('button[type="submit"]');

        // Estado de carga visual
        $('#alerta-login').addClass('d-none'); // Oculta alertas previas
        btnSubmit.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Validando...');

        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            //se usa serialize porque es mas eficiente que FormData para enviar datos de formularios simples, si tuvieramos archivos adjuntos, usaríamos FormData.
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Si el login es correcto: Mostrar mensaje verde y esperar 2 segundos para redirigir
                    mostrarMensaje(response.mensaje, 'success', 2000);
                    
                    setTimeout(function() {
                        window.location.href = response.redirect;
                    }, 2000);

                } else {
                    // Si el login falla: Mostrar mensaje rojo y reactivar botón
                    mostrarMensaje(response.mensaje, 'danger', 3000);
                    btnSubmit.prop('disabled', false).text('Entrar');

                    // ¡MÁGIA CSRF!: Actualizamos el token oculto del formulario con el nuevo que envió el servidor
                    if (response.token) {
                        $('input[name="csrf_test_name"]').val(response.token);
                    }
                }
            },
            error: function() {
                // en caso de caída del servidor (500)
                mostrarMensaje('Error de comunicación con el servidor.', 'danger', 4000);
                btnSubmit.prop('disabled', false).text('Entrar');
            }
        });
    });
});

