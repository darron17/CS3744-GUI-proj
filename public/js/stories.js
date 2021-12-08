$(document).ready(function() {

  // event handler for the delete post button
  $('.delete').click(function() {

    // Popup box that confirms whether or not the user wants to delete the post.
    // Has 2 options, OK or Cancel. If OK is clicked then the page is directed
    // to the normal action path stated in "My_Page" where the post will get deleted.
    // If Cancel is clicked then the user is brought back to "My_Page" and the post wasn't deleted.
    if (confirm('Are you sure you want to delete this post?')) {
      // Don't change the action path
    }
    else {
      document.getElementById("deleting").action = "My_Page";
    }
  });

  $('.like').click(function() {
    var id = $(this).parent().parent().attr('id');
    var storyID = id.substr(8);
    console.log(storyID);

    if ($(this).text() == "Like") {
      $.post(
        base_url + '/News/like/process',
        {
          'story_id': storyID,
          'like_action': 'like'
        },
        function(data) {
          //alert("Callback activated");
          if (data.success == 'success') {

            //Change the button text to "Liked"
            $('#storyID-' + data.story_id).find('button.like').eq(0).text("Liked");
            //$(this).text("Liked");

            //Change the button background to red
            $('#storyID-' + data.story_id).find('button.like').css('background-color', 'red');

            //Change the button text font color to white
            $('#storyID-' + data.story_id).find('button.like').css('color', 'white');

            //Sets the like counter to the new number of likes
            $('#storyID-' + data.story_id).find('h3.likes').eq(0).text(data.new_likes);

            //For the like button on the "Post" page, change the text next to the button
            $('#storyID-' + data.story_id).find('button.like').parent().parent().find('h3.liked_post_question').text('You liked this post!');

            //reports that user liked the story

            // remove any existing success boxes
            $('div.success').remove();

            //Message being printed
            var success = $('<div class="success">Your like has been recorded!</div>');

            //Prints the messsage to the page depending on the page
            $('#content-left').prepend(success);
            $('#content-upper-left').prepend(success);
          }
          else {
            alert("Error: " + data.error);
          }
        },
        "json"
      );
    }
    else {
      $.post(
        base_url + '/News/like/process',
        {
          'story_id': storyID,
          'like_action': 'dislike'
        },
        function(data) {
          //alert("Callback activated");
          if (data.success == 'success') {

            //Change the button text to "Like"
            $('#storyID-' + data.story_id).find('button.like').text("Like");

            //Change the button background to red
            $('#storyID-' + data.story_id).find('button.like').css('background-color', 'white');

            //Change the button text font color to white
            $('#storyID-' + data.story_id).find('button.like').css('color', 'red');

            //Sets the like counter to the new number of likes
            $('#storyID-' + data.story_id).find('h3.likes').eq(0).text(data.new_likes);

            //For the like button on the "Post" page, change the text next to the button
            $('#storyID-' + data.story_id).find('button.like').parent().parent().find('h3.liked_post_question').text('Like this post?');

            //reports that user liked the story

            // remove any existing success boxes
            $('div.success').remove();

            //Message being printed
            var success = $('<div class="success">Your dislike has been recorded!</div>');

            //Prints the messsage to the page depending on the page
            $('#content-left').prepend(success);
            $('#content-upper-left').prepend(success);
          }
          else {
            alert("Error: " + data.error);
          }
        },
        "json"
      );
    }

  });

  // // event handler for like button
  // $('.like').click(function() {
  //   var likes = $(this).parent().parent().find('h3.likes').eq(0).text();
  //
  //   //if the story isn't liked then it turns red and the like counter increases
  //   //else if the story is already liked, then the story is disliked and the
  //   //counter decrements. A statement also appears on the top of the page
  //   //which corressponds with the like/dislike action made.
  //   if ($(this).text() === "Like") {
  //     //Change the button text to "Liked"
  //     $(this).text("Liked");
  //
  //     //Change the button background to red
  //     $(this).css('background-color', 'red');
  //
  //     //Change the button text font color to white
  //     $(this).css('color', 'white');
  //
  //     //Increment the like counter
  //     likes = parseInt(likes) + 1;
  //
  //     //Sets the like counter to the new number of likes
  //     $(this).parent().parent().find('h3.likes').eq(0).text(likes);
  //
  //     //For the like button on the "Post" page, change the text next to the button
  //     $(this).parent().parent().find('h3.liked_post_question').text('You liked this post!');
  //
  //     // reports that user liked the story
  //
  //     // remove any existing success boxes
  //     $('div.success').remove();
  //
  //     //Message being printed
  //     var success = $('<div class="success">Your like has been recorded!</div>');
  //
  //     //Prints the messsage to the page depending on the page
  //     $('#content-left').prepend(success);
  //     $('#content-upper-left').prepend(success);
  //   }
  //   else {
  //     //Change the button text to "Like"
  //     $(this).text("Like");
  //
  //     //Change the button background to white
  //     $(this).css('background-color', 'white');
  //
  //     //Change the button text color to red
  //     $(this).css('color', 'red');
  //
  //     //Decrement the like counter
  //     likes = parseInt(likes) - 1;
  //
  //     //Sets the like counter to the new number of likes
  //     $(this).parent().parent().find('h3.likes').eq(0).text(likes);
  //
  //     //For the like button on the "Post" page, change the text next to the button
  //     $(this).parent().parent().find('h3.liked_post_question').text('Like this post?');
  //
  //     // reports the user disliked a story
  //
  //     // remove any existing success boxes
  //     $('div.success').remove();
  //
  //     //Message being printed
  //     var success = $('<div class="success">Your dislike has been recorded!</div>');
  //
  //     //Prints the messsage to the page depending on the page
  //     $('#content-left').prepend(success);
  //     $('#content-upper-left').prepend(success);
  //   }
  //
  //   //Used for debugging and checking number of likes behind the scenes
  //   console.log(likes);
  // });
});
