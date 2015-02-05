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

        registerDtLoadedEvents: function() {
            $('.lnkPropertyEdit').colorbox({iframe:true,className:'billingDefault',href:function(){return $(this).attr('rel');},
                                           innerWidth:500,innerHeight:370, trapFocus:true, 
                                           onComplete:function(){
                                                                $('#property').focus();}});
            $('.lnkPropertyDelete').colorbox({iframe:true,className:'billingDefault',href:function(){return $(this).attr('rel');},
                                           innerWidth:500,innerHeight:370, trapFocus:true,
                                           onComplete:function(){parent.$.fn.colorbox.resize({innerHeight:270});
                                                                $('#property').focus();}}
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
//innerHeight:$('.content .row').height()+75