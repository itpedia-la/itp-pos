
(function($) {
    $.fn.ddPayment = function(options) {

    	
    	var settings = $.extend({
    		success : null
        }, options);
    	
    	var data = [
                    { text: "Cheque", value: "Cheque" },
                    { text: "Bank Transfer", value: "Bank Transfer" },
                    { text: "Cash", value: "Cash" }
                ];

        // create DropDownList from input HTML element
        $(this).kendoDropDownList({
            dataTextField: "text",
            dataValueField: "value",
            value : $(this).val(),
            dataSource: data,
            index: 0,
            optionLabel: {
            	text: '- ປະເພດ ການຊຳລະເງິນ -',
            	value: ""
	        },
            
        });

    }
}(jQuery));


(function($) {
    $.fn.ddCustomerType = function(options) {

    	var settings = $.extend({
    		success : null,
    		change : null,
        }, options);
    	
    	var data = [
                    { text: "15 ມື້", value: "15" },
                    { text: "45 ມື້", value: "45" },
                ];

        // create DropDownList from input HTML element
        $(this).kendoDropDownList({
            dataTextField: "text",
            dataValueField: "value",
            value : $(this).val(),
            dataSource: data,
            change : function() {
            	settings.change(this.value());
            },
            index: 0,
            optionLabel: {
            	text: '- ປະເພດ ລູກຄ້າ -',
            	value: ""
	        },
            
        });

    }
}(jQuery));