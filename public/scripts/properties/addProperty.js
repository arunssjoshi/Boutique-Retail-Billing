var addProperty = function () {
    var totalUnfilledRowsCount
    return {
        init: function () {
            this.registerEvents();
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
        }
    };
}();
addProperty.init();