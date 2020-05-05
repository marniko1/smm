jQuery(document).ready(function(){

    let table = $('#users-table').DataTable({
        dom: 'Bft',
        processing: true,
        serverSide: true,
        ajax: URL + '/admin/users',
        columns: [
            { data: 'name', name: 'name' },
            { data: 'username', name: 'username' },
            { data: 'email', name: 'email' },
            { data: 'roles', name: 'roles', orderable: false, searchable: false },
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        "columnDefs": [
            { className: "user-name", "targets": [ 0 ] },
            { className: "user-username", "targets": [ 1 ] },
            { className: "user-email", "targets": [ 2 ] },
            { className: "user-roles", "targets": [ 3 ] },
        ]
    });




    /*==================================================================
    =            Add new User ajax form submit in bs4 modal            =
    ==================================================================*/
    
    
    $('#ajaxSubmit').click(function(e){
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let roles = new Array();

        $.each($('input.roles:checked'), function(key, role){
            roles.push($(role).val());
        });

        jQuery.ajax({
            url: URL + "/admin/users",
            method: 'POST',
            data: {
                name: $('#name').val(),
                username: $('#username').val(),
                email: $('#email').val(),
                password: $('#password').val(),
                password_confirmation: $('#password-confirmation').val(),
                roles: roles,
            },
            success: function(result){

                if(result.errors)
                {

                    $('div.form-group input.form-control').removeClass('is-invalid');
                    $('div.form-group span.invalid-feedback').remove();

                    $.each(result.errors, function(key, value){

                        $('#' + key).addClass('is-invalid');
                        $('#' + key).after(`<span class="invalid-feedback" role="alert">
                                                <strong>${value[0]}</strong>
                                            </span>`);
                        $('span.invalid-feedback').show();
                    });
                }
                else
                {
                
                    $('div.form-group input.form-control').removeClass('is-invalid');
                    $('div.form-group input.form-control').val('');
                    $('div.form-group input.form-check-input').prop('checked', false);
                    $('div.form-group span.invalid-feedback').remove();
                    $('div.alert').remove();
                    $('div.card-body button').before(`<div class="alert alert-success" role="alert">
                                                ${result.success}
                                            </div>`);
                    $('#open').hide();
                    $('#addUserModal').modal('hide');

                    refreashTable(table);
                }
            }
        });
    });
    
    /*=====  End of Add new User ajax form submit in bs4 modal  ======*/
    


    /*===============================================================
    =            Edit User ajax form submit in bs4 modal            =
    ===============================================================*/


    $('#ajaxEditSubmit').click(function(e){
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let roles_arr = new Array();
        let roles = $('input.edit-roles:checked');
        $.each($(roles), function(key, role){
            roles_arr.push($(role).val());
        });

        console.log(roles_arr);

        jQuery.ajax({
            url: URL + "/admin/users" + "/" + $('#edit-user-id').val(),
            type: 'PATCH',
            data: {
                name: $('#edit-name').val(),
                username: $('#edit-username').val(),
                email: $('#edit-email').val(),
                password: $('#edit-password').val(),
                id: $('#edit-user-id').val(),
                roles: roles_arr,
            },
            success: function(result){

                console.log(result);

                if(result.errors)
                {

                    $('#editUserModal div.form-group input.form-control').removeClass('is-invalid');
                    $('#editUserModal div.form-group span.invalid-feedback').remove();

                    $.each(result.errors, function(key, value){

                        $('#editUserModal #edit-' + key).addClass('is-invalid');
                        $('#editUserModal #edit-' + key).after(`<span class="invalid-feedback" role="alert">
                                                <strong>${value[0]}</strong>
                                            </span>`);
                        $('#editUserModal span.invalid-feedback').show();
                    });
                }
                else
                {
                
                    $('#editUserModal div.form-group input.form-control').removeClass('is-invalid');
                    $('#editUserModal div.form-group input.form-control').val('');
                    $('#editUserModal div.form-group span.invalid-feedback').remove();
                    $('div.alert').remove();
                    $('div.card-body button').before(`<div class="alert alert-success" role="alert">
                                                ${result.success}
                                            </div>`);
                    $('#editUserModal #open').hide();
                    $('#editUserModal').modal('hide');

                    refreashTable(table);
                }
            }
        });
    });

    /*=====  End of Edit User ajax form submit in bs4 modal  ======*/




    /*=================================================================
    =            Delete User ajax form submit in bs4 modal            =
    =================================================================*/
    
    
    $('#ajaxDeleteUserSubmit').click(function(e) {

        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            url: URL + "/admin/users" + "/" + $('#delete-user-id').val(),
            type: 'DELETE',
            success: function(result){

                $('div.alert').remove();
                $('div.card-body button').before(`<div class="alert alert-success" role="alert">
                                            ${result.success}
                                        </div>`);
                $('#removeUserModal').modal('hide');

                refreashTable(table);
            }
        });
    });
    
    /*=====  End of Delete User ajax form submit in bs4 modal  ======*/
    


    /*=========================================================
    =            Prepare delete User modal for use            =
    =========================================================*/
    
    
    $('body').click('.editDeleteWrapp .delete', function(e) {
        if ($(e.target).hasClass('delete')) {
            e.preventDefault();

            let id = $(e.target).parents('.editDeleteWrapp').data('id');

            $('#delete-user-id').remove();
            $('#removeUserModal .modal-body').after(`<input type="hidden" id="delete-user-id" name="id" value="${id}">`);
        }
    });
    
    /*=====  End of Prepare delete User modal for use  ======*/
    





    /*=======================================================
    =            Prepare edit User modal for use            =
    =======================================================*/
    
    
    $('body').click('.editDeleteWrapp .edit', function (e) {


        if ($(e.target).hasClass('edit')) {

            let click_element = e.target;
            let roles = $(click_element).parents('tr').find('td.user-roles').text();
            let roles_arr = roles.split(', ');

            $('#editUserModal').on('show.bs.modal', function (e) {

                $.each($('#editUserModal input[type=checkbox]'), function(key, checkbox){

                    $(checkbox).prop('checked', false);

                    if ($.inArray($(checkbox).attr('id'), roles_arr) !== -1) {

                        $(checkbox).prop('checked', true);
                    }
                });
                
                let id = $(click_element).parents('.editDeleteWrapp').data('id');

                let tds = $(click_element).parents('tr').find('td');
                let inputs = $('#editUserModal').find('input');

                let user_name = $(click_element).parents('tr').find('td.user-name');
                let user_username = $(click_element).parents('tr').find('td.user-username');
                let user_email = $(click_element).parents('tr').find('td.user-email');

                $('input[name="edit_name"]').val($(user_name).text());
                $('input[name="edit_username"]').val($(user_username).text());
                $('input[name="edit_email"]').val($(user_email).text());

                $('#edit-user-id').remove();
                $('#editUserModal form').append(`<input type="hidden" id="edit-user-id" name="id" value="${id}">`);
            });

        }


    });
    
    /*=====  End of Prepare edit Role modal for use  ======*/
    

    /*===========================================================
    =            Clear error messages on modal close            =
    ===========================================================*/
    
    $('#editRoleModal').on('hidden.bs.modal', function (e) {
        $('#editRoleModal div.form-group input.form-control').removeClass('is-invalid');
        $('#editRoleModal div.form-group span.invalid-feedback').remove();
    })
    
    /*=====  End of Clear error messages on modal close  ======*/
    

    function refreashTable(table) {

        table.clear().draw();
        table.columns.adjust().draw(); // Redraw the DataTable
    }
});