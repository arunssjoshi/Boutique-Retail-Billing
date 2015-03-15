var addShop = function () {
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
            var newPropertyValidator = $("#frmNewBatch").validate({
                rules: {
                    batch: {
                        required: true
                    },
                    ddCity: {
                        required: true
                    }
                },
                messages: {
                    batch: {
                        required: "Batch required",
                    },
                    ddCity: {
                        required: "City required",
                    }
                },
                invalidHandler: function(form, validator){
                    
                },
                submitHandler: function(form) {
                    $('#btnPropertySave-error').html('').hide()
                    $.post( baseUrl+'/admin/batch/new', $("#frmNewBatch").serialize(), function( response ) {
                        if(response.status) {
                            parent.batch.updateDT();
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