var employee = function () {
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
        	//$('#btnNewProperty').click(function(){
        	//	alert('hjiii');
        	//})
        	$('#btnNewProperty').colorbox({className:'billingModal'});
        	
        }
    };
}();
employee.init();