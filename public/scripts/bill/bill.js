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
                    $(this).closest('tr').find('.txtBillProductQuantity').focus();
                    //bill.getProductDetails(this);
                }
            });

            $(document).on("blur", ".txtBillProductCode", function(e) {
                if($(this).val()!=''){
                    bill.getProductDetails(this);
                } else {
                    $('#newProductEntry #txtNewProductEntry').removeClass('txtProductError');
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

            $('#txtNewProductQuanity').focus(function(){
                if ($('#txtNewProductEntry').hasClass('txtProductError') || $('#txtNewProductEntry').val()==''){
                    $('#txtNewProductEntry').focus();
                }
            })
            
            $(document).on("click", ".lnkRemoveBillProduct", function(e) {
                $(this).closest('tr').remove();
                var i = 1;
                $('.colNo').each(function(){
                    $(this).html(i++);
                })
                bill.updateProductPrice(productCode);
            });

            $('#btnBillPreviewAndSave').click(function(){
                var product_quantity = '';
                $('.rowProduct').each(function(){
                    product_quantity = (product_quantity!='')?product_quantity+'||'+$(this).find('.colCode').html()+'*'+$(this).find('.txtBillProductQuantity').val():$(this).find('.colCode').html()+'*'+$(this).find('.txtBillProductQuantity').val();
                    //alert($(this).find('.colCode').html()+'#'+$(this).find('.txtBillProductQuantity').val());
                })

                //alert(product_quantity);
                 window.open(baseUrl+'/print-bill?products='+product_quantity, "printBill", "width=559, height=793");
            })
        },
        getProductDetails: function(element) {
            productCode = $(element).val();
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
                        var colNo = parseInt($('#newBillBody tr').length)-2;
                        newProductRow = ''+
                                '<tr id="tr-'+productCode+'" class="rowProduct">'+
                                    '<td class="colNo">'+colNo+'</td>'+
                                    '<td id="col-'+productCode+'-code" class="colCode">'+product.product_code+'</td>'+
                                    '<td id="col-'+productCode+'-category" class="colCategory">'+product.category+'</td>'+
                                    '<td id="col-'+productCode+'-quantity" class="colQuantity"><input type="text" value="1" class="txtBillProductQuantity txtBillTBox"></td>'+
                                    '<td id="col-'+productCode+'-mrp" class="colMRP">'+product.selling_price+'</td>'+
                                    '<td id="col-'+productCode+'-discount" class="colDiscount"><label class="discount-amount" id="discount-amount-'+productCode+'"></label><label class="hide" id="discount-'+productCode+'">'+product.discount+'</label></td>'+
                                    '<td id="col-'+productCode+'-tax" class="colTax"><label id="tax-amount-'+productCode+'"></label> <label id="tax-'+productCode+'"  class="hide" >'+product.tax+'</label></td>'+
                                    '<td id="col-'+productCode+'-total" class="colTotal">675</td>'+
                                    '<td><a href="javascript:;" class="lnkRemoveBillProduct">Remove</a></td>'+
                                '</tr>';

                        $(newProductRow).insertBefore('#newProductEntry');
                        bill.updateProductPrice(productCode);
                    }

                    $('#newProductEntry #txtNewProductEntry, #newProductEntry #txtNewProductQuanity').val('');
                    $('#newProductEntry #txtNewProductEntry').focus();
                    $('#newProductEntry #txtNewProductEntry').removeClass('txtProductError');

                } else {
                    $('#newProductEntry #txtNewProductEntry').addClass('txtProductError');
                    $('#txtNewProductEntry').focus();
                    
                }
                
            }, "json");
        },
        updateProductPrice: function(productCode) {
            if(productCode == '')
                return ;

            discount = parseInt($('#discount-'+productCode).html());
            quantity = parseInt($('#col-'+productCode+'-quantity .txtBillProductQuantity').val());
            mrp = parseFloat($('#col-'+productCode+'-mrp').html());
            discountAmount = 0;
            if(discount) {
                discountAmount = (mrp * quantity) * discount/100;
                $('#discount-amount-'+productCode).html(discountAmount);
            } else {
                $('#discount-amount-'+productCode).html(' - ')
            }

            $('#col-'+productCode+'-total').html((mrp*quantity)-discountAmount);
            $('#tax-amount-'+productCode).html((mrp*quantity- discountAmount) *  ( parseFloat($('#tax-'+productCode).html()) )/100 );

            var totalItems = 0;
            $('.txtBillProductQuantity').each(function(){
                if($(this).val()!='') {
                    totalItems = totalItems + parseInt($(this).val());
                }
            })
            $('#lblTotalProducts').html(totalItems);


            var totalDiscount = 0;
            $('.discount-amount').each(function(){
                if($(this).html()!=' - ') {
                    totalDiscount = totalDiscount + parseFloat($(this).html());
                }
            })
            $('#lblTotalDiscount').html(totalDiscount);

            var totalProductPrice = 0;
            $('.colTotal').each(function(){
                if($(this).html()!=' - ') {
                    totalProductPrice = totalProductPrice + parseFloat($(this).html());
                }
            })
            $('#lblTotalAmount').html(totalProductPrice);
            $('#lblPaidAmount').val(totalProductPrice);
            
            

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