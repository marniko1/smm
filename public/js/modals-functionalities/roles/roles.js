jQuery(document).ready(function(){

    let table = $('#roles-table').DataTable({
        dom: 'Bft',
        processing: true,
        serverSide: true,
        ajax: URL + '/admin/roles',
        columns: [
            { data: 'name', name: 'name' },
            {data: 'permissions', name: 'permissions', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        "columnDefs": [
            { className: "role-name", "targets": [ 0 ] },
            { className: "permissions", "targets": [ 1 ] }
        ]
    });




    /*==================================================================
    =            Add new Role ajax form submit in bs4 modal            =
    ==================================================================*/
    
    
    $('#ajaxSubmit').click(function(e){
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let permissions = new Array();

        $.each($('input.permissions:checked'), function(key, permission){
            permissions.push($(permission).val());
        });

        jQuery.ajax({
            url: URL + "/admin/roles",
            method: 'POST',
            data: {
                name: jQuery('#name').val(),
                permissions: permissions,
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
                    $('#addRoleModal').modal('hide');

                    refreashTable(table);
                }
            }
        });
    });
    
    /*=====  End of Add new Role ajax form submit in bs4 modal  ======*/
    


    /*===============================================================
    =            Edit Role ajax form submit in bs4 modal            =
    ===============================================================*/


    $('#ajaxEditSubmit').click(function(e){
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let permissions_arr = new Array();
        let permissions = $('input.edit-permissions:checked');
        $.each($(permissions), function(key, permission){
            permissions_arr.push($(permission).val());
        });

        jQuery.ajax({
            url: URL + "/admin/roles" + "/" + $('#edit-user-id').val(),
            type: 'PATCH',
            data: {
                name: $('#edit-name').val(),
                id: $('#edit-user-id').val(),
                permissions: permissions_arr,
            },
            success: function(result){

                if(result.errors)
                {

                    $('#editRoleModal div.form-group input.form-control').removeClass('is-invalid');
                    $('#editRoleModal div.form-group span.invalid-feedback').remove();

                    $.each(result.errors, function(key, value){

                        $('#editRoleModal #edit-' + key).addClass('is-invalid');
                        $('#editRoleModal #edit-' + key).after(`<span class="invalid-feedback" role="alert">
                                                <strong>${value[0]}</strong>
                                            </span>`);
                        $('#editRoleModal span.invalid-feedback').show();
                    });
                }
                else
                {
                
                    $('#editRoleModal div.form-group input.form-control').removeClass('is-invalid');
                    $('#editRoleModal div.form-group input.form-control').val('');
                    $('#editRoleModal div.form-group span.invalid-feedback').remove();
                    $('div.alert').remove();
                    $('div.card-body button').before(`<div class="alert alert-success" role="alert">
                                                ${result.success}
                                            </div>`);
                    $('#editRoleModal #open').hide();
                    $('#editRoleModal').modal('hide');

                    refreashTable(table);
                }
            }
        });
    });

    /*=====  End of Edit Role ajax form submit in bs4 modal  ======*/




    /*=================================================================
    =            Delete Role ajax form submit in bs4 modal            =
    =================================================================*/
    
    
    $('#ajaxDeleteRoleSubmit').click(function(e) {

        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            url: URL + "/admin/roles" + "/" + $('#delete-role-id').val(),
            type: 'DELETE',
            success: function(result){

                $('div.alert').remove();
                $('div.card-body button').before(`<div class="alert alert-success" role="alert">
                                            ${result.success}
                                        </div>`);
                $('#removeRoleModal').modal('hide');

                refreashTable(table);
            }
        });
    });
    
    /*=====  End of Delete Role ajax form submit in bs4 modal  ======*/
    


    /*=========================================================
    =            Prepare delete Role modal for use            =
    =========================================================*/
    
    
    $('body').click('.editDeleteWrapp .delete', function(e) {
        if ($(e.target).hasClass('delete')) {
            e.preventDefault();

            let id = $(e.target).parents('.editDeleteWrapp').data('id');

            $('#delete-role-id').remove();
            $('#removeRoleModal .modal-body').after(`<input type="hidden" id="delete-role-id" name="id" value="${id}">`);
        }
    });
    
    /*=====  End of Prepare delete Role modal for use  ======*/
    





    /*=======================================================
    =            Prepare edit Role modal for use            =
    =======================================================*/
    
    
    $('body').click('.editDeleteWrapp .edit', function (e) {


        if ($(e.target).hasClass('edit')) {

            let click_element = e.target;
            let permissions = $(click_element).parents('tr').find('td.permissions').text();
            let permissions_arr = permissions.split(',');

            $('#editRoleModal').on('show.bs.modal', function (e) {

                $.each($('#editRoleModal input[type=checkbox]'), function(key, checkbox){

                    $(checkbox).prop('checked', false);

                    if ($.inArray($(checkbox).attr('id'), permissions_arr) !== -1) {

                        $(checkbox).prop('checked', true);
                    }
                });
                
                let id = $(click_element).parents('.editDeleteWrapp').data('id');

                let tds = $(click_element).parents('tr').find('td');
                let inputs = $('#editRoleModal').find('input');

                let role_name = $(click_element).parents('tr').find('td.role-name');

                $('input[name="edit_name"]').val($(role_name).text());

                $('#edit-user-id').remove();
                $('#editRoleModal form').append(`<input type="hidden" id="edit-user-id" name="id" value="${id}">`);
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