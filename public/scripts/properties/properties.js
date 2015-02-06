var dtProperties;
var properties = function () {

    return {
        init: function () {
            this.initPropertiesDataTable();
            this.registerEvents();
        },

        initPropertiesDataTable: function() {
        	dtProperties = $('#tblProperties').dataTable( {
                "serverSide": true,
		        "ajax": {
                    url:baseUrl+'/admin/properties/properties.json',
                    type:'POST'
                },
                "fnDrawCallback":this.registerDtLoadedEvents 
		    });
        },

        updateDT: function() {
          dtProperties.fnDraw();
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
        	$('#btnNewProperty').colorbox({iframe:true,className:'billingDefault',href:function(){return $(this).attr('rel');},
                                           innerWidth:500,innerHeight:370, trapFocus:true,
                                           onComplete:function(){parent.$.fn.colorbox.resize({innerHeight:270});
                                                                $('#property').focus();}}
                                            );

            
            $('#btnTEzxt').click(function(){
                
            })
        }
    };
}();
properties.init();