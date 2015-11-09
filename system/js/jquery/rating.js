// JQuery for Rating on Feedback Form
$(document).ready(function()
{
	$('.rate_widget').each(function(i) 
	{
		var widget = this;
		var out_data = 
		{
			widget_id : $(widget).attr('id'),
			fetch: 1
		};
		$.post(
			'../feedback/modules/rating/ratings.php',
			out_data,
			function(INFO) 
			{
				$(widget).data( 'fsr', INFO );
				set_votes(widget);
			},
			'json'
		);
	});

	$('.ratings_stars').hover(
		// on mouseover
		function() 
		{
			$(this).prevAll().andSelf().addClass('ratings_over');
			$(this).nextAll().removeClass('ratings_vote'); 
		},
		// on mouseout
		function() 
		{
			$(this).prevAll().andSelf().removeClass('ratings_over');
			set_votes($(this).parent());
		}
	);
	
	// record vote
	$('.ratings_stars').bind('click', function() 
	{
		var star = this;
		var widget = $(this).parent();
		
		var clicked_data = 
		{
			clicked_on : $(star).attr('class'),
			widget_id : $(star).parent().attr('id')
		};
		$.post(
			'../feedback/modules/rating/ratings.php',
			clicked_data,
			function(INFO) 
			{
				widget.data( 'fsr', INFO );
				set_votes(widget);
			},
			'json'
		); 
	});
});

function set_votes(widget)
{
	var avg = $(widget).data('fsr').whole_avg;
	var votes = $(widget).data('fsr').number_votes;
	var exact = $(widget).data('fsr').dec_avg;
	
	$(widget).find('.star_' + avg).prevAll().andSelf().addClass('ratings_vote');
	$(widget).find('.star_' + avg).nextAll().removeClass('ratings_vote'); 
	$(widget).find('.total_votes').text( votes + ' votes.  Rating Average: ' + exact);
}