var e_grid = $("#e_grid");
var e_id = $("#e_id");
var e_name = $("#e_name");
var e_dni = $("#e_dni");
var e_search = $("#e_search");
var btn_search = $("#btn_search");

$(document).ready(function () {

    btn_search.click(function () {
        addgrid();
    });
    e_search.keyup(function () {
        addgrid();
    })
});

function addgrid() {
    params = {
        'method': 'list',
        'search': e_search.val()
    }
    $.post('aplication/entityController.php', params, function (response) {
        if (response.status === true) {
            e_grid.empty();
            _.each(response.data, function (item) {
                var tr = $('<tr></tr>');
                var td_1 = $('<td>' + item.name + '</td>');
                var td_2 = $('<td>' + item.dni + '</td>');
                var td_3 = $('<td width="25%"></td>');
                var a_edit = $('<a id="' + item.id + '" href="javascript:void(0)" class="btn btn-success edit_e">Editar</a>');
                var a_delete = $('<a id="' + item.id + '" href="javascript:void(0)"  class="btn btn-danger delete_e">Eliminar</a>');
                td_3.append(a_edit).append(a_delete);
                tr.append(td_1).append(td_2).append(td_3);
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
        } else {
            swal("error", "error!", "error");
        }
    }, 'json');
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