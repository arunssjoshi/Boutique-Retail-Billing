var addProperty = function () {
    var totalUnfilledRowsCount
    return {
        init: function () {
            this.registerEvents();
            this.initValidation();
        },
        registerEvents: function(){
            $('#optionWrap').append($('#optionHtml').html());
            $(document).on('keyup','.txtPropertyOption',function(){
                totalUnfilledRowsCount = $('#optionWrap .txtPropertyOption').filter(function(){
                    return $(this).val()=='';
                }).length;
                if(totalUnfilledRowsCount == 0) {
                    $('#optionWrap').append($('#optionHtml').html());
                    parent.$.fn.colorbox.resize({innerHeight:$('.content').height()+60});
                }
            });

            $(document).on('click','.btnDeleteOption',function(){
                if ($('#optionWrap .optionRow').length > 1) {
                    $(this).parents('#optionWrap .optionRow').remove();
                }
            });
        },
        initValidation: function(){
            var newPropertyValidator = $("#frmNewProperty").validate({
                rules: {
                    property: {
                        required: true
                    }
                },
                messages: {
                    property: {
                        required: "Property required",
                    }
                },
                submitHandler: function(form) {
                    $.post( baseUrl+'/admin/properties/save_new_property', 
                        $("#frmNewProperty").serialize())
                        .done(function( data ) {
                        alert( "Data Loaded: " + data );
                    });
                }
            });
            $.validator.messages.required = 'Option required';
            jQuery.validator.addClassRules( {
                txtPropertyOption:{
                    required: true,
                    minlength: 1,
                }   
            });
        }
    };
}();
addProperty.init();