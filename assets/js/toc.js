$( document ).ready(function() {
  var ToC = "";


var newLine, el, title, link, previndent, prevel;

// $("article :header").each(function() {
$("article h1").each(function() {
  newLine = "";
  el = $(this);
  title = el.text();
  link = "#" + el.attr("id");

  if ( el.is( "h1" ) ){
    indent = 0;
  }
  if ( el.is( "h2" ) ){
    indent = 1;
  }
  if ( el.is( "h3" ) ){
    indent = 2;
  }

  if (previndent > indent){
    newLine += "  </ul>" +
               "</li>";
  }
  if (previndent < indent){
    newLine += "<li>" +
                 "<ul>";
  }


  newLine +=
    "<li>" +
      "<a href='" + link + "'>" +
        title +
      "</a>" +
    "</li>";

  ToC += newLine;
  prevel = el;
  previndent = indent;
});

// ToC += "</ul>";

$(".toc").prepend(ToC);


});
