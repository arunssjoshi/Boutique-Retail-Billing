var dtShops;
var batch = function () {

    return {
        init: function () {
            this.initShopsDataTable();
            this.registerEvents();
        },

        initShopsDataTable: function() {
        	dtShops = $('#tblShops').dataTable( {
                "serverSide": true,
		        "ajax": {
                    url:baseUrl+'/admin/batch/batch.json',
                    type:'POST'
                },
                "fnDrawCallback":this.registerDtLoadedEvents 
		    });
        },

        updateDT: function() {
          dtShops.fnDraw();
        },

        deleteBatch: function() {
            $.post( baseUrl+'/admin/batch/delete/'+$('#hdnBatchId').val(), 
                {}, 
                function( response ) {
                    if(response.status) {
                        parent.batch.updateDT();
                        parent.$.fn.colorbox.close();
                    } else {
                        $('#btnShopSave-error').html(response.message).show();
                    }
                }, "json");
        },
        registerDtLoadedEvents: function() {
            $('.lnkBatchEdit').colorbox({iframe:true,className:'billingDefault',href:function(){return $(this).attr('rel');},
                                           innerWidth:500,innerHeight:240, 
                                           onComplete:function(){
                                                                $('#property').focus();}});
            $('.lnkBatchDelete').colorbox({iframe:true,className:'billingDefault',href:function(){return $(this).attr('rel');},
                                           innerWidth:500,innerHeight:205, 
                                           onComplete:function(){
                                           
                                           }}
                                            );
            

        },
        registerEvents: function(){
        	$('#btnNewBatch').colorbox({iframe:true,className:'billingDefault',href:function(){return $(this).attr('rel');},
                                           innerWidth:500,innerHeight:400, trapFocus:true,
                                           }
                                      );

            
           
        }
    };
}();
batch.init();