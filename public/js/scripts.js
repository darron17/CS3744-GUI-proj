$(document).ready(function() {

  // Action for when the delete button in the Visualization section is clicked
  $('#btnDelete').click(function() {
    var str = $('.selected-circle').eq(0).attr('class').split(" ");
    var id = str[1];
    console.log(id);

    $.post(
      base_url + '/My_Page/deleteBubble/process',
      {
        'story_id': id
      },
      function(data) {
        if (data.success == 'success') {
          $('.selected-circle').eq(0).fadeOut();
          $('.selected-text').eq(0).fadeOut();
          $('#topBubbleAndText_' + id).fadeOut();

          console.log('delete success');
        }
        else {
          alert("Error: " + data.error);
        }
      }
    );
  });

  // Action for when the edit button in the Visualization section is clicked
  $('#btnEdit').click(function() {
    var str = $('.selected-circle').eq(0).attr('class').split(" ");
    var id = str[1];
    console.log($('#txtEditTitle').val());

    $.post(
      base_url + '/My_Page/editBubble/process',
      {
        'story_id': id,
        'new_title': $('#txtEditTitle').val()
      },
      function(data) {
        if (data.success == 'success') {
          $('#topBubbleAndText_' + id).find('text').eq(0).text("diff");
          console.log($('#topBubbleAndText_' + id).find('text').eq(0).text($('#txtEditTitle').val()));
          //console.log($('#txtEditTitle').val());
        }
        else {
          alert("Error: " + data.error);
        }
      }
    );

  });


  // d3 starts here

  var w = window.innerWidth*0.68*0.95;
  var h = Math.ceil(w*0.7);
  var oR = 0;
  var nTop = 0;

  var svgContainer = d3.select("#mainBubble")
     .style("height", h+"px");

  var svg = d3.select("#mainBubble").append("svg")
       .attr("class", "mainBubbleSVG")
       .attr("width", w)
       .attr("height",h)
       .on("mouseleave", function() {return resetBubbles();});

  var mainNote = svg.append("text")
   .attr("id", "bubbleItemNote")
   .attr("x", 10)
   .attr("y", w/2-15)
   .attr("font-size", 12)
   .attr("dominant-baseline", "middle")
   .attr("alignment-baseline", "middle")
   .style("fill", "#888888")
   .text(function(d) {return "D3.js bubble menu developed by Shipeng Sun (sunsp.gis@gmail.com), Institute of Environment, University of Minnesota, and University of Springfield, Illinois.";});


   d3.json(base_url + '/My_Page/viz', function(error, root) {
       console.log(error);

       var bubbleObj = svg.selectAll(".topBubble")
               .data(root.children)
           .enter().append("g")
               .attr("id", function(d,i) {return "topBubbleAndText_" + d.story_id.toString()});

       //console.log(root);
       nTop = root.children.length;
       oR = 100;

   h = nTop * 500;
   svgContainer.style("height",h+"px");

   mainNote.attr("y",h-15);

   svg.attr("width", w);
   svg.attr("height",h);

       var colVals = d3.scale.category20();

       bubbleObj.append("circle")
           .attr("class", "topBubble")
           .attr("id", function(d,i) {return "topBubble" + d.story_id.toString();})
           .attr("r", function(d) { return oR; })
           .attr("cx", function(d, i) {return 50 +"%";})
           .attr("cy", function(d, i) {return (i+1) * 300;})
           .style("fill", function(d,i) { return colVals(i); }) // #1f77b4
       .style("opacity",0.3)
           .on("mouseover", function(d,i) {return activateBubble(d,i);});


       bubbleObj.append("text")
           .attr("class", "topBubbleText")
           .attr("x", function(d, i) {return 50 +"%";})
           .attr("y", function(d, i) {return (i+1) * 300;})
       .style("fill", function(d,i) { return colVals(i); }) // #1f77b4
           .attr("font-size", 20)
           .attr("text-anchor", "middle")
       .attr("dominant-baseline", "middle")
       .attr("alignment-baseline", "middle")
           .text(function(d) {return d.name})
           .on("mouseover", function(d,i) {return activateBubble(d,i);});


       for(var iB = 0; iB < nTop; iB++)
       {
           var childBubbles = svg.selectAll(".childBubble" + iB)
               .data(root.children[iB].children)
               .enter().append("g");

       //var nSubBubble = Math.floor(root.children[iB].children.length/2.0);

           childBubbles.append("circle")
               .attr("class", function(d,i) {return "childBubble" + iB + " " + d.story_id;})
               .attr("id", function(d,i) {return "childBubble_" + iB + "sub_" + i;})
               .attr("r",  function(d) {return oR/3.0;})
               .attr("cx", function(d,i) {return (w/2 + oR*1.5*Math.cos((i-1)*45/180*3.1415926));})
               .attr("cy", function(d,i) {return (300 * (iB + 1) + oR*1.5*Math.sin((i-1)*45/180*3.1415926));})
               .attr("cursor","pointer")
               .style("opacity",0.5)
               .style("fill", "#eee")
               .on("click", function(d,i) {
                 $(this).parent().parent().find('circle').removeClass('selected-circle');
                 $(this).parent().parent().find('text').removeClass('selected-text');
                 $(this).addClass('selected-circle');
                 $(this).parent().find('text').addClass('selected-text');
                 $('#panel').fadeIn();
                 $('#txtEditTitle').val(d.story);

                 //console.log(d.story_id);
               //window.open(d.address);
             })
           // .on("mouseover", function(d,i) {
           //   //window.alert("say something");
           //   var noteText = "";
           //   if (d.note == null || d.note == "") {
           //     noteText = d.address;
           //   } else {
           //     noteText = d.note;
           //   }
           //   d3.select("#bubbleItemNote").text(noteText);
           //   })
           .append("svg:title")
           .text(function(d) { return d.address; });

           childBubbles.append("text")
               .attr("class", "childBubbleText" + iB)
               .attr("x", function(d,i) {return (w/2 + oR*1.5*Math.cos((i-1)*45/180*3.1415926));})
               .attr("y", function(d,i) {return (300 * (iB + 1) +        oR*1.5*Math.sin((i-1)*45/180*3.1415926));})
               .style("opacity",0.5)
               .attr("text-anchor", "middle")
           .style("fill", function(d,i) { return colVals(iB); }) // #1f77b4
               .attr("font-size", 15)
               .attr("cursor","pointer")
               .attr("dominant-baseline", "middle")
           .attr("alignment-baseline", "middle")
               .text(function(d) {return d.name})
               .on("click", function(d,i) {
               //window.open(d.address);
               });

       }


    });

   resetBubbles = function () {
     w = window.innerWidth*0.68*0.95;
     oR = 100;

     svgContainer.style("height",h+"px");

     mainNote.attr("y",h-15);

     svg.attr("width", w);
     svg.attr("height",h);

     var t = svg.transition()
         .duration(650);

       t.selectAll(".topBubble")
           .attr("r", function(d) { return oR; })
           .attr("cx", function(d, i) {return 50 +"%";})
           .attr("cy", function(d, i) {return (i+1) * 300;});

       t.selectAll(".topBubbleText")
       .attr("font-size", 20)
           .attr("x", function(d, i) {return 50 +"%";})
           .attr("y", function(d, i) {return (i+1) * 300;});

     for(var k = 0; k < nTop; k++)
     {
       t.selectAll(".childBubbleText" + k)
               .attr("x", function(d,i) {return (w/2 + oR*1.5*Math.cos((i-1)*45/180*3.1415926));})
               .attr("y", function(d,i) {return (300 * (k + 1) +        oR*1.5*Math.sin((i-1)*45/180*3.1415926));})
           .attr("font-size", 15)
               .style("opacity",0.5);

       t.selectAll(".childBubble" + k)
               .attr("r",  function(d) {return oR/3.0;})
           .style("opacity",0.5)
               .attr("cx", function(d,i) {return (w/2 + oR*1.5*Math.cos((i-1)*45/180*3.1415926));})
               .attr("cy", function(d,i) {return (300 * (k + 1) +        oR*1.5*Math.sin((i-1)*45/180*3.1415926));});

     }
   }

   function activateBubble(d,i) {
       // increase this bubble and decrease others
       var t = svg.transition()
           .duration(d3.event.altKey ? 7500 : 350);

       t.selectAll(".topBubble")
           .attr("cx", function(d,ii){
               if(i == ii) {
                   // Nothing to change
                   return 50 +"%";
               } else {
                   // Push away a little bit
                   if(ii < i){
                       // left side
                       return 50 +"%";
                   } else {
                       // right side
                       return 50 +"%";
                   }
               }
           })
           .attr("r", function(d, ii) {
               if(i == ii)
                   return oR*1.3;
               else
                   return oR*0.8;
               });

       t.selectAll(".topBubbleText")
           .attr("x", function(d,ii){
               if(i == ii) {
                   // Nothing to change
                   return 50 +"%";
               } else {
                   // Push away a little bit
                   if(ii < i){
                       // left side
                       return 50 +"%";
                   } else {
                       // right side
                       return 50 +"%";
                   }
               }
           })
           .attr("font-size", function(d,ii){
               if(i == ii)
                   return 20*1.5;
               else
                   return 20*0.8;
           });

       var signSide = -1;
       for(var k = 0; k < nTop; k++)
       {
           signSide = 1;
           if(k < nTop/2) signSide = 1;
           t.selectAll(".childBubbleText" + k)
               .attr("x", function(d,i) {return (w/2  + signSide*oR*2.5*Math.cos((i-1)*45/180*3.1415926));})
               .attr("y", function(d,i) {return (300 * (k + 1) + signSide*oR*2.5*Math.sin((i-1)*45/180*3.1415926));})
               .attr("font-size", function(){
                       return (k==i)?20:15;
                   })
               .style("opacity",function(){
                       return (k==i)?1:0;
                   });

           t.selectAll(".childBubble" + k)
               .attr("cx", function(d,i) {return (w/2  + signSide*oR*2.5*Math.cos((i-1)*45/180*3.1415926));})
               .attr("cy", function(d,i) {return (300 * (k + 1) + signSide*oR*2.5*Math.sin((i-1)*45/180*3.1415926));})
               .attr("r", function(){
                       return (k==i)?(oR*0.55):(oR/3.0);
               })
               .style("opacity", function(){
                       return (k==i)?1:0;
                   });
       }
   }
   window.onresize = resetBubbles;
});
