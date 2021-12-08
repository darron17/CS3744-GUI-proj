var endpoint = 'https://cs3744-proj5.cognitiveservices.azure.com/';
var key = 'ec4739a066d6418f833514a555a11087';


$(function() {

    $('#body').blur(function() {
      checkBody();
    });
});

// Checks the emotion level of the input for the body and lets the user know if it seems negative or positive
function checkBody() {

  var params = {
      // Request parameters
      "showStats": false,
  };

  var commentObj = {
      "documents": [
      {
        "language": "en",
        "id": "1",
        "text": $('#body').val()
      }
    ]
  };

  $.ajax({
      url: endpoint + "text/analytics/v2.1/sentiment?" + $.param(params),
      beforeSend: function(xhrObj){
          // Request headers
          xhrObj.setRequestHeader("Content-Type","application/json");
          xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key", key);
      },
      type: "POST",
      // Request body
      data: JSON.stringify(commentObj),
  })
  .done(function(data) {

    if (data.documents[0] != undefined) {
      if (data.documents[0].score < 0.5) {
        $('.positive').remove();
        $('.negative').remove();
        var neg = $('<div class="negative">Note the body seems negative.</div>');
        $('.body').after(neg);
      }
      else if(data.documents[0].score > 0.5) {
        $('.positive').remove();
        $('.negative').remove();
        var pos = $('<div class="positive">Note the body seems positive.</div>');
        $('.body').after(pos);
      }
    }
    else {
      $('.positive').remove();
      $('.negative').remove();
    }
  })
  .fail(function() {
      alert("error");
  });
}



$(function() {

    $('#desc').blur(function() {
      checkDesc();
    });
});

// Checks the emotion level of the input for the description and lets the user know if it seems negative or positive
function checkDesc() {

  var params = {
      // Request parameters
      "showStats": false,
  };

  var commentObj = {
      "documents": [
      {
        "language": "en",
        "id": "1",
        "text": $('#desc').val()
      }
    ]
  };

  $.ajax({
      url: endpoint + "text/analytics/v2.1/sentiment?" + $.param(params),
      beforeSend: function(xhrObj){
          // Request headers
          xhrObj.setRequestHeader("Content-Type","application/json");
          xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key", key);
      },
      type: "POST",
      // Request body
      data: JSON.stringify(commentObj),
  })
  .done(function(data) {

    if (data.documents[0] != undefined) {
      if (data.documents[0].score < 0.5) {
        $('.positive').remove();
        $('.negative').remove();
        var neg = $('<div class="negative">Note the description seems negative.</div>');
        $('.imageBox').after(neg);
      }
      else if(data.documents[0].score > 0.5) {
        $('.positive').remove();
        $('.negative').remove();
        var pos = $('<div class="positive">Note the description seems positive.</div>');
        $('.imageBox').after(pos);
      }
    }
    else {
      $('.positive').remove();
      $('.negative').remove();
    }
  })
  .fail(function() {
      alert("error");
  });
}
