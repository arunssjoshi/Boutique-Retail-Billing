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

        deleteProperty: function() {
            $.post( baseUrl+'/admin/properties/delete/'+$('#hdnPropertyId').val(), 
                {}, 
                function( response ) {
                    if(response.status) {
                        parent.properties.updateDT();
                        parent.$.fn.colorbox.close();
                    } else {
                        $('#btnPropertySave-error').html(response.message).show();
                    }
                }, "json");
        },
        registerDtLoadedEvents: function() {
            $('.lnkPropertyEdit').colorbox({iframe:true,className:'billingDefault',href:function(){return $(this).attr('rel');},
                                           innerWidth:500,innerHeight:370, trapFocus:true, 
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