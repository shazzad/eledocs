(function($){
  $("body").on('click', function(e){
    if (e.target.className !== "results-wrap") {
      $('.eledocs-search-doc').removeClass('results-open');
    }
  });

  $('.eledocs-search-form').on('submit', function(e){
    e.preventDefault();
    var $parent = $(this).closest('.eledocs-search-doc');
    var query = $parent.find('.search-input').val();
    var docId = $parent.find('.doc-id').length > 0 ? $parent.find('.doc-id').val() : 0;

    $parent.addClass('results-open').find('.results, .notice').empty().hide();

    if ( ! query ) {
      $parent.find('.notice').html(eledocsSearchDoc.noKeywords).show();
    } else {
      $parent.find('.notice').html(eledocsSearchDoc.loadingResults).show();

      var data = {query: query, in: docId};
      $.get(eledocsSearchDoc.apiUrl, data)
      .done(function(resp){
        $parent.find('.notice').empty().hide();

        if (resp.length < 1) {
          $parent.find('.notice').html(eledocsSearchDoc.noResults).show();
        } else {
          $parent.find('.results').empty().show();
          resp.forEach(function(result){
            $parent.find('.results').append(
              '<li><a href="'+ result.permalink +'">'
              + result.title.rendered
              + '</a></li>'
            );
          })
        }
      })
    }

    return false;
  });
})(jQuery);
