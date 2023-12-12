$(document).ready(function() {

    var $submitButton = $('#submitButton');
    var $loader = $submitButton.find('.loader');

    $('#reservation').submit(function(event) {
        event.preventDefault();

        $submitButton.attr('disabled', true);
        $loader.addClass('show');

        var endpointUrl = $(this).data('endpoint');
        var formData = $(this).serialize();

        $.ajax({
            url: endpointUrl,
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                console.log('Réponse du serveur : ', response);

                if (response.success) {
                    showAlert('success', 'Succès', response.message);
                    setTimeout(function() {
                        window.location.href = response.redirectUrl;
                    }, 2000);
                } else {
                    showAlert('danger', 'Erreur', response.message);
                }

                $submitButton.attr('disabled', false);
                $loader.removeClass('show');
            },
            error: function(xhr, status, error) {
                console.log('Erreur lors de la requête AJAX : ' + error);
                console.log('Réponse du serveur : ' + xhr.responseText);

                showAlert('danger', 'Erreur', 'Une erreur s\'est produite lors du processus. Assurez-vous d\'avoir bien rempli le formulaire.');

                $submitButton.attr('disabled', false);
                $loader.removeClass('show');
            }
        });
    });

    function showAlert(type, title, message) {
        var alertHtml = '<div class="mt-5 alert alert-' + type + ' alert-dismissible fade show" role="alert">' +
                            '<strong>' + title + '</strong> ' + message +
                            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">' +
                                '</button>' +
                        '</div>';

        var $container = $('#container');

        $container.prepend(alertHtml);

        
        $('html, body').animate({
            scrollTop: $('#alertContainer').offset().top
        }, 1000);
    }
});
