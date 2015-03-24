var editBatch = function () {
    return {
        init: function () {
            this.registerEvents();
            this.initValidation();
            this.loadShops();
        },
        registerEvents: function(){
           $('#purchaseDate').datetimepicker({
                format: 'YYYY-MM-DD'
            });
            $('#ddCity').change(function(){
                editBatch.loadShops();
            })
        },
        initValidation: function(){
            var newPropertyValidator = $("#frmEditBatch").validate({
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
                    
                    $.post( baseUrl+'/admin/batch/edit/'+$('#hdnBatchId').val(), $("#frmEditBatch").serialize(), function( response ) {
                        if(response.status) {
                            parent.batch.updateDT();
                            parent.$.fn.colorbox.close();
                        } else {
                            $('#btnBatchSave-error').html(response.message).show();
                        }
                    }, "json");
                }
            });
        },
        loadShops: function(){
                
                $.post( baseUrl+'/admin/batch/shops.json', {city:$('#ddCity').val(), batchId: $('#hdnBatchId').val()}, function( shops ) {
                        if(shops) {
                           var chkSelect;
                           $('#shopWrap').html('');
                           $.each(shops,function(key, shop) {
                                chkSelect = (shop.batch_shop_id!=null)?"checked='checked'":"";
                                $('#shopWrap').append('<div class="col chkVList">  <input name="chkShop[]" '+chkSelect+' type="checkbox" value="'+shop.id+'"> '+shop.shop+'</div>');
                           });
                           parent.$.fn.colorbox.resize({innerHeight:$('.content').height()+20});
                        } else {
                           
                        }
                }, "json");
                
        }
    };
}();
editBatch.init();