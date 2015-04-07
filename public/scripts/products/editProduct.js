var editCategory = function () {
    var totalUnfilledRowsCount
    return {
        init: function () {
            this.registerEvents();
            this.initValidation();
        },
        registerEvents: function(){
           
        },
        initValidation: function(){
            var newPropertyValidator = $("#frmEditCategory").validate({
                rules: {
                    category: {
                        required: true
                    }
                },
                messages: {
                    category: {
                        required: "Category required",
                    }
                },
                invalidHandler: function(form, validator){
                    
                },
                submitHandler: function(form) {
                    $('#btnPropertySave-error').html('').hide()
                    var checkedValues = $('input:checkbox:checked').map(function() {
                            return this.value;
                        }).get();
                    $.post( baseUrl+'/admin/categories/edit/'+$('#hdnCategoryId').val(), $("#frmEditCategory").serialize()+'&properties='+checkedValues, function( response ) {
                        if(response.status) {
                            location.href=baseUrl+'/admin/categories';
                        } else {
                            $('#btnCategorySave-error').html(response.message).show();
                        }
                    }, "json");
                }
            });

            
        }
    };
}();
editCategory.init();