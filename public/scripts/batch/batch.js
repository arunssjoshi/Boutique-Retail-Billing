var dtShops;
var shops = function () {

    return {
        init: function () {
            this.initShopsDataTable();
            this.registerEvents();
        },

        initShopsDataTable: function() {
        	dtShops = $('#tblShops').dataTable( {
                "serverSide": true,
		        "ajax": {
                    url:baseUrl+'/admin/shops/shops.json',
                    type:'POST'
                },
                "fnDrawCallback":this.registerDtLoadedEvents 
		    });
        },

        updateDT: function() {
          dtShops.fnDraw();
        },

        deleteShop: function() {
            $.post( baseUrl+'/admin/shops/delete/'+$('#hdnShopId').val(), 
                {}, 
                function( response ) {
                    if(response.status) {
                        parent.shops.updateDT();
                        parent.$.fn.colorbox.close();
                    } else {
                        $('#btnShopSave-error').html(response.message).show();
                    }
                }, "json");
        },
        registerDtLoadedEvents: function() {
            $('.lnkPropertyEdit').colorbox({iframe:true,className:'billingDefault',href:function(){return $(this).attr('rel');},
                                           innerWidth:500,innerHeight:240, 
                                           onComplete:function(){
                                                                $('#property').focus();}});
            $('.lnkPropertyDelete').colorbox({iframe:true,className:'billingDefault',href:function(){return $(this).attr('rel');},
                                           innerWidth:500,innerHeight:205, 
                                           onComplete:function(){
                                           
                                           }}
                                            );
            

        },
        registerEvents: function(){
        	$('#btnNewShop').colorbox({iframe:true,className:'billingDefault',href:function(){return $(this).attr('rel');},
                                           innerWidth:500,innerHeight:245, trapFocus:true,
                                           }
                                            );

            
           
        }
    };
}();
shops.init();