Codeigniter-minify-Javascript-and-CSS
=====================================

Codeigniter minify Javascript and CSS



Example Use:

For JavaScript: Create a folder on the root of your web directory called “js”. This is where you will put all of you script files. Next, create your script tag in the HTML. Then as the source of your script tag add the route to the controller followed by the script files to be included. You can pass multiple script files by separating them with | .


&#060;script type="text/javascript" src="/minify/js/script_one.js|script_two.js"></script&#062;


For CSS: Create a folder on the root of your web directory call “css”. This is where you will put all the style sheets. Next, create your link tag in the HTML. Then as the href for the link tag add the route to the controller followed by the style sheets to be included. You can pass multiple script files by separating them with | .


&#060;link href="/minify/css/sheet_one.css|sheet_two.css" rel="stylesheet" type="text/css" /&#062;
