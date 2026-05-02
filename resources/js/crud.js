
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.store('editModal', {
    ...dataObj,
    saveChanges(e) {
        var editModalEl = document.querySelector('#editModal');
        var editModal = window.bsmodal.getOrCreateInstance(editModalEl);
        var form = e.currentTarget;
        $.ajax({
            url: $(form).attr('action'),
            method: $(form).attr('method'),
            data: new FormData(form),
            contentType: false,
            processData: false,
            success: function(json) {
                if (json.redirect)
                    window.location.href = json.redirect;
                if (json.message)
                    notyf.success(json.message);
                editModal.hide();
            },
            complete: function() {
                if(CRUD_DT)
                    window.LaravelDataTables[CRUD_DT].ajax.reload();
            }
        });
    }
});

Alpine.start();

$(function() {
    $('body').on('click', '.ajax-edit', function editEntry(e) {
        var editModalEl = document.querySelector('#editModal');
        var editModal = window.bsmodal.getOrCreateInstance(editModalEl);
        var id = $(e.currentTarget).data('id');
        $.ajax({
            url: CRUD_BASE + id + '/edit',
            method: 'get',
            cache: false,
            success: function(data) {
                editCallback(data)
                editModal.show()
            }
        });
        e.stopPropagation();
    });
});
