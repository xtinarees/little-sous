(function($) {
	$(document).ready(function() {

		$names = [];
		$count = 0;

		$('.acf-field-recipe-facets .acf-row').each(function(index) {
			$name = $(this).find('.acf-field-recipe-facet-name input').val();

			if ($name) { 
				$names.push($name);
				$(this).addClass('tabz-tab').addClass('tabz-' + $count);

				if ($count !== 0) { $(this).hide(); }
				// $(this).hide();
				// if ($count === 0) { $(this).show(); }
				$count = $count + 1;

			}
		});





		tabz = '';
		tabz += '<ul class="tabz-labels">';
		for (i = 0; i < $names.length; i++ ) {
			tabz += '<li ';
			tabz += 'class="tabz-label ';
			if (i == 0) { tabz += 'is-active'; }
			tabz += '" ';
			tabz += 'data-tabzmatch="tabz-' + i + '"';
			tabz += '>';
			tabz += $names[i];
			tabz += '</li>';
		}
		tabz += '</ul>';





		$('label[for=acf-field_recipe_facets]').parent().after(tabz);

		$('.tabz-label').click(function() {
			$('.tabz-tab').hide();

			$('.tabz-label').removeClass('is-active');
			$(this).addClass('is-active');

			$match = $(this).data('tabzmatch');

			$('.tabz-tab.' + $match).show();
		});


		// h- prefix = hidden
		$('th[data-name^="h_"]').hide();


	});
})(jQuery);