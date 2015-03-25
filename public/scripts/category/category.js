var dtProperties;
var categories = function () {

    return {
        init: function () {
            this.initPropertiesDataTable();
            this.registerEvents();
        },

        initPropertiesDataTable: function() {
        	dtProperties = $('#tblProperties').dataTable( {
                "serverSide": true,
		        "ajax": {
                    url:baseUrl+'/admin/categories/categories.json',
                    type:'POST'
                },
                "fnDrawCallback":this.registerDtLoadedEvents 
		    });
        },

        updateDT: function() {
          dtProperties.fnDraw();
        },

        deleteProperty: function() {
            $.post( baseUrl+'/admin/categories/delete/'+$('#hdnPropertyId').val(), 
                {}, 
                function( response ) {
                    if(response.status) {
                        parent.categories.updateDT();
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
        	$("input[type='checkbox']:not(.simple), input[type='radio']:not(.simple)").iCheck({
                checkboxClass: 'icheckbox_minimal',
                radioClass: 'iradio_minimal'
            });
        }
    };
}();
categories.init();