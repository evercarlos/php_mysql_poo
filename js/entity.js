var e_grid = $("#e_grid");
var e_id = $("#e_id");
var e_name = $("#e_name");
var e_dni = $("#e_dni");
var e_search = $("#e_search");
var btn_search = $("#btn_search");
var e_birth_date = $("#e_birth_date");
var btn_new_entity = $("#btn_new_entity");

$(document).ready(function () {

    btn_search.click(function () {
        addgrid();
    });

    e_search.keyup(function () {
        addgrid();
    });

    btn_new_entity.click(function () {
        cleanEntity();
    });

    $("#save_entity").click(function () {
        // para validaciones
        var b_val = true;
        //b_val = b_val && e_name.required();
        // b_val = b_val && e_dni.required();

        if (b_val) {
            params = {
                'method': 'createUpdate',
                'id': (e_id.val() === '') ? 0 : e_id.val(),
                'name': e_name.val(),
                'dni': e_dni.val(),
                'birth_date': e_birth_date.val(),
            }
            $.post('aplication/entityController.php', params, function (response) {
                if (response.status) {
                    cleanEntity();
                    addgrid();
                    swal("Good", "Guardado correctamente", "success");
                } else {
                    swal("error", "error!", "error");
                }
            }, 'json');
        }
    });

});

function addgrid() {
    params = {
        'method': 'list',
        'search': e_search.val(),
        'rows': 10
    }
    $.post('aplication/entityController.php', params, function (response) {
        if (response.status === true) {
            e_grid.empty();
            _.each(response.data, function (item) {
                var tr = $('<tr></tr>');
                var td_1 = $('<td>' + item.name + '</td>');
                var td_2 = $('<td>' + item.dni + '</td>');
                var td_3 = $('<td style="text-align: center;">' + item.birth_date + '</td>');
                var td_4 = $('<td></td>');
                var a_edit = $('<a id="' + item.id + '" href="javascript:void(0)" class="btn btn-success edit_e btn-sm"><i class="fas fa-edit"></i></a>');
                var a_delete = $('<a id="' + item.id + '" href="javascript:void(0)"  class="btn btn-danger delete_e btn-sm"><i class="far fa-trash-alt"></i></a>');
                td_4.append(a_edit).append(a_delete);
                tr.append(td_1).append(td_2).append(td_3).append(td_4);
                //console.log('hola');
                e_grid.append(tr);

                e_grid.find('a.edit_e').click(function () {
                    var tr_ = $(this);
                    var tr_id = tr_.attr('id');
                    findEntity(tr_id);
                });
                e_grid.find('a.delete_e').click(function () {
                    var tr_ = $(this);
                    var tr_id = tr_.attr('id');
                    deleteEntity(tr_id);
                })
            });
        } else {
            // con sweel
            swal("error", "error!", "error");
        }
    }, 'json');
}

addgrid();


function findEntity(id) {
    params = {
        'method': 'find',
        'id': id
    };
    $.post('aplication/entityController.php', params, function (response) {
        if (response.status === true) {
            var data = response.data;
            e_id.val(data.id);
            e_name.val(data.name);
            e_dni.val(data.dni);
            e_birth_date.val(data.birth_date);
        } else {
            swal("error", "error!", "error");
        }
    }, 'json');
}

function cleanEntity() {
    e_id.val('');
    e_dni.val('');
    e_name.val('');
    e_birth_date.val('');
}

function deleteEntity(id) {
    params = {
        'method': 'delete',
        id: id
    }
    $.post('aplication/entityController.php', params, function (response) {
        if (response.status === true) {
            addgrid();
            swal("Good", "Eliminado Correctamente", "success");
        } else {
            swal("error", "error!", "error");
        }
    }, 'json');
}