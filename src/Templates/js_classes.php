<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>

<!-- Sweetalert 2 -->
<script src="plugins/sweetalert2/sweetalert2.js"></script>

<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<script>
    $(function () {
        $.ajax({
            url: "products",
            type: "GET",
            success : function(data) {
                var productData = JSON.parse(data);
                $('#example2').dataTable( {
                    "paging": true,
                    "lengthChange": false,
                    "searching": false,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                    data : productData.response,
                    columns: [
                        {"data" : "id"},
                        {"data" : "description"},
                        {"data" : "price"},
                        {"data" : "price_usd"},
                        {
                            "data": "id",
                            "render": function ( data ) {
                                return "<div class='btn-group'><button type='button' class='btn btn-sm btn-default' onclick=editProduct('"+data+"');>Editar</button><button type='button' class='btn btn-sm btn-danger' onclick=deleteProduct('"+data+"')>Eliminar</button></div>";
                            },
                        }

                    ],
                });
            }
        });
    });

    function editProduct(prodId){
        $.ajax({
            url: "product/"+prodId,
            type: "GET",
            success: function(data){
                var productDetail = JSON.parse(data);
                if(productDetail.response === false){
                    Swal.fire(
                        'Hubo un error',
                        'Intente nuevamente mas tarde',
                        'error'
                    )
                    return;
                }
                productDetail = productDetail.response[0];
                $('#ProdId').val(productDetail.id);
                $('#ProdDescription').val(productDetail.description);
                $('#ProdPrice').val(productDetail.price);
                $('#modal-edit').modal();
            },
        })
    }

    function saveUpdatedProduct(){
        var id = $('#ProdId').val();
        var description = $('#ProdDescription').val();
        var price = $('#ProdPrice').val();
        $.ajax({
            url: "product/update",
            type: "POST",
            data: {
                "id": id,
                "description": description,
                "price": price
            },
            success: function(data){
                var productDetail = JSON.parse(data);
                if(productDetail.response === false){
                    Swal.fire(
                        'Hubo un error',
                        'Intente nuevamente mas tarde',
                        'error'
                    )
                    return
                }
                Swal.fire(
                    'Producto Actualizado',
                    'Se ha actualizado correctamente el producto',
                    'success'
                ).then((result) => {
                    window.location.reload();
                });
            },
        })
    }

    function saveNewProduct(){
        var description = $('#NewProdDescription').val();
        var price = $('#NewProdPrice').val();
        $.ajax({
            url: "product/new",
            type: "POST",
            data: {
                "description": description,
                "price": price
            },
            success: function(data){
                var productDetail = JSON.parse(data);
                console.log(productDetail);
                if(productDetail.response === false){
                    Swal.fire(
                        'Hubo un error',
                        productDetail.message,
                        'error'
                    )
                    return
                }
                Swal.fire(
                    'Producto Creado',
                    'Se ha cread correctamente el producto',
                    'success'
                ).then((result) => {
                    window.location.reload();
                });
            },
        })
    }

    function deleteProduct(id){
        Swal.fire({
            title: '¿Está seguro de borrar el producto?',
            text: "Una vez borrado no podrá recuperar los datos.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Borrar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "product/"+id,
                    type: "DELETE",
                    success: function(data){
                        var productDetail = JSON.parse(data);
                        if(productDetail.response === false){
                            Swal.fire(
                                'Hubo un error',
                                'Intente nuevamente mas tarde',
                                'error'
                            )
                            return
                        }
                        Swal.fire(
                            'Producto Borrado',
                            '',
                            'success'
                        ).then((result) => {
                            window.location.reload();
                        });
                    },

                }).fail(function( jqXHR, textStatus, errorThrown ) {
                    if ( console && console.log ) {
                        console.log( "La solicitud a fallado: " +  errorThrown);
                    }
                    Swal.fire(
                        'Hubo un error',
                        'Intente nuevamente mas tarde',
                        'error'
                    )
                })
            }
        })
    }

</script>