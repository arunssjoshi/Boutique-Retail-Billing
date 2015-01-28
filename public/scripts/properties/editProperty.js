var editProperty = function () {
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
                    parent.$.fn.colorbox.resize({innerHeight:$('.content').height()+40});
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
                invalidHandler: function(form, validator){
                    parent.$.fn.colorbox.resize({innerHeight:$('.content').height()+80});
                },
                submitHandler: function(form) {
                    $('#btnPropertySave-error').html('').hide()
                    $.post( baseUrl+'/admin/properties/new', $("#frmNewProperty").serialize(), function( response ) {
                        if(response.status) {
                            parent.properties.updateDT();
                            parent.$.fn.colorbox.close();
                        } else {
                            $('#btnPropertySave-error').html(response.message).show();
                        }
                    }, "json");
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
editProperty.init();