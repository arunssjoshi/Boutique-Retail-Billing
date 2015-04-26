var bill = function () {
    var totalUnfilledRowsCount
    return {
        init: function () {
            this.registerEvents();
            this.initValidation();
        },
        registerEvents: function(){
            $('#product').focus();
            
            $(document).on("keypress", ".txtBillProductCode", function(e) {
                 if (e.which == 13) {
                     alert($(this).val());
                 }
            });
            
            $('#ddBatch').change(function(){
                $.post( baseUrl+'/admin/batch/batch-shop.json/'+$(this).val(), {}, function( response ) {
                        if (response.length > 0) {
                            var shopDDHtml = '';
                            $.each(response, function (key, shop){
                                shopDDHtml+= "<option value='"+shop.batch_shop_id+"'>"+shop.shop+"</option>";
                            }) ;
                            $('#ddBatchShop').html(shopDDHtml);
                        }   
                        
                    }, "json");
            })

            bill.loadProductProperties();
        },
        loadProductProperties: function(){
            $.post( baseUrl+'/admin/products/property_list', 
               {categoryId:$('#ddCategory').val()}, function( shops ) {
               $('#wrapProductProperties').html(shops);

               $("input[type='checkbox']:not(.simple), input[type='radio']:not(.simple)").iCheck({
                checkboxClass: 'icheckbox_minimal',
                radioClass: 'iradio_minimal'
            });
            }, "html");


        },
        initValidation: function(){
            var newPropertyValidator = $("#frmNewProduct").validate({
                rules: {
                    product: {
                        required: true
                    },
                    purchase_price: {
                        required: true
                    },
                    customer_price: {
                        required: true
                    }
                },
                messages: {
                    product: {
                        required: "Product required",
                    },
                    purchase_price: {
                        required: "Purchase price required",
                    },
                    customer_price: {
                        required: "Customer Price required",
                    }
                },
                invalidHandler: function(form, validator){
                    
                },
                submitHandler: function(form) {
                    $('#btnPropertySave-error').html('').hide()
                    var checkedValues = $('input:radio:checked').map(function() {
                            return this.value;
                        }).get();
                    $.post( baseUrl+'/admin/products/new', $("#frmNewProduct").serialize()+'&properties='+checkedValues, function( response ) {
                        if(response.status) {
                            location.href=baseUrl+'/admin/products';
                        } else {
                            $('#btnProductSave-error').html(response.message).show();
                        }
                    }, "json");
                }
            });
        }
    };
}();
bill.init();