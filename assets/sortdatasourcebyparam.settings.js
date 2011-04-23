
(function($) {

	$(document).ready(function() {
		// Find context path.
		var env = Symphony.Context.get('env');
		if (env.length < 1) return;

		// Build form action URL by which we will find data source edit form.
		var action = Symphony.Context.get('root') + '/symphony/blueprints/datasources';
		if (env[0] == 'new') action += '/new/';
		else if (env[0] == 'edit' && env.length > 1) action += '/edit/' + env[1] + '/';

		// Find form.
		var form = $('div#contents form[action^="'+action+'"]');
		if (form.length < 1) return;

		// Get current sort and order values.
		var params = Symphony.Context.get('sortdatasourcebyparam');

		// Add sort input field.
		$('select[name="fields\\[sort\\]"]', $(form)).attr('data-input', 'sort').before('<input type="text" name="fields[sortInput]" data-select="sort" value="'+params['sort']+'" />');

		// Add order input field.
		$('select[name="fields\\[order\\]"]', $(form)).attr('data-input', 'order').before('<input type="text" name="fields[orderInput]" data-select="order" value="'+params['order']+'" />');

		// Connect our input fields with sort and order select boxes.
		$('input[name="fields\\[sortInput\\]"], input[name="fields\\[orderInput\\]"]', $(form)).live('change', function(event) {
			// Find connected select field.
			var select = $(this).next('select[name="fields\\['+$(this).data('select')+'\\]"]');
			// Cache current value for faster access.
			var value = $(this).val();

			// Reset option if value was emptied.
			if (value == '') {
				$('option:selected', $(select)).removeAttr('selected');
				$(this).val($(select).val());
				return;
			}

			// Prevent never ending loop of events by returning when selected option is equal to  input value.
			if ($('option:selected', $(select)).attr('value') == value) return;

			// Remove old typed option and append new one.
			$('option.typedparam', $(select)).remove();
			$(select).append('<option value="'+value+'" class="typedparam" selected="selected">'+value+'</option>');
		}).trigger('change');

		// Update value of sort-input or order-input field whenever sort-option or order-option is changed.
		$('select[name="fields\\[sort\\]"], select[name="fields\\[order\\]"]', $(form)).live('change', function(event) {
			$('input[data-select="'+$(this).data('input')+'"]', $(form)).val($('option:selected', $(this)).attr('value'));
			//$('input#'+$(this).attr('id')+'-input', $(form)).val($('option:selected', $(this)).attr('value'));
		});
	});
	
})(jQuery.noConflict());
