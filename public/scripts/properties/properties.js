var properties = function () {
    return {
        init: function () {
            this.initPropertiesDataTable();
            this.registerEvents();
        },

        initPropertiesDataTable: function() {
        	$('#tblProperties').dataTable( {
		        "ajax": baseUrl+'/admin/properties/properties.json'
		    });
        },
        registerEvents: function(){
        	$('#btnNewProperty').colorbox({iframe:true,className:'billingDefault',href:function(){return $(this).attr('rel');},
                                           innerWidth:500,innerHeight:355,
                                           onComplete:function(){parent.$.fn.colorbox.resize({innerHeight:$('.content').height()+60});}});
        	
        }
    };
}();
properties.init();