function eliminar(id){
    
    var Ruta = Routing.generate('eliminar/6');
    $.ajax({
        type: "DELETE",
        url: Ruta,
        data: ({id:id}),
        async: true,
        success: function (data){
            console.log(data['resultado']);
        }
    });
}