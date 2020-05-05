jQuery(document).ready(function(){

    let table = $('#permissions-table').DataTable({
        dom: 'Bft',
        processing: true,
        serverSide: true,
        ajax: URL + '/admin/permissions',
        columns: [
            { data: 'name', name: 'name' },
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        "columnDefs": [
            { className: "permission-name", "targets": [ 0 ] }
        ]
    });




    /*==================================================================
    =            Add new Permission ajax form submit in bs4 modal            =
    ==================================================================*/
    
    
    $('#ajaxSubmit').click(function(e){
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            url: URL + "/admin/permissions",
            method: 'POST',
            data: {
                name: jQuery('#name').val(),
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
                    $('div.form-group span.invalid-feedback').remove();
                    $('div.alert').remove();
                    $('div.card-body button').before(`<div class="alert alert-success" role="alert">
                                                ${result.success}
                                            </div>`);
                    $('#open').hide();
                    $('#addPermissionModal').modal('hide');

                    refreashTable(table);
                }
            }
        });
    });
    
    /*=====  End of Add new Permission ajax form submit in bs4 modal  ======*/
    


    /*===============================================================
    =            Edit Permission ajax form submit in bs4 modal            =
    ===============================================================*/


    $('#ajaxEditSubmit').click(function(e){
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            url: URL + "/admin/permissions" + "/" + $('#edit-user-id').val(),
            type: 'PATCH',
            data: {
                name: $('#edit-name').val(),
                id: $('#edit-user-id').val(),
            },
            success: function(result){

                if(result.errors)
                {

                    $('#editPermissionModal div.form-group input.form-control').removeClass('is-invalid');
                    $('#editPermissionModal div.form-group span.invalid-feedback').remove();

                    $.each(result.errors, function(key, value){

                        $('#editPermissionModal #edit-' + key).addClass('is-invalid');
                        $('#editPermissionModal #edit-' + key).after(`<span class="invalid-feedback" role="alert">
                                                <strong>${value[0]}</strong>
                                            </span>`);
                        $('#editPermissionModal span.invalid-feedback').show();
                    });
                }
                else
                {
                
                    $('#editPermissionModal div.form-group input.form-control').removeClass('is-invalid');
                    $('#editPermissionModal div.form-group input.form-control').val('');
                    $('#editPermissionModal div.form-group span.invalid-feedback').remove();
                    $('div.alert').remove();
                    $('div.card-body button').before(`<div class="alert alert-success" role="alert">
                                                ${result.success}
                                            </div>`);
                    $('#editPermissionModal #open').hide();
                    $('#editPermissionModal').modal('hide');

                    refreashTable(table);
                }
            }
        });
    });

    /*=====  End of Edit Permission ajax form submit in bs4 modal  ======*/




    /*=======================================================================
    =            Delete Permission ajax form submit in bs4 modal            =
    =======================================================================*/
    
    
    $('#ajaxDeletePermissionSubmit').click(function(e) {

        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            url: URL + "/admin/permissions" + "/" + $('#delete-permission-id').val(),
            type: 'DELETE',
            success: function(result){

                $('div.alert').remove();
                $('div.card-body button').before(`<div class="alert alert-success" role="alert">
                                            ${result.success}
                                        </div>`);
                $('#removePermissionModal').modal('hide');

                refreashTable(table);
            }
        });
    });
    
    /*=====  End of Delete Permission ajax form submit in bs4 modal  ======*/
    



    /*===============================================================
    =            Prepare delete Permission modal for use            =
    ===============================================================*/
    
    
    $('body').click('.editDeleteWrapp .delete', function(e) {
        if ($(e.target).hasClass('delete')) {
            e.preventDefault();

            let id = $(e.target).parents('.editDeleteWrapp').data('id');

            $('#delete-user-id').remove();
            $('#removePermissionModal .modal-body').after(`<input type="hidden" id="delete-permission-id" name="id" value="${id}">`);
        }
    });
    
    /*=====  End of Prepare delete Permission modal for use  ======*/
    



    /*=============================================================
    =            Prepare edit Permission modal for use            =
    =============================================================*/
    
    
    $('body').click('.editDeleteWrapp .edit', function (e) {

        let click_element = e.target;

        if ($(e.target).hasClass('edit')) {
            /*----------  On modal open take data from table and put it in form  ----------*/
            
            $('#editPermissionModal').on('show.bs.modal', function (e) {
                
                let id = $(click_element).parents('.editDeleteWrapp').data('id');

                let tds = $(click_element).parents('tr').find('td');
                let inputs = $('#editPermissionModal').find('input');

                let permission_name = $(click_element).parents('tr').find('td.permission-name');

                $('input[name="edit_name"]').val($(permission_name).text());

                $('#edit-user-id').remove();
                $('#editPermissionModal form').append(`<input type="hidden" id="edit-user-id" name="id" value="${id}">`);
            });
        }


    });
    
    /*=====  End of Prepare edit Permission modal for use  ======*/
    


    /*===========================================================
    =            Clear error messages on modal close            =
    ===========================================================*/
    
    $('#editPermissionModal').on('hidden.bs.modal', function (e) {
        $('#editPermissionModal div.form-group input.form-control').removeClass('is-invalid');
        $('#editPermissionModal div.form-group span.invalid-feedback').remove();
    })
    
    /*=====  End of Clear error messages on modal close  ======*/
    

    function refreashTable(table) {

        table.clear().draw();
        table.columns.adjust().draw(); // Redraw the DataTable
    }
});