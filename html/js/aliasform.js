$.fn.serializeObject = function() {
    var o = {};
    //o['map'] = {};
    var a = this.serializeArray();
    var mapname;
    var maptype;
    var fieldnames = {};
    $.each(a, function() {

        if (this.name != 'description' && this.name != 'info') {
            //this.value = splitTrim(this.value);
        }

        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');

        } else {
            o[this.name] = this.value || '';
        }


		if(this.name.substr(0, 9) == 'fieldname') {
			
			var name = this.name.split('-');
            var index = name[1];
            
            fieldnames[index] = this.value;
			o[this.value] = '';
			delete o['fieldname-' + index];
		}

		if(this.name.substr(0, 10) == 'fieldvalue') {
			
			var name = this.name.split('-');
            var index = name[1];
            
            if(fieldnames[index] != '' || this.value != '') {
            
            	o[fieldnames[index]] = this.value;
            
            } else {
            	delete o[fieldnames[index]];
            }
            
            delete o['fieldvalue-' + index];
		}

        if (this.name.substr(0, 3) == 'map') {

            var name = this.name.split('-');
            var index = name[1];

            if (this.name.indexOf('name') > -1) {

                mapname = this.value;
                o['map'][this.value] = {};
                delete o['map_name-' + index];

            } else if (this.name.indexOf('type') > -1 && mapname) {

                maptype = this.value;
                o['map'][mapname][this.value] = '';
                delete o['map_type-' + index];

            } else if (this.name.indexOf('value') > -1 && mapname && maptype) {

                o['map'][mapname][maptype] = this.value;
                mapname = '';
                maptype = '';
                delete o['map_value-' + index];

            } else {

                delete o['map_value-' + index];
                delete o['map_type-' + index];
                delete o['map_name-' + index];
            }

        }

        if (this.value == '') {
            delete o[this.name]
        }
    });

    if (JSON.stringify(o['map']) == '{"":{}}') {
        delete(o['map']);
    }
    return o;
};

var splitTrim = function(data) {
    data = data.split(',');
    data = $.map(data, $.trim);
    if (data.length < 2) {
        data = data.toString();
    }
    return data;
}



$(function() {
    $('#buttonSubmit').click(function() {
        result = JSON.stringify($('form').serializeObject());
        $('#result').text(result);
        $('#result-text').val(result);
        return false;
    });

	$('div.removeFieldsRow').click(function()
	{
		$(this).closest('.fieldsRow').remove();
		e.preventDefault();
	});


    $("#addField").click(function() {
        var count = $('.fieldsRow').length;
        var newItem = count + 1;
        
        var row = '<div class="fieldsRow" id="fieldsRow-' + newItem + '">' +
				  '<div class="fieldLeft"><label for="fieldname">Field name</label>' +
				  '<input type="text" name="fieldname-' + newItem + '" class="form-control" maxlength="255" size="25"/>' +
				  '</div><div class="fieldRight"><label for="fieldvalue">Field value</label>' + 
				  '<input type="text" name="fieldvalue-' + newItem + '" class="form-control" maxlength="255" size="25"/>' + 
				  '</div></div>';
		

        if (count > 0) {
            var element = '#fieldsRow-' + count;
        } else {
            var element = '#headFieldsRow';
        }
        
        $(element).after(row);
    });
});
