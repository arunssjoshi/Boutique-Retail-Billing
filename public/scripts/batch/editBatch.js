var editBatch = function () {
    return {
        init: function () {
            this.registerEvents();
            this.initValidation();
        },
        registerEvents: function(){
           $('#purchaseDate').datetimepicker({
                format: 'YYYY-MM-DD'
            });
            $('#ddCity').change(function(){
                $.post( baseUrl+'/admin/batch/shops.json', {city:$(this).val()}, function( shops ) {
                    if(shops) {
                       $('#shopWrap').html('');
                       $.each(shops,function(key, shop) {
                            $('#shopWrap').append('<div class="col chkVList">  <input name="chkShop[]" type="checkbox" value="'+shop.id+'"> '+shop.shop+'</div>');
                       });
                       parent.$.fn.colorbox.resize({innerHeight:$('.content').height()+20});
                    } else {
                       
                    }
                }, "json");
            })
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
editBatch.init();