$(document).ready(function() {

  // Action when the search button is clicked
  $('.search_btn').click(function() {

    var actives = document.getElementsByClassName("active");
    actives[0].className = actives[0].className.replace(" active", "");

    $(this)[0].className += " active";

    var keyword = $(this).parent().find('input.search_bar')[0].value;
    console.log(keyword);
    $.post(
      base_url + '/News/Search/process',
      {
        'keyword': keyword
      },
      function(data) {
        //alert("Callback activated");
        if (data.success == 'success') {
          // remove any existing success boxes
          $('div.success').remove();
          var st = $('.story');
          st.remove();

          // Adds the stories depending on if the user is logged in
          var i = 1;
          while (data.stories[i] != undefined) {
            if (data.loggedIn == true) {
              var st = $('<div id="storyID-' + data.stories[i].id + '" class="story">' +
                  '<div class="like_button">' +
                    '<button class="like">Like</button>' +
                  '</div><!-- like_button -->' +
                '<h3 class= "likes">' + data.stories[i].likes + '</h3>' +
                '<h3 class= "title"><a href="' + base_url + '/Post' + data.stories[i].id + '">' + data.stories[i].title + '</a></h3>' +
                '<p class= "author">By <a href="' + base_url + '/User-' + data.usernames[i] + '">' + data.usernames[i] + '</a> - ' + data.stories[i].date + '</p>' +
                '<p class= "desc">' + data.stories[i].description + '</p>' +
                '</div>');
              $('.endStories').before(st);
              i++;
            }
            else {
              var st = $('<div id="storyID-' + data.stories[i].id + '" class="story">' +
                '<div class="like_button">' +
                  '<button class="like">Like</button>' +
                '</div><!-- like_button -->' +
              '<h3 class= "likes">' + data.stories[i].likes + '</h3>' +
              '<h3 class= "title"><a href="' + base_url + '/Post' + data.stories[i].id + '">' + data.stories[i].title + '</a></h3>' +
              '<p class= "author">By <a href="' + base_url + '/User-' + data.usernames[i] + '">' + data.usernames[i] + '</a> - ' + data.stories[i].date + '</p>' +
              '<p class= "desc">' + data.stories[i].description + '</p>' +
              '</div>');
              $('.endStories').before(st);
              i++;
            }
          }

          // add .like function again for the new stories' like buttons
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
        }
        else {
          alert("Error: " + data.error);
        }
      },
      "json"
    );
  });


  // Action for clicking the trending option on the news page
  $('.trending').click(function() {

    var actives = document.getElementsByClassName("active");
    actives[0].className = actives[0].className.replace(" active", "");

    $(this)[0].className += " active";

    $.get(
      base_url + '/News/sort/process',
      {
        'sort_type': 'trending'
      },
      function(data) {
        // alert("Callback activated");
        if (data.success == 'success') {
          // remove any existing success boxes
          $('div.success').remove();
          var st = $('.story');
          st.remove();

          // Adds the stories depending on if the user is logged in
          var i = 1;
          while (data.stories[i] != undefined) {
            if (data.loggedIn == true) {
              var st = $('<div id="storyID-' + data.stories[i].id + '" class="story">' +
                  '<div class="like_button">' +
                    '<button class="like">Like</button>' +
                  '</div><!-- like_button -->' +
                '<h3 class= "likes">' + data.stories[i].likes + '</h3>' +
                '<h3 class= "title"><a href="' + base_url + '/Post' + data.stories[i].id + '">' + data.stories[i].title + '</a></h3>' +
                '<p class= "author">By <a href="' + base_url + '/User-' + data.usernames[i] + '">' + data.usernames[i] + '</a> - ' + data.stories[i].date + '</p>' +
                '<p class= "desc">' + data.stories[i].description + '</p>' +
                '</div>');
              $('.endStories').before(st);
              i++;
            }
            else {
              var st = $('<div id="storyID-' + data.stories[i].id + '" class="story">' +
                '<div class="like_button">' +
                  '<button disabled class="like">Like</button>' +
                '</div><!-- like_button -->' +
              '<h3 class= "likes">' + data.stories[i].likes + '</h3>' +
              '<h3 class= "title"><a href="' + base_url + '/Post' + data.stories[i].id + '">' + data.stories[i].title + '</a></h3>' +
              '<p class= "author">By <a href="' + base_url + '/User-' + data.usernames[i] + '">' + data.usernames[i] + '</a> - ' + data.stories[i].date + '</p>' +
              '<p class= "desc">' + data.stories[i].description + '</p>' +
              '</div>');
              $('.endStories').before(st);
              i++;
            }
          }
          // add .like function again for the new stories' like buttons
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
        }
        else {
          alert("Error: " + data.error);
        }
      },
      "json"
    );
  });

  // Action for clicking the most recent option on the news page
  $('.most_recent').click(function() {

    var actives = document.getElementsByClassName("active");
    actives[0].className = actives[0].className.replace(" active", "");

    $(this)[0].className += " active";

      $.get(
        base_url + '/News/sort/process',
        {
          'sort_type': 'most_recent'
        },
        function(data) {
          //alert("Callback activated");
          if (data.success == 'success') {
            // remove any existing success boxes
            $('div.success').remove();
            var st = $('.story');
            st.remove();

            // Adds the stories depending on if the user is logged in
            var i = 1;
            while (data.stories[i] != undefined) {
              if (data.loggedIn == true) {
                var st = $('<div id="storyID-' + data.stories[i].id + '" class="story">' +
                  '<div class="like_button">' +
                    '<button class="like">Like</button>' +
                  '</div><!-- like_button -->' +
                '<h3 class= "likes">' + data.stories[i].likes + '</h3>' +
                '<h3 class= "title"><a href="' + base_url + '/Post' + data.stories[i].id + '">' + data.stories[i].title + '</a></h3>' +
                '<p class= "author">By <a href="' + base_url + '/User-' + data.usernames[i] + '">' + data.usernames[i] + '</a> - ' + data.stories[i].date + '</p>' +
                '<p class= "desc">' + data.stories[i].description + '</p>' +
                '</div>');
                $('.endStories').before(st);
                i++;
              }
              else {
                var st = $('<div id="storyID-' + data.stories[i].id + '" class="story">' +
                  '<div class="like_button">' +
                    '<button disabled class="like">Like</button>' +
                  '</div><!-- like_button -->' +
                '<h3 class= "likes">' + data.stories[i].likes + '</h3>' +
                '<h3 class= "title"><a href="' + base_url + '/Post' + data.stories[i].id + '">' + data.stories[i].title + '</a></h3>' +
                '<p class= "author">By <a href="' + base_url + '/User-' + data.usernames[i] + '">' + data.usernames[i] + '</a> - ' + data.stories[i].date + '</p>' +
                '<p class= "desc">' + data.stories[i].description + '</p>' +
                '</div>');
                $('.endStories').before(st);
                i++;
              }
            }
            // add .like function again for the new stories' like buttons
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

          }
        else {
          alert("Error: " + data.error);
        }
      },
      "json"
    );
  });
});
