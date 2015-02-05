var editProperty = function () {
    var totalUnfilledRowsCount
    return {
        init: function () {
            this.registerEvents();
            this.initValidation();
            parent.$.fn.colorbox.resize({innerHeight:parseInt($('#hdntotalOptions').val())*35+295});
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

            $(document).on('click','.btnDeleteOption',function(e){
                e.preventDefault();
                if ($('#optionWrap .optionRow').length > 1) {
                    $(this).parents('#optionWrap .optionRow').find('.txtPropertyOption').val('');
                    $(this).parents('#optionWrap .optionRow').hide();
                }
            });
        },
        initValidation: function(){
            var newPropertyValidator = $("#frmEditProperty").validate({
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
                    var propertyoptionId;
                    var propertyOptions =   [];
                    var newOptions      =   [];
                    $('.existingOption').each(function(){
                        if( $.trim($(this).attr('rel'))!='' ){
                            propertyoptionId = $(this).attr('rel');
                        }
                        propertyOptions.push({
                                            propertyoptionId:propertyoptionId,
                                            value:$(this).val()
                                        });
                    });
                    $('.newOption').each(function(){
                        if( $.trim($(this).val())!='' ){
                            newOptions.push({ value:$(this).val() });
                        }
                    });


                    console.log(propertyOptions);
                    console.log(newOptions);
                    $.post( baseUrl+'/admin/properties/edit/'+$('#hdnPropertyId').val(), 
                        {existingOptions:JSON.stringify(propertyOptions), newOptions:JSON.stringify(newOptions),property:$('#property').val()}, 
                        function( response ) {
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
                txtPropertyOptiond:{
                    required: true,
                    minlength: 1,
                }   
            });
        }
    };
}();
editProperty.init();