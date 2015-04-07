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

        deleteCategory: function() {
            $.post( baseUrl+'/admin/categories/delete/'+$('#hdnCategoryId').val(), 
                {}, 
                function( response ) {
                    if(response.status) {
                        parent.categories.updateDT();
                        parent.$.fn.colorbox.close();
                    } else {
                        $('#btnCategorySave-error').html(response.message).show();
                    }
                }, "json");
        },
        registerDtLoadedEvents: function() {
            $('.lnkCategoryDelete').colorbox({iframe:true,className:'billingDefault',href:function(){return $(this).attr('rel');},
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