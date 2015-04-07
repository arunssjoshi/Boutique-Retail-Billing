var addProduct = function () {
    var totalUnfilledRowsCount
    return {
        init: function () {
            this.registerEvents();
            this.initValidation();
        },
        registerEvents: function(){
            $('#product').focus();
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