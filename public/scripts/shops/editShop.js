var editShop = function () {
    return {
        init: function () {
            this.registerEvents();
            this.initValidation();
        },
        registerEvents: function(){
            
            $('#city').typeahead({
                name: 'city',
                remote : baseUrl+'/admin/shops/citysuggestions/%QUERY'
            });
        },
        initValidation: function(){
            var newPropertyValidator = $("#frmEditShop").validate({
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
                    
                    $.post( baseUrl+'/admin/shops/edit/'+$('#hdnShopId').val(), $("#frmEditShop").serialize(), function( response ) {
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
editShop.init();