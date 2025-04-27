function disableSubmitButtons() {
    $('body').on('beforeValidate', 'form.disable-submit-buttons', function (e) {
      $(':input[type="submit"], :button[type="submit"]', this).attr('disabled', 'disabled');
/*
      $(':input[type="submit"][data-disabled-text], :button[type="submit"][data-disabled-text]', this).each(function (i) {
        var $this = $(this)
        if ($this.prop('tagName') === 'input') {
          $this.data('enabled-text', $this.val());
          $this.val($this.data('disabled-text'));
        } else {
          $this.data('enabled-text', $this.html());
          $this.html($this.data('disabled-text'));
        }
      });
*/
    }).on('afterValidate', 'form.disable-submit-buttons', function (e) {
      if ($(this).find('.has-error').length > 0) {
        $(':input[type="submit"], :button[type="submit"]', this).removeAttr('disabled');
/*
        $(':input[type="submit"][data-disabled-text], :button[type="submit"][data-disabled-text]', this).each(function (i) {
          var $this = $(this)
          if ($this.prop('tagName') === 'input') {
            $this.val($this.data('enabled-text'));
          } else {
            $this.html($this.data('enabled-text'));
          }
        });
*/
      }
    });
}

$(function() {
    $('[data-fancybox]').fancybox({
        autoFocus: false
    });

    $('.header-nav .navbar .dropdown > a').click(function(){
        location.href = this.href;
    });

    $('.page-top_youtube a').click(function() {
        var this_id = $(this).attr('data-id');
        var this_title = $(this).attr('data-title');
        var youtube_iframe = $(this).parents('.page-top_youtube').find('iframe');
        if (youtube_iframe.length == 1) {
            var youtube_iframe_id = youtube_iframe.attr('data-id');
            var youtube_iframe_title = youtube_iframe.attr('data-title');
            $(this).attr('data-id', youtube_iframe_id);
            $(this).attr('data-title', youtube_iframe_title);
            $(this).find('.page-top_youtube-thumb').attr('src', 'http://img.youtube.com/vi/'+youtube_iframe_id+'/maxresdefault.jpg');
            $(this).find('.page-top_youtube-title').html(youtube_iframe_title);

            youtube_iframe.attr('data-id', this_id);
            youtube_iframe.attr('data-title', this_title);
            youtube_iframe.attr('src', 'https://www.youtube.com/embed/'+this_id+'?modestbranding=0&rel=0&showinfo=0');
        }
        return false;
    });
});