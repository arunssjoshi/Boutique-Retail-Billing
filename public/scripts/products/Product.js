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
                "columnDefs": [    { "orderable": false, "targets": [0,8] }  ],
                "iDisplayLength": 30,
                "aLengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]]

            });
        },
        registerEvents: function(){
            $('#btnGenerateBarcode').click(function(){
                var checkedValues = $('.chkProduct:checked').map(function() {
                            return this.value;
                        }).get();
                alert(checkedValues);
            });
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
                    $('#tblProducts').dataTable().fnDraw();
                });

                $('#chkAllProduct').on('ifChecked', function(event){
                  $('.chkProduct').iCheck('check'); 
                });

                $('#chkAllProduct').on('ifUnchecked', function(event){
                  $('.chkProduct').iCheck('uncheck'); 
                });
               
            }
        }
    };
}();
products.init();