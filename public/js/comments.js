$(document).ready(function() {

  // Action when the plus button is clicked
  $('.plus').click(function() {

    // Adds the comment input box and its submit button

    var comment_box = $('<input class="commentBox" name="comment" type="text" placeholder="Type comment here">');
    var submit = $('<input class="submitComment" type="button" value="Post comment">');

    $('.addCommentText').append(comment_box);
    $('.addCommentText').append(submit);

    // Action when the submit button for a comment is clicked
    $('.submitComment').click(function() {
      var id = $(this).parent().parent().attr('id');
      var storyID = parseInt(id.substr(8));
      var comment = $(this).parent().find('input.commentBox').eq(0).val();

      $.post(
        base_url + '/posts/comment/process',
        {
          'story_id': storyID,
          'comment': comment,

        },
        function(data) {
          //alert("Callback activated");
          if (data.success == 'success') {
            comment_box.remove();
            submit.remove();
            var newComment = $('<div class="comment">' +
              '<img src="public/img/User_icon.jpg" alt="User icon" width=50>' +
              '<p>By <a href="' + base_url + '/User-' + data.user.username + '">' + data.user.username + '</a>' + ' - ' + data.newComment.date + '</p>' +
              '<p>' + data.newComment.comment + '</p>' +
              '<form>' +
                '<button>Reply</button>' +
              '</form>' +
            '</div><!-- comment -->');
            $('.addCommentText').after(newComment);
          }
          else {
            alert("Error: " + data.error);
          }
        },
        "json"
      );
    });

  });
});
