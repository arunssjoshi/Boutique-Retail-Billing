var employee = function () {
    return {
        init: function () {
            this.initPropertiesDataTable();
        },

        initPropertiesDataTable: function() {
           $('#tblProperties').dataTable( {
		        "ajax": {
		        	"url": baseUrl+'/admin/properties/properties.json',
		        	"type": "POST"
		        },
        		"serverSide": true,
        		
		        "columnDefs": [
				    { "orderable": false, "targets": [0] }
				  ]
		    } );
        }
    };
}();
employee.init();