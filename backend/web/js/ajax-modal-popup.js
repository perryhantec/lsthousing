$(function() {
   $('.popupModal').click(function(e) {
     e.preventDefault();
     $('#modal').modal('show')
     .find('.modal-dialog').css("z-index", "1050")
     .find('.modal-content').load($(this).attr('href'));
   });
});
