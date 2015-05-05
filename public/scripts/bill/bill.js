var bill = function () {
    var totalUnfilledRowsCount
    return {
        init: function () {
            this.registerEvents();
            this.initValidation();
        },
        registerEvents: function(){
            $('#txtNewProductEntry').focus();
            
            $(document).on("keypress", ".txtBillProductCode", function(e) {
                 if (e.which == 13) {
                     productCode = $(this).val();
                     $.post( baseUrl+'/new-bill/product.json/'+productCode, {}, function( response ) {
                        
                        if(response.status) {
                            
                            var product = response.product_info[0];
                            var productCode = product.product_code;

                            var productExists = false;
                            $('.colCode').each(function(){
                                if($(this).html() == productCode) {
                                    productExists = true;
                                }
                            })


                            if (productExists) {
                                $('#col-'+productCode+'-quantity .txtBillProductQuantity').val(parseInt($('#col-'+productCode+'-quantity .txtBillProductQuantity').val())+1);
                                bill.updateProductPrice(productCode);
                            } else {
                                newProductRow = ''+
                                        '<tr id="tr-'+productCode+'">'+
                                            '<td>'+$('#newBillBody tr').length+'</td>'+
                                            '<td id="col-'+productCode+'-code" class="colCode">'+product.product_code+'</td>'+
                                            '<td id="col-'+productCode+'-category" class="colCategory">'+product.category+'</td>'+
                                            '<td id="col-'+productCode+'-quantity" class="colQuantity"><input type="text" value="1" class="txtBillProductQuantity txtBillTBox"></td>'+
                                            '<td id="col-'+productCode+'-mrp" class="colMRP">'+product.selling_price+'</td>'+
                                            '<td id="col-'+productCode+'-discount" class="colDiscount"><label id="discount-amount-'+productCode+'"></label><label class="hide" id="discount-'+productCode+'">'+product.discount+'</label></td>'+
                                            '<td id="col-'+productCode+'-tax" class="colTax"><label id="tax-amount-'+productCode+'"></label> <label id="tax-'+productCode+'"  class="hide" >'+product.tax+'</label></td>'+
                                            '<td id="col-'+productCode+'-total" class="colTotal">675</td>'+
                                            '<td><a href="javascript:;">Remove</a></td>'+
                                        '</tr>';

                                $(newProductRow).insertBefore('#newProductEntry');
                                bill.updateProductPrice(productCode);
                            }

                            $('#newProductEntry .txtBillProductCode').val('');

                            

                        }
                        
                    }, "json");
                 }
            });

            $(document).on('keyup','.txtBillProductQuantity',function(){
                bill.updateProductPrice($(this).parent('td').attr('id').split('-')[1]);
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
        updateProductPrice: function(productCode) {
            discount = parseInt($('#discount-'+productCode).html());
            quantity = parseInt($('#col-'+productCode+'-quantity .txtBillProductQuantity').val());
            mrp = parseFloat($('#col-'+productCode+'-mrp').html());
            discountAmount = 0;
            if(discount) {
                discountAmount = (mrp * quantity) * discount/100;
                $('#discount-amount-'+productCode).html(discountAmount+ ' ('+discount+'%)');
            } else {
                $('#discount-amount-'+productCode).html(' - ')
            }

            $('#col-'+productCode+'-total').html((mrp*quantity)-discountAmount);
            $('#tax-amount-'+productCode).html((mrp*quantity- discountAmount) *  ( parseFloat($('#tax-'+productCode).html()) )/100 );
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