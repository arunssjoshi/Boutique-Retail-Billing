var addShop = function () {
    var totalUnfilledRowsCount
    return {
        init: function () {
            this.registerEvents();
            this.initValidation();
        },
        registerEvents: function(){
            
            $(document).on('click','.btnDeleteOption',function(){
                if ($('#optionWrap .optionRow').length > 1) {
                    $(this).parents('#optionWrap .optionRow').remove();
                }
            });

            
        },
        initValidation: function(){
            var newPropertyValidator = $("#frmNewShop").validate({
                rules: {
                    shop: {
                        required: true
                    },
                    city: {
                        required: true
                    }
                },
                messages: {
                    shop: {
                        required: "Shop required",
                    },
                    city: {
                        required: "City required",
                    }
                },
                invalidHandler: function(form, validator){
                    
                },
                submitHandler: function(form) {
                    $('#btnPropertySave-error').html('').hide()
                    $.post( baseUrl+'/admin/shops/new', $("#frmNewShop").serialize(), function( response ) {
                        if(response.status) {
                            parent.shops.updateDT();
                            parent.$.fn.colorbox.close();
                        } else {
                            $('#btnShopSave-error').html(response.message).show();
                        }
                    }, "json");
                }
            });

            
        }
    };
}();
addShop.init();