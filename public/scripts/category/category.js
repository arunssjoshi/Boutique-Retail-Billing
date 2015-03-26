var dtCategories;
var categories = function () {

    return {
        init: function () {
            this.initPropertiesDataTable();
            this.registerEvents();
        },

        initPropertiesDataTable: function() {
        	dtCategories = $('#tblCategories').dataTable( {
                "serverSide": true,
		        "ajax": {
                    url:baseUrl+'/admin/categories/category.json',
                    type:'POST'
                },
                "fnDrawCallback":this.registerDtLoadedEvents 
		    });
        },

        updateDT: function() {
          dtCategories.fnDraw();
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