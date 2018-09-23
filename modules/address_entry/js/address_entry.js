
jQuery(document).ready(function ($) {
    function addressResult(classRow, value) {
        $output =   '<tr class='+classRow+'><td>'+value.id+'</td><td>'+value.name+'</td>' +
                    '<td>'+value.email+'</td><td>'+value.phone+'</td>' +
                    '<td>'+value.birth_date+'</td>' +
                    '<td>  <div class="dropbutton-wrapper dropbutton-multiple"><div class="dropbutton-widget">' +
                    '<ul class="dropbutton"><li class="edit dropbutton-action">' +
                    '<a href="/addressbook/'+value.id+'/edit?destination=/addressbook/manage" hreflang="und">Edit</a></li>' +
                    '<li class="dropbutton-toggle"><button type="button"><span class="dropbutton-arrow"><span class="visually-hidden">List additional actions</span></span></button></li>' +
                    '<li class="delete dropbutton-action secondary-action"><a href="/addressbook/'+value.id+'/delete?destination=/addressbook/manage" hreflang="und">Delete</a></li>' +
                    '</ul></div></div></td></tr>';
        return $output;
    }

    $('.search-address-book-form .js-form-submit').click(function (event) {
        event.preventDefault();
        event.stopPropagation();
        var name = $('.js-search-name input').val();
        var email = $('.js-search-email input').val();
        $('table tbody tr').remove();
        $.ajax({
            url: Drupal.url('addressbook/search'),
            type: "POST",
            data: JSON.stringify({
                "name": name,
                "email": email
            }),
            contentType: "application/json; charset=utf-8",
            async: false,
            success: function (response) {
                $.each( response, function( key, value ) {
                    var classRow = key % 2 ? 'odd' : 'even';
                    $('table tbody').append(addressResult(classRow, value));
                });
            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        });

    });
});
