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
                        d.listType = $('#productListType').val();
                    }
                },
                "order": [[ 1, "desc" ]],
                "fnDrawCallback":this.registerDtLoadedEvents,
                "columnDefs": [    { "orderable": false, "targets": [0,8] }  ],
                "iDisplayLength": 30,
                "aLengthMenu": [[30, 50, 100, -1], [30, 50, 100, "All"]]

            });
        },
        registerEvents: function(){
            $('#btnGenerateBarcode').click(function(){
                var checkedValues = $('.chkProduct:checked').map(function() {
                            return this.value;
                        }).get();
                window.open(
                  baseUrl+'/admin/products/generate-barcode/'+checkedValues,
                  '_blank' // <- This is what makes it open in a new window.
                );
            });

            $('#btnAddQueue').click(function(){
                var checkedValues = $('.chkProduct:checked').map(function() {
                            return this.value;
                        }).get();
                $.post( baseUrl+'/admin/products/addqueue', {products:checkedValues}, function( response ) {
                    $('#queueCount').html(response.count);
                    $('#chkAllProduct, .chkProduct').iCheck('uncheck'); 
                }, "json");
            });

            $('#btnMarkAsPrinted').click(function(){
                var checkedValues = $('.chkProduct:checked').map(function() {
                            return this.value;
                        }).get();
                $.post( baseUrl+'/admin/products/mark-printed', {barcodeQueueIds:checkedValues}, function( response ) {
                    $('#queueCount').html(response.count);
                    $('#chkAllProduct, .chkProduct').iCheck('uncheck'); 
                }, "json");

                $('#tblProducts').dataTable().fnDraw();
            });


            $('#productListType').change(function(){
                listType = $('#productListType').val();
                if(listType == 'product') {
                    $('#btnAddQueue').removeClass('hide');
                    $('.queueLink').addClass('hide');
                }if(listType == 'tobe_queued') {
                    $('#btnAddQueue').removeClass('hide');
                    $('.queueLink').addClass('hide');
                } else {
                    $('#btnAddQueue').addClass('hide');
                    $('.queueLink').removeClass('hide');
                }
                $('#tblProducts').dataTable().fnDraw();
            })
        },
        registerDtLoadedEvents: function(){
            $("input[type='checkbox']:not(.simple), input[type='radio']:not(.simple)").iCheck({
                checkboxClass: 'icheckbox_minimal',
                radioClass: 'iradio_minimal'
            });
            $('#chkAllProduct').on('ifChecked', function(event){
              $('.chkProduct').iCheck('check'); 
            });

            $('#chkAllProduct').on('ifUnchecked', function(event){
              $('.chkProduct').iCheck('uncheck'); 
            });
            if ($('#tblProducts_wrapper #ddCategory').length == 0){
                $('#tblProducts_wrapper').append($('#categoryHolder').html());
                $('#categoryHolder').remove();
                $('#ddCategory').change(function(){
                    $('#tblProducts').dataTable().fnDraw();
                });
            }

            $('.lnkBarcodeQueueDelete').click(function(){
                if($(this).attr('rel')=='')
                    return
                $.post( baseUrl+'/admin/products/delete-barcode-queue', {barcodeQueueId:$(this).attr('rel')}, function( response ) {
                    $('#queueCount').html(response.count);
                    $('#tblProducts').dataTable().fnDraw();
                }, "json");
            });
        }
    };
}();
products.init();