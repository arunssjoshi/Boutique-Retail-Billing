var products = function () {
    var totalUnfilledRowsCount;
    var ddProducts;
    return {
        init: function () {
            this.registerEvents();
            this.initPropertiesDataTable();
        },
        initPropertiesDataTable: function() {
            ddProducts = $('#tblProducts').dataTable( {
                "serverSide": true,
                "ajax": {
                    url:baseUrl+'/admin/products/product.json',
                    type:'POST',
                    "data": function ( d ) {
                        d.categoryId = $('#tblProducts_wrapper #ddCategory').val();
                    }
                },
                "order": [[ 1, "desc" ]],
                "fnDrawCallback":this.registerDtLoadedEvents,
                "columnDefs": [    { "orderable": false, "targets": [0,8] }  ]

            });
        },
        registerEvents: function(){

        },
        registerDtLoadedEvents: function(){
            $("input[type='checkbox']:not(.simple), input[type='radio']:not(.simple)").iCheck({
                checkboxClass: 'icheckbox_minimal',
                radioClass: 'iradio_minimal'
            });
            if ($('#tblProducts_wrapper #ddCategory').length == 0){
                $('#tblProducts_wrapper').append($('#categoryHolder').html());
                $('#categoryHolder').remove();
                $('#ddCategory').change(function(){
                    //ddProducts.fnReloadAjax();
                    $('#tblProducts').dataTable().fnDraw();
                })
            }
        }
    };
}();
products.init();