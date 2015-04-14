var addProduct = function () {
    var totalUnfilledRowsCount
    return {
        init: function () {
            this.registerEvents();
            this.initValidation();
        },
        registerEvents: function(){
            $('#product').focus();

            $('#purchase_price').keyup(function(){
                sellingPrice = parseInt($(this).val()) + parseInt($(this).val()) * parseInt($('#profit_margin').val())/100;
                $('#customer_price').val(sellingPrice);
            })

            $('#customer_price').keyup(function(){
                sellingPrice = ( (parseInt($(this).val()) - parseInt($('#purchase_price').val())) / parseInt($('#purchase_price').val()) ) * 100  ;
                $('#profit_margin').val(sellingPrice);
            })

            
            $('#profit_margin').keyup(function(){
                sellingPrice = parseInt($('#purchase_price').val()) + parseInt($('#purchase_price').val()) * parseInt($('#profit_margin').val())/100;
                $('#customer_price').val(sellingPrice);
            })
            
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
                    var checkedValues = $('input:checkbox:checked').map(function() {
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
addProduct.init();